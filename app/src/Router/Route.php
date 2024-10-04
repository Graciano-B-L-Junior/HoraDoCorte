<?php
    namespace Router;
    include_once 'RouterSwitch.php';
    use Router\RouterSwitch;
    
    class Router extends RouterSwitch{
        
        public $routes = [
            "home"                  =>  "/",
            "cadastro"              =>  "/cadastro",
            "dashboard"             =>  "/dashboard",
            "servicos"              =>  "/dashboard/servicos",
            "dias_de_trabalho"      => "/dashboard/dias_de_trabalho",
            "proximos_clientes"     => "/dashboard/proximos_clientes",
            "clientes"              =>  "/dashboard/clientes",
            "quantidade_clientes"   => "/dashboard/quantidade_clientes",
            
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
                    else if($uri == $this->routes["quantidade_clientes"])
                    {
                        header('content-type: application/json');
                        $result = $this->get_total_clients();
                        echo json_encode(["result" => $result]);
                    }
                    else if($uri == $this->routes["dias_de_trabalho"])
                    {
                        $this->dias_de_trabalho();
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
                            setcookie("user_database",strtoupper($form_data["name"]),strtotime('+1 day'),"/", "", false, true);
                            echo json_encode(['redirect' => $this->routes["dashboard"]]);
                        }
                        else
                        {
                            http_response_code(404);
                            echo json_encode(["error" => true]);
                        }
                    }
                    else if($uri == $this->routes["servicos"])
                    {
                        // header('content-type: application/json');
                        
                        if($this->register_service($_POST))
                        {
                            http_response_code(200);
                            echo json_encode("serviços criados com sucesso");
                        }
                        else
                        {
                            http_response_code(404);
                            echo json_encode("falha ao criar os serviços");
                        }
                    }
                    break;
                default:
                    break;
            }
        }
    }

?>