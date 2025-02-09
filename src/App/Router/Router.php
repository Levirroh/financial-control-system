<?php

    class Router{

        public static function router($url){

            if(empty($url)){
                $url['url'] = 'error';
            }

            $uri = explode('/', $url['url']);

            $controller = ucfirst($uri[0]) . 'Controller'; 
            $method = isset($uri[1]) ? $uri[1] : 'index';

            $uri_info['controller'] = $controller;
            $uri_info['method'] = $method;

            return $uri_info;
        }
    }
