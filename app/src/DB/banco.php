<?php
    namespace src\DB;

use Exception;
use \PDO;
use PDOException;

    class Connection{
        private static $instance;

        private function __construct() {
            
        }

        //TODO
        //->CRIAR UM ALGORITMO QUE PEGA A INSTANCIA DA CONEXAO E SELECIONA UM BANCO DE UM CLIENTE ESPECIFICO
        public static function getInstance() {
            try{

                if (!isset(self::$instance)) {
                    self::$instance = new PDO("mysql:host=".$_ENV["HOST"].";", "root",$_ENV["MYSQL_ROOT_PASSWORD"], 
                                                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
                }
                return self::$instance;
        
            }catch(PDOException $e){

            }
        }
        public static function select_database($db_name,$user,$password)
        {
            if (isset(self::$instance)) {
                self::$instance = new PDO("mysql:host=".$_ENV["HOST"].";dbname=".$db_name, $user,$password, 
                                            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
                return self::$instance;
            }else
            {
                throw new Exception("PDO instance is not initializaded");
            }
    
        }
    }

?>