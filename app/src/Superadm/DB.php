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
}

?>