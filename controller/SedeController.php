<?php 
    session_start();
    require_once '../models/Sede.php';
    require_once '../controller/Check.php';

    class SedeController{
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
            $sede = new Sede();
            $datos = $sede->consultarDatos();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/sede/index.php";
        }

        public function insertar(){            
            $sede = new Sede();  
            $datos = $sede->consultarDatos();   
            include '../views/sede/insertar.php';
        }
    
        public function guardarInser(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $sede = new Sede();        
            $sede->sede = $_POST["sede"];            
            $res = $sede->insertarSede();
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }
            echo $msg;
        }
    
        public function editar(){            
            $id_sede = isset($_GET["id_sede"]) ? $_GET["id_sede"] : " ";
            $sede = Sede::buscarXID($id_sede);
            $datos = Sede::consultarDatos();
            if($sede == null){
                $this->todos("No se encontro sede");
            }else{
                include '../views/sede/editar.php';
            }
        }
    
        public function guardarEdit(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $sede = new Sede();
            $sede->id_sede = $_POST["id"];
            $sede->sede = $_POST["sede"];                     
            
            $res = $sede->modificarDatos();
    
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
            $id_sede = isset($_GET["id_sede"]) ? $_GET["id_sede"] : -1;
            $res = Sede::modificarEstado($id_sede);
    
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }
            echo $msg;
        }

        public function eliminados($msg = ""){                        
            $sede = new Sede();
            $datos = $sede->buscarEliminados();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/sede/eliminados.php";
        }
    
        public function restaurarSede(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $id_sede = isset($_GET["id_sede"]) ? $_GET["id_sede"] : -1;
            $sede = new Sede();
            $res = $sede->restaurarSede($id_sede);
    
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }
            echo $msg;
        }

        public function error(){            
            include "../views/error/404.php";
        }
    }
    new SedeController();    
?>