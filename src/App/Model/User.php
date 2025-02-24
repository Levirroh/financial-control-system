<?php

    class User{

        private $id_user;
        private $password_user;
        protected $name_user;
        protected $email_user;
        protected $type_user;

        public function register($info){

            $conn = Connection::getConn();

            if($conn->connect_error){
                die('algo deu errado');
            }
            $name_user = $info['name'];
            $email_user = $info['email'];
            $password_user = $info['password']; 
            $function_user = $info['type'];
            $isAdmin = (int) $info['admin']; // transforma o bool em int, pra ser inserido no BD

            $query = "INSERT INTO users
            (name_user, email_user, password_user, type_user, isAdmin)
            VALUES
            (?, ?, ?, ?, ?)";

            $statement = $conn->prepare($query);

            if ($statement === false) {
                die('Erro ao preparar a consulta: ' . $conn->error);
            }
    
            $statement->bind_param('ssssi', $name_user, $email_user, $password_user, $function_user, $isAdmin);
    
            $sql = "SELECT * FROM users WHERE email_user = ?";
            $sql = $conn->prepare($sql);
            $sql->bind_param('s', $name_user);
            $sql->execute();

            if ($sql->get_result()->num_rows > 0){
                echo json_encode([
                    'success' => false,
                    'type' => 'text',
                    'message' => 'Usuário já cadastrado'
                ]);
                return false;
            }

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

            

            $query = "SELECT * FROM users WHERE email_user = ?";

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
                    $_SESSION['function'] = $data['user']->type_user;
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
            $sql->bind_param('i', $id);
            $sql->execute();
    
            $result = $sql->get_result();

            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data = $row; 
            }

            if (!$data){
                throw new Exception("Não foi encontrado nenhum usuário.");
            } 
        
            return $data;
        }
        public static function update($data){

            $con = Connection::getConn();
            $id = $data['id'];            
            $name = $data['name'];
            $email = $data['email'];
            $password = $data['password']; 
            $function = $data['function'];
            $isAdmin = (int) $data['admin'];

            $sql = "UPDATE users SET name_user = ?, email_user = ?, function_user = ?, password_user = ?, isAdmin = ? WHERE id_user = ?";
            $sql = $con->prepare($sql);
            if ($sql === false) {
                die('Erro ao preparar a consulta: ' . $con->error);
            }
            $sql->bind_param('ssssii', $name, $email, $function, $password, $isAdmin, $id);

            if ($sql->execute()) {
                return true;
            } else {
                die('Erro ao executar a consulta: ' . $sql->error);
            }
        }
        public static function delete_user($data){

            $con = Connection::getConn();
            $id = $data;            

            $sql = "DELETE FROM users WHERE id_user = ?";
            $sql = $con->prepare($sql);
            if ($sql === false) {
                die('Erro ao preparar a consulta: ' . $con->error);
            }
            $sql->bind_param('i',$id);

            if ($sql->execute()) {
                return true;
            } else {
                die('Erro ao executar a consulta: ' . $sql->error);
            }
        }
    }