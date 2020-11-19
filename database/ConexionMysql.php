<?php
require_once '../config/db.php';

class ConexionMysql{
    private $con = null;

    function __construct(){
        $this->con = new mysqli(HOST, USER, PASS, DB);
        $this->con->set_charset(CHARSET);
    }

    public function consultar($select){
        $res = $this->con->query($select);
        return $res;
    }

    public function ejecutar($action){
        $res = $this->con->query($action);
        if($res == 1){
            return true;
        }else{
            return false;
        }
    }

    public function cerrar(){
        $this->con->close();
    }
}


