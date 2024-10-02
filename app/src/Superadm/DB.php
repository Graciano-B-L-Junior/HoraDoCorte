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
            $sql = "INSER INTO servicos (nome, valor) VALUES (";
            $params = [];
            foreach($request_data as $key => $value)
            {
                $sql.= ":$key, ";
                if (preg_match('/\bvalor\b/', $key))
                {

                    $params[":$key"]=number_format(floatval($value),2);
                }
                else
                {
                    $params[":$key"]=$value;
                }
            }
            $sql = substr($sql,0,-2);
            $sql.= ")";
            echo $sql;
            $connection->exec("use GRACIANO");
            $stmt = $connection->prepare($sql);
            $stmt->execute($params);

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