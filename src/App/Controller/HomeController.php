<?php
class HomeController{
    public function index(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('Home.html'); 


            $parametros = array(); 

            $conteudo = $template->render($parametros);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function menu(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/user');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('menu.html'); 

            $user['id'] = $_SESSION['id'];
            $user['name'] = $_SESSION['name'];
            $user['email'] = $_SESSION['email'];
            $user['function'] = $_SESSION['function'];
            $user['isAdmin'] = $_SESSION['isAdmin'];


            $conteudo = $template->render($user);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function stock(){
        try {
            $user['id'] = $_SESSION['id'];
            $user['name'] = $_SESSION['name'];
            $user['email'] = $_SESSION['email'];
            $user['function'] = $_SESSION['function'];
            $user['isAdmin'] = $_SESSION['isAdmin'];
                
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/user');
            $twig = new \Twig\Environment($loader); 
            $template = $twig->load('stock.html'); 
            

            $conteudo = $template->render($user);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}