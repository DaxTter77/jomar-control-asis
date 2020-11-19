<?php
    require_once '../database/ConexionMysql.php';
    require_once '../models/Empleado.php';
    require_once '../models/Asistencia.php';
    
    class ControlAsistencia{
        public $id_controlAsis;
        public $fecha;
        public $empleado;
        public $asistencia;
        public $administrador;        
        public $nota;        
        public $estado;
        
        public function consultarDatos($month, $year){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
            FROM control_asistencias c
            INNER JOIN empleado e on c.id_empleado = e.id_empleado
            INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
            INNER JOIN administradores ad on c.id_admin = ad.id_admin
            INNER JOIN sede s on e.id_sede = s.id_sede
            WHERE c.id_estado = '01' AND MONTH(c.fecha) = $month AND YEAR(c.fecha) = $year
            ORDER BY fecha ASC, c.id_controlAsis ASC";
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
        public function consultarDatosFecha($fecha){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
            FROM control_asistencias c
            INNER JOIN empleado e on c.id_empleado = e.id_empleado
            INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
            INNER JOIN administradores ad on c.id_admin = ad.id_admin
            INNER JOIN sede s on e.id_sede = s.id_sede
            WHERE c.id_estado = '01' AND fecha = '$fecha' 
            ORDER BY c.id_controlAsis ASC";
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
            $select = "SELECT *, e.id_sede
            FROM control_asistencias c
            INNER JOIN empleado e on e.id_empleado = c.id_empleado
            WHERE id_controlAsis = '$id'";
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

    public function consultarXSedeFecha($sede, $fecha){
        $con = new ConexionMysql();
        $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
        FROM control_asistencias c
        INNER JOIN empleado e on c.id_empleado = e.id_empleado
        INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
        INNER JOIN administradores ad on c.id_admin = ad.id_admin
        INNER JOIN sede s on e.id_sede = s.id_sede
        WHERE c.id_estado = '01' AND fecha = '$fecha' AND s.id_sede = '$sede'
        ORDER BY c.id_controlAsis ASC";         
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
    
    public function consultarXSedeMes($sede, $month, $year){
        $con = new ConexionMysql();
        $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
        FROM control_asistencias c
        INNER JOIN empleado e on c.id_empleado = e.id_empleado
        INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
        INNER JOIN administradores ad on c.id_admin = ad.id_admin
        INNER JOIN sede s on e.id_sede = s.id_sede
        WHERE c.id_estado = '01' AND MONTH(c.fecha) = $month AND YEAR(c.fecha) = $year AND s.id_sede = '$sede'
        ORDER BY fecha ASC, c.id_controlAsis ASC";
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

    public function consultarXSiglaFecha($siglas, $fecha){
        $con = new ConexionMysql();
        $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
        FROM control_asistencias c
        INNER JOIN empleado e on c.id_empleado = e.id_empleado
        INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
        INNER JOIN administradores ad on c.id_admin = ad.id_admin
        INNER JOIN sede s on e.id_sede = s.id_sede
        WHERE c.id_estado = '01' AND fecha = '$fecha' AND (a.id_asistencia = '$siglas[0]' ";
        if(count($siglas) > 2){
            for($i=1; $i < count($siglas)-1; $i++){
                $select .= "OR a.id_asistencia = '$siglas[$i]' ";
            }
        }
        $select .= ") ORDER BY c.id_controlAsis ASC";  
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

    public function consultarXSiglaMes($siglas, $month, $year){
        $con = new ConexionMysql();
        $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
        FROM control_asistencias c
        INNER JOIN empleado e on c.id_empleado = e.id_empleado
        INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
        INNER JOIN administradores ad on c.id_admin = ad.id_admin
        INNER JOIN sede s on e.id_sede = s.id_sede
        WHERE c.id_estado = '01' AND MONTH(c.fecha) = $month AND YEAR(c.fecha) = $year AND (a.id_asistencia = '$siglas[0]' ";
        if(count($siglas) > 2){
            for($i=1; $i < count($siglas)-1; $i++){
                $select .= "OR a.id_asistencia = '$siglas[$i]' ";
            }
        }
        $select .= ") ORDER BY fecha ASC, c.id_controlAsis ASC";
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

    public function consultarXSedeSiglaFecha($sede, $siglas, $fecha){
        $con = new ConexionMysql();
        $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
        FROM control_asistencias c
        INNER JOIN empleado e on c.id_empleado = e.id_empleado
        INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
        INNER JOIN administradores ad on c.id_admin = ad.id_admin
        INNER JOIN sede s on e.id_sede = s.id_sede
        WHERE c.id_estado = '01' AND fecha = '$fecha' AND s.id_sede = '$sede' AND (a.id_asistencia = '$siglas[0]' ";
        if(count($siglas) > 2){
            for($i=1; $i < count($siglas)-1; $i++){
                $select .= "OR a.id_asistencia =  '$siglas[$i]' ";
            }
        }
        $select .= ") ORDER BY c.id_controlAsis ASC";
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

    public function consultarXSedeSiglaMes($sede, $siglas, $month, $year){
        $con = new ConexionMysql();
        $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
        FROM control_asistencias c
        INNER JOIN empleado e on c.id_empleado = e.id_empleado
        INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
        INNER JOIN administradores ad on c.id_admin = ad.id_admin
        INNER JOIN sede s on e.id_sede = s.id_sede
        WHERE c.id_estado = '01' AND MONTH(c.fecha) = $month AND YEAR(c.fecha) = $year AND s.id_sede = '$sede' AND (a.id_asistencia = '$siglas[0]' ";
        if(count($siglas) > 2){
            for($i=1; $i < count($siglas)-1; $i++){
                $select .= "OR a.id_asistencia =  '$siglas[$i]' ";
            }
        }
        $select .= ") ORDER BY fecha ASC, c.id_controlAsis ASC";
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

        public function insertarControl(){
            $con = new ConexionMysql();
            $sql = "SELECT * FROM control_asistencias WHERE fecha = '$this->fecha' AND id_empleado = '$this->empleado' AND id_estado = '01'";
            $rq = $con->consultar($sql);
            if($rq != null && $rq->num_rows > 0){
                return false;
            }else{
                $select = "SELECT max(CAST(id_controlAsis as UNSIGNED)) as id FROM control_asistencias";
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
                        $this->id_controlAsis = $num ;
                    }else{
                        $this->id_controlAsis = "0". $num ;
                    }
                    $action = "INSERT INTO control_asistencias VALUES ('$this->id_controlAsis',
                    '$this->fecha',
                    '$this->empleado',
                    '$this->asistencia',
                    '$this->administrador',   
                    '$this->nota',             
                    '01')";
                    $res = $con->ejecutar($action);
                    $con->cerrar();
                    return $res;
                }else{
                    return null;
                }
            }
        }

        public function modificarDatos(){
            $con = new ConexionMysql();
            $action = "UPDATE control_asistencias 
            SET fecha = '$this->fecha', 
            id_empleado = '$this->empleado', 
            id_asistencia = '$this->asistencia',             
            nota = '$this->nota'             
            WHERE id_controlAsis = '$this->id_controlAsis'";        
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public static function modificarEstado($id){
            $con = new ConexionMysql();
            $action = "UPDATE control_asistencias
            SET id_estado = '02'
            WHERE id_controlAsis = '$id'";        
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }
        
        public function modificarAsistencia($id){
            $con = new ConexionMysql();
            $action = "UPDATE control_asistencias
            SET id_asistencia = '$this->asistencia'
            WHERE id_controlAsis = '$id'";
            $res = $con->ejecutar($action);
            $con->cerrar();
            return $res;
        }

        public static function buscarFecha($fecha, $sede){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, 
            c.fecha, 
            e.id_empleado,
            e.id_sede
            FROM control_asistencias c
            INNER JOIN empleado e on e.id_empleado = c.id_empleado
            WHERE c.id_estado = '01' AND c.fecha = '$fecha' AND e.id_sede = '$sede'
            ORDER BY c.id_empleado";
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

        public static function buscarFechaEmpleado($fecha, $sede, $empleado){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, 
            c.fecha, 
            e.id_empleado,
            e.id_sede
            FROM control_asistencias c
            INNER JOIN empleado e on e.id_empleado = c.id_empleado
            WHERE e.id_empleado = '$empleado' AND c.id_estado = '01' AND c.fecha = '$fecha' AND e.id_sede = '$sede'
            ORDER BY c.id_empleado";
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
            $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
            FROM control_asistencias c
            INNER JOIN empleado e on c.id_empleado = e.id_empleado
            INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
            INNER JOIN administradores ad on c.id_admin = ad.id_admin
            INNER JOIN sede s on e.id_sede = s.id_sede
            WHERE c.id_estado = '02'
            ORDER BY fecha ASC";             
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

        public function restaurarRegistro($id){
            $con = new ConexionMysql();
            $datos = $this->buscarXID($id);
            $select = "SELECT * FROM control_asistencias
            WHERE id_estado = '01' AND id_empleado = '{$datos[0]['id_empleado']}' AND fecha = '{$datos[0]['fecha']}'";            
            $rs = $con->consultar($select);
            if($rs == null){
                return null;
            }else if($rs->num_rows > 0){
                $con->cerrar();
                return false;
            }else{            
                $action = "UPDATE control_asistencias
                SET id_estado = '01'
                WHERE id_controlAsis = '$id'";        
                $res = $con->ejecutar($action);
                $con->cerrar();
                return $res;
            }
        }


        // En este metodo se consultan las fechas de los diferentes de días excepto domingos y trae los que tenga como asistencia TC, IT ó MT, ayuda al apartado de conteo de festivos
        public function consultarFechas($mes, $ano, $sede){
            $con = new ConexionMysql();
            $empleado = new Empleado();
            $empleados = $empleado->buscarXSede($sede);
            $datosEmp = [];
            for($i=0; $i < count($empleados); $i++){
                $datos = [];
                $select = "SELECT c.id_controlAsis, 
                c.fecha, 
                c.id_empleado
                FROM control_asistencias c 
                INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
                WHERE c.id_estado = '01' AND c.id_empleado = '{$empleados[$i]['id_empleado']}' AND MONTH(c.fecha) = '$mes' AND  YEAR(c.fecha) = '$ano' AND DATE_FORMAT(c.fecha, '%W') != 'Sunday' AND (a.siglas = 'TC' OR a.siglas = 'MT' OR a.siglas = 'IT')
                ORDER BY id_empleado";
                $rs = $con->consultar($select);                
                if($rs == null){
                    $datosEmp[$i][0]["fecha"] = "00-00-00";
                    $datosEmp[$i][0]["id_empleado"] = $empleados[$i]['id_empleado'];
                }else if($rs->num_rows > 0){
                    while($row = $rs->fetch_assoc()){
                        $datos[] = $row;
                    }   
                    $datosEmp[$i] = $datos;
                }else{
                    $datosEmp[$i][0]["fecha"] = "00-00-00";
                    $datosEmp[$i][0]["id_empleado"] = $empleados[$i]['id_empleado'];
                }
            }
            $con->cerrar();

            if($datosEmp != null){
                return $datosEmp;
            }else{
                return null;
            }
        }

        public function contarAsistencia($mes, $ano, $sede){
            $con = new ConexionMysql();
            $empleado = new Empleado();
            $asistencia = new Asistencia();
            $empleados = $empleado->buscarXSede($sede);
            $asistencias = $asistencia->consultarDatos();
            $datosEmp = [];
            for($i=0; $i < count($empleados); $i++){
                $datosAsis = [];
                for($j=0; $j < count($asistencias); $j++){
                    $select = "SELECT  e.id_empleado, e.nombres, e.apellidos, COUNT(c.id_asistencia) as asistencia, a.siglas
                    FROM control_asistencias c
                    INNER JOIN empleado e on e.id_empleado = c.id_empleado
                    INNER JOIN asistencia a on a.id_asistencia = c.id_asistencia
                    WHERE c.id_asistencia = '{$asistencias[$j]["id_asistencia"]}' AND c.id_empleado = '{$empleados[$i]["id_empleado"]}' AND c.id_estado = '01' AND MONTH(c.fecha) = '$mes' AND YEAR(c.fecha) = '$ano'";
                    $rs = $con->consultar($select);
                    if($rs == null){
                        return null;
                    }else if($rs->num_rows > 0){
                        while($row = $rs->fetch_assoc()){                            
                            $datosAsis[] = $row;
                        }
                    }else{

                    }
                }
                $datosEmp[$i] = $datosAsis;
            }
            $con->cerrar();
            if($datosEmp != null){
                return $datosEmp;
            }else{
                return null;
            }
        }

        public function contarDomingos($mes, $ano, $sede){
            $con = new ConexionMysql();
            $empleado = new Empleado();            
            $empleados = $empleado->buscarXSede($sede);            
            $datosEmp = [];
            for($i=0; $i < count($empleados); $i++){                         
                $select = "SELECT  c.id_empleado, COUNT(c.id_asistencia) as domingos
                FROM control_asistencias c
                INNER JOIN empleado e on e.id_empleado = c.id_empleado
                INNER JOIN asistencia a on a.id_asistencia = c.id_asistencia
                WHERE c.id_empleado = '{$empleados[$i]["id_empleado"]}' AND c.id_estado = '01' AND MONTH(c.fecha) = '$mes' AND YEAR(c.fecha) = '$ano' AND DATE_FORMAT(c.fecha, '%W') = 'Sunday' AND (a.siglas = 'TC' OR a.siglas = 'MT' OR a.siglas = 'HE' OR a.siglas = 'IT')";
                $rs = $con->consultar($select);
                if($rs == null){
                    $datosEmp[$i]["domingos"] = 0;
                    $datosEmp[$i]["id_empleado"] = $empleados[$i]["id_empleado"];
                }else if($rs->num_rows > 0){
                    while($row = $rs->fetch_assoc()){                        
                        $datosEmp[$i] = $row;
                    }
                }else{
                    $datosEmp[$i]["domingos"] = 0;
                    $datosEmp[$i]["id_empleado"] = $empleados[$i]["id_empleado"];
                }
            }
            $con->cerrar();
            if($datosEmp != null){
                return $datosEmp;
            }else{
                return null;
            }
        }

        public function contarDias($mes, $ano, $sede){
            $con = new ConexionMysql();
            $empleado = new Empleado();            
            $empleados = $empleado->buscarXSede($sede);            
            $datosEmp = [];
            for($i=0; $i < count($empleados); $i++){                         
                $select = "SELECT  c.id_empleado, COUNT(a.id_asistencia) as dias
                FROM control_asistencias c
                INNER JOIN empleado e on e.id_empleado = c.id_empleado
                INNER JOIN asistencia a on a.id_asistencia = c.id_asistencia
                WHERE c.id_empleado = '{$empleados[$i]["id_empleado"]}' AND a.siglas != 'VAC' AND a.siglas != 'SUSP' AND a.siglas != 'RT' AND a.siglas != 'DP' AND a.siglas != 'NE' AND c.id_estado = '01' AND MONTH(c.fecha) = '$mes' AND YEAR(c.fecha) = '$ano'";
                $rs = $con->consultar($select);
                if($rs == null){
                    $datosEmp[$i]["dias"] = 0;
                    $datosEmp[$i]["id_empleado"] = $empleados[$i]["id_empleado"];
                }else if($rs->num_rows > 0){
                    while($row = $rs->fetch_assoc()){                        
                        $datosEmp[$i] = $row;
                    }
                }else{
                    $datosEmp[$i]["dias"] = 0;
                    $datosEmp[$i]["id_empleado"] = $empleados[$i]["id_empleado"];
                }
            }
            $con->cerrar();
            if($datosEmp != null){
                return $datosEmp;
            }else{
                return null;
            }
        }

        public function asistenciaMensual($mes, $ano, $sede){
            $con = new ConexionMysql();
            $empleado = new Empleado();            
            $empleados = $empleado->buscarXSede($sede);            
            $datosEmp = [];
            for($i=0; $i < count($empleados); $i++){
                $select = "SELECT id_empleado, siglas, Date_format(fecha,'%d') as dia 
                FROM control_asistencias c
                INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
                WHERE id_empleado = '{$empleados[$i]["id_empleado"]}' AND id_estado = '01' AND MONTH(fecha) = '$mes' AND YEAR(fecha) = '$ano'
                ORDER BY dia ASC";
                $rs = $con->consultar($select);
                if($rs == null){
                    $datosEmp[$i] = null;
                }else if($rs->num_rows > 0){
                    while($row = $rs->fetch_assoc()){
                        $datosEmp[$i][] = $row;
                    }
                }else{
                    $datosEmp[$i] = null;
                }
            }
                $con->cerrar();

            if($datosEmp != null){
                return $datosEmp;
            }else{
                return null;                    
            }
        }

        public function consultarFechaHasta($fecha, $fechaHasta){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
            FROM control_asistencias c
            INNER JOIN empleado e on c.id_empleado = e.id_empleado
            INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
            INNER JOIN administradores ad on c.id_admin = ad.id_admin
            INNER JOIN sede s on e.id_sede = s.id_sede
            WHERE c.id_estado = '01' AND fecha BETWEEN '$fecha' AND '$fechaHasta' 
            ORDER BY fecha ASC";
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

        public function consultarXSedeHasta($sede, $fecha, $fechaHasta){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
            FROM control_asistencias c
            INNER JOIN empleado e on c.id_empleado = e.id_empleado
            INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
            INNER JOIN administradores ad on c.id_admin = ad.id_admin
            INNER JOIN sede s on e.id_sede = s.id_sede
            WHERE c.id_estado = '01' AND fecha BETWEEN '$fecha' AND '$fechaHasta' AND s.id_sede = '$sede'
            ORDER BY fecha ASC";         
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

        public function consultarXSiglaHasta($siglas, $fecha, $fechaHasta){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
            FROM control_asistencias c
            INNER JOIN empleado e on c.id_empleado = e.id_empleado
            INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
            INNER JOIN administradores ad on c.id_admin = ad.id_admin
            INNER JOIN sede s on e.id_sede = s.id_sede
            WHERE c.id_estado = '01' AND fecha BETWEEN '$fecha' AND '$fechaHasta' AND (a.id_asistencia = '$siglas[0]' ";
            if(count($siglas) > 2){
                for($i=1; $i < count($siglas)-1; $i++){
                    $select .= "OR a.id_asistencia =  '$siglas[$i]' ";
                }
            }
            $select .= ") ORDER BY fecha ASC";  
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

        public function consultarXSedeSiglaHasta($sede, $siglas, $fecha, $fechaHasta){
            $con = new ConexionMysql();
            $select = "SELECT c.id_controlAsis, date_format(c.fecha, '%d-%m-%Y %W') as fecha, e.documento, e.nombres, e.apellidos, s.sede, a.siglas, ad.nombres as administrador, c.nota
            FROM control_asistencias c
            INNER JOIN empleado e on c.id_empleado = e.id_empleado
            INNER JOIN asistencia a on c.id_asistencia = a.id_asistencia
            INNER JOIN administradores ad on c.id_admin = ad.id_admin
            INNER JOIN sede s on e.id_sede = s.id_sede
            WHERE c.id_estado = '01' AND fecha BETWEEN '$fecha' AND '$fechaHasta' AND s.id_sede = '$sede' AND (a.id_asistencia = '$siglas[0]' ";
            if(count($siglas) > 2){
                for($i=1; $i < count($siglas)-1; $i++){
                    $select .= "OR a.id_asistencia = '$siglas[$i]' ";
                }
            }
            $select .= ") ORDER BY fecha ASC";
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
    }
?>