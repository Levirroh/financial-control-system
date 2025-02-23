<?php

    class Stock{
        public static function selectAllApproved(){
            $con = Connection::getConn();

            $sql = "SELECT DISTINCT * FROM requests INNER JOIN users ON requests.fk_user = users.id_user INNER JOIN stock ON stock.id_item = requests.fk_item WHERE requests.status_request = 'Aprovado' ORDER BY requests.id_request";
            $sql = $con->prepare($sql);
            $sql->execute();
    
            $result = $sql->get_result();

            $resultado = [];
            while ($row = $result->fetch_assoc()) {
                $resultado[] = (object) $row; 
            }

            return $resultado;
        }
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

        
            return $data;
        }
        public static function selectRequests(){

            $con = Connection::getConn();

            $sql = "SELECT DISTINCT * FROM requests INNER JOIN users ON requests.fk_user = users.id_user INNER JOIN stock ON stock.id_item = requests.fk_item ";
            $sql = $con->prepare($sql);
            $sql->execute();
    
            $result = $sql->get_result();

            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row; 
            }

            if (!$data){
                return false;
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
        public static function deleteRequest($id){

            $con = Connection::getConn();

            $sql = "DELETE FROM requests WHERE id_request = ?";
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
        public static function buyItem($data){

            $con = Connection::getConn();

            if (!$con) {
                throw new Exception("Erro ao conectar ao banco de dados.");
            }

            $item = $data['item'];
            $quantity = $data['quantity'];
            $id_item = $data['id_item'];
            $id_request = $data['id_request'];
            $price = $data['price_item'];
            $totalPrice = $price * $quantity;

            try {
                // Iniciar transação
                $con->begin_transaction();
        
                // Atualizar estoque
                $sql = "UPDATE stock SET quantity_item = quantity_item + ? WHERE id_item = ?";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('ii', $quantity, $id_item);
                $stmt->execute();
                $stmt->close();
        
                // Fazer o "recibo"
                $sql = "INSERT INTO company_transactions (type_transaction, amount, description, fk_item) VALUES ('entrada', ?, 'Recarga de Estoque', ?)";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('ii', $totalPrice, $id_item);
                $stmt->execute();
                $stmt->close();
        
                // Remover as requisições do item
                $sql = "DELETE FROM requests WHERE fk_item = ?";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('i', $id_item);
                $stmt->execute();
                $stmt->close();
        
                // atualizar monetário
                $sql = "UPDATE company_balance SET total_balance = total_balance - ? WHERE id_balance = 1";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('i', $totalPrice);
                $stmt->execute();
                $stmt->close();
        
                $con->commit();
        
                return true;
            } catch (Exception $e) {
                $con->rollback();
                throw new Exception("Erro na compra do item: " . $e->getMessage());
            }
            
        }
        public static function sellItem($id) {
            $con = Connection::getConn();
        
            if (!$con) {
                throw new Exception("Erro ao conectar ao banco de dados.");
            }
        
            try {
                $con->begin_transaction();
        
                $sql = "SELECT price_item, quantity_item FROM stock WHERE id_item = ?";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $item = $result->fetch_assoc();
                $stmt->close();
        
                if (!$item) {
                    throw new Exception("Item não encontrado no estoque.");
                }
        
                if ($item['quantity_item'] <= 0) {
                    throw new Exception("Estoque insuficiente para venda.");
                }
        
                $totalPrice = $item['price_item'];
        
                $sql = "UPDATE stock SET quantity_item = quantity_item - 1 WHERE id_item = ?";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->close();
        
                $sql = "INSERT INTO company_transactions (type_transaction, amount, description, fk_item) VALUES ('saída', ?, 'Venda de Item', ?)";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('di', $totalPrice, $id);
                $stmt->execute();
                $stmt->close();
        
                $sql = "UPDATE company_balance SET total_balance = total_balance + ? WHERE id_balance = 1";
                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Erro ao preparar a consulta: " . $con->error);
                }
                $stmt->bind_param('d', $totalPrice);
                $stmt->execute();
                $stmt->close();
        
                $con->commit();
        
                return true;
            } catch (Exception $e) {
                $con->rollback();
                throw new Exception("Erro ao vender o item: " . $e->getMessage());
            }
        }
    public static function allTransactions(){
        $con = Connection::getConn();

        $sql = "SELECT COUNT(fk_item), name_item FROM company_transactions INNER JOIN stock ON company_transactions.fk_item = stock.id_item GROUP BY fk_item HAVING COUNT(fk_item) >= 2"; // vai mostrar quantas vezes o item foi vendido e o fk do item
        $sql = $con->prepare($sql);
        $sql->execute();

        $result = $sql->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row; 
        }
    
        return $data;
    }
    public static function entryTransactions(){
        $con = Connection::getConn();

        $sql = "SELECT SUM(amount) AS total_amount, DATE(date_transaction) AS transaction_date 
        FROM company_transactions 
        WHERE type_transaction = 'Entrada' 
        GROUP BY DATE(date_transaction) 
        ORDER BY transaction_date ASC"; // vai mostrar quantas vezes o item foi vendido e o fk do item
        $sql = $con->prepare($sql);
        $sql->execute();

        $result = $sql->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row; 
        }
    
        return $data;
    }
    public static function outTransactions(){
        $con = Connection::getConn();

        $sql = "SELECT SUM(amount) AS total_amount, DATE(date_transaction) AS transaction_date 
        FROM company_transactions 
        WHERE type_transaction = 'Saída' 
        GROUP BY DATE(date_transaction) 
        ORDER BY transaction_date ASC"; 
        $sql = $con->prepare($sql);
        $sql->execute();

        $result = $sql->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row; 
        }
    
        return $data;
    }
}
