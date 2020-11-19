<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">    
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <title>Nueva clave</title>
</head>
<script type="text/javascript">        
</script>
<body style="background-color:#800D0D0D">
    <form action="/Jomar/users_control/controller/AdminController.php?action=nuevaContra" method="POST" onsubmit="return validarCampos()" name="formNew">
        <div class='container shadow p-5 mt-5 bg-white rounded' style= "width: 500px">
            <h3>Nueva Clave</h3>
            <br>
            <div id="errores" class="alert-danger divHidden"> <?php if($error != ""){echo "<li> $error </li>";} ?></div> 
            <input type="hidden" id="id_admin" name="id_admin" value="<?php echo $id_admin ?>" />
            <div class="form-group row"> 
                <label class="col-sm-auto col-form-label" style="margin-right: 26px" for="nueva">Clave nueva:</label>
                <div class="col-sm-auto ">
                    <input type="password" class="col-sm-auto form-control" name="nueva" id="nueva"/>
                </div>
            </div>
            <div class="form-group row"> 
                <label class="col-sm-auto col-form-label" for="confirmación">Confirmar clave:</label>
                <div class="col-sm-auto ">
                    <input type="password" class="form-control" name="confirm" id="confirm"/>
                </div>
            </div>
            <br> 
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary" width="150px">Restablecer</button>
            </div>
            <br>            
        </div>
    </form>
</body>
<script type="text/javascript">
    function validarCampos(){
        var claveNew = document.forms["formNew"]["nueva"].value;
        var confirm = document.forms["formNew"]["confirm"].value;

        var msg = "<ul>";
        var formOk = true;

        if(claveNew == ""){
            msg += "<li> Clave nueva no puede ir vacío </li>";
            formOk = false;
        }            

        if(confirm == "" && claveNew != ""){
            msg += "<li> Tienes que confirmar la clave </li>";
            formOk = false;
        }else if(confirm != claveNew){
            msg += "<li> Claves no coinciden </li>";
            formOk = false;
        }
        msg += "</ul>";

        if (!formOk) {
            $("#errores").html(msg);
            $("#errores").fadeIn("slow");
        }

        return formOk;
}
</script>    
</html>