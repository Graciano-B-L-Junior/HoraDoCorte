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
                return true;
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
        
    }
?>
