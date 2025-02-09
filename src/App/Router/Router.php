<?php

    class Router{

        public static function router($url){

            if(empty($url)){
                $url['url'] = 'Error';
            }

            $uri = explode('/', $url['url']);

            $controller = ucfirst($uri[0]) . 'Controller'; 

            if($uri[0] === ''){
                $controller = 'HomeController';
            }
            if($uri[0] === 'menu'){
                $controller = 'HomeController';
            }

            $uri_info['controller'] = $controller;

            return $uri_info;
        }
    }
