<?php

    class Stock{

        public static function selectAll(){
            $con = Connection::getConn();

            $sql = "SELECT * FROM stock ORDER BY id_item";
            $sql = $con->prepare($sql);
            $sql->execute();
    
            $result = $sql->get_result();

            $resultado = [];
            while ($row = $result->fetch_assoc()) {
                $resultado[] = (object) $row; 
            }

        
            return $resultado;
        }
        public static function add_item($info){
            
            $conn = Connection::getConn();

            if($conn->connect_error){
                die('algo deu errado');
            }
            $name_item = $info['name'];
            $quantity_item = $info['quantity'];
            $code_item = $info['code'];
            $price_item = $info['price']; 
            $category_item = $info['category'];
            $sale_item = (int) $info['sale']; 

            $query = "INSERT INTO stock
            (name_item, code_item, price_item, category_item, sale_item, quantity_item)
            VALUES
            (?, ?, ?, ?, ?, ?)";

            $statement = $conn->prepare($query);

            if ($statement === false) {
                die('Erro ao preparar a consulta: ' . $conn->error);
            }
    
            $statement->bind_param('ssisii', $name_item, $code_item, $price_item, $category_item, $sale_item, $quantity_item);
    
            if ($statement->execute()) {
                return true;
            } else {
                die('Erro ao executar a consulta: ' . $statement->error);
            }
        }
        public static function selectById($id){

            $con = Connection::getConn();

            $sql = "SELECT * FROM stock WHERE id_item = ?";
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
            $category = $data['category'];
            $price = $data['price']; 
            $code = $data['code'];
            $sale = (int) $data['sale'];

            $sql = "UPDATE stock SET name_item = ?, category_item = ?, code_item = ?, price_item = ?, sale_item = ? WHERE id_item = ?";
            $sql = $con->prepare($sql);
            if ($sql === false) {
                die('Erro ao preparar a consulta: ' . $con->error);
            }
            $sql->bind_param('sssiii', $name, $category, $code, $price, $sale, $id);

            if ($sql->execute()) {
                return true;
            } else {
                die('Erro ao executar a consulta: ' . $sql->error);
            }
        }
        public static function delete_item($data){

            $con = Connection::getConn();
            $id = $data;            

            $sql = "DELETE FROM stock WHERE id_item = ?";
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
        public static function request_item($data){

            $con = Connection::getConn();
            $id_item = $data[0];
            $id_user = $data[1];

            $sql = "INSERT INTO requests (fk_item, fk_user, status_request) VALUES (?, ?, 'Não visto')";
            $sql = $con->prepare($sql);
            if ($sql === false) {
                die('Erro ao preparar a consulta: ' . $con->error);
            }
            $sql->bind_param('ii', $id_item, $id_user);

            if ($sql->execute()) {
                return true;
            } else {
                die('Erro ao executar a consulta: ' . $sql->error);
            }
        }
        public static function selectRequestById($id){

            $con = Connection::getConn();

            $sql = "SELECT * FROM requests INNER JOIN users ON requests.fk_user = users.id_user INNER JOIN stock ON stock.id_item = requests.fk_item WHERE fk_user = ?";
            $sql = $con->prepare($sql);
            $sql->bind_param('i', $id);
            $sql->execute();
    
            $result = $sql->get_result();

            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row; 
            }

            if (!$data){
                throw new Exception("Não foi encontrado nenhum pedido.");
            } 
        
            return $data;
        }
        public static function selectRequests(){

            $con = Connection::getConn();

            $sql = "SELECT DISTINCT * FROM requests INNER JOIN users ON requests.fk_user = users.id_user ";
            $sql = $con->prepare($sql);
            $sql->execute();
    
            $result = $sql->get_result();

            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row; 
            }

            if (!$data){
                throw new Exception("Não foi encontrado nenhum pedido.");
            } 
        
            return $data;
        }
        public static function acceptRequest($id){

            $con = Connection::getConn();

            $sql = "UPDATE requests SET status_request = 'Aprovado' WHERE id_request = ?";
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
        public static function refuseRequest($id){

            $con = Connection::getConn();

            $sql = "UPDATE requests SET status_request = 'Recusado' WHERE id_request = ?";
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