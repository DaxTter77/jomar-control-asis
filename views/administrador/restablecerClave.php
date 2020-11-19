<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <title>Restablecer clave</title>
</head>
<body class="container" style="background-color:#800D0D0D">
    <div class="row mt-5">
        <div class="col"></div>
        <div class="col card shadow p-5">
            <h1 class="text-center">Restablecer Clave</h1>
            <?php 
                if($msg != ""){
                    echo "<br>";
                    echo "<div class='text-center alert-danger'> $msg </div>";
                }
            ?>
            <div class="alert-danger divHidden" id="errores"></div>
            <br>
            <form action="/Jomar/users_control/controller/AdminController.php?action=verificarRes" onsubmit="return validarCampos()" method="post" name="formRes">
                <div class="form-group">
                    <label for="usuario" class="col-form-label">Usuario: </label>
                    <br>
                    <input type="text" class="form-control" name="usuario" id="usuario" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="usuario" class="col-form-label">Correo: </label>
                    <br>
                    <input type="text" class="form-control" name="correo" id="correo" autocomplete="off">
                </div>
                <br>
                <button type="submit" class="btn btn-block btn-primary">Siguiente</button>
                <a href="/Jomar/users_control/controller/AdminController.php?action=login" class="btn btn-block btn-danger">Cancelar</a>
            </form>        
        </div>
        <div class="col"></div>
    </div>
</body>
<script type="text/javascript">
    function validarCampos() {
        var usuario = document.forms["formRes"]["usuario"].value;
        var correo = document.forms["formRes"]["correo"].value;

        var msg = "<ul>";
        var formOk = true;

        if(correo == ""){
            msg += "<li> Correo no puede ir vacío </li>";
            formOk = false;
        }else{
            if(correo.indexOf('@') == -1){
                msg += "<li> El correo debe tener @ </li>";
                formOk = false;
            }
            
            if(correo.indexOf('.') == -1){
                msg += "<li> El correo debe tener \".\" </li>";
                formOk = false;
            }    
        }    
        
        if(usuario == ""){
            msg += "<li> Usuario no puede ir vacío </li>";
            formOk = false;            
        }        
        msg += "</ul>"

        if(!formOk){
            $("#errores").html(msg);
            $("#errores").fadeIn("slow");
        }
        return formOk;
    }
</script>
</html>