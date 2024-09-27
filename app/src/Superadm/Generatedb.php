<?php
    namespace superadm;
    include_once '../src/DB/banco.php';
    include_once 'IGeneratedb.php';
    use \IGenerate\IGenerateDB;
    use \src\DB\Connection;
    use \Exception;
use PDOException;

    class GenerateDB implements IGenerateDB{

        private $connection;
        private $db_name;
        private $client;
        private $client_email;
        private $client_phonenumber;
        public function __construct($db_name,$client,$client_email, $client_phonenumber)
        {
            $this->connection = Connection::getInstance();
            $this->db_name = $db_name;
            $this->client = $client;
            $this->client_email = $client_email;
            $this->client_phonenumber = $client_phonenumber;
        }
        

        public function generate_database()
        {
            try{
                $sql = "CREATE DATABASE IF NOT EXISTS ".$this->db_name;
                $this->connection->exec($sql);
            }catch(Exception $e){
                echo $e->getMessage();
                echo "<br></br>";
                return false;
            }
            return true;
        }

        public function generate_tables()
        {
            try{
                $db_name = $this->db_name;
                $sql = "USE $db_name";
                $this->connection->exec($sql);
            }catch(PDOException $e){
                echo "<br></br>";
                echo $e->getMessage();
                return false;
            }
            //cria tabela adm
            $sql = "
                CREATE TABLE IF NOT EXISTS Dono (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    celular VARCHAR(100) NOT NULL
                ) ENGINE=INNODB;
            ";

            try {
                $this->connection->exec($sql);
            } catch (\PDOException $e) {
                echo "<br></br>";
                echo "Error creating table: Dono" . $e->getMessage();
                return false;
            }

            $sql = "
                CREATE TABLE IF NOT EXISTS servicos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR(200) NOT NULL,
                    valor float NOT NULL
                ) ENGINE=INNODB;
            ";

            try {
                $this->connection->exec($sql);
            } catch (\PDOException $e) {
                echo "<br></br>";
                echo "Error creating table: servicos" . $e->getMessage();
                return false;
            }

            $sql = "
                CREATE TABLE IF NOT EXISTS horariotrabalho (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    incio TIME NOT NULL,
                    fim TIME NOT NULL,
                    tempo_servico INT NOT NULL
                ) ENGINE=INNODB;
            ";

            try {
                $this->connection->exec($sql);
            } catch (\PDOException $e) {
                echo "<br></br>";
                echo "Error creating table: horariotrabalho" . $e->getMessage();
                return false;
            }

            $sql = "
                CREATE TABLE IF NOT EXISTS dia_semana_trabalhada (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    seg BIT NOT NULL,
                    ter BIT NOT NULL,
                    qua BIT NOT NULL,
                    qui BIT NOT NULL,
                    sex BIT NOT NULL,
                    sab BIT NOT NULL,
                    dom BIT NOT NULL
                ) ENGINE=INNODB;
            ";

            try {
                $this->connection->exec($sql);
            } catch (\PDOException $e) {
                echo "<br></br>";
                echo "Error creating table: dia_semana_trabalhada" . $e->getMessage();
                return false;
            }

            $sql = "
                CREATE TABLE IF NOT EXISTS clientes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR(100) NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    celular VARCHAR(20) NOT NULL
                ) ENGINE=INNODB;
            ";

            try {
                $this->connection->exec($sql);
            } catch (\PDOException $e) {
                echo "<br></br>";
                echo "Error creating table: cliente " . $e->getMessage();
                return false;
            }

            $sql = "
                CREATE TABLE IF NOT EXISTS horario_reservado (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    id_cliente INT NOT NULL,
                    horario TIME NOT NULL,
                    data Date NOT NULL,
                    id_servico INT NOT NULL,
                    FOREIGN KEY (id_cliente) REFERENCES clientes(id) ON DELETE CASCADE,
                    FOREIGN KEY (id_servico) REFERENCES servicos(id) ON DELETE CASCADE
                ) ENGINE=INNODB;
            ";

            try {
                $this->connection->exec($sql);
            } catch (\PDOException $e) {
                echo "<br></br>";
                echo "Error creating table: horario_reservado" . $e->getMessage();
                return false;
            }
            try{
                $sql = "INSERT INTO Dono (username, email, celular) VALUES (?,?,?)";
                $stmt = $this->connection->prepare($sql);
                $stmt->execute([$this->client,$this->client_email,$this->client_phonenumber]);
            }catch(Exception $e){
                echo "<br></br>";
                echo $e->getMessage();
            }
            return true;
        }
        public function generate(){
            $result = $this->generate_database();
            if($result == false){
                return false;
            }
            $result2 = $this->generate_tables();
            if($result2 == false){
                return false;
            }
            return true;

        }
    }

?>