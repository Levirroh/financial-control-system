<?php

Class ErrorController{
    public function index(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/user');
            $twig = new \Twig\Environment($loader); 

            $admin = $_SESSION['isAdmin'];

            if ($admin){
                $template = $twig->load('errorAdmin.html'); 
            } else{
                $template = $twig->load('error.html'); 

            }


            $conteudo = $template->render();
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

?>