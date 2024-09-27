<?php
    namespace Router;
    include_once 'RouterSwitch.php';
    use Router\RouterSwitch;

    class Router extends RouterSwitch{
        
        public $routes = [
            "GET" => [
                "/",
                "/cadastro",
                "/dashboard"
            ],
            "POST" => [
                "/",
                "/cadastro"
            ]
        ];

        public function route($uri,$method){
            switch($method){
                case "GET":
                    if($uri =="/"){
                        $this->home();
                    }
                    else if($uri == "/cadastro"){
                        $this->cadastro();
                    }
                    else if($uri == "/dashboard"){
                        $this->dashboard();
                    }
                    else
                    {
                        $this->error();
                    }
                    break;
                case "POST":
                    if($uri == "/cadastro")
                    {
                        $form_data = array(
                            "name" => $_POST["name"],
                            "password" => $_POST["password"],
                            "password2" => $_POST["password2"],
                            "phone" => $_POST["phone"],
                            "email" => $_POST["email"]
                        );
                        $this->signin($form_data);
                    }
                    break;
                default:
                    break;
            }
        }
    }

?>