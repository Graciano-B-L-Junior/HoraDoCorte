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
            
            "agenda"               => "/ref",
            "agenda_dados"         => "/api/barbershop_data"
            
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

                    
                    else if($uri == $this->routes["agenda"])
                    {
                        //link example: /ref?barbershop=GRACIANO
                        $ref_db_user = false;
                        
                        if(isset($_GET['barbershop']))
                        {
                            $ref_db_user = $_GET['barbershop'];                            
                        }
                        
                        if($ref_db_user==false)
                        {
                            $this->error();
                        }
                        else
                        {
                            $this->agenda();
                        }
                    }

                    else if($uri == $this->routes["agenda_dados"])
                    {
                        header('content-type: application/json');
                        //link example: /api/barbershop_data?barbershop=GRACIANO
                        if(isset($_GET['barbershop']))
                        {
                            $ref = $_GET['barbershop'];
                            $ref = htmlspecialchars($ref);
                            if($this->check_client_database($ref))
                            {
                                $result = $this->get_client_services_and_work_days_and_work_hours($ref);                                
                                if($result == false)
                                {
                                    http_response_code(404);
                                    echo $result;
                                }
                                else
                                {
                                    http_response_code(200);
                                    echo $result;
                                }
                            }
                        }
                        else
                        {
                            http_response_code(404);
                            echo json_encode("barbershop data isn't went referenced in http get");
                        }
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
                            http_response_code(200);
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
                    else if($uri == $this->routes["dias_de_trabalho"])
                    {
                        
                        header('content-type: application/json');
                        if($this->register_work_and_hour_days($_POST)== true)
                        {
                            http_response_code(200);
                            echo json_encode("ok");
                        }
                        else
                        {
                            http_response_code(404);
                            echo json_encode("error");
                        }
                    }
                    break;
                default:
                    break;
            }
        }
    }

?>