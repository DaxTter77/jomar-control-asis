<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">    
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <title>Cambiar clave</title>
</head>
<script type="text/javascript">
    function goOut(){
        window.close();
    }
    
    function goBack(msg){
        alert(msg);
        window.history.back();
    }

    function success(msg){
        window.close();
        alert(msg);
    }
</script>
<body>
    <form action="/Jomar/users_control/controller/AdminController.php?action=cambiarContra" method="POST" onsubmit="return validarCampos()" name="formChange">
        <div class='container shadow p-5 mb-1 mt-n1 bg-white rounded' style= "width: 500px">
            <h3>Cambiar Clave</h3>
            <?php 
                if($msg != ""){
                    if(strncasecmp ($msg , "No" , 2) === 0){                        
                        echo "<script> goBack(\"$msg\") </script>";
                    }else{                        
                        echo "<script> success(\"$msg\") </script>";
                    }
                }
            ?>
            <br>
            <div id="errores" class="alert-danger divHidden"></div> 
            <input type="hidden" id="id_admin" name="id_admin" value="<?php echo $id_admin ?>" />
            <div class="form-group row"> 
                <label class="col-sm-auto col-form-label" style="margin-right: 26px" for="actual">Clave actual:</label>
                <div class="col-sm-auto ">
                    <input type="password" class="col-sm-auto form-control" name="actual" id="actual"/>
                </div>
            </div>
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
                <button type="submit" class="btn btn-primary" width="150px">Cambiar Contraseña</button>
            </div>
            <br>
            <div class="row justify-content-center">
                <a role="button" class="btn btn-danger btn-md" style="width: 170px" href="javascript: goOut();">Cancelar</a>
            </div>
        </div>
    </form>
</body>
<script type="text/javascript">
    function validarCampos(){    
    var claveAct = document.forms["formChange"]["actual"].value;
    var claveNew = document.forms["formChange"]["nueva"].value;
    var confirm = document.forms["formChange"]["confirm"].value;

    var error = "<ul>";
    var formOk = true;

    if(claveAct == ""){
        error += "<li> Clave actual no puede ir vacío </li>";
        formOk = false;
    }

    if(claveNew == ""){
        error += "<li> Clave nueva no puede ir vacío </li>";
        formOk = false;
    }else if(claveNew === claveAct){
        error += "<li> La clave no puede ser una que ya esté establecida </li>";
        formOk = false;
    }
    
    


    if(confirm == "" && claveNew != ""){
        error += "<li> Tienes que confirmar la clave </li>";
        formOk = false;
    }else if(confirm != claveNew){
        error += "<li> Claves no coinciden </li>";
        formOk = false;
    }
    error += "</ul>";

    if (!formOk) {
        $("#errores").html(error);
        $("#errores").fadeIn("slow");
    }

    return formOk;
}
</script>
</html>