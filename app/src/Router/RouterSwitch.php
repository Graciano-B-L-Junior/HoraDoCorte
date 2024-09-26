<?php
    namespace Router;
    abstract class RouterSwitch{
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
        
    }
?>
