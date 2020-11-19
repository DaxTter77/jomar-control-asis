<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta id="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <title>Realizar registro</title>
</head>
<script type="text/javascript"> 
    function llenarEmpleados(){
        var sede = $("#sede").val();
        var fecha = $("#fecha").val();
        var parametros = {
            'sede' : sede,
            'fecha' : fecha
        };

        if(sede != 0 && fecha != ""){
            $.ajax({
                data: parametros,
                url: '/Jomar/users_control/controller/ControlAsisController.php?action=llenarEmpleados',
                type: 'post',
                success: function (response){
                    $("#empleado").html(response);
                    $("#empleado").attr("disabled", false);
                    $("#empleado").selectpicker("refresh");
                }
            });
        }else{
            var html = ""
            $("#empleado").attr("disabled", "disabled");
            $("#empleado").html(html);
            $("#empleado").selectpicker("refresh");
        }
    }
    
    $(document).ready(function () {
        $('#empleado').selectpicker();
        /*$('#empleado').multiselect({
            buttonWidth: '200px',
            inheritClass: true,
            buttonText: function(options, select) {
                if (options.length === 0) {
                    return 'Seleccionar Empleados';
                }
                if (options.length === select[0].length) {
                    return 'Todos ('+select[0].length+')';
                }
                else if (options.length >= 1) {
                    return options.length + ' Seleccionados';
                }
            }
        });*/
    });

    function empleadoDisabled(){
        $("#empleado").attr("disable", "disabled");
    }    
    
    $(document).ready(function(){
        $("header").load("/Jomar/users_control/views/header/header.php");
    });

    function habilitarInput(){
        if($("#checkinput").prop("checked")){
            $("#hasta").prop("disabled", false);
        }else{
            $("#hasta").prop("disabled", true);
        }
    }

    $(document).ready(function(){
        habilitarInput();
    });

    function contarSeleccionados(){
        var cont=0;
        $("#empleado option:selected").each(function(){
            cont++;
        });
        if(cont > 1){
            $("#empleado").prop("name", "empleado[]");
            enviarMultiple();
        }else{
            $("#empleado").prop("name", "empleado");
            enviarRegistro();
        }
    }

    function enviarRegistro(){
        if(validarCampos()){
            var datos = $("#formRegistro").serialize();
            $("#pageLoader").fadeIn("fast");
            if($("#checkinput").prop("checked")){
                $.ajax({
                    data: datos,
                    url: '/Jomar/users_control/controller/ControlAsisController.php?action=guardarHasta',
                    type: 'post',
                    success: function(response){
                        var html;
                        if(response.trim() != "1"){
                            html = "<h4> No se han podido insertar "+ response.trim() +" registros</h4>";
                            $("#respuesta").addClass("alert-danger");
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            setTimeout(function(){
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    $("#respuesta").removeClass("alert-danger");
                                    });
                            }, 2000);
                        }else{
                            $("#respuesta").addClass("alert-success");
                            html = "<h4> Se ha insertado correctamente </h4>";
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            $("#empleado").val(0);
                            $("#nota").val("");
                            llenarEmpleados();
                            $("#errores").fadeOut("slow");
                            setTimeout(function(){
                                $("#respuesta").removeClass("alert-success");
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    });
                            }, 2000);
                        }
                    }
                });
            }else{
                $.ajax({
                    data: datos,
                    url: '/Jomar/users_control/controller/ControlAsisController.php?action=guardarInser',
                    type: 'post',
                    success: function (response){
                        var html;
                        if(response.trim() != "1"){
                            html = "<h4> No se ha podido insertar </h4>";
                            $("#respuesta").addClass("alert-danger");
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            setTimeout(function(){
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    $("#respuesta").removeClass("alert-danger");
                                    });
                            }, 2000);
                        }else{
                            $("#respuesta").addClass("alert-success");
                            html = "<h4> Se ha insertado correctamente </h4>";
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            $("#empleado").val(0);
                            $("#nota").val("");
                            llenarEmpleados();
                            $("#errores").fadeOut("slow");
                            setTimeout(function(){
                                $("#respuesta").removeClass("alert-success");
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    });
                            }, 2000);
                        }
                    }
                });
            }
        }
    }

    function enviarMultiple(){
        if(validarCampos()){
            var datos = $("#formRegistro").serializeArray();
            $("#pageLoader").fadeIn("fast");
            if($("#checkinput").prop("checked")){
                $.ajax({
                    data: datos,
                    url: '/Jomar/users_control/controller/ControlAsisController.php?action=guardarMultiHasta',
                    type: 'post',
                    success: function (response){
                        var html;
                        if(response.trim() != "1"){
                            html = "<h4> No se han podido insertar "+ response.trim() +" registros</h4>";
                            $("#respuesta").addClass("alert-danger");
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            setTimeout(function(){
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    $("#respuesta").removeClass("alert-danger");
                                    });
                            }, 2000);
                        }else{
                            $("#respuesta").addClass("alert-success");
                            html = "<h4> Se ha insertado correctamente </h4>";
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            $("#empleado").val(0);
                            $("#nota").val("");
                            llenarEmpleados();
                            $("#errores").fadeOut("slow");
                            setTimeout(function(){
                                $("#respuesta").removeClass("alert-success");
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    });
                            }, 2000);
                        }
                    }
                });
            }else{
                $.ajax({
                    data: datos,
                    url: '/Jomar/users_control/controller/ControlAsisController.php?action=guardarMulti',
                    type: 'post',
                    success: function (response){
                        var html;
                        if(response.trim() != "1"){
                            html = "<h4> No se han podido insertar"+ response +" registros</h4>";
                            $("#respuesta").addClass("alert-danger");
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            setTimeout(function(){
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    $("#respuesta").removeClass("alert-danger");
                                    });
                            }, 2000);
                        }else{
                            $("#respuesta").addClass("alert-success");
                            html = "<h4> Se ha insertado correctamente </h4>";
                            $("#respuesta").html(html);
                            $("#pageLoader").fadeOut("fast");
                            $("#respuesta").fadeIn("slow");
                            $("#empleado").val(0);
                            $("#nota").val("");
                            llenarEmpleados();
                            $("#errores").fadeOut("slow");
                            setTimeout(function(){
                                $("#respuesta").removeClass("alert-success");
                                $("#respuesta").fadeOut(2000, function() {
                                    $("#respuesta").html("");
                                    });
                            }, 2000);
                        }
                    }
                });
            }
        }
    }
