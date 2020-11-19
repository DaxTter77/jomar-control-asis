<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <title>Inicio Sesión</title>
</head>
<script type="text/javascript">
    function goToLogin(){        
        let page = setTimeout(function(){ self.location.replace('/Jomar/users_control/controller/AdminController.php?action=login');},2000);
    }
    function reloadPage(){
        self.location.replace('/Jomar/users_control/controller/AdminController.php?action=login')
    }

    function verificarDatos(){
        if(validarCampos()){
            var datos = $("#formLogin").serialize();

            $.ajax({
                data: datos,
                url: "/Jomar/users_control/controller/AdminController.php?action=verificarLogin",
                type: "post",
                success: function(response){
                    if(response.trim() != "1"){
                        var html = "<ul><li>Usuario o Clave inválidos</li></ul>";
                        $("#errores").html("");
                        $("#errores").fadeOut("fast");
                        $("#errores").html(html);
                        $("#errores").fadeIn("fast");
                    }else{
                        $("#formLogin").submit();
                    }
                }
            });
        }
    }
</script>
<body class="container" style="background-color:#800D0D0D">
    <div class="row mt-5">
        <div class="col"></div>
        <div class="col card shadow p-5">
            <img src="\Jomar\users_control\images\JOMAR-LOGO.png" class="img-fluid" alt="logo jomar">            
            <div class="row justify-content-center">
                <h3 class="font-weight-bold">Control de Asistencia</h3>
            </div>
            <div class="alert-danger divHidden" id="errores"></div>
            <?php
                $url = $_SERVER["REQUEST_URI"];
                $urlneed = "/Jomar/users_control/controller/AdminController.php?action=login";                
                if($url != $urlneed){
                    echo "<script>reloadPage()</script>";
                }
            ?>            
            <br>
            <form action="/Jomar/users_control/controller/AdminController.php?action=login" onsubmit="return validarCampos()" method="post" name="formLogin" id="formLogin">
                <div class="form-group">
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario">
                </div>
                <br>
                <div class="form-group">
                    <input type="password" id="clave" name="clave" class="form-control" placeholder="Clave">
                </div>                
                <div class="justify-content-center row">
                    <a href="/Jomar/users_control/controller/AdminController.php?action=restablecer" class="btn btn-link">¿Has olvidado tu clave?</a>
                    <br>
                    <button type="button" onclick="verificarDatos()" class="btn btn-block btn-success">Iniciar sesión</button>
                </div>
            </form>
        </div>
        <div class="col"></div>
    </div>
</body>
<script type="text/javascript">
    function validarCampos(){
        var usuario = document.forms["formLogin"]["usuario"].value;
        var clave = document.forms["formLogin"]["clave"].value;

        var msg = "<ul>";
        var formOk = true;

        if(usuario == ""){
            msg += "<li> Usuario no puede ir vacío </li>";
            formOk = false;
        }
        if(clave == ""){
            msg += "<li> Clave no puede ir vacío </li>";
            formOk = false
        }

        msg += "</u>";
        
        if(!formOk){
            $("#errores").html(msg);
            $("#errores").fadeIn("slow");
        }
        return formOk;
    }

    $("#formInsertar").submit(function(e){
        e.preventDefault();
    });

    $("input").keyup(function(e){
        if(e.key == "Enter"){
            verificarDatos();
        }
    });
</script>
</html>