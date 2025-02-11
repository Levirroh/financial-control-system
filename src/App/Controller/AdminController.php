<?php
class AdminController{
    public function index(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('admin.html'); 

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
}