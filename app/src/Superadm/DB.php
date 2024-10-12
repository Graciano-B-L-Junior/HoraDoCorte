<?php
namespace Database;
include_once '../src/DB/banco.php';

use Exception;
use \src\DB\Connection;
use \PDO;
class DB
{
    private $connection;

    static public function create_superadm_db()
    {
        try
        {
            $connection = Connection::getInstance();
            $sql= "CREATE DATABASE IF NOT EXISTS GERENCIA";
            $connection->exec($sql);

            $sql = "use GERENCIA";
            $connection->exec($sql);

            $sql = "CREATE TABLE IF NOT EXISTS Clientes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    cliente_database VARCHAR(100) NOT NULL)
                    ";

            $connection->exec($sql);

            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }


    static public function create_services($request_data)
    {
        try
        {
            $connection = Connection::getInstance();
            $sql = "INSERT INTO servicos (nome, valor) VALUES (:nome, :valor)";
            $db_name = $_COOKIE["user_database"];
            $connection->exec("use ".$db_name);
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
                
                if(preg_match($pattern_1,$value))
                {
                    $arr_hours[$key] = $value . ":00";
                    // array_push($arr_hours,[$key => 1]);
                }
                else if(preg_match($pattern_2,$key))
                {
                    $arr_week_days[$key] = (int)$value;
                }
            }
            
            var_dump($arr_hours);
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
            
            
            $sql = "INSERT INTO horario_trabalho (inicio,fim) VALUES (:inicio, :fim)";

            $stmt = $connection->prepare($sql);
            $stmt->execute(
                [
                    "inicio"    => $arr_hours["inicio"],
                    "fim"       => $arr_hours["fim"]
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

    static public function insert_cliente_in_gerencia($cliente_db)
    {
        try
        {
            self::create_superadm_db();
            $sql = "use GERENCIA";
            $connection = Connection::getInstance();
            $connection->exec($sql);

            $sql = "INSERT INTO Clientes (cliente_database) VALUES (:cliente_database)";

            $stmt = $connection->prepare($sql);
            $stmt->execute(
                [
                    "cliente_database" => $cliente_db
                ]
            );
            setcookie("user_database",$cliente_db,strtotime('+1 day'),"/", "", false, true);
            return true;
        }
        catch(Exception $e)
        {
            echo "oi";
            echo $e->getMessage();
            return false;
        }
    }

    static public function check_cliente_database($db_name)
    {
        try
        {
            $sql = "use GERENCIA";
            $connection = Connection::getInstance();
            $connection->exec($sql);

            $sql = "SELECT * FROM Clientes WHERE cliente_database LIKE :data";
            $stmt = $connection->prepare($sql);
            $stmt->execute(
                ["data" => "%".$db_name."%"]
            );
            $result = $stmt->fetch();
            return $result ? true : false;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
        
    }
    static public function get_client_services_and_work_days_and_work_hours($db_name)
    {
        try
        {
            $sql = "use $db_name";
            $connection = Connection::getInstance();
            $connection->exec($sql);
            
            $services =[];
            $dias_da_semana_que_trabalha=[];

            $sql = "SELECT nome, valor FROM servicos";
            $result = $connection->prepare($sql);
            $result->execute();
            $services=$result->fetchall(PDO::FETCH_ASSOC);

            $sql = "SELECT seg,ter,qua,qui,sex,sab,dom FROM dia_semana_trabalhada";
            $result = $connection->prepare($sql);
            $result->execute();
            $dias_da_semana_que_trabalha=$result->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT inicio, fim, tempo_servico FROM horario_trabalho";
            $stmt = $connection->prepare($sql);
            $stmt->execute();

            $horario_trabalho = $stmt->fetch(PDO::FETCH_ASSOC);

            

            $response = $dias_da_semana_que_trabalha + $horario_trabalho + $services;
            

            // var_dump($response);
            $final_response = json_encode($response);            
            return $final_response;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
        
    }
}

?>