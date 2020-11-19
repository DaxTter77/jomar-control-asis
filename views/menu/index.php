<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <title>Menu Principal</title>
</head>
<body class="container" style="background-color:#800D0D0D">
        <?php
            $url = $_SERVER["REQUEST_URI"];
            $urlneed = "/Jomar/users_control/controller/AdminController.php?action=menu";
            if($url != $urlneed){
                echo "<script>self.location.replace('$urlneed')</script>";
            }
        ?>
    <div class="row mt-5">
        <div class="col"></div>
        <div class="col card shadow p-5">
            <h3 class="text-center font-weight-bold">Bienvenid@ </h3>
            <h4 class="text-center font-weight-bold"> <?php echo $_SESSION["usuario"]["nombres"]. " ". $_SESSION["usuario"]["apellidos"] ?> </h4>            
            <a class="btn btn-link" onclick="localStorage.setItem('menu', true)" href="/Jomar/users_control/controller/AdminController.php?action=editar&id_admin=<?php echo $_SESSION['usuario']['id_admin'] ?>">(Editar mi información)</a>
            <br>
            <a href="/Jomar/users_control/controller/ControlAsisController.php?action=todos" class="btn btn-block btn-dark" role="button" >Control de Asistencia</a>
            <br>
            <h4 class="text-center">Información</h4>
            <br>
            <a href="/Jomar/users_control/controller/AdminController.php?action=todos" class="btn btn-block btn-dark" role="button">Administradores</a>
            <a href="/Jomar/users_control/controller/EmpleadoController.php?action=todos" class="btn btn-block btn-dark" role="button">Empleados</a>
            <a href="/Jomar/users_control/controller/AsistenciaController.php?action=todos" class="btn btn-block btn-dark" role="button">Asistencias</a>
            <a href="/Jomar/users_control/controller/CargoController.php?action=todos" class="btn btn-block btn-dark" role="button">Cargos</a>
            <a href="/Jomar/users_control/controller/SedeController.php?action=todos" class="btn btn-block btn-dark" role="button">Sedes</a>
            <br>
            <a href="/Jomar/users_control/controller/AdminController.php?action=logout" class="btn btn-block btn-danger" role="button">Cerrar Sesión</a>
        </div>
        <div class="col"></div>
    </div>
    
</body>
</html>