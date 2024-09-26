<?php
    namespace Router;
    include_once 'RouterSwitch.php';
    use Router\RouterSwitch;

    class Router extends RouterSwitch{
        
        public $routes = [
            "GET" => [
                "/",
                "/cadastro",
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
                    else
                    {
                        $this->error();
                    }
                    break;
                case "POST":
                    break;
                default:
                    break;
            }
        }
    }

?>