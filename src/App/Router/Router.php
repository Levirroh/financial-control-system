<?php

    class Router{

        public static function router($url){

            if(empty($url)){
                $url['url'] = 'Error';
            }

            $uri = explode('/', $url['url']);

            $controller = ucfirst($uri[0]) . 'Controller'; 
            $method = 'index';

            if($uri[0] === '' || $uri[0] === 'Home'){
                $controller = 'HomeController';
            }
            if($uri[0] == 'menu'){
                $controller = 'HomeController';
                $method = 'menu';
            }
            if($uri[0] === 'register'){
                $controller = 'AuthController';
                $method = 'register';
            }
            if($uri[0] === 'login'){
                $controller = 'AuthController';
                $method = 'login';
            }

            $uri_info['controller'] = $controller;

            if (class_exists($controller)){
                if (!empty($uri[1])){
                    $method = $uri[1];
                }

            }


            $uri_info['method'] = $method;


            return $uri_info;
        }
    }
