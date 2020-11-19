<?php
    require_once '../database/ConexionMysql.php';
    class Cargo{
        public $id_cargo;
        public $cargo;
        public $estado;

        public function consultarDatos(){
            $con = new ConexionMysql();
            $select = "SELECT * FROM cargo WHERE id_estado = '01'";
            $res = $con->consultar($select);
            $con->cerrar();
            if($res == null){
                return null;
            }else if($res->num_rows > 0){
                $datos = [];
                while($row = $res->fetch_assoc()){
                    $datos[] = $row;
                }
                return $datos;
            }else{
                return null;
            }
        }

        public static function buscarXID($id){
            $con = new ConexionMysql();
            $select = "SELECT * FROM cargo WHERE id_cargo = '$id'";
            $res = $con->consultar($select);
            $con->cerrar();
            if($res == null){
                return null;
            }else if($res->num_rows > 0){
                $datos = [];
                while($row = $res->fetch_assoc()){
                    $datos[] = $row;
                }
                return $datos;
            }else{
                return null;
            }
        }

        public function insertarCargo(){
            $con = new ConexionMysql();
            $select = "SELECT max(CAST(id_cargo as UNSIGNED)) as id FROM cargo";
            $rs = $con->consultar($select);
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $row = $rs->fetch_assoc();
                $dato = [];
                if($row["id"] > 9){
                    $num = $row["id"] + 1;
                }else{
                    $dato = explode('0', $row['id']);                
                    if($dato[count($dato) - 1] > 0){                                        
                        $num = $dato[count($dato) - 1] + 1;                     
                    }else{
                        $num = 1; 
                    }
                }           
                if($num > 9){
                    $this->id_cargo = $num ;
                }else{
                    $this->id_cargo = "0". $num ;
                }
                $action = "INSERT INTO cargo VALUES ('$this->id_cargo',
                '$this->cargo',
                '01')";
                $res = $con->ejecutar($action);
                $con->cerrar();
                return $res;
            }else{
                return null;
            }        
        }

        public function modificarDatos(){
            $con = new ConexionMysql();
            $action = "UPDATE cargo 
            SET cargo = '$this->cargo'            
            WHERE id_cargo = $this->id_cargo";
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public static function modificarEstado($id){
            $con = new ConexionMysql();
            $action = "UPDATE cargo
            SET id_estado = '02'
            WHERE id_cargo = '$id'";        
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public function buscarEliminados(){
            $con = new ConexionMysql();
            $select = "SELECT * FROM cargo WHERE id_estado = '02'";
            $res = $con->consultar($select);
            $con->cerrar();
            if($res == null){
                return null;
            }else if($res->num_rows > 0){
                $datos = [];
                while($row = $res->fetch_assoc()){
                    $datos[] = $row;
                }
                return $datos;
            }else{
                return null;
            }
        }

        public function restaurarCargo($id){
            $con = new ConexionMysql();
            $datos = $this->buscarXID($id);
            $select = "SELECT * FROM cargo
            WHERE id_estado = '01' AND cargo = '{$datos[0]["cargo"]}'";
            $rs = $con->consultar($select);
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $con->cerrar();
                return false;
            }else{
                $action = "UPDATE cargo
                SET id_estado = '01'
                WHERE id_cargo = '$id'";        
                $res = $con->ejecutar($action);
                $con->cerrar();
                return $res;
            }
        }
    }
?>