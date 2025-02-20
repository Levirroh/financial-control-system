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
        $con = Connection::getConn();
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('financial.html'); 
            
            $item = array();

            $aprovados = Stock::selectAllApproved();
            $stmt =  "SELECT total_balance FROM company_balance WHERE id_balance = 1";
            $stmt = $con->prepare($stmt);
            $stmt->execute();
    
            $moneyResult  = $stmt->get_result();
            $money = $moneyResult->fetch_assoc(); 
            $totalBalance = $money ? $money['total_balance'] : 0; // se nao tiver é zero

            $item['aprovados'] = $aprovados;
            $item['totalBalance'] = $totalBalance;

            $conteudo = $template->render($item);
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

        $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
        $twig = new \Twig\Environment($loader); 
        $template = $twig->load('update_user.html'); 

        $employee_info['user'] = User::selectById($id);

        $conteudo = $template->render($employee_info);
        echo $conteudo;
        
    }
    public function delete(){
        
        $url = $_GET['url'];

        $uri = explode('/', $url);

        $id = $uri[2];

        $delete = User::delete_user($id);

        if ($delete === true) {
            header('Location: /financial-control-system/employees');
        } else{
            echo "algo deu errado!";
        }
    }
    //REFERENTES AO ESTOQUE

    public function add_item(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('add_item.html'); 

            $user = [];

            $conteudo = $template->render($user);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function update_item(){
        
        $url = $_GET['url'];

        $uri = explode('/', $url);

        $id = $uri[2];

        $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
        $twig = new \Twig\Environment($loader); 
        $template = $twig->load('update_item.html'); 

        $item_info['item'] = Stock::selectById($id);

        $conteudo = $template->render($item_info);
        echo $conteudo;
        
    }
    public function delete_item(){
        
        $url = $_GET['url'];

        $uri = explode('/', $url);

        $id = $uri[2];

        $delete = Stock::delete_item($id);

        if ($delete === true) {
            header('Location: /financial-control-system/stock_admin');
        } else{
            echo "algo deu errado!";
        }
        
    }
    public function stock(){
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('stock_admin.html'); 

            $item['item'] = Stock::selectAll();

            $conteudo = $template->render($item);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function sales(){
        $con = Connection::getConn();
        try {
            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('sales.html'); 

            $item['item'] = Stock::selectAll();
            $stmt =  "SELECT total_balance FROM company_balance WHERE id_balance = 1";
            $stmt = $con->prepare($stmt);
            $stmt->execute();
    
            $moneyResult  = $stmt->get_result();
            $money = $moneyResult->fetch_assoc(); 
            $totalBalance = $money ? $money['total_balance'] : 0; // se nao tiver é zero

            $item['totalBalance'] = $totalBalance;

            $conteudo = $template->render($item);
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
            
            $user['users'] = Stock::selectRequests();


            $conteudo = $template->render($user);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function accept_request(){
        
        $url = $_GET['url'];

        $uri = explode('/', $url);

        $id = $uri[2];

        $accept = Stock::acceptRequest($id);

        if ($accept === true) {
            header('Location: /financial-control-system/requests');
        } else{
            echo "algo deu errado!";
        }
        
    }
    public function refuse_request(){
        
        $url = $_GET['url'];

        $uri = explode('/', $url);

        $id = $uri[2];

        $accept = Stock::refuseRequest($id);

        if ($accept === true) {
            header('Location: /financial-control-system/requests');
        } else{
            echo "algo deu errado!";
        }
        
    }
    public function sell_item(){
        
        $url = $_GET['url'];

        $uri = explode('/', $url);

        $id = $uri[2];

        $accept = Stock::sellItem($id);

        if ($accept === true) {
            header('Location: /financial-control-system/sales');
        } else{
            echo "algo deu errado!";
        }
        
    }
    public function graphics(){
        try {
            $allTransactions = Stock::allTransactions();

            $loader = new \Twig\Loader\FilesystemLoader('../src/App/View/admin');
            $twig = new \Twig\Environment($loader); 

            $template = $twig->load('graphics.html'); 

            $parametros = array(); 
            $parametros['transactions'] = $allTransactions;

            $conteudo = $template->render($parametros);
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
}