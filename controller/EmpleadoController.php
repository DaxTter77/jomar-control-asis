<?php 
    session_start();
    require_once '../models/Empleado.php';
    require_once '../models/Sede.php';
    require_once '../models/Cargo.php';
    require_once '../controller/Check.php';

    class EmpleadoController{
    
        public function __construct(){
            $action = isset($_GET["action"]) ? $_GET["action"] : "todos";
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
            $empleado = new Empleado();            
            $datos = $empleado->consultarDatos();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/empleado/index.php";
        }
        
        public function registrar(){
            
            $empleado = new Empleado();
            $sede = new Sede();
            $cargo = new Cargo();
            $sedes = $sede->consultarDatos(); 
            $cargos = $cargo->consultarDatos(); 
            $documentos = $empleado->buscarDocumento();
            include '../views/empleado/insertar.php';
        }
    
        public function guardarInser(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $empleado = new Empleado();                    
            $empleado->documento = $_POST["documento"];
            $empleado->nombres = $_POST["nombres"];
            $empleado->apellidos = $_POST["apellidos"];
            $empleado->sede = $_POST["sede"];
            $empleado->cargo = $_POST["cargo"];     
            $res = $empleado->insertarEmpleado();
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }
            echo $msg;
        }
    
        public function editar(){
            $id_empleado = isset($_GET["id_empleado"]) ? $_GET["id_empleado"] : " ";
            $sede = new Sede();
            $cargo = new Cargo();
            $sedes = $sede->consultarDatos();            
            $cargos = $cargo->consultarDatos();            
            $empleado = Empleado::buscarXID($id_empleado);            
            $documento = Empleado::buscarDocumento();
            if($empleado == null){
                $this->todos("No se encontro empleado");
            }else{
                include '../views/empleado/editar.php';
            }
        }
    
        public function guardarEdit(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            } 
            $empleado = new Empleado();
            $empleado->id_empleado = $_POST["id"];
            $empleado->documento = $_POST["documento"];
            $empleado->nombres = $_POST["nombres"];
            $empleado->apellidos = $_POST["apellidos"];
            $empleado->sede = $_POST["sede"];
            $empleado->cargo = $_POST["cargo"];
            
            $res = $empleado->modificarDatos();
    
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
            $id_empleado = isset($_GET["id_empleado"]) ? $_GET["id_empleado"] : -1;
            $res = Empleado::modificarEstado($id_empleado);
    
            if($res){
                $msg = "1";
            }else{            
                $msg = "0";
            }
    
            echo $msg;
        }    
    
        public function eliminados($msg = ""){            
            $empleado = new Empleado();
            $datos = $empleado->buscarEliminados();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/empleado/eliminados.php";
        }
    
        public function restaurarEmpleado(){   
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $id_empleado = isset($_GET["id_empleado"]) ? $_GET["id_empleado"] : -1;
            $empleado = new Empleado();
            $res = $empleado->restaurarEmpleado($id_empleado);
    
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
    new EmpleadoController();
    
?>