</script>
<body>    
    <header></header>
    <div class='container text-center shadow col-md-4 p-5 mb-5 mt-3 bg-white rounded'>
        <h2>Realizar registro</h2>
        <br>        
    </div>  
    <br>
    <div class="loader divHidden" id="pageLoader"></div>
    <div id="respuesta" class="container w-50 text-center mb-5 divHidden"></div>      
    <form name="formRegistro" id="formRegistro" method="POST">
        <div class='container justify-content-center shadow p-5 mb-1 mt-n1 bg-white rounded' style= "width: 800px">
            <div id="errores" class="alert-danger divHidden"></div>
            <div class="form-g align-content-centerroup row ml-1 justify-content-center">
                <label for="fecha" class="col-form-label">Fecha:</label>
                <div class='col-sm-4 mr-5'>
                    <input type="date" class="form-control" onchange="llenarEmpleados()" onkeydown="return false" value="<?php echo date("Y-m-d") ?>" max="<?php echo date("Y-m-d") ?>" id="fecha" name="fecha">
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" onclick="habilitarInput()" class="custom-control-input" id="checkinput">
                    <label for="checkinput" class="col-form-label custom-control-label"> Hasta:</label>
                </div>
                <div class='col-sm-4'>
                    <input type="date" class="form-control disabled" onkeydown="return false" onchange="llenarEmpleados()" value="<?php echo date("Y-m-d") ?>" id="hasta" name="hasta" disabled>
                </div>
            </div>
            <br>      
            <div class="form-g align-content-centerroup row ml-1 justify-content-center">                              
                <label for="sede" class="col-form-label">Sede:</label>
                <div class='col-sm-4'>
                    <select type="text" class="custom-select" onchange="llenarEmpleados()" id="sede" name="sede" >
                        <option value="0">Seleccionar sede</option>
                        <?php 
                            for ($i=0; $i < count($sedes); $i++) { 
                                echo "<option value='{$sedes[$i]['id_sede']}'>{$sedes[$i]['sede']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label for="empleado" class="col-form-label">Empleado:</label>
                <div class='col-sm-4 mr-3'>
                    <select class="selectpicker" multiple data-size="6" data-live-search="true" data-selected-text-format="count" data-actions-box="true" title="Seleccionar empleado(s)" id="empleado" name="empleado" disabled="disabled">
                    </select>
                    <!--<div id="mascara" onclick="empleadoIsEmpty()"></div>-->
                </div>
                <label for="asistencia" class="col-form-label">Asistencia:</label>
                <div class='col-sm-4'>
                    <select type="text" class="custom-select" id="asistencia" name="asistencia"> 
                            <option value="0">Seleccionar asistencia</option>
                            <?php
                                for($i=0; $i < count($asistencias); $i++){
                                    echo "<option value='{$asistencias[$i]['id_asistencia']}'>{$asistencias[$i]['siglas']}</option>";
                                }
                            ?>
                    </select>
                </div>           
            </div>                                    
            <br>
            <div class="form-group row ml-1 justify-content-center">
                <label for="nota" class="col-form-label">Nota:</label>
                <div class='col-sm-5 mr-3'>
                    <textarea name="nota" id="nota" class="form-control" cols="4" rows="3"></textarea>
                </div>                                                
            </div>
            <div class="form-group row justify-content-center">
                <div class="justify-content-center">                
                    <button class="btn btn-primary mr-4 btn-md" style="width: 150px" id="submit" onclick="contarSeleccionados();" type="button">Registrar</button>
                    <a class="btn btn-danger btn-md" role="button" style="width: 150px" href="/Jomar/users_control/controller/ControlAsisController.php?action=todos" >Cancelar</a>
                </div>
            </div>
                <div class="row justify-content-end">
                    <button class="btn btn-info btn-md" onclick="setTimeout('llenarEmpleados(); habilitarInput();', 1)" type="reset">Limpiar</button>            
                </div>
        </div>
    </form>        
    <br>
    <div class='container text-center shadow col-md-4 p-5 mb-5 mt-3 bg-white rounded'>                  
        <div class=''>
        <h2>Siglas de asistencia</h2>
            <br>
            <?php 
                if($asistencias != null){
                    $html = "<ul class='list-group list-group-flush'>";
                    for($i=0; $i < count($asistencias); $i++){
                        $html .= "<li class='list-group-item'> {$asistencias[$i]['asistencia']} = {$asistencias[$i]['siglas']} </li>";
                    }
                    $html .= "</ul>";
                    echo $html;
                }else{
                    echo "<h4>No hay asistencias</h4>";
                }
            ?>
        </div>
    </div>
</body>
<script type="text/javascript">
    function validarCampos(){        
        var fecha = document.forms["formRegistro"]["fecha"].value;
        var empleado = document.forms["formRegistro"]["empleado"].value;
        var sede = document.forms["formRegistro"]["sede"].value;
        var asistencia = document.forms["formRegistro"]["asistencia"].value;
        var nota = document.forms["formRegistro"]["nota"].value;  
        var hasta = document.forms["formRegistro"]["hasta"].value;
        var fechaPart = fecha.split("-");
        var hastaPart = hasta.split("-");
        
        var msg = "<ul>";
        var formOk = true;        
        var cont=0;
        $("#empleado option:selected").each(function(){
            cont++;
        });
        
        if(fecha == "" || sede == "0"){
            if(cont == 0){
                msg += "<li> Debe seleccionar fecha y sede para habilitar los empleados </li>";
                formOk = false;
            }
        }else{
            if(cont == 0){
                msg += "<li> Debe seleccionar un empleado </li>";
                formOk = false;
            }   
        }
        if(sede == "0"){
            msg += "<li> Debe seleccionar una sede </li>";
            formOk = false;
        }
        if(fecha == ""){
            msg += "<li> Debe seleccionar la fecha </li>";
            formOk = false;
        }else if(!$("#hasta").prop("disabled")){
            if(fecha === hasta){
                msg += "<li> Ambas fechas no pueden ser las mismas </li>";
                formOk = false;
            }
            if(fechaPart["0"] != hastaPart["0"]){
                msg += "<li> Las fechas no pueden ser de años distintos </li>";
                formOk = false;
            }else if(fechaPart["1"] != hastaPart["1"]){
                msg += "<li> Las fechas no pueden ser de meses distintos </li>";
                formOk = false;
            }
            if(fechaPart["2"] > hastaPart["2"] && fechaPart["1"] == hastaPart["1"] && fechaPart["1"] == hastaPart["1"]){
                msg += "<li> La fecha hasta no puede ser menor que la otra </li>";
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
        }else{
            $("#errores").fadeOut("fast");
        }
        return formOk;
    }

    function empleadoIsEmpty(){
        empleado = document.forms["formRegistro"]["empleado"];

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
            enviarRegistro();
        }
    });

</script>
<style type="text/css">
    /*#contenedor{
        position: relative;
    }*/

    /* Aplicamos la instrucción de que si el elemento "empleado" es disabled entonces su elemento hermano "mascara" tendrá un display block */
    /*#empleado:disabled + #mascara{
        display: block;
    }

    #mascara{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
    }*/
</style>
</html>