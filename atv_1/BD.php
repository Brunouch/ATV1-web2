<?php

    include_once 'global.php';

    class BD {

        public static function connection() {

            $str_conn = "mysql:host=wagnerweinert.com.br;dbname=tads20_bruno";

    		return new PDO($str_conn, 'tads20_bruno', 'tads20_bruno',
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    	}

        public static function select($tabela, $orderby="") {

            $conn = self::connection();
    		$stmt = $conn->prepare("SELECT * FROM $tabela $orderby" );
            $stmt->execute();

            return $stmt;
        }

        public static function selectFind($tabela, $condicao) {

            $sql = "SELECT * FROM $tabela WHERE $condicao";

            $conn = self::connection();
    		$stmt = $conn->prepare($sql);
    		$stmt->execute();

            return $stmt->fetchObject();
        }
        
        public static function insert($tabela, $dados) {

            $sql = "INSERT INTO $tabela(";

            $flag = 0;
            foreach($dados as $campo => $valor) {
                if($flag == 0) { $sql .= $campo; }
                else { $sql .= ", $campo"; }
                $flag = 1;
            }

            $sql .= ") VALUES(";

            $flag = 0;
            foreach($dados as $campo => $valor) {
                if($flag == 0) { $sql .= ":$campo"; }
                else { $sql .= ", :$campo"; }
                $flag = 1;
            }

            $sql .= ")";

            $conn = self::connection();
    		$stmt = $conn->prepare($sql);

            foreach($dados as $campo => &$valor) {
                $stmt->bindParam($campo, $valor);
            }

            $stmt->execute();

            return $stmt;
        }
    
        public static function edit($tabela, $dados, $condicao) {

            $sql = "UPDATE $tabela SET ";

            $flag = 0;
            foreach($dados as $campo => $valor) {
                if($flag == 0) { $sql .= "$campo=:$campo"; }
                else { $sql .= ", $campo=:$campo"; }
                $flag = 1;
            }

            $sql .= " WHERE $condicao";

            $conn = self::connection();
    		$stmt = $conn->prepare($sql);

            foreach($dados as $campo => &$valor) {
                $stmt->bindParam($campo, $valor);
            }

            $stmt->execute();

            return $stmt;
        }

        public static function delete($tabela, $condicao) {

            $conn = self::connection();
    		$stmt = $conn->prepare("DELETE FROM $tabela WHERE $condicao" );
            $stmt->execute();

            return $stmt;
        }
    }