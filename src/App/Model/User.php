<?php

    class User{

        private $id;
        private $password;
        protected $full_name;
        protected $email;
        protected $post;

        public function register($info){

            $conn = Connection::getConn();

            if($conn->connect_error){
                die('algo deu errado');
            }

            $query = "INSERT INTO users
            (name_user, email_user, password_user, function_user, isAdmin)
            VALUES
            (?, ?, ?, ?, ?)";

            $statement = $conn->prepare($query);

            $statement->bind_param('sssss', $name_user, $email_user, $password_user, $function_user, $isAdmin);

            $statement->execute();
        }
    }