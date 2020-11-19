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
    <title>Registrar Empleado</title>
</head>
<script type="text/javascript">
    function guardarEmp() {        
        if(validarCampos()){
            var datos = $("#formRegistro").serialize();                        
            $.ajax({
                data: datos,
                url: '/Jomar/users_control/controller/EmpleadoController.php?action=guardarInser',
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
                        html = "<h4> Se ha insertado correctamente </h4>";
                        $("#respuesta").removeClass("alert-danger");
                        $("#respuesta").addClass("alert-success");
                        $("#respuesta").html(html);
                        $("#respuesta").fadeIn("slow");
                        setTimeout(function(){
                            $("#respuesta").fadeOut(2000, function() {
                                $("#respuesta").html("");   
                                $("#respuesta").removeClass("alert-success");
                                $("#respuesta").addClass("alert-danger");                             
                                });
                        }, 2000);
                        $("#documento").val("");
                        $("#nombres").val("");
                        $("#apellidos").val("");
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
        <h1>Registrar <br> Empleado</h1>
    </div>
    <div id="respuesta" class="container w-50 text-center mb-5 alert-danger divHidden"></div>
    <form name="formRegistro" id="formRegistro" method="POST">
        <div class='container shadow p-5 mb-1 mt-n1 bg-white rounded' style= "width: 800px">            
            <div id="errores" class="alert-danger divHidden"></div>
            <div class="form-group row ml-1 justify-content-center">
                <label for="documento" class="col-form-label">No. Documento de Identidad:</label>
                <div class='col-sm-5 ml-2'>
                    <input type="number" class="form-control" autocomplete="off" id="documento" name="documento">
                </div>                         
            </div>                                    
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label for="nombres" class="col-form-label">Nombres:</label>
                <div class='col-sm-4 mr-3'>
                    <input type="text" class="form-control" autocomplete="off" id="nombres" name="nombres">
                </div>
                <label for="apellidos" class="col-form-label">Apellidos:</label>
                <div class='col-sm-4'>
                    <input type="text" class="form-control" autocomplete="off" id="apellidos" name="apellidos"> 
                </div>           
            </div>                                    
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label for="sede" class="col-form-label">Sede:</label>
                <div class='col-sm-4 mr-3'>
                    <select class="custom-select" name="sede" id="sede">
                    <option value="0">Seleccionar sede</option>
                    <?php 
                        for ($i=0; $i < count($sedes); $i++) { 
                            echo "<option value='{$sedes[$i]["id_sede"]}'>{$sedes[$i]["sede"]}</option>";
                        }
                    ?>
                    </select>
                </div>                
                <label for="cargo" class="col-form-label">Cargo:</label>
                <div class='col-sm-auto'>
                    <select class="custom-select" name="cargo" id="cargo">
                        <option value="0">Seleccionar cargo</option>
                        <?php 
                            for ($i=0; $i < count($cargos); $i++) { 
                                echo "<option value='{$cargos[$i]["id_cargo"]}'>{$cargos[$i]["cargo"]}</option>";
                            }
                        ?>
                    </select> <br><br>
                </div>
            </div>
            <div class="form-group row justify-content-center">
                <div class="justify-content-center">                
                    <button class="btn btn-primary mr-4 btn-md" style="width: 150px" id="submit" onclick="guardarEmp()" type="button">Registrar</button>            
                    <a class="btn btn-danger btn-md" role="button" style="width: 150px" href="/Jomar/users_control/controller/EmpleadoController.php?action=todos" >Cancelar</a>            
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
        var documento = document.forms["formRegistro"]["documento"].value;
        var sede = document.forms["formRegistro"]["sede"].value;
        var cargo = document.forms["formRegistro"]["cargo"].value;        
        var documentExist = <?php echo json_encode($documentos) ?>;

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

        if(documento == ""){
            msg += "<li> Documento no puede ir vacío </li>";
            formOk = false;
        }else{
            if(documentExist != null){
                for(i=0; i < documentExist.length; i++){
                    if(documento === documentExist[i]["documento"]){
                        msg += "<li> Documento ya existente </li>";                    
                        formOk = false;            
                    }  
                }
            }
        }                                               

        if(!/^([0-9])*$/.test(documento)){
            msg += "<li> Documento no debe tener signos, ni letras </li>";                    
            formOk = false; 
        }
        if(sede == "0"){
            msg += "<li> Debe seleccionar una sede </li>";
            formOk = false;
        }

        if(cargo == "0"){
            msg += "<li> Debe seleccionar un cargo </li>";
            formOk = false;
        }
        msg += "</ul>"

        if(!formOk){
            $("#errores").html(msg);            
            $("#errores").fadeIn("slow");
        }else{
            $("#errores").fadeOut("fast");
        }
        return formOk;
    }

    $("#formRegistro").submit(function(e){
        e.preventDefault();
    });

    $("input").keyup(function(e){
        if(e.key == "Enter"){
            guardarEmp();
        }
    });
</script>
</html>