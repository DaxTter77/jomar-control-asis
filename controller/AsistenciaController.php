<?php 
    session_start();
    require_once '../models/Asistencia.php';
    require_once '../controller/Check.php';

    class AsistenciaController{

        public function __construct(){
            $action = isset($_GET['action']) ? $_GET["action"] : "todos";
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                include '../views/administrador/login.php';
                return;
            }
            if(method_exists($this, $action)){
                $this->$action();
            }else{
                $this->error();
            }
        }

        public function todos($msg = ""){            
            $asis = new Asistencia();
            $datos = $asis->consultarDatos();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/asistencia/index.php";
        }

        public function insertar(){
            $asis = new Asistencia();  
            $datos = $asis->consultarDatos();   
            include '../views/asistencia/insertar.php';
        }
    
        public function guardarInser(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }            
            $asis = new Asistencia();        
            $asis->asistencia = $_POST["asistencia"];
            $asis->siglas = $_POST["sigla"];           
            $res = $asis->insertarAsis();
            if($res){
                $msg = "1";
            }else{            
                $msg = "0";
            }
    
            echo $msg;
        }
    
        public function editar(){            
            $id_asis = isset($_GET["id_asis"]) ? $_GET["id_asis"] : " ";
            $asistencia = Asistencia::buscarXID($id_asis);
            $datos = Asistencia::consultarDatos();
            if($asistencia == null){
                $this->todos("No se encontro asistencia");
            }else{
                include '../views/asistencia/editar.php';
            }
        }
    
        public function guardarEdit(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $asis = new Asistencia();
            $asis->id_asistencia = $_POST["id"];
            $asis->asistencia = $_POST["asistencia"];
            $asis->siglas = $_POST["sigla"];            
            
            $res = $asis->modificarDatos();
    
            if($res){
                $msg = "1";
            }else{            
                $msg = "0";
            }
    
            echo $msg;
        }
    
        public function eliminar(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $id_asis = isset($_GET["id_asis"]) ? $_GET["id_asis"] : -1;

            if($id_asis == "10"){
                $msg = "0";
            }else{
                $res = Asistencia::eliminarDatos($id_asis);
                if($res){
                    $msg = "1";
                }else{            
                    $msg = "0";
                }
            }
            echo $msg;
        }

        public function error(){            
            include "../views/error/404.php";
        }
    }
    new AsistenciaController();    
?>