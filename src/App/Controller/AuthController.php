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

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos']);
            exit;
        } // verifica se são realmente JSON

        $user = new User();
        $registerSuccess = $user->register($data);

        if ($registerSuccess) {
             echo json_encode(['success' => true, 'redirect' => 'login']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar usuário']);
        }
    }



    public function enter(){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos']);
            exit;
        } 


        $user = new User();
        $registerSuccess = $user->login($data);
        if ($registerSuccess === true) {
             echo json_encode(['success' => true, 'redirect' => 'menu']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao entrar na conta!']);
        }
    }
}