<?php
    require_once '../models/Administrador.php';
    require_once '../config/PHPMailer/PHPMailerAutoload.php';
    require_once '../controller/Check.php';

    class AdminController{
        
        public function __construct(){
            $action = isset($_GET["action"]) ? $_GET["action"] : "todos";
            
            session_start();

            if($action == "enviarCorreoMail" || $action == "enviarCorreo" || $action == "generarCodigo"){
                $this->login();
            }else{
                if(method_exists($this, $action)){
                    $this->$action();
                }else{
                    $this->error();
                }
            }

        }

        public function todos($msg = ""){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $admin = new Administrador();
            $datos = $admin->consultarDatos();
            include '../views/administrador/index.php';
        }

        public function devolverTodos(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            
            $admin = new Administrador();
            $datos = $admin->consultarDatos();
            echo json_encode($datos);
        }
        public function login(){

            if(isset($_SESSION["login"]) && $_SESSION["login"]){        
                $this->menu();      
                return;
            }
            if(isset($_POST["usuario"])){
                $usuario = $_POST["usuario"];
                $clave = md5($_POST["clave"]);

                $admin = Administrador::validarAdmin($usuario, $clave);

                if($admin != null){
                    $_SESSION["login"] = true;
                    $_SESSION["usuario"] = $admin;                
                    include '../views/menu/index.php';
                }
            }else{            
                include '../views/administrador/login.php';
            }
        }

        public function verificarLogin(){
            $check = new Check();
            if(!$check->isAjax()){
                include '../views/administrador/index.php';
                return;
            }
            $usuario = $_POST["usuario"];
            $clave = md5($_POST["clave"]);

            $admin = Administrador::validarAdmin($usuario, $clave);

            if($admin != null){
                echo "1";
            }else{
                echo "0";
            }
        }

        public function logout(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $_SESSION["login"] = false;
            $_SESSION["msg"] = "Se ha cerrado la sesión";
            session_destroy();
            $this->login();
        }

        public function restablecer($msg = ""){
            if(isset($_SESSION["login"])){            
                    $this->menu();
                    return;            
            }  
            if(isset($_SESSION["codigo"])){
                session_destroy();
            }
            $_SESSION["codigo"] = null;      
            include '../views/administrador/restablecerClave.php';        
            
        }

        public function menu(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $datos = Administrador::buscarXID($_SESSION["usuario"]["id_admin"]);
            $_SESSION["usuario"] = $datos[0];
            include '../views/menu/index.php';
        }
        
        public function registrar(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $admin = new Administrador();
            $usuario = $admin->buscarUsuario();
            $correo = $admin->buscarCorreo();
            include '../views/administrador/insertar.php';
        }
        
        public function guardarInser(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $check = new Check();
            if(!$check->isAjax()){
                include '../views/administrador/index.php';
                return;
            }
            $admin = new Administrador();        
            $admin->nombres = $_POST["nombres"];
            $admin->apellidos = $_POST["apellidos"];
            $admin->correo = $_POST["correo"];
            $admin->usuario = $_POST["usuario"];
            $confirmClave = $_POST["confirmClave"];
            $admin->clave = md5($_POST["clave"]);
            $res = $admin->insertarAdmin();
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }
            echo $msg;
        }

        public function editar(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $id_admin = isset($_GET["id_admin"]) ? $_GET["id_admin"] : " ";
            $admin = Administrador::buscarXID($id_admin);
            $usuario = Administrador::buscarUsuario();
            $correo = Administrador::buscarCorreo();
            if($admin == null){
                $this->todos("No se encontro administrador");
            }else{
                include '../views/administrador/editar.php';
            }
        }

        public function guardarEdit(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $check = new Check();
            if(!$check->isAjax()){
                include '../views/administrador/index.php';
                return;
            }
            $admin = new Administrador();
            $admin->id_admin = $_POST["id"];
            $admin->nombres = $_POST["nombres"];
            $admin->apellidos = $_POST["apellidos"];
            $admin->correo = $_POST["correo"];
            $admin->usuario = $_POST["usuario"];
            
            $res = $admin->modificarDatos();

            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }

            echo $msg;
        }

        public function eliminar(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $check = new Check();
            if(!$check->isAjax()){
                include '../views/administrador/index.php';
                return;
            }
            $id_admin = isset($_GET["id_admin"]) ? $_GET["id_admin"] : -1;        
            if($id_admin == $_SESSION["usuario"]["id_admin"] || $id_admin == "01"){
                $msg = "0";
            }else{
                $res = Administrador::modificarEstado($id_admin);        
                if($res){
                    $msg = "1";
                }else{            
                    $msg = "0";
                }        
            }

            echo $msg;
        }

        public function cambiar($msg = ""){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $id_admin = isset($_GET["id_admin"]) ? $_GET["id_admin"] : -1;
            include '../views/administrador/cambiarClave.php';
        }

        public function cambiarContra(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            if($_POST){
                $admin = new Administrador();
                $id_admin = $_POST["id_admin"];
                $claveNew = md5($_POST["nueva"]);
                $claveAnt = md5($_POST["actual"]);
        
                $res = $admin->cambiarContra($claveAnt, $claveNew, $id_admin);        
                if($res){
                    $msg = "Se ha cambiado la clave satisfactoriamente";
                }else{
                    $msg = "No se ha podido cambiar la clave";
                }
        
                $this->cambiar($msg);
            }else{
                $this->menu();
            }
        }

        public function eliminados($msg = ""){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $admin = new Administrador();
            $datos = $admin->buscarEliminados();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/administrador/eliminados.php";
        }

        public function restaurarAdmin(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            $check = new Check();
            if(!$check->isAjax()){
                include '../views/administrador/index.php';
                return;
            }
            $id_admin = isset($_GET["id_admin"]) ? $_GET["id_admin"] : -1;
            $admin = new Administrador();
            $res = $admin->restaurarAdmin($id_admin);

            if($res){
                $msg = "1";
            }else{            
                $msg = "0";
            }

            echo $msg;
        }
        
        public function verificarRes(){   
            if(isset($_SESSION["login"])){            
                    $this->menu();
                    return;            
            }

            if(isset($_POST["usuario"])){
                $usuario = $_POST["usuario"];
                $correo = $_POST["correo"];
                
                $admin = Administrador::verificarRes($usuario, $correo);            
                if($admin != null){
                    if($_SESSION["codigo"] == null){                    
                        $_SESSION["codigo"] = $this->generarCodigo();
                        //$this->enviarCorreoMail($correo, $_SESSION["codigo"]);
                        $this->enviarCorreo($correo, $_SESSION["codigo"]);
                    }
                    include '../views/administrador/codigoRes.php';
                }else{
                    $msg = "Usuario o Correo no coincidentes";
                    $this->restablecer($msg);
                }
            }else if(isset($_POST["codInser"])) {
                $codInser = $_POST["codInser"];            
                if($_SESSION["codigo"] != $codInser){
                    echo "<ul><li> El codigo es incorrecto </li></ul>";
                }else{
                    echo "";
                }
            }else{
                $this->menu();
                return;
            }
        }

        public function enviarCorreo($correo, $codigo){
            if(isset($_SESSION["login"])){            
                    $this->menu();
                    return;
            }
            $userMail = "dylrc12@gmail.com";
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com; smtp.live.com';
            //$mail->SMTPDebug  = 2;
            $mail->SMTPAuth = true;
            $mail->Username = $userMail;
            $mail->Password = "dylanrestrepoc123123";
            $mail->AuthType = 'LOGIN';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->setFrom($userMail, "Jomar Inversiones SA");
            $mail->addReplyTo($userMail, "Jomar Inversiones SA");        
            $mail->addAddress($correo);
            $message = utf8_decode(file_get_contents("../views/administrador/templateEmail.html"));
            $message = str_replace('{{codigo}}', $codigo, $message);
            $mail->isHTML(true);

            $mail->Subject = "Solicitud para restablecer clave";
            $mail->msgHTML($message);     
            $mail->send();   
        }

        public function enviarCorreoMail($correo, $codigo){
            if(isset($_SESSION["login"])){
                    $this->menu();
                    return;            
            }

            $email_to = $correo;
            $email_subject = "Restablecer clave";
            $email_message = utf8_decode(file_get_contents("../views/administrador/templateEmail.html"));
            $email_message = str_replace('{{codigo}}', $codigo, $email_message);
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            /*$headers .= "From: jomar_control@jomarcontrol.com \r\n
            Reply-To jomar_control@jomarcontrol.com \r\n
            X-Mailer: PHP/". phpversion();*/

            if(! @mail($email_to, $email_subject, $email_message, $headers)){
                echo $errorMessage = error_get_last()['message'];
            }
            
        }

        private function generarCodigo() {
            if(isset($_SESSION["login"])){            
                $this->menu();
                return;            
            }
            $key = '';
            $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
            $max = strlen($pattern)-1;
            for($i=0;$i < 4;$i++) $key .= $pattern{mt_rand(0,$max)};
            return $key;
        }

        public function nueva($error = ""){    
            if(isset($_SESSION["login"])){            
                    $this->menu();
                    return;            
            }

            if(isset($_POST["id_admin"])) {
                $id_admin = $_POST["id_admin"];
                session_destroy();
                include '../views/administrador/nuevaClave.php';
            }else{
                $this->login();
            }
            
        }

        public function nuevaContra(){
            if(isset($_SESSION["login"])){            
                    $this->menu();
                    return;            
            }
            if($_POST){
                $nueva = md5($_POST["nueva"]);
                $id_admin = $_POST["id_admin"];
        
                $admin = new Administrador();
                $res = $admin->nuevaClave($nueva, $id_admin);
                if($res){
                    $this->login();
                }else{
                    $error = "Ocurrió un error";
                    $this->nueva($error);
                }
            }else{
                $this->login();
            }
        }

        public function error(){
            if(!isset($_SESSION["login"]) || !$_SESSION["login"]){
                $this->login();
                return;
            }
            include "../views/error/404.php";
        }
        
    }

    new AdminController();
