<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>    
    <title>Codigo restablecimiento</title>
</head>
<script type="text/javascript">    

    function validarCodigo(codInser){
        var parametros = {                
                "codInser" : codInser
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   '/Jomar/users_control/controller/AdminController.php?action=verificarRes', //archivo que recibe la peticion
                type:  'post', //método de envio                
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        if(response == ""){
                            formCod.submit();

                            $('#errores').removeClass("alert-danger");
                            $('#errores').addClass("alert-success");

                        }else{
                            $("#errores").html(response);                            
                        }
                        
                }
        });
    }
</script>
<body class="container" style="background-color:#800D0D0D">
    <div class="row mt-5">
        <div class="col"></div>
        <div class="col card shadow p-5">
            <br>
            <h1 class="text-center">Codigo de Restablecimiento</h1>                                 
            <br>         
            <label class="text-center">Se ha enviado un codigo a su correo para poder restablecer la contraseña</label>
            <br>
            <div class="alert-danger divHidden" id="errores"></div>
            <form action="/Jomar/users_control/controller/AdminController.php?action=nueva" onsubmit="return validarCampos()" class="form-group" method="post" name="formCod">
                <input type="hidden" name="id_admin" id="id_admin" value="<?php echo $admin["id_admin"] ?>">                
                <input class="form-control text-center" maxlength="4" type="text" name="codInser" id="codInser" autocomplete="off">
                <br>
                <button class="btn btn-block btn-primary" type="submit">Enviar</button>
            </form>                        
        </div>
        <div class="col"></div>
    </div>    
</body>
<script type="text/javascript">
    function validarCampos(){        
        var codInser = document.forms["formCod"]["codInser"].value;

        var formOk = true;
        var msg = "<ul>";        

        if(codInser == ""){
            msg += "<li> Debe insertar el codigo </li>";
            formOk = false;
        }else{
            validarCodigo(codInser);
            formOk = false;
        }

        msg += "</ul>";

        if(!formOk){
            $("#errores").html(msg);
            $("#errores").fadeIn("slow");
        }
        return formOk;
    }
    
</script>
</html>