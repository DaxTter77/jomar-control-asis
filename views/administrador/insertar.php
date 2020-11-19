<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta id="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <title>Registrar Administrador</title>
</head>
<script type="text/javascript">
    function guardarAdmin() {        
        if(validarCampos()){
            var datos = $("#formRegistro").serialize();                        
            $.ajax({
                data: datos,
                url: '/Jomar/users_control/controller/AdminController.php?action=guardarInser',
                type: 'post',
                success: function (response){
                    var html;                    
                    if(response.trim() != "1"){
                        html = "<h4> No se ha podido insertar </h4>";                        
                        $("#respuesta").html(html);
                        $("#respuesta").fadeIn("slow");
                        setTimeout(function(){
                            $("#respuesta").fadeOut(2000, function() {
                                $("#respuesta").html("");                                
                                });
                        }, 2000);
                    }else{                        
                        msg = "<h4> Se ha insertado correctamente </h4>";                        
                        localStorage.setItem("msg", msg);
                        location.href = "/Jomar/users_control/controller/AdminController.php?action=todos";
                    }
                }
            });
        }
    }

    $(document).ready(function(){
        $("header").load("/Jomar/users_control/views/header/header.php");
    });
</script>
<body>
    <header></header>
    <div class='container text-center shadow col-md-4 p-5 mb-5 mt-3 bg-white rounded'>
        <h1>Registrar <br> Administrador</h1>
    </div>
    <div id="respuesta" class="container w-50 text-center mb-5 alert-danger divHidden"></div>
    <form name="formRegistro" id="formRegistro" method="POST">
        <div class='container shadow p-5 mb-1 mt-n1 bg-white rounded' style= "width: 800px">            
            <div id="errores" class="alert-danger divHidden"></div>
            <div class="form-group row ml-1 justify-content-center">
                <label for="nombres" class="col-form-label">Nombres:</label>
                <div class='col-sm-4 mr-3'>
                    <input type="text" class="form-control" id="nombres" name="nombres" autocomplete="off">
                </div>
                <label for="apellidos" class="col-form-label">Apellidos:</label>
                <div class='col-sm-4'>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" autocomplete="off"> 
                </div>           
            </div>            
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label class="col-form-label" for="inlineFormInputGroup">Correo:</label>
                <div class="input-group-prepend col-sm-4 mr-3">
                <div class="input-group-text">@</div>                
                <input type="text" class="form-control" id="inlineFormInputGroup" name="correo" autocomplete="off">                       
                </div>
                <label for="usuario" class="col-form-label">Usuario:</label>
                <div class='col-sm-4'>
                    <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off">
                </div>
            </div>
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label for="clave" class="col-form-label">Clave:</label>
                <div class='col-sm-4 mr-3'>
                    <input type="password" class="form-control" id="clave"name="clave">
                </div>                
                <label for="confirmClave" class="col-form-label">Confirmar clave:</label>
                <div class='col-sm-4'>
                    <input type="password"  class="form-control" id="confirmClave" name="confirmClave"> <br><br>
                </div>
            </div>
            <div class="form-group row justify-content-center">
                <div class="justify-content-center">                
                    <button class="btn btn-primary mr-4 btn-md" style="width: 150px" id="submit" onclick="guardarAdmin()" type="button">Registrar</button>            
                    <a class="btn btn-danger btn-md" role="button" style="width: 150px" href="/Jomar/users_control/controller/AdminController.php?action=todos" >Cancelar</a>            
                </div>
            </div>
                <div class="row justify-content-end">
                    <button class="btn btn-info btn-md" type="reset">Limpiar</button>            
                </div>
        </div>
    </form>
</body>
<script type="text/javascript">        
    function validarCampos(){
        var nombres = document.forms["formRegistro"]["nombres"].value;
        var apellidos = document.forms["formRegistro"]["apellidos"].value;
        var correo = document.forms["formRegistro"]["correo"].value;
        var usuario = document.forms["formRegistro"]["usuario"].value;
        var clave = document.forms["formRegistro"]["clave"].value;
        var confirmClave = document.forms["formRegistro"]["confirmClave"].value;        
        var userExist = <?php echo json_encode($usuario) ?>;
        var correoExist = <?php echo json_encode($correo) ?>;

        var msg = "<ul>";
        var formOk = true;

        if(nombres == ""){
            msg += "<li> Nombres no puede ir vacío </li>";
            formOk = false;
        }        

        if(apellidos == ""){
            msg += "<li> Apellidos no puede ir vacío </li>";
            formOk = false;
        }        

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
            }else{
                if(correoExist != null){
                    for(i=0; i < correoExist.length; i++){
                        if(correo === correoExist[i]["correo"]){
                            msg += "<li> Correo ya existente </li>";                    
                            formOk = false;            
                        }  
                    }
                }
            }
        }        

        if(usuario == ""){
            msg += "<li> Usuario no puede ir vacío </li>";
            formOk = false;            
        }else{
            if(userExist != null){
                for(i=0; i < userExist.length; i++){
                    if(usuario === userExist[i]["usuario"]){
                        msg += "<li> Usuario ya existente </li>";                    
                        formOk = false;            
                    }  
                }
            }
        }
        
        if(clave == ""){
            msg += "<li> Clave no puede ir vacío </li>";
            formOk = false;            
        }        
            
        

        if(confirmClave == "" && clave != ""){
            msg += "<li> Tienes que confirmar Clave </li>";
            formOk = false;            
        }else if(clave != confirmClave){            
            msg += "<li> Claves no coinciden </li>" ;
            formOk = false;
        }                
        msg += "</ul>"

        if(!formOk){
            $("#errores").html(msg);
            $("#errores").fadeIn("slow");
        }
        return formOk;
    }

    $("#formRegistro").submit(function(e){
        e.preventDefault();
    });

    $("input").keyup(function(e){
        if(e.key == "Enter"){
            guardarAdmin();
        }
    });
</script>
</html>