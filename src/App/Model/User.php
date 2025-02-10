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
    }