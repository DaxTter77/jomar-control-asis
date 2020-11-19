<?php 
    require_once '../database/ConexionMysql.php';

    class Sede{
        public $id_sede;
        public $sede;
        public $estado;

        public function consultarDatos(){
            $con = new ConexionMysql();
            $select = "SELECT * FROM sede WHERE id_estado = '01'";
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
            $select = "SELECT * FROM sede WHERE id_sede = '$id'";
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

        public function insertarSede(){
            $con = new ConexionMysql();
            $select = "SELECT max(CAST(id_sede as UNSIGNED)) as id FROM sede";
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
                    $this->id_sede = $num ;
                }else{
                    $this->id_sede = "0". $num ;
                }
                $action = "INSERT INTO sede VALUES ('$this->id_sede',
                '$this->sede',
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
            $action = "UPDATE sede 
            SET sede = '$this->sede'            
            WHERE id_sede = $this->id_sede";
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public static function modificarEstado($id){
            $con = new ConexionMysql();
            $action = "UPDATE sede
            SET id_estado = '02'
            WHERE id_sede = '$id'";        
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public function buscarEliminados(){
            $con = new ConexionMysql();
            $select = "SELECT * FROM sede WHERE id_estado = '02'";
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

        public function restaurarSede($id){
            $con = new ConexionMysql();
            $datos = $this->buscarXID($id);
            $select = "SELECT * FROM sede
            WHERE id_estado = '01' AND sede = '{$datos[0]["sede"]}'";
            $rs = $con->consultar($select);
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $con->cerrar();
                return false;
            }else{
                $action = "UPDATE sede
                SET id_estado = '01'
                WHERE id_sede = '$id'";        
                $res = $con->ejecutar($action);
                $con->cerrar();
                return $res;
            }
        }
    }
?>

