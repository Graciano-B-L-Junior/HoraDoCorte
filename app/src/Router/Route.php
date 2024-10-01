<?php
    namespace Router;
    include_once 'RouterSwitch.php';
    use Router\RouterSwitch;
    
    class Router extends RouterSwitch{
        
        public $routes = [
            "home"      =>  "/",
            "cadastro"  =>  "/cadastro",
            "dashboard" =>  "/dashboard",
            "servicos"  =>  "/dashboard/servicos",
            "dias_de_trabalho" => "/dashboard/dias_de_trabalho",
            "proximos_clientes" => "/dashboard/proximos_clientes",
            "clientes"  =>  "/dashboard/clientes",
            
        ];

        public function route($uri,$method){
            switch($method){

                case "GET":
                    if($uri =="/"){
                        $this->home();
                    }
                    else if($uri == "/cadastro" || $uri == "cadastro"){
                        $this->cadastro();
                    }
                    else if($uri == "/dashboard"){
                        $this->dashboard();
                    }
                    else if($uri == $this->routes["servicos"])
                    {
                        $this->servicos();
                    }
                    else
                    {
                        $this->error();
                    }
                    break;
                case "POST":
                    if($uri == "/cadastro" || $uri == "cadastro")
                    {
                        header('content-type: application/json');

                        $form_data = array(
                            "name" => $_POST["name"],
                            "password" => $_POST["password"],
                            "password2" => $_POST["password2"],
                            "phone" => $_POST["phone"],
                            "email" => $_POST["email"]
                        );
                        
                        if($this->signin($form_data))
                        {
                            echo json_encode(['redirect' => $this->routes["dashboard"]]);
                        }
                        else
                        {
                            http_response_code(404);
                            echo json_encode(["error" => true]);
                        }
                    }
                    break;
                default:
                    break;
            }
        }
    }

?>