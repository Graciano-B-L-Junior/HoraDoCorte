<?php
namespace Database;
include_once '../src/DB/banco.php';

use Exception;
use \src\DB\Connection;
class DB
{
    private $connection;
    static public function create_services($request_data)
    {
        try
        {
            $connection = Connection::getInstance();
            $sql = "INSERT INTO servicos (nome, valor) VALUES (:nome, :valor)";
            $connection->exec("use GRACIANO");
            $stmt = $connection->prepare($sql);
            $final_param = [];
            
            array_map(function($key,$value) use(&$final_param){
                $arr = [$key => $value];
                if (preg_match('/\bvalor\b/', $key))
                {
                    $result = (float)$value;
                    $index = count($final_param)-1;
                    array_push($final_param[$index],$result);
                    return $result;
                }
                else
                {
                    array_push($final_param,[$value]);
                    return $value;
                }
            },array_keys($request_data),array_values($request_data));
            
            foreach($final_param as $data)
            {
                $stmt->execute(
                    ["nome" => $data[0], "valor" => $data[1] ]
                );
                
            }

            return true;

        }
        catch(Exception $e)
        {
            echo json_encode($e->getMessage());
            // var_dump($e->getMessage());
            // echo "<br></br>";
            
            return false;
        }

    }
    static public function get_total_clients($user_database)
    {
        try
        {
            $connection = Connection::getInstance();
            $sql = "use $user_database";
            $connection->exec($sql);
            $sql = "SELECT COUNT('nome') FROM clientes";
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        
    }

    static public function register_work_and_hour_day($user_database,$request_data)
    {
        try
        {
            $connection = Connection::getInstance();
            $arr_hours = [];
            $arr_week_days = [];
            $pattern_1 = '/\d{2}:\d{2}/';
            $pattern_2 = '/[a-z]+/';

            
            foreach($request_data as $key => $value)
            {
                
                if(preg_match($pattern_1,$key))
                {
                    $arr_hours[$key] = (int)$value;
                    // array_push($arr_hours,[$key => 1]);
                }
                else if(preg_match($pattern_2,$key))
                {
                    $arr_week_days[$key] = (int)$value;
                }
            }
            
            $sql = "use $user_database";
            $connection->exec($sql);
            
            $sql = "INSERT INTO dia_semana_trabalhada (seg,ter,qua,qui,sex,sab,dom) VALUES (:seg,:ter,:qua,:qui,:sex,:sab,:dom)";

            $stmt = $connection->prepare($sql);
            $stmt->execute(
                [
                    "seg" => $arr_week_days["seg"],
                    "ter" => $arr_week_days["ter"],
                    "qua" => $arr_week_days["qua"],
                    "qui" => $arr_week_days["qui"],
                    "sex" => $arr_week_days["sex"],
                    "sab" => $arr_week_days["sab"],
                    "dom" => $arr_week_days["dom"]
                ]
            );            
            return true;
        }
        catch(Exception $e)
        {
            var_dump($arr_week_days);
            echo "<br></br>";
            var_dump($arr_week_days["seg"]);
            echo "<br></br>";
            echo $e->getMessage();
            return $e->getMessage();
        }
    }
}

?>