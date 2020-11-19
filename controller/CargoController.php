<?php
    session_start();
    require_once '../models/Cargo.php';
    require_once '../controller/Check.php';

    class CargoController{
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
            $cargo = new Cargo();
            $datos = $cargo->consultarDatos();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/cargo/index.php";
        }

        public function insertar(){
            $cargo = new Cargo();  
            $datos = $cargo->consultarDatos();   
            include '../views/cargo/insertar.php';
        }
    
        public function guardarInser(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $cargo = new Cargo();        
            $cargo->cargo = $_POST["cargo"];            
            $res = $cargo->insertarCargo();
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }
            echo $msg;
        }
    
        public function editar(){
            $id_cargo = isset($_GET["id_cargo"]) ? $_GET["id_cargo"] : " ";
            $cargo = Cargo::buscarXID($id_cargo);
            $datos = Cargo::consultarDatos();
            if($cargo == null){
                $this->todos("No se encontro cargo");
            }else{
                include '../views/cargo/editar.php';
            }
        }
    
        public function guardarEdit(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $cargo = new Cargo();
            $cargo->id_cargo = $_POST["id"];
            $cargo->cargo = $_POST["cargo"];                     
            
            $res = $cargo->modificarDatos();
    
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
            $id_cargo = isset($_GET["id_cargo"]) ? $_GET["id_cargo"] : -1;
            $res = Cargo::modificarEstado($id_cargo);
    
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }
            echo $msg;
        }

        public function eliminados($msg = ""){
            $cargo = new Cargo();
            $datos = $cargo->buscarEliminados();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/cargo/eliminados.php";
        }
    
        public function restaurarCargo(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $id_cargo = isset($_GET["id_cargo"]) ? $_GET["id_cargo"] : -1;
            $cargo = new Cargo();
            $res = $cargo->restaurarCargo($id_cargo);
    
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
    new CargoController();        
?>