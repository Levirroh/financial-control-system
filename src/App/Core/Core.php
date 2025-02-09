<?php

    class Core{

        public function start($url){

            $uri_info = Router::router($url);

            $controller = $uri_info['controller'];
            $method = $uri_info['method'];


            call_user_func_array(array(new $controller, $method), array());
        }
    }