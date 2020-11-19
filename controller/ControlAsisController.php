<?php 
    session_start();
    require_once '../models/ControlAsistencia.php';
    require_once '../models/Empleado.php';
    require_once '../models/Asistencia.php';
    require_once '../models/Sede.php';
    require_once '../controller/Festivos.php';
    require_once '../controller/Check.php';
    class ControlAsisController{
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
            $year = date("Y");
            $month = date("m");
            if(isset($_GET["mes"]) && isset($_GET["ano"])){
                $mes = $_GET["mes"];
                $ano = $_GET["ano"];
            }else if(isset($_GET["fecha"])){
                $fecha = $_GET["fecha"];

                $date = explode("-", $fecha);
                $dia = $date[2];
                $mes = $date[1];
                $ano = $date[0];
                if(isset($_GET["hasta"])){
                    $hasta = $_GET["hasta"];
                    $fechaHasta = "$ano-$mes-$hasta";
                }
            }else{
                $mes = $month;
                $ano = $year;
            }

            if(isset($_GET["sede"])){
                $sedeSelect = $_GET["sede"];
            }
            if (isset($_GET["sigla"])) {
                $siglaSelect = []; 
                $siglaSelect = explode("-", $_GET["sigla"]);
            }
            $controlAsis = new ControlAsistencia();
            $sede = new Sede();
            $asistencia = new Asistencia();
            $sedes = $sede->consultarDatos();
            $asistencias = $asistencia->consultarDatos();
            
            if(isset($fechaHasta)){
                if(isset($sedeSelect) && !isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSedeHasta($sedeSelect, $fecha, $fechaHasta);
                }else if(!isset($sedeSelect) && isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSiglaHasta($siglaSelect, $fecha, $fechaHasta);
                }else if(isset($sedeSelect) && isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSedeSiglaHasta($sedeSelect, $siglaSelect, $fecha, $fechaHasta);
                }else{
                    $datos = $controlAsis->consultarFechaHasta($fecha, $fechaHasta);
                }
            }else if(isset($fecha)){
                if(isset($sedeSelect) && !isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSedeFecha($sedeSelect, $fecha);
                }else if(!isset($sedeSelect) && isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSiglaFecha($siglaSelect, $fecha);
                }else if(isset($sedeSelect) && isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSedeSiglaFecha($sedeSelect, $siglaSelect, $fecha);
                }else{
                    $datos = $controlAsis->consultarDatosFecha($fecha);
                }
            }else{
                if(isset($sedeSelect) && !isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSedeMes($sedeSelect, $mes, $ano);            
                }else if(!isset($sedeSelect) && isset($siglaSelect)){            
                    $datos = $controlAsis->consultarXSiglaMes($siglaSelect, $mes, $ano);
                }else if(isset($sedeSelect) && isset($siglaSelect)){
                    $datos = $controlAsis->consultarXSedeSiglaMes($sedeSelect, $siglaSelect, $mes, $ano);
                }else{
                    $datos = $controlAsis->consultarDatos($mes, $ano);
                }
            }
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/control_asistencia/index.php";
        }

        public function llenarDias(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $mes = $_POST["mes"];
            $ano = $_POST["ano"];
            if(isset($_POST["dia"])){
                $dia = $_POST["dia"];
            }

            $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
            $html = "<option value='0'>Día</option>";        
            for($i=1; $i <= $dias; $i++){
                if($i >= 10){
                    $html .= "<option value='$i'>$i</option>";                
                }else{
                    $html .= "<option value='0$i'>0$i</option>";                
                }
            }
            echo $html;
        }
        
        public function registrar(){
            
            $controlAsis = new ControlAsistencia();        
            $asistencia = new Asistencia();
            $sede = new Sede();
            $sedes = $sede->consultarDatos();        
            $asistencias = $asistencia->consultarDatos();         
            include '../views/control_asistencia/insertar.php';
        }

        public function llenarEmpleados(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $sede = $_POST["sede"];
            $fecha = $_POST["fecha"];
            if(isset($_POST["empleado"])){
                $emp = $_POST["empleado"];
            }
            $empleado = new Empleado();
            $registros = ControlAsistencia::buscarFecha($fecha, $sede);
            $empleados = $empleado->buscarXSede($sede);
            if($empleados != null){
                $html = "";            
                $cantidad = 0;
                if($registros != null){
                    if(count($empleados) > count($registros) ){
                        $cantidad = count($empleados); 
                    }else{
                        $cantidad = count($registros);
                    }

                    for ($i=0, $j= 0; $i < $cantidad; $i++) {   
                        if(isset($emp)){
                            if($empleados[$i]["id_empleado"] == $emp){
                                $html .= "<option value='{$empleados[$i]['id_empleado']}' selected>{$empleados[$i]['nombres']} {$empleados[$i]['apellidos']}</option>";
                                $j++;
                                $i++;
                            }
                        }                 
                        if($empleados[$i]["id_empleado"] == $registros[$j]['id_empleado']){
                            $j++;
                        }else{
                            $html .= "<option value='{$empleados[$i]['id_empleado']}'>{$empleados[$i]['nombres']} {$empleados[$i]['apellidos']}</option>";
                        }
                    }
                }else{
                    for ($i=0; $i < count($empleados); $i++) {                     
                        $html .= "<option value='{$empleados[$i]['id_empleado']}'>{$empleados[$i]['nombres']} {$empleados[$i]['apellidos']}</option>";                    
                    }

                }
                echo $html;
            }else{
                echo "<option value='0'>No hay empleados</option>";
            }
        }

        public function guardarHasta(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $controlAsis = new ControlAsistencia();                    
            $controlAsis->fecha = $_POST["fecha"];
            $hasta = $_POST["hasta"];
            $controlAsis->empleado = $_POST["empleado"];
            $controlAsis->asistencia = $_POST["asistencia"];     
            $controlAsis->administrador = $_SESSION["usuario"]["id_admin"];        
            $controlAsis->nota = $_POST["nota"];
            $sede = $_POST["sede"];
            $cont = 0;
            $fechaPart = explode("-", $controlAsis->fecha);
            $hastaPart = explode("-", $hasta);
            while((int)$hastaPart[2] >= (int)$fechaPart[2]) { 
                $registros = ControlAsistencia::buscarFechaEmpleado($controlAsis->fecha, $sede, $controlAsis->empleado);
                if($registros != null){

                }else{
                    $res = $controlAsis->insertarControl();
                    if(!$res){
                        $cont++;
                    }
                }
                $fechaPart[2] += 1;
                $controlAsis->fecha = "{$fechaPart[0]}-{$fechaPart[1]}-{$fechaPart[2]}";
            }
            
            if($cont > 0){
                $msg = $cont;
            }else{
                $msg = "1";
            }
            echo $msg;
        }
        
        public function guardarInser(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $controlAsis = new ControlAsistencia();                    
            $controlAsis->fecha = $_POST["fecha"];
            $controlAsis->empleado = $_POST["empleado"];
            $controlAsis->asistencia = $_POST["asistencia"];     
            $controlAsis->administrador = $_SESSION["usuario"]["id_admin"];        
            $controlAsis->nota = $_POST["nota"];     
            $res = $controlAsis->insertarControl();
            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }       
            
            echo $msg;
        }

        public function guardarMulti(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $empleados = [];
            $controlAsis = new ControlAsistencia();                    
            $controlAsis->fecha = $_POST["fecha"];
            $empleados[] = $_POST["empleado"];
            $controlAsis->asistencia = $_POST["asistencia"];
            $controlAsis->administrador = $_SESSION["usuario"]["id_admin"];        
            $controlAsis->nota = ($_POST["nota"] != null) ? $_POST["nota"] : "";
            $cont = 0;
            for($i=0; $i < count($empleados[0]); $i++){
                $controlAsis->empleado = $empleados[0][$i];
                $res = $controlAsis->insertarControl();
                if(!$res){
                    $cont++;
                }
            }
            if($cont > 0){
                echo $cont;
            }else{
                echo "1";
            }
        }

        public function guardarMultiHasta(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $empleados = [];
            $controlAsis = new ControlAsistencia();                    
            $empleados[] = $_POST["empleado"];
            $hasta = $_POST["hasta"];
            $controlAsis->asistencia = $_POST["asistencia"];     
            $controlAsis->administrador = $_SESSION["usuario"]["id_admin"];        
            $controlAsis->nota = $_POST["nota"];
            $sede = $_POST["sede"];
            $cont = 0;
            for($i=0; $i < count($empleados[0]); $i++){
                $controlAsis->empleado = $empleados[0][$i];
                $controlAsis->fecha = $_POST["fecha"];
                $fechaPart = explode("-", $controlAsis->fecha);
                $hastaPart = explode("-", $hasta);
                while((int)$hastaPart[2] >= (int)$fechaPart[2]) { 
                    $registros = ControlAsistencia::buscarFechaEmpleado($controlAsis->fecha, $sede, $controlAsis->empleado);
                    if($registros != null){

                    }else{
                        $res = $controlAsis->insertarControl();
                        if(!$res){
                            $cont++;
                        }
                    }
                    $fechaPart[2] += 1;
                    $controlAsis->fecha = "{$fechaPart[0]}-{$fechaPart[1]}-{$fechaPart[2]}";
                }
            }
            
            if($cont > 0){
                $msg = $cont;
            }else{
                $msg = "1";
            }
            echo $msg;
        }

        public function editar(){
            $id_controlAsis = isset($_GET["id_controlAsis"]) ? $_GET["id_controlAsis"] : " ";
            $asistencia = new Asistencia();
            $sede = new Sede();
            $sedes = $sede->consultarDatos();        
            $asistencias = $asistencia->consultarDatos();            
            $controlAsis = ControlAsistencia::buscarXID($id_controlAsis);          
            if($controlAsis == null){
                $this->todos("No se encontro empleado");
            }else{
                include '../views/control_asistencia/editar.php';
            }
        }

        public function guardarEdit(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $controlAsis = new ControlAsistencia();
            $controlAsis->id_controlAsis = $_POST["id"];
            $controlAsis->fecha = $_POST["fecha"];
            $controlAsis->empleado = $_POST["empleado"];
            $controlAsis->asistencia = $_POST["asistencia"];                
            $controlAsis->nota = $_POST["nota"];                
            
            $res = $controlAsis->modificarDatos();

            if($res){
                $msg = "1";
            }else{
                $msg = "0";
            }

            echo $msg;
        }
        
        public function guardarEditMulti(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $controlAsis = new ControlAsistencia();
            $ids = [];
            $ids = $_POST["ids"];
            $controlAsis->asistencia = $_POST["asistencia"];
            $cont = 0;
            if($ids != null){
                for($i=0; $i < count($ids); $i++){
                    $id = $ids[$i];
                    $res = $controlAsis->modificarAsistencia($id);
                    if(!$res){
                        $cont++;
                    }
                }

                if($cont > 0){
                    $msg = $cont;
                }else{
                    $msg = "1";
                }
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
            $id_controlAsis = isset($_GET["id_controlAsis"]) ? $_GET["id_controlAsis"] : -1;
            $res = ControlAsistencia::modificarEstado($id_controlAsis);

            if($res){
                $msg = "1";
            }else{            
                $msg = "0";
            }
            echo $msg;
        }

        public function eliminarMulti(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $ids = [];
            $ids = isset($_POST["ids"]) ? $_POST["ids"] : -1;
            $cont = 0;
            for($i=0; $i < count($ids); $i++){
                $id_controlAsis = $ids[$i];
                $res = ControlAsistencia::modificarEstado($id_controlAsis);
                if(!$res){
                    $cont++;
                }
            }

            if($cont > 0){
                $msg = $cont;
            }else{
                $msg = "1";
            }
            echo $msg;
        }

        public function eliminados($msg = ""){
            
            $controlAsis = new ControlAsistencia();
            $datos = $controlAsis->buscarEliminados();
            if(isset($_POST["confirm"])){
                echo json_encode($datos);
                return;
            }
            include "../views/control_asistencia/eliminados.php";
        }    

        public function restaurarRegistro(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $controlAsis = new ControlAsistencia();
            $id_controlAsis = isset($_GET["id_controlAsis"]) ? $_GET["id_controlAsis"] : -1;
            $res = $controlAsis->restaurarRegistro($id_controlAsis);

            if($res){
                $msg = "1";
            }else{            
                $msg = "0";
            }

            echo $msg;
        }

        public function conteos(){
            $sedeMo = new Sede();        
            $sedes = $sedeMo->consultarDatos();        
            $mes = date("m");            
            include '../views/control_asistencia/conteos.php';
        }

        public function hacerConteos(){    
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $controlAsis = new ControlAsistencia();
            $festivo = new Festivos();
            $empleado = new Empleado();
            $asistencia = new Asistencia();            
            $mes = $_GET["mes"];
            $ano = $_GET["ano"];
            $sede = $_GET["sede"];
            $empleados = $empleado->buscarXSede($sede);
            $asistencias = $asistencia->consultarDatos();
            $sedeSelect = $sede;
            $datos = $controlAsis->contarAsistencia($mes, $ano, $sede);
            $domingos = $controlAsis->contarDomingos($mes, $ano, $sede);
            $totalDias = $controlAsis->contarDias($mes, $ano, $sede);
            $fechas = $controlAsis->consultarFechas($mes, $ano, $sede);            
            $festivos = [];
            for($i=0; $i < count($fechas); $i++){
                $conteo = 0;
                for($j=0; $j < count($fechas[$i]); $j++){
                    if($festivo->esFestivoFecha($fechas[$i][$j]["fecha"])){
                        $conteo += 1;
                    }
                }
                $festivos[$i] = $conteo;
            }
            $response = [];
            $response["empleados"] = $empleados;
            $response["asistencias"] = $asistencias;
            $response["sedeSelect"] = $sedeSelect;
            $response["datos"] = $datos;
            $response["domingos"] = $domingos;
            $response["totalDias"] = $totalDias;        
            $response["festivos"] = $festivos;

            echo json_encode($response);
        }

        public function asistenciaMes(){
            $sede = new Sede();
            $asistencia = new Asistencia();
            $sedes = $sede->consultarDatos();
            $asistencias = $asistencia->consultarDatos();
            $mes = date("m");            
            include '../views/control_asistencia/asistenciaMes.php';
        }

        public function asistenciaMensual(){
            $check = new Check();
            if(!$check->isAjax()){
                $this->todos();
                return;
            }
            $controlAsis = new ControlAsistencia();
            $empleado = new Empleado();
            $mes = $_GET["mes"];
            $ano = $_GET["ano"];
            $sede = $_GET["sede"];
            $diasM = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
            $dias = [];
            for($i=0; $i < $diasM; $i++){
                $dia = date("N", strtotime("$ano-$mes-".($i+1)));
                if($dia == "7"){
                    $dia = "Do";
                }else if($dia == "1"){
                    $dia = "Lu";
                }else if($dia == "2"){
                    $dia = "Ma";
                }else if($dia == "3"){
                    $dia = "Mi";
                }else if($dia == "4"){
                    $dia = "Ju";
                }else if($dia == "5"){
                    $dia = "Vi";
                }else if($dia == "6"){
                    $dia = "Sa";
                }
                $dias[$i]["dia"] = $dia;
                $dias[$i]["fecha"] = ($i+1);
            }
            $empleados = $empleado->buscarXSede($sede);
            $datos = $controlAsis->asistenciaMensual($mes, $ano, $sede);
            
            $response = [];
            $response["empleados"] = $empleados;
            $response["datos"] = $datos;
            $response["dias"] = $dias;
            echo json_encode($response);
        }

        public function error(){        
            include "../views/error/404.php";
        }
    }
    new ControlAsisController();