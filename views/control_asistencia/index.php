<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta id="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--<script src="https://unpkg.com/floatthead"></script>!-->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <link href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <title>Control de Asistencia</title>
</head>
<style>
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
</style>
<script type="text/javascript">
    function goPage(){
        self.location.replace('/Jomar/users_control/controller/ControlAsisController.php?action=todos');
    }

    function ajustarScroll(){
        var divTable = document.getElementById("contentTable");
        var table = document.getElementById("table");
        
        if(divTable.clientHeight > 425){
            //divTable.className += " divScroll";
            //floatHead();
        }
    }

    function filtros(){
        var sede = document.getElementById("sede").value;
        var sigla = document.getElementById("sigla");
        var dia = document.getElementById("dia").value;
        var hasta = document.getElementById("diaHasta").value;
        var mes = document.getElementById("mes").value;
        var ano = document.getElementById("year").value;
        var action = "/Jomar/users_control/controller/ControlAsisController.php?action=todos";
        var cont=0;
        var siglas = $("#sigla").serializeArray();
        $("#sigla option:selected").each(function(){
            cont++;
        });
        
        if(dia != 0){
            action += "&fecha=" + ano + "-" + mes + "-" + dia;
            if(hasta != 0){
                action += "&hasta=" + hasta;
            }
        }else if(mes != 0 && ano != 0){
            action += "&mes=" + mes + "&ano=" + ano
        }
        if(sede != 0){
            action += "&sede=" + sede;
        }
        if (cont != 0) {
            action += "&sigla=";
            for(let i=0; i < siglas.length; i++){
                action += siglas[i]["value"] +"-";
            }
        }

        location.href = action;
    }

    function limpiarFiltros(){
        var sede = document.getElementById("sede");
        var sigla = document.getElementById("sigla");
        var dia = document.getElementById("dia");
        var mes = document.getElementById("mes");
        var ano = document.getElementById("year");
        
        dia.value = 0;
        mes.value = 0;
        ano.value = 0;
        sigla.value = 0;
        sede.value = 0;

        filtros();
        llenarSelect();
    }

    function llenarSelect(mes, ano){        
        var parametros = {
                "mes" : mes,
                "ano" : ano
        };

        if(mes != 0 && ano != 0){
            $.ajax({
                    data:  parametros, //datos que se envian a traves de ajax
                    url:   '/Jomar/users_control/controller/ControlAsisController.php?action=llenarDias', //archivo que recibe la peticion
                    type:  'post', //método de envio
                    success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                                $("#dia").html(response);
                                $("#dia").attr("disabled", false);
                                $("#diaHasta").html(response);
                                selectDia();
                                habilitarHasta();
                    }
            });
        }else{
            $("#dia").attr("disabled", "disabled");     
            $("#diaHasta").attr("disabled", "disabled");     
        }
    }

    function selectDia(){
        dia = <?php echo isset($dia) ? $dia : 0 ?>;
        select = document.getElementById("dia");
        hasta = <?php echo isset($hasta) ? $hasta : 0 ?>;
        selectHasta = document.getElementById("diaHasta");

        if(dia != 0){
            for(var i=0; i < select.length; i++){
                if(select.options[i].value == dia){
                    select.selectedIndex = i;
                }
            }
        }
        
        if(hasta != 0){
            for(var i=0; i < selectHasta.length; i++){
                if(selectHasta.options[i].value == hasta){
                    selectHasta.selectedIndex = i;
                }
            }
        }
    }

    function desHabilitarMes(){
        year = $("#year").val();

        if(year == 0){
            $("#mes").attr("disabled", "disabled");
            $("#dia").attr("disabled", "disabled");
            $("#diaHasta").attr("disabled", "disabled");
        }else{
            $("#mes").attr("disabled", false);
            $("#dia").attr("disabled", false);
            $("#diaHasta").attr("disabled", false);
        }
    }

    function floatHead(){
        var $table = $("table");
        $table.floatThead({
            scrollContainer: function($table){
                return $table.closest('#contentTable');
            }
        });
    }

    function floatDestroy(){
        var $table = $("table");
        $table.floatThead('destroy');
    }

    function tableDT(){
        tableData = $('#table').DataTable( {
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            columnDefs:[{
                targets: "_all",
                sortable: false
            }],
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true,
            language: {
                "search" : "Buscar",
                "zeroRecords" : "No se encontraron registros coincidentes",
                "info" : "Viendo _END_ de _TOTAL_ entradas en total",
                "infoFiltered" : "(Filtrados de _MAX_ entradas en total)",
                "loadingRecords" : "Cargando......",
                "infoEmpty" : "Viendo 0 de 0 entradas",
                "emptyFile" : "No hay información disponible"
            }
        });
    }

    function consultarDatos(){
        var url = window.location.pathname + window.location.search;
        var datos = {
            'confirm': true
        };        
        
        $.ajax({
            data: datos,
            url: url,
            type: 'post',
            dataType: 'json',
            success: function(response){ 
                    if(response != null){
                        $("table tbody").html("");
                        $.each(response, function(i){
                            var rutaEd = "/Jomar/users_control/controller/ControlAsisController.php?action=editar&id_controlAsis="+this.id_controlAsis;
                            $("table tbody").append("<tr><td>"+ (i+1) +"</td>"
                            + "<td>"+ this.fecha+"</td>"
                            + "<td>"+ this.documento+"</td>"
                            + "<td>"+ this.nombres +" "+ this.apellidos +"</td>"
                            + "<td>"+ this.sede+"</td>"
                            + "<td>"+ this.siglas+"</td>"
                            + "<td style='text-align: justify; width: 200px'>"+ this.nota+"</td>"
                            + "<td> <a href='"+rutaEd+"' class='badge badge-primary'>Editar </a> <a href='javascript: eliminarRegistro(\""+this.id_controlAsis+"\")' class='badge badge-warning'>Eliminar </a>"
                            + "<br><input type='checkbox' value='"+ this.id_controlAsis+"'></td></tr>");
                        });                    
                    }else{
                        $("#contentTable").html("");                        
                        $("#contentTable").remove("divScroll");
                        $("#vacio").fadeIn("slow");
                    }     
            }
        });
    }

    function eliminarRegistro(id){
        eliminar = confirm("¿Desea eliminar este registro?");
        if(eliminar){
            //floatDestroy();
            $.ajax({                        
                url: "/Jomar/users_control/controller/ControlAsisController.php?action=eliminar&id_controlAsis="+id,
                success: function(response){
                    if(response.trim() == "1"){
                        consultarDatos();
                        $("#mensaje").html("<h4>Se ha eliminado correctamente</h4>");
                        $("#mensaje").fadeIn("slow");
                        setTimeout(function(){
                            $("#mensaje").fadeOut(2000, function(){
                                $("#mensaje").html("");
                            });
                        }, 2000);
                    }else{                    
                        $("#mensaje").html("<h4>No se ha podido eliminar</h4>");
                        $("#mensaje").removeClass("alert-success");
                        $("#mensaje").addClass("alert-danger");
                        $("#mensaje").fadeIn("slow");
                        setTimeout(function(){
                            $("#mensaje").fadeOut(2000, function(){
                                $("#mensaje").html("");
                                $("#mensaje").removeClass("alert-danger");
                                $("#mensaje").addClass("alert-success");
                            });
                        }, 2000);
                    }
                }        
            });
        }
    }

    function guardarSeleccionados(){
        var seleccionados = [];
        $("table input[type=checkbox]:checked").each(function(){
            seleccionados.push($(this).val());
        });
        return seleccionados;
    }

    function deSeleccionar(){
        $("table input[type=checkbox]:checked").each(function(){
            $(this).prop("checked", false);
        });
    }

    function seleccionarTodos(){
        $("table input[type=checkbox]").each(function(){
            $(this).prop("checked", "checked");
        });
    }

    function contarCheck(){
        var selec = 0;
        $("table input[type=checkbox]:checked").each(function(){
            selec++;
        });
        return selec;
    }

    function abrirModal(){
        var selec = 0;
        selec = contarCheck();
        if(selec >= 1){
            $("#modalEdit").modal();
        }else{
            $("#modalAviso .modal-body").html("<p>No se han seleccionado registros.</p>"
            + "<br><br> <button type='button' class='btn btn-primary center-content-div' data-dismiss='modal'>Aceptar</button>");
            $("#modalAviso").modal();
        }
    }

    function editarSeleccionados(){
        if(validarCampos()){
            $("#pageLoader").fadeIn("fast");
            var ids = guardarSeleccionados();
            var asistencia = document.getElementById("asistencia").value;
            var html = "";
            var datos = {
                "ids" : ids,
                "asistencia" : asistencia
            };
            $.ajax({
                url: "/Jomar/users_control/controller/ControlAsisController.php?action=guardarEditMulti",
                data: datos,
                type: "post",
                success: function(response){
                    if(response.trim() != "1"){
                        consultarDatos();
                        if(response.trim() == "0"){
                            html = "<h5>Error al intentar editar</h5>";
                        }else{
                            html = "<h5>No se han podido editar "+ response + " registros</h5>";
                        }
                        $("#pageLoader").fadeOut("fast");
                        $("#modalEdit").modal("hide");
                        $("#modalAviso .modal-body").html(html
                        + "<br><br> <button type='button' class='btn btn-primary center-content-div' data-dismiss='modal'>Aceptar</button>");
                        $("#modalAviso").modal();

                    }else{
                        consultarDatos();
                        html = "<h5>Se han editado correctamente</h5>";
                        $("#pageLoader").fadeOut("fast");
                        $("#modalEdit").modal("hide");
                        $("#modalAviso .modal-body").html(html
                        + "<br><br> <button type='button' class='btn btn-primary center-content-div' data-dismiss='modal'>Aceptar</button>");
                        $("#modalAviso").modal();
                    }
                }
            });
        }
    }

    function eliminarVarios(id){
        var selec = 0;
        selec = contarCheck();
        if(selec >= 1){
            eliminar = confirm("¿Desea eliminar este registro?");
            if(eliminar){
                $("#pageLoader").fadeIn("fast");
                var html = "";
                var ids = guardarSeleccionados();
                var datos = {
                    "ids": ids
                };
                $.ajax({                        
                    url: "/Jomar/users_control/controller/ControlAsisController.php?action=eliminarMulti",
                    data: datos,
                    type: "post",
                    success: function(response){
                        if(response.trim() == "1"){
                            consultarDatos();
                            html = "<h5>Se han eliminado correctamente</h5>";
                            $("#pageLoader").fadeOut("fast");
                            $("#modalAviso .modal-body").html(html
                            + "<br><br> <button type='button' class='btn btn-primary center-content-div' data-dismiss='modal'>Aceptar</button>");
                            $("#modalAviso").modal();
                            setTimeout(function(){
                                $("#mensaje").fadeOut(2000, function(){
                                    $("#mensaje").html("");
                                });
                            }, 2000);
                        }else{
                            html = "<h5>No se han podido eliminar"+ response +" registros</h5>";
                            $("#pageLoader").fadeOut("fast");
                            $("#modalAviso .modal-body").html(html
                            + "<br><br> <button type='button' class='btn btn-primary center-content-div' data-dismiss='modal'>Aceptar</button>");
                            $("#modalAviso").modal();
                            setTimeout(function(){
                                $("#mensaje").fadeOut(2000, function(){
                                    $("#mensaje").html("");
                                    $("#mensaje").removeClass("alert-danger");
                                    $("#mensaje").addClass("alert-success");
                                });
                            }, 2000);
                        }
                    }        
                });
            }
        }else{
            $("#modalAviso .modal-body").html("<p>No se han seleccionado registros.</p>"
            + "<br><br> <button type='button' class='btn btn-primary center-content-div' data-dismiss='modal'>Aceptar</button>");
            $("#modalAviso").modal();
        }
        
    }

    function habilitarHasta(){
        select = document.getElementById("diaHasta");
        selectDia = document.getElementById("dia").value;

        if(selectDia != 0){
            select.disabled = false;
        }else{
            select.disabled = true;
        }
    }

    $(document).ready(function(){
        $("header").load("/Jomar/users_control/views/header/header.php");
        $('#sigla').selectpicker();
    });

