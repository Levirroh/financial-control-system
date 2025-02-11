<?php

    class Router{

        public static function router($url){

            if(empty($url)){
                $url['url'] = 'Error';
            }

            $uri = explode('/', $url['url']);

            $controller = ucfirst($uri[0]) . 'Controller'; 

            if($uri[0] === '' || $uri[0] === 'Home'){
                $controller = 'HomeController';
                $method = 'index';
            } else if($uri[0] === 'menu'){
                $controller = 'HomeController';
                $method = 'menu';
            } else if($uri[0] === 'register'){
                $controller = 'AuthController';
                $method = 'register';
            } else if($uri[0] === 'login'){
                $controller = 'AuthController';
                $method = 'login';
            } else if($uri[0] === 'auth'){
                $controller = 'AuthController';
                $method = $uri[1] ?? 'index';
            } else if($uri[0] === 'admin'){
                $controller = 'AdminController';
                $method = $uri[1] ?? 'index';
            } else{
                $method = 'index';
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
