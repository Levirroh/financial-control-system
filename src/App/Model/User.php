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

            

            $query = "SELECT * FROM users WHERE name_user = ? OR email_user = ?
            VALUES
            (?, ?)";

            $statement = $conn->prepare($query);

            if ($statement === false) {
                die('Erro ao preparar a consulta: ' . $conn->error);
            }
    
            $statement->bind_param('ss', $name_user, $name_user);
            
            $statement->execute();

            $result = $statement->get_result();

            while($row = $result->fetch_object('user')){
                $data['user'] = $row;
            }

            if ($data){
                if ($password_user === $data['user']->password_user){
                    $_SESSION['user'] = $data['user']->id;
                    return;
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
                    'type' => 'email',
                    'message' => 'E-mail não cadastrado'
                ]);
                exit;
            }
        }
    }