</script>
<body style="background-color:#800D0D0D">
    <header></header>
    <div class='container text-center shadow p-5 mb-5 mt-3 bg-white rounded'>
        <h3> Control de Asistencia </h3> 
        <br>           
        <div class="row">                
            <div class="col">
                <label for="sede" class="col-form-label align-self-center ">Sede:</label>
                <br>
                <select name="sede" id="sede" class="custom-select text-center align-self-center" style="height: 40px; width: 200px">
                <option value="0">Todas las Sedes</option>
                    <?php                         
                        for($i=0; $i < count($sedes); $i++){                                                            
                            if($sedes[$i]["id_sede"] == $sedeSelect){
                                echo "<option value='{$sedes[$i]["id_sede"]}' selected>{$sedes[$i]["sede"]}</option>";                                
                            }else{
                                echo "<option value='{$sedes[$i]["id_sede"]}'>{$sedes[$i]["sede"]}</option>";
                            }
                        }
                    ?>
                </select>                    
            </div>
            <div class="col">                                
                <label class="col-form-label">Fecha: </label>
                <br>
                <select name="mes" id="mes" class="custom-select" onchange="llenarSelect($('#mes').val(), $('#year').val())" style="height: 40px; width: 130px">
                    <option value="0">Mes</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
                <script>
                    mes = <?php echo $mes ?>;
                    select = document.getElementById("mes");

                    for(var i=0; i < select.length; i++){
                        if(select.options[i].value == mes){
                            select.selectedIndex = i;
                        }
                    }
                </script>
                <select name="year" id="year" class="custom-select text-center" onchange="desHabilitarMes()" style="height: 40px; width: 80px">
                    <option value="0">Año</option>
                    <?php 
                        $y = date("Y");
                        for($i=2015; $i <= $y; $i++){
                            if($i == $y){
                                echo "<option value='$i' selected>$i</option>";
                            }else{
                                echo "<option value='$i'>$i</option>";
                            }
                        }
                        ?>
                </select>
                <br>                
                <select name="dia" id="dia" class="custom-select" onchange="habilitarHasta()" style="height: 40px; width: 80px; margin-top: 10px" ">
                    <option value="0">Día</option>
                </select>
                <label for="diaHasta" style="margin-left: 5px; margin-right: 5px">A</label>
                <select name="diaHasta" id="diaHasta" class="custom-select" style="height: 40px; width: 80px; margin-top: 10px" ">
                    <option value="0">Día</option>
                </select>
            </div>
            <div class="col">
                <label for="sigla" class="col-form-label">Sigla:</label>
                <br>
                <select class="selectpicker" name="sigla" id="sigla" style="height: 40px; width: 200px" multiple data-size="6" data-live-search="true" data-selected-text-format="count" title="Todas las siglas">
                    <?php
                        $j = 0;
                        for($i=0; $i < count($asistencias); $i++){
                            if($asistencias[$i]["id_asistencia"] == $siglaSelect[$j]){
                                echo "<option value='{$asistencias[$i]["id_asistencia"]}' selected>{$asistencias[$i]["siglas"]}</option>";
                                $j++;
                            }else{
                                echo "<option value='{$asistencias[$i]["id_asistencia"]}'>{$asistencias[$i]["siglas"]}</option>";
                            }
                        }
                    ?>
                </select> 
                <br>
            </div>
            <div class="col-sm-2">
                <a href="javascript: limpiarFiltros()" class="btn btn-link">Limpiar filtros</a>
                <br>
                <a href="javascript: filtros()" class="btn btn-outline-dark mt-2">Filtrar</a>
            </div>
        </div>    
    </div>
    <div class='alert-success container w-75 text-center mb-5' id="mensaje"></div>
    <?php
        $url = $_SERVER["REQUEST_URI"];
        $posicion = strpos($url, "action=todos");
        if($posicion === false){
            echo "<script> goPage() </script>";
        }else if($posicion = strpos($url, "&") !== false){
            $posicionF = strpos($url, "&fecha=");
            $posicionS = strpos($url, "&sede=");
            $posicionSi = strpos($url, "&sigla=");
            $posicionMes = strpos($url, "&mes=");
            
            if($posicionF === false){
                if($posicionMes === false){
                    echo "<script> goPage() </script>";
                }else{
                    if($posicionS !== false && ($posicionS - $posicionF) < 16){
                        echo "<script> goPage() </script>";
                    }
                    if($posicionSi !== false && ($posicionSi - $posicionS) < 8){
                        echo "<script> goPage() </script>";
                    }
                }
            }else{
                if($posicionS !== false && ($posicionS - $posicionF) < 17){
                    echo "<script> goPage() </script>";
                }
                if($posicionSi !== false && ($posicionSi - $posicionS) < 8){
                    echo "<script> goPage() </script>";
                }
            }
        }
        
    ?>
    <script>
        llenarSelect(document.getElementById("mes").value, document.getElementById("year").value);
        desHabilitarMes();
    </script>
    <div class="loader divHidden" id="pageLoader"></div>
    <div class='container text-center shadow p-5 mb-5 bg-white rounded' style="width: 5000px">
        <a class='btn btn-success btn-lg btn-block' style="margin-bottom: 10px" href="/Jomar/users_control/controller/ControlAsisController.php?action=registrar">Registrar</a>
        <div id="vacio" class="divHidden">
            <br> <h3> No se encontraron registros <h3>
            <br> <img src='\Jomar\users_control\images\clean.png' alt='vacio' width='200' />
        </div>
        <?php        
            if($datos == null){
                echo "<br> <h3> No se encontraron registros <h3>";
                echo "<br> <img src='\Jomar\users_control\images\clean.png' alt='vacio' width='200' />";
            }else{
        ?>
            <div class='d-flex justify-content-center' id="contentTable">
                <table class='table display' border=1 id="table" style="width: 100%">
                    <thead class= 'thead-dark'>
                        <tr>
                            <th>#</th>
                            <th style='width: 110px'>Fecha</th>
                            <th>Documento</th>
                            <th>Nombre completo</th>                            
                            <th>Sede</th>
                            <th>Siglas</th>                                                  
                            <th style='width: 200px'>Nota</th>                        
                            <th style='width: 40px'>Acciones</th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <a href="/Jomar/users_control/controller/ControlAsisController.php?action=todos"></a>
                        <?php
                            for($i = 0; $i < count($datos); $i++){
                                $id = $datos[$i]['id_controlAsis'];
                                $rutaEd = "/Jomar/users_control/controller/ControlAsisController.php?action=editar&id_controlAsis=$id";
                                $rutaEl = "/Jomar/users_control/controller/ControlAsisController.php?action=eliminar&id_controlAsis=$id";
                                echo "<tr>";
                                echo "<td>". ($i+1) ."</td>";
                                echo "<td> {$datos[$i]['fecha']} </td>";
                                echo "<td> {$datos[$i]['documento']} </td>";
                                echo "<td> {$datos[$i]['nombres']} {$datos[$i]['apellidos']} </td>";                                
                                echo "<td> {$datos[$i]['sede']} </td>";
                                echo "<td> {$datos[$i]['siglas']} </td>";                                                          
                                echo "<td style='text-align: justify; width: 150px;'> {$datos[$i]['nota']} </td>";                            
                                echo "<td>
                                <a href='$rutaEd' class='badge badge-primary'>Editar </a>
                                <a href='javascript: eliminarRegistro(\"$id\")' class='badge badge-warning'>Eliminar </a>
                                <br>
                                <input type='checkbox' value='$id'>
                                </td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="row">
                                    <div class="justify-content-start col-7 ">
                                        <label class="text-left font-italic" style="font-size: 15px"><strong>Advertencia:</strong> Sí se seleccionan muchos registros tenga en cuenta de que el proceso puede tomar algo de tiempo, o incluso puede no completarse.</label>
                                    </div>
                                    <div class="justify-content-end row align-self-center col-5">
                                        <label class="font-weight-bold" style="margin-right: 20px">Acciones <br> para los seleccionados:</label>
                                        <div class="align-self-center">
                                            <a class="badge badge-dark" style="margin-right: 20px" href="javascript: seleccionarTodos()">Marcar todos</a>
                                            <br>
                                            <a class="badge badge-dark" style="margin-right: 20px" href="javascript: deSeleccionar()">Desmarcar todos</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td> 
                            <div class="justify-content-center">
                                <a class="badge badge-primary" href="javascript: abrirModal();">Editar</a>
                                <a class="badge badge-warning" href="javascript: eliminarVarios();">Eliminar</a>
                            </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
                <br>
                
        <?php
        }
        ?>
        <script>
        //ajustarScroll();        
        </script>
        <br>
        <div class="row">
            <div class="">
                <a class="btn btn-info" href="/Jomar/users_control/controller/AdminController.php?action=menu">Menu principal</a>
            </div>
            <div class="col">
                <a class="btn btn-info" href="/Jomar/users_control/controller/ControlAsisController.php?action=conteos">Conteo de Asistencia</a>
            </div>
            <div class="col">
                <a class="btn btn-info" href="/Jomar/users_control/controller/ControlAsisController.php?action=asistenciaMes">Tabla grafica del Mes</a>
            </div>
            <div class="justify-content-end row">
                <a class="btn btn-info" onclick="localStorage.setItem('url', window.location.pathname + window.location.search)" href="/Jomar/users_control/controller/ControlAsisController.php?action=eliminados">Registros Eliminados</a>
            </div>
        </div>        
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalEditLabel">Editar seleccionados</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class='p-5 mb-1 mt-n1 '>
                        <div id="errores" class="alert-danger divHidden"></div>
                        <div class="form-g row justify-content-center">
                            <label for="asistencia" class="col-form-label mr-4">Asistencia:</label>
                            <div class=''>
                                <select type="text" class="custom-select" id="asistencia" name="asistencia" style="width: 200px"> 
                                        <option value="0">Seleccionar asistencia</option>
                                        <?php
                                            for($i=0; $i < count($asistencias); $i++){
                                                echo "<option value='{$asistencias[$i]['id_asistencia']}'>{$asistencias[$i]['siglas']}</option>";
                                            }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">                
                            <button class="btn btn-primary mr-4 btn-md" style="width: 150px" id="submit" onclick="editarSeleccionados()" type="button">Editar</button>
                            <button class="btn btn-danger btn-md" role="button" style="width: 150px" type="button" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" id="modalAviso" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!--<h4 class="modal-title" id="modalErrorLabel"></h4>-->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row text-center justify-content-center">
                </div>
            </div>
        </div>
    </div>                
    <div class='container text-center shadow p-5 mb-5 mt-5 bg-white rounded'>
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
    <script type="text/javascript">
        tableDT();
        if(localStorage.getItem("msg") !== undefined){
            var msg = localStorage.getItem("msg");             
            $("#mensaje").html(msg);
            $("#mensaje").fadeIn("slow");
            setTimeout(function(){
                $("#mensaje").fadeOut(2000, function(){
                    $("#mensaje").html("");
                });
                localStorage.removeItem("msg");            
            }, 2000);
        }
        
        function validarCampos(){
            var asistencia = document.getElementById("asistencia").value;

            var formOk = true;
            var msg = "<ul>";

            if(asistencia == 0){
                msg += "<li>Debes ingresar una asistencia</li>";
                formOk = false;
            }

            msg += "</ul>";

            if(!formOk){
                $("#errores").html(msg);
                $("#errores").fadeIn("fast");
            }else{
                $("#errores").fadeOut("fast");
            }
            return formOk;
        }
    </script>
</body>

</html>