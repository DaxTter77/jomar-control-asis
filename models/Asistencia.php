<?php 
    require_once '../database/ConexionMysql.php';

    class Asistencia{
        public $id_asistencia;
        public $asistencia;
        public $siglas;
        
        public function consultarDatos(){
            $con = new ConexionMysql();
            $select = "SELECT * FROM asistencia ORDER BY id_asistencia ASC";
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
            $select = "SELECT * FROM asistencia WHERE id_asistencia = '$id'";
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

        public function insertarAsis(){
            $con = new ConexionMysql();
            $select = "SELECT max(CAST(id_asistencia as UNSIGNED)) as id FROM asistencia";
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
                    $this->id_asistencia = $num ;
                }else{
                    $this->id_asistencia = "0". $num ;
                }
                $action = "INSERT INTO asistencia VALUES ('$this->id_asistencia',
                '$this->asistencia',
                '$this->siglas')";
                $res = $con->ejecutar($action);
                $con->cerrar();
                return $res;
            }else{
                return null;
            }        
        }

        public function modificarDatos(){
            $con = new ConexionMysql();
            $action = "UPDATE asistencia 
            SET asistencia = '$this->asistencia', 
            siglas = '$this->siglas'                         
            WHERE id_asistencia = $this->id_asistencia";
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public function eliminarDatos($id){
            $con = new ConexionMysql();
            $action = "DELETE FROM asistencia WHERE id_asistencia = $id";
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }
    }
?>