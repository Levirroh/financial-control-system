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
    public function create_employee(){

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos']);
            exit;
        }

        $user = new User();
        $registerSuccess = $user->register($data);

        if ($registerSuccess) {
             echo json_encode(['success' => true, 'redirect' => 'employees']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar usuário']);
        }
    }
    public function update_employee(){

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos']);
            exit;
        }

        $registerSuccess = User::update($data);

        if ($registerSuccess) {
             echo json_encode(['success' => true, 'redirect' => '/financial-control-system/employees']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao alterar usuário']);
        }
    }
    public function update_item(){

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos']);
            exit;
        }

        $registerSuccess = Stock::update($data);

        if ($registerSuccess) {
             echo json_encode(['success' => true, 'redirect' => '/financial-control-system/stock_admin']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao alterar item']);
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
            if ($_SESSION['isAdmin']){
                echo json_encode(['success' => true, 'redirect' => 'admin']);
            } else {
                echo json_encode(['success' => true, 'redirect' => 'menu']);
            }
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao entrar na conta!']);
        }
    }
    public function add_item(){

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos']);
            exit;
        }

        $stock = new Stock();
        $registerSuccess = $stock->add_item($data);

        if ($registerSuccess) {
             echo json_encode(['success' => true, 'redirect' => 'stock_admin']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao adicionar item']);
        }
    }
    public function request_item(){

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos recebidos']);
            exit;
        }

        $stock = new Stock();
        $registerSuccess = $stock->request_item($data);

        if ($registerSuccess) {
             echo json_encode(['success' => true, 'redirect' => 'home/stock']);
        } else {
             echo json_encode(['success' => false, 'message' => 'Erro ao adicionar item']);
        }
    }
}