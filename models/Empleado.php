<?php 
    require_once '../database/ConexionMysql.php';

    class Empleado{
        public $id_empleado;
        public $documento;
        public $nombres;
        public $apellidos;
        public $sede;
        public $cargo;
        public $estado;
        
        public function consultarDatos(){
            $con = new ConexionMysql();
            $select = "SELECT e.id_empleado, e.documento, e.nombres, e.apellidos, s.sede, c.cargo 
            FROM empleado e 
            INNER JOIN sede s on e.id_sede = s.id_sede
            INNER JOIN cargo c on e.id_cargo = c.id_cargo
            WHERE e.id_estado = '01'
            ORDER BY s.sede, c.cargo";
            $rs = $con->consultar($select);
            $con->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $datos = [];
                while($row = $rs->fetch_assoc()){
                    $datos[] = $row;                
                }
                return $datos;
            }else{
                return null;
            }   
        }

        public static function buscarXID($id){
            $con = new ConexionMysql();
            $select = "SELECT id_empleado, documento, nombres, apellidos, id_sede, id_cargo 
            FROM empleado 
            WHERE id_empleado = '$id'";
            $rs = $con->consultar($select);
            $con->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $datos = [];
                while($row = $rs->fetch_assoc()){
                    $datos[] = $row;
                }
                return $datos;
            }else{
                return null;
            }   
        }
        
        public static function buscarXSede($sede){
            $con = new ConexionMysql();
            $select = "SELECT id_empleado, documento, nombres, apellidos, id_sede, id_cargo 
            FROM empleado 
            WHERE id_estado = '01' AND id_sede = '$sede'";
            $rs = $con->consultar($select);
            $con->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $datos = [];
                while($row = $rs->fetch_assoc()){
                    $datos[] = $row;
                }
                return $datos;
            }else{
                return null;
            }   
        }

        public function insertarEmpleado(){
            $con = new ConexionMysql();
            $select = "SELECT max(CAST(id_empleado as UNSIGNED)) as id FROM empleado";
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
                    $this->id_empleado = $num ;
                }else{
                    $this->id_empleado = "0". $num ;
                }
                $action = "INSERT INTO empleado VALUES ('$this->id_empleado',
                '$this->documento',
                '$this->nombres',
                '$this->apellidos',
                '$this->sede',
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
            $action = "UPDATE empleado 
            SET documento = '$this->documento', 
            nombres = '$this->nombres', 
            apellidos = '$this->apellidos', 
            id_sede = '$this->sede', 
            id_cargo = '$this->cargo' 
            WHERE id_empleado = $this->id_empleado";
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public static function modificarEstado($id){
            $con = new ConexionMysql();
            $action = "UPDATE empleado
            SET id_estado = '02'
            WHERE id_empleado = '$id'";        
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public static function buscarDocumento(){
            $con = new ConexionMysql();
            $select = "SELECT id_empleado,
            documento 
            FROM empleado
            WHERE id_estado = '01'";
            $rs = $con->consultar($select);
            $con->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $datos = [];
                while($row = $rs->fetch_assoc()){
                    $datos[] = $row;            
                }
                return $datos;
            }else{
                return null;
            }               
        }

        public function buscarEliminados(){
            $con = new ConexionMysql();
            $select = "SELECT e.id_empleado, e.documento, e.nombres, e.apellidos, s.sede, c.cargo 
            FROM empleado e 
            INNER JOIN sede s on e.id_sede = s.id_sede
            INNER JOIN cargo c on e.id_cargo = c.id_cargo
            WHERE e.id_estado = '02'";           
            $rs = $con->consultar($select);
            $con->cerrar();
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $datos = [];
                while($row = $rs->fetch_assoc()){
                    $datos[] = $row;                
                }
                return $datos;
            }else{
                return null;
            }
        }

        public function restaurarEmpleado($id){
            $con = new ConexionMysql();
            $datos = $this->buscarXID($id);
            $select = "SELECT * FROM empleado
            WHERE id_estado = '01' AND documento = '{$datos[0]["documento"]}' AND id_sede = '{$datos[0]["id_sede"]}'";
            $rs = $con->consultar($select);
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $con->cerrar();
                return false;
            }else{
                $action = "UPDATE empleado
                SET id_estado = '01'
                WHERE id_empleado = '$id'";        
                $res = $con->ejecutar($action);
                $con->cerrar();
                return $res;
            }
        }
    }
?>