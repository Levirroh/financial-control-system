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
            $code_item = $info['code'];
            $price_item = $info['price']; 
            $category_item = $info['category'];
            $sale_item = (int) $info['sale']; 

            $query = "INSERT INTO stock
            (name_item, code_item, price_item, category_item, sale_item)
            VALUES
            (?, ?, ?, ?, ?)";

            $statement = $conn->prepare($query);

            if ($statement === false) {
                die('Erro ao preparar a consulta: ' . $conn->error);
            }
    
            $statement->bind_param('ssisi', $name_item, $code_item, $price_item, $category_item, $isAdsale_itemmin);
    
            if ($statement->execute()) {
                return true;
            } else {
                die('Erro ao executar a consulta: ' . $statement->error);
            }
        }
    }