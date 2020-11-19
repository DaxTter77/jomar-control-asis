<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">    
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <title>Editar Administrador</title>
</head>
<script type="text/javascript">
    function editarAdmin() {        
        if(validarCampos()){
            var datos = $("#formEditar").serialize();                        
            $.ajax({
                data: datos,
                url: '/Jomar/users_control/controller/AdminController.php?action=guardarEdit',
                type: 'post',
                success: function (response){
                    var html;      
                    if(response.trim() != "1"){
                        html = "<h4> No se ha podido editar </h4>";                        
                        $("#respuesta").html(html);
                        $("#respuesta").fadeIn("slow");
                        setTimeout(function(){
                            $("#respuesta").fadeOut(2000, function() {
                                $("#respuesta").html("");                            
                                });
                        }, 2000);
                    }else{                        
                        if(localStorage.getItem("menu") == "true"){
                            localStorage.removeItem("menu");
                            location.href = "/Jomar/users_control/controller/AdminController.php?action=menu";                    
                        }else{
                            msg = "<h4> Se ha editado correctamente </h4>";                        
                            localStorage.setItem("msg", msg);
                            location.href = "/Jomar/users_control/controller/AdminController.php?action=todos";
                        }
                    }
                }
            });
        }
    }

    $(document).ready(function(){
        $("header").load("/Jomar/users_control/views/header/header.php");
    });

    function volver(){
        if(localStorage.getItem("menu") == "true"){
            localStorage.removeItem("menu");
            location.href = "/Jomar/users_control/controller/AdminController.php?action=menu";                    
        }else{
            location.href = "/Jomar/users_control/controller/AdminController.php?action=todos";
        }
    }
</script>
<body>
    <header></header>
    <div class='container text-center shadow col-md-4 p-5 mb-5 mt-3 bg-white rounded'>
        <h1>Editar <br> Administrador</h1>
    </div>
    <div id="respuesta" class="container w-50 text-center mb-5 alert-danger divHidden"></div>
    <form id="formEditar" name="formEditar" method="POST">
        <div class='container shadow p-5 mb-1 mt-n1 bg-white rounded' style= "width: 800px">            
            <div id="errores" class="alert-danger divHidden"></div>
            <input type="hidden" name="id" value="<?php echo ($admin[0]["id_admin"]); ?>">
            <div class="form-group row ml-1">
                <label for="nombres" class=" col-form-label">Nombres:</label>
                <div class='col-sm-auto mr-2'>
                    <input type="text" class="form-control" id="nombres" name="nombres" autocomplete="off" value="<?php echo $admin[0]["nombres"]; ?>">
                </div>
                <label for="apellidos" class="col-form-label">Apellidos:</label>
                <div class='col-sm-auto'>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" autocomplete="off" value="<?php echo $admin[0]["apellidos"] ?>"> 
                </div>           
            </div>            
            <br>
            <div class="form-group row ml-1">
                <label class=" col-form-label" for="inlineFormInputGroup">Correo:</label>
                <div class="input-group-prepend col-sm-auto">
                <div class="input-group-text">@</div>                
                <input type="text" class="form-control" id="inlineFormInputGroup" name="correo" autocomplete="off" value="<?php echo $admin[0]["correo"] ?>">
                </div>
                <label for="usuario" class="col-form-label">Usuario:</label>
                <div class='col-sm-auto'>
                    <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" value="<?php echo $admin[0]["usuario"] ?>">
                </div>
            </div>
            <br>          
            <div>
                <a role="button" style="width: 200px" class="btn btn-link mb-3 row" href="javascript: abrirVentana()">Cambiar Contraseña</a>
            </div>  
            <div class="form-group row justify-content-center">
                <div class="justify-content-center">
                    <button class="btn btn-primary mr-4 btn-md" style="width: 150px" onclick="editarAdmin()" type="button">Editar</button>            
                    <a class="btn btn-danger btn-md" role="button" style="width: 150px" href="javascript: volver()" >Cancelar</a>
                </div>
            </div>
                <div class="row justify-content-end">
                    <button class="btn btn-info btn-md" type="reset">Restaurar</button>            
                </div>
        </div>
    </form>
</body>
<script type="text/javascript">        
    function validarCampos(){
        var nombres = document.forms["formEditar"]["nombres"].value;
        var apellidos = document.forms["formEditar"]["apellidos"].value;
        var correo = document.forms["formEditar"]["correo"].value;
        var usuario = document.forms["formEditar"]["usuario"].value;   
        var antUsu = "<?php echo $admin[0]["usuario"] ?>";
        var antCorreo = "<?php echo $admin[0]["correo"] ?>";
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
            }
            if(correo != antCorreo){
                for(i=0; i < correoExist.length; i++){
                        if(correo === correoExist[i]["correo"]){
                            msg += "<li> Correo ya existente </li>";                    
                            formOk = false;            
                        }  
                    }
            }
        }      

        if(usuario == ""){
            msg += "<li> Usuario no puede ir vacío </li>";
            formOk = false;            
        }else if (usuario != antUsu){
            for(i=0; i < userExist.length; i++){
                if(usuario === userExist[i]["usuario"]){
                    msg += "<li> Usuario ya existente </li>";                    
                    formOk = false;            
                }  
            }
        }
        
        msg += "</ul>"

        if(!formOk){
            $("#errores").html(msg);
            $("#errores").fadeIn("slow");
        }
        return formOk;
    }

    function abrirVentana(){
        window.open("/Jomar/users_control/controller/AdminController.php?action=cambiar&id_admin=<?php echo $admin[0]["id_admin"] ?>", 
        "Cambiar Clave", "width= 600, height= 600, top= 100, left= 543, menubar= no");
    }

    $("#formEditar").submit(function(e){
        e.preventDefault();
    });

    $("input").keyup(function(e){
        if(e.key == "Enter"){
            editarAdmin();
        }
    });
</script>
</html>