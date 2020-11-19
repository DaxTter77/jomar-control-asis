<?php
require_once '../database/ConexionMysql.php';

class Administrador{

    public $id_admin;
    public $nombres;
    public $apellidos;
    public $correo;
    public $usuario;
    public $clave;
    public $estado;
    
    public function consultarDatos(){
        $con = new ConexionMysql();
        $select = "SELECT id_admin, 
        nombres, 
        apellidos,
        correo,
        usuario 
        FROM administradores 
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

    public static function validarAdmin($usuario, $clave){
        $con = new ConexionMysql();
        $select = "SELECT *
        FROM administradores 
        WHERE id_estado = '01' AND usuario = '$usuario' AND clave = '$clave'";         
        $rs = $con->consultar($select);
        $con->cerrar();
        if($rs == null){
            return null;
        }else if($rs->num_rows > 0){            
            return $rs->fetch_assoc();
        }else{
            return null;
        }
    }

    public static function buscarXID($id){
        $con = new ConexionMysql();
        $select = "SELECT id_admin, 
        nombres, 
        apellidos,
        correo,
        usuario 
        FROM administradores 
        WHERE id_admin = '$id'";
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

    public function insertarAdmin(){
        $con = new ConexionMysql();
        $select = "SELECT max(CAST(id_admin as UNSIGNED)) as id FROM administradores";
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
                $this->id_admin = $num ;
            }else{
                $this->id_admin = "0". $num ;
            }
            $action = "INSERT INTO administradores VALUES ('$this->id_admin',
            '$this->nombres',
            '$this->apellidos',
            '$this->correo',
            '$this->usuario',
            '$this->clave',
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
        $action = "UPDATE administradores 
        SET nombres = '$this->nombres', 
        apellidos = '$this->apellidos', 
        correo = '$this->correo', 
        usuario = '$this->usuario' 
        WHERE id_admin = $this->id_admin";
        $res = $con->ejecutar($action);
        $con->cerrar();
        return $res;
    }

    public static function modificarEstado($id){
        $con = new ConexionMysql();
        $action = "UPDATE administradores
        SET id_estado = '02'
        WHERE id_admin = '$id'";        
        $res = $con->ejecutar($action);
        $con->cerrar();
        return $res;
    }

    public static function buscarUsuario(){
        $con = new ConexionMysql();
        $select = "SELECT id_admin,
        usuario 
        FROM administradores
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
    
    public static function buscarCorreo(){
        $con = new ConexionMysql();
        $select = "SELECT id_admin,
        correo 
        FROM administradores
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

    public function cambiarContra($passAnt, $newPass, $id){
        $con = new ConexionMysql();
        $select = "SELECT id_admin, clave FROM administradores WHERE id_admin = '$id'";
        $rs = $con->consultar($select);        
        if($rs == null){
            return null;
        }else if($rs->num_rows > 0){
            $row = $rs->fetch_assoc();                        
            if($row["clave"] === $passAnt){
                $action = "UPDATE administradores SET clave = '$newPass' WHERE id_admin = '$id'";
                $res = $con->ejecutar($action);
                $con->cerrar();                
                return $res;
            }else{
                return null;
            }
        }else{
            return null;            
        }
    }

    public function buscarEliminados(){
        $con = new ConexionMysql();
        $select = "SELECT id_admin, 
        nombres, 
        apellidos,
        correo,
        usuario 
        FROM administradores 
        WHERE id_estado = '02'";         
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

    public function restaurarAdmin($id){
        $con = new ConexionMysql();
        $datos = $this->buscarXID($id);
        $select = "SELECT * FROM administradores 
        WHERE id_estado = '01' AND correo = '{$datos[0]['correo']}' AND usuario = '{$datos[0]['usuario']}'";
        $rs = $con->consultar($select);
        if($rs == null){
            return null;
        }else if($rs->num_rows > 0){
            $con->cerrar();
            return false;
        }else{
            $action = "UPDATE administradores
            SET id_estado = '01'
            WHERE id_admin = '$id'";        
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }
    }

    public static function verificarRes($usuario, $correo){
        $con = new ConexionMysql();
        $select = "SELECT *
        FROM administradores 
        WHERE id_estado = '01' AND usuario = '$usuario' AND correo = '$correo'";         
        $rs = $con->consultar($select);
        $con->cerrar();
        if($rs == null){
            return null;
        }else if($rs->num_rows > 0){            
            return $rs->fetch_assoc();
        }else{
            return null;
        }
    }

    public function nuevaClave($newPass, $id){
        $con = new ConexionMysql();    
        $action = "UPDATE administradores SET clave = '$newPass' WHERE id_admin = '$id'";
        $res = $con->ejecutar($action);
        $con->cerrar();                
        return $res;         
    }
}