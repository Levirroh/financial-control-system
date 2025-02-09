<?php
class AuthController{
    public function register(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/auth');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('Register.html'); 


            $parametros = array(); 

            $conteudo = $template->render($parametros);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function login(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/auth');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('Login.html'); 


            $parametros = array(); 

            $conteudo = $template->render($parametros);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function create(){
        $data = json_decode(file_get_contents("php://input"), true);

        $user = new User;
        $user = new User();
        $registerSuccess = $user->register($data);

        if ($registerSuccess) {
            echo json_encode(['success' => true, 'redirect' => '/login']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar usuário']);
        }
    }
}