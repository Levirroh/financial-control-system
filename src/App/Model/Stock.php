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

            // s 
        
            return $resultado;
        }
    }