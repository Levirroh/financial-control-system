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
    public function financial(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('financial.html'); 

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
    public function employees(){
        try {
            $allEmployees = User::allUsers();

            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('employees.html'); 

            $parametros = array(); 
            $parametros['users'] = $allEmployees;

            $conteudo = $template->render($parametros);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function requests(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('requests.html'); 

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
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('stock_admin.html'); 

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
    public function create_employee(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('create_employee.html'); 

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
    public function update(){
        
        $url = $_GET['url'];

        $uri = explode('/', $url);

        $id = $uri[2];

        $_SESSION['employee'] = $id;

        try {

            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 
            $template = $twig->load('update_user.html'); 

            $employee_info['user'] = User::selectById($id);
            $conteudo = $template->render($employee_info);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}