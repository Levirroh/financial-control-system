<?php
    class Core{
        public function start(){

            $acao = "index";
            if (isset($urlGet['pagina'])) {// se a pagina existe
                $controller = ucfirst($urlGet['pagina'].'Controller');
            } else {
                $controller = 'HomeController';
            }
            if (!class_exists($controller)) {
                $controller = 'ErroController';
            }
            call_user_func_array(array(new $controller, $acao), array());
        }
    }
?>