<?php
    namespace Router;
    include_once '../src/Superadm/Generatedb.php';
    include_once '../src/Superadm/DB.php';
    use superadm\GenerateDB;
    use Database\DB;
    abstract class RouterSwitch{

        //GET
        protected function home()
        {
            require_once __DIR__ . '/pages/home.html';
        }

        protected function cadastro()
        {
            require __DIR__ . '/pages/cadastro.html';
        }

        protected function contact()
        {
            require __DIR__ . '/pages/contact.html';
        }
        protected function error()
        {
            require __DIR__ . '/pages/error404.html';
        }
        protected function dashboard()
        {
            require __DIR__ . '/pages/dashboard.html';
        }

        protected function servicos()
        {
            require __DIR__ . '/pages/dashboard/servicos.html';
        }

        protected function dias_de_trabalho()
        {
            require __DIR__ . '/pages/dashboard/dias_de_trabalho.html';
        }


        //clientes
        protected function agenda()
        {
            require __DIR__ . '/pages/clientes/agenda.html';
        }


        //POST
        //CADASTRO DE DONO
        //
        protected function signin($form_data){
            
            $name_upper =strtoupper(explode(" ",$form_data["name"])[0]);
            $name = explode(" ",$form_data["name"])[0];
            $pass1 = $form_data["password"];
            $pass2 = $form_data["password2"];
            $phone = $form_data["phone"];
            if($pass1 != $pass2){
                return false;
            }
            $email = $form_data["email"];

            $instance = new GenerateDB($name_upper,$name,$email,$phone);

            if($instance->generate()){
                $result = DB::insert_cliente_in_gerencia($name_upper) ?? false;
                return $result;
            }
            else{
                return false;
            }
            
        }
        //TODO
        //colocar segurança no sistema
        //fazer sanitização do algoritimo
        protected function register_service($form_data)
        {
            return DB::create_services($form_data);
        }

        protected function get_total_clients()
        {
            $database = $_COOKIE["user_database"];
            return DB::get_total_clients($database);
        }

        protected function register_work_and_hour_days($request)
        {
            $database = $_COOKIE["user_database"];
            return DB::register_work_and_hour_day($database,$request);
        }

        protected function check_client_database($db_name)
        {
            return DB::check_cliente_database($db_name);
        }

        protected function get_client_services_and_work_days_and_work_hours($db_name)
        {
            return DB::get_client_services_and_work_days_and_work_hours($db_name);
        }
        
    }
?>
