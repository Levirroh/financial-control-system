<?php

    class User{

        private $id_user;
        private $password_user;
        protected $name_user;
        protected $email_user;
        protected $func_user;

        public function register($info){

            $conn = Connection::getConn();

            if($conn->connect_error){
                die('algo deu errado');
            }
            $name_user = $info['name'];
            $email_user = $info['email'];
            $password_user = $info['password']; 
            $function_user = $info['function'];
            $isAdmin = (int) $info['admin']; // transforma o bool em int, pra ser inserido no BD

            $query = "INSERT INTO users
            (name_user, email_user, password_user, function_user, isAdmin)
            VALUES
            (?, ?, ?, ?, ?)";

            $statement = $conn->prepare($query);

            if ($statement === false) {
                die('Erro ao preparar a consulta: ' . $conn->error);
            }
    
            $statement->bind_param('ssssi', $name_user, $email_user, $password_user, $function_user, $isAdmin);
    
            if ($statement->execute()) {
                return true;
            } else {
                die('Erro ao executar a consulta: ' . $statement->error);
            }
        }


        public function login($info){

            $conn = Connection::getConn();

            if($conn->connect_error){
                die('algo deu errado');
            }
            $name_user = $info['name'];
            $password_user = $info['password']; 

            

            $query = "SELECT * FROM users WHERE name_user = ?";

            $statement = $conn->prepare($query);

            if ($statement === false) {
                die('Erro ao preparar a consulta: ' . $conn->error);
            }
    
            $statement->bind_param('s', $name_user);
            
            $statement->execute();

            $result = $statement->get_result();

            while($row = $result->fetch_object('user')){
                $data['user'] = $row;
            }

            if ($data){
                if ($password_user === $data['user']->password_user){
                    $_SESSION['id'] = $data['user']->id_user;
                    $_SESSION['name'] = $data['user']->name_user;
                    $_SESSION['email'] = $data['user']->email_user;
                    $_SESSION['function'] = $data['user']->function_user;
                    $_SESSION['isAdmin'] = $data['user']->isAdmin;

                    return true;
                } else {
                    echo json_encode([
                        'success' => false,
                        'type' => 'password',
                        'message' => 'Senha incorreta'
                    ]);
                    exit;
                }
            } else {

                echo json_encode([
                    'success' => false,
                    'type' => 'text',
                    'message' => 'Conta não cadastrada'
                ]);
                exit;
            }
        }
        public static function allUsers(){
            $con = Connection::getConn();

            $sql = "SELECT * FROM users ORDER BY id_user";
            $sql = $con->prepare($sql);
            $sql->execute();
    
            $result = $sql->get_result();

            $resultado = [];
            while ($row = $result->fetch_assoc()) {
                $resultado[] = (object) $row; 
            }

            if (!$resultado){
                throw new Exception("Não foi encontrado nenhum usuário.");
            } 
        
            return $resultado;
        }
        public static function selectById($id){
            $con = Connection::getConn();

            $sql = "SELECT * FROM users WHERE id_user = ?";
            $sql = $con->prepare($sql);
            $sql->bind_param('i', $id_user);
            $sql->execute();
    
            $result = $sql->get_result();

            $resultado = [];
            while ($row = $result->fetch_assoc()) {
                $resultado[] = (object) $row; 
            }

            if (!$resultado){
                throw new Exception("Não foi encontrado nenhum usuário.");
            } 
        
            return $resultado;
        }
    }