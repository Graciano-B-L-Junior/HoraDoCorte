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
            $params = [];
            $connection->exec("use GRACIANO");
            $stmt = $connection->prepare($sql);
            foreach($request_data as $key => $value)
            {
                if (preg_match('/\bvalor\b/', $key))
                {

                    array_push($params,[$key => number_format(floatval($value),2)]);
                }
                else
                {
                    array_push($params,[$key => $value]);
                }
            }
            $param_number=0;
            var_dump($params);
            echo "<br></br>";
            foreach($params as $data)
            {
                var_dump($data);
                echo "<br></br>";
                if($param_number != 0)
                {
                    $stmt->execute(
                        ["nome" => $data["servico-$param_number"], "valor" => $data["valor-$param_number"] ]
                    );
                }
                else
                {
                    $stmt->execute(
                        ["nome" => $data["servico"], "valor" => $data["valor"] ]
                    );
                }
                $param_number+=1;
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