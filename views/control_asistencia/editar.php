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
    <title>Editar registro</title>
</head>
    <script> 
    function llenarEmpleados(){
        var sede = $("#sede").val();
        var fecha = $("#fecha").val();
        var empleado = <?php echo $controlAsis[0]["id_empleado"] ?>;
        var parametros = {
            'sede' : sede,
            'fecha' : fecha,
            'empleado' : empleado
        };

        if(sede != 0 && fecha != ""){
            $.ajax({
                data: parametros,
                url: '/Jomar/users_control/controller/ControlAsisController.php?action=llenarEmpleados',
                type: 'post',
                success: function (response){
                    $("#empleado").html(response);                    
                    $("#empleado").attr("disabled", false);
                }
            });
        }else{
            var html = "<option value'0'>Seleccionar empleado</option>"
            $("#empleado").attr("disabled", "disabled");
            $("#empleado").html(html);
        }
    }

    function empleadoDisabled(){
        $("#empleado").attr("disable", "disabled");
    }    

    function editarRegistro() {        
        if(validarCampos()){
            var datos = $("#formEdit").serialize();                        
            $.ajax({
                data: datos,
                url: '/Jomar/users_control/controller/ControlAsisController.php?action=guardarEdit',
                type: 'post',
                success: function (response){
                    var html;                                  
                    if(response.trim() != "1"){                        
                        html = "<h4> No se ha podido insertar </h4>";
                        $("#respuesta").addClass("alert-danger");
                        $("#respuesta").html(html);
                        $("#respuesta").fadeIn("slow");
                        setTimeout(function(){
                            $("#respuesta").fadeOut(2000, function() {
                                $("#respuesta").html("");
                                $("#respuesta").removeClass("alert-danger");
                                });
                        }, 2000);
                    }else{                        
                        msg = "<h4> Se ha insertado correctamente </h4>";                        
                        localStorage.setItem("msg", msg);
                        location.href = "/Jomar/users_control/controller/ControlAsisController.php?action=todos";
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
        <h2>Editar registro</h2>
        <br>        
    </div>  
    <div id="respuesta" class="container w-50 text-center mb-5 divHidden"></div>      
    <form name="formEdit" id="formEdit" method="POST">
        <div class='container justify-content-center shadow p-5 mb-1 mt-n1 bg-white rounded' style= "width: 800px">            
            <div id="errores" class="alert-danger divHidden"></div>
            <input type="hidden" name="id" id="id" value="<?php echo $controlAsis[0]["id_controlAsis"] ?>">
            <div class="form-g align-content-centerroup row ml-1 justify-content-center">
                <label for="fecha" class="col-form-label">Fecha:</label>
                <div class='col-sm-4 mr-3'>
                    <input type="date" class="form-control" onchange="llenarEmpleados()" value="<?php echo $controlAsis[0]["fecha"] ?>" max="<?php echo date("Y-m-d") ?>" id="fecha" name="fecha">
                </div>
                <label for="sede" class="col-form-label">Sede:</label>
                <div class='col-sm-4'>
                    <select type="text" class="custom-select" onchange="llenarEmpleados()" id="sede" name="sede" >
                        <option value="0">Seleccionar sede</option>
                        <?php 
                            for ($i=0; $i < count($sedes); $i++) { 
                                if($sedes[$i]["id_sede"] == $controlAsis[0]["id_sede"]){
                                    echo "<option value='{$sedes[$i]['id_sede']}'selected>{$sedes[$i]['sede']}</option>";
                                }else{
                                    echo "<option value='{$sedes[$i]['id_sede']}'>{$sedes[$i]['sede']}</option>";
                                }
                            }
                        ?>
                    </select>
                </div>                 
            </div>                                    
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label for="empleado" class="col-form-label">Empleado:</label>
                <div class='col-sm-4 mr-3'>
                    <select type="text" class="custom-select" id="empleado" name="empleado" disabled="disabled">
                        <option value="0">Seleccionar empleado</option>
                        <?php 
                            for ($i=0; $i < count($empleados); $i++) { 
                                if($empleados[$i]["id_empleado"] == $controlAsis[0]["id_empleado"]){
                                    echo "<option value='{$empleados[$i]['id_empleado']}'selected>{$empleados[$i]['empleado']}</option>";
                                }else{
                                    echo "<option value='{$empleados[$i]['id_empleado']}'>{$empleados[$i]['empleado']}</option>";
                                }
                            }
                        ?>
                    </select>
                    <div id="mascara" onclick="empleadoIsEmpty()"></div>
                </div>
                <label for="asistencia" class="col-form-label">Asistencia:</label>
                <div class='col-sm-4'>
                    <select type="text" class="custom-select" id="asistencia" name="asistencia"> 
                            <option value="0">Seleccionar asistencia</option>
                            <?php
                                for($i=0; $i < count($asistencias); $i++){
                                    if($asistencias[$i]["id_asistencia"] == $controlAsis[0]["id_asistencia"]){
                                        echo "<option value='{$asistencias[$i]['id_asistencia']}'selected>{$asistencias[$i]['siglas']}</option>";
                                    }else{
                                        echo "<option value='{$asistencias[$i]['id_asistencia']}'>{$asistencias[$i]['siglas']}</option>";
                                    }
                                }
                            ?>
                    </select>
                </div>           
            </div>                                    
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label for="nota" class="col-form-label">Nota:</label>
                <div class='col-sm-5 mr-3'>
                    <textarea name="nota" id="nota" class="form-control" cols="4" rows="3" maxlength="100"></textarea>
                </div>                                                
            </div>
            <div class="form-group row justify-content-center">
                <div class="justify-content-center">                
                    <button class="btn btn-primary mr-4 btn-md" style="width: 150px" id="submit" onclick="editarRegistro()" type="button">Editar</button>            
                    <a class="btn btn-danger btn-md" role="button" style="width: 150px" href="/Jomar/users_control/controller/ControlAsisController.php?action=todos" >Cancelar</a>            
                </div>
            </div>
                <div class="row justify-content-end">
                    <button class="btn btn-info btn-md" onclick="setTimeout('llenarEmpleados()', 1)" type="reset">Limpiar</button>            
                </div>
        </div>
    </form>   
    <script> llenarEmpleados() </script>     
    <br>
    <div class='container text-center shadow col-md-4 p-5 mb-5 mt-3 bg-white rounded'>                  
        <div class=''>
        <h2>Siglas de asistencia</h2>
            <br>
            <?php 
                $html = "<ul class='list-group list-group-flush'>";
                for($i=0; $i < count($asistencias); $i++){
                    $html .= "<li class='list-group-item'> {$asistencias[$i]['asistencia']} = {$asistencias[$i]['siglas']} </li>";
                }
                $html .= "</ul>";
                echo $html;
            ?>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready( function(){
        $("#nota").val("<?php echo $controlAsis[0]["nota"] ?>");
    })

    function validarCampos(){        
        var fecha = document.forms["formEdit"]["fecha"].value;
        var empleado = document.forms["formEdit"]["empleado"].value;
        var sede = document.forms["formEdit"]["sede"].value;
        var asistencia = document.forms["formEdit"]["asistencia"].value;
        var nota = document.forms["formEdit"]["nota"].value;        

        var msg = "<ul>";
        var formOk = true;        
        
        if(fecha == "" || sede == "0"){
            if(empleado == "0"){
                msg += "<li> Debe seleccionar fecha y sede para habilitar los empleados </li>";
                formOk = false;
            }

            if(fecha == ""){
                msg += "<li> Debe seleccionar la fecha </li>";
                formOk = false;
            }                                                               
            
            if(sede == "0"){
                msg += "<li> Debe seleccionar una sede </li>";
                formOk = false;
            }
        }else{ 
            if(empleado == "0"){
                msg += "<li> Debe seleccionar un empleado </li>";
                formOk = false;
            }            
        }

        if(asistencia == "0"){
                msg += "<li> Debe seleccionar una asistencia </li>";
                formOk = false;
        }

        msg += "</ul>"

        if(!formOk){
            $("#errores").html(msg);            
            $("#errores").fadeIn("slow");
        }
        return formOk;
    }

    function empleadoIsEmpty(){
        empleado = document.forms["formEdit"]["empleado"];

        if(empleado.disabled){
            msg = "<ul>";
            msg += "<li> Debes seleccionar fecha y sede para habilitar los empleados </li>" 
            msg += "</ul>";

            $("#errores").html(msg);
            $("#errores").fadeIn("slow");
        }else{            
        }
    }

    $("#formRegistro").submit(function(e){
        e.preventDefault();
    });

    $("input").keyup(function(e){
        if(e.key == "Enter"){
            editarRegistro();
        }
    });

</script>
<style type="text/css">
    #contenedor{
    position: relative;
    }
    
    #empleado:disabled + #mascara{
    display: block;
    }

    #mascara{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    }
</style>
</html>