<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
    <!--<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">!-->
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="/Jomar/users_control/config/dist/css/tableexport.css" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>    
    <script src="/Jomar/users_control/config/Blob.min.js"> </script> 
    <script src="/Jomar/users_control/config/xls.core.min.js"></script>    
    <script src ="/Jomar/users_control/config/FileSaver.min.js"></script> 
    <script src ="/Jomar/users_control/config/dist/js/tableexport.js"></script>
    <!--<script src="https://unpkg.com/floatthead"></script>!-->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <link href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <title>Tabla Grafica de Asistencia</title>
</head>
<style>
    th, td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

</style>
<script type="text/javascript">
    function goPage(){
        self.location.replace('/Jomar/users_control/controller/ControlAsisController.php?action=asistenciaMes');
    }

    function ajustarScroll(){
        var table = document.getElementById("table");
        var divTable = document.getElementById("contentTable");
        
        if(table.clientHeight > 800){
            divTable.className += " scrollVertical";
            
        }else{
            $("#contentTable").removeClass("scrollVertical");
            $("#contentTable").addClass("d-flex");
        }
        if(table.clientWidth > 1543){
            $("#contentTable").removeClass("d-flex");
            divTable.className += " scrollHorizontal";
        }else{
            $("#contentTable").removeClass("scrollHorizontal");
            $("#contentTable").addClass("d-flex");
        }
    }

    var tableData;

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
            fixedColumns:   {
                leftColumns: 3
            },
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

    function tableDestroy(){
        tableData.destroy();
    }

    function filtroActivado(){
        var sede = document.getElementById("sede").value;        
        var ano = document.getElementById("year").value;
        var mes = document.getElementById("mes").value; 
        if(ano != 0 && mes != 0 && sede != 0){
            $("#filtrar").removeClass("disabled");
        }else{
            $("#filtrar").addClass("disabled");
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

    localStorage.removeItem("evento");

    function generarTabla(){
        if(localStorage.getItem("evento") == "1"){
            alert("Por favor, espera a que cargue la tabla");
            return;
        }
        $("#pageLoader").fadeIn("fast");
        var mesText = $("#mes option:selected").text();
        var sedeText = $("#sede option:selected").text();
        var mes = $("#mes").val();
        var ano = $("#year").val();
        var sede = $("#sede").val();
        var cadena = "asistencia" + " " + sedeText + " "+ mesText + " " + ano;
        cadena = cadena.replace(/\s/g, "-");
        localStorage.setItem("filename", cadena.toLowerCase());
        localStorage.setItem("evento", 1);
        //floatDestroy();
        if(tableData != null){
            tableDestroy();
        }
        $.ajax({
            url: "/Jomar/users_control/controller/ControlAsisController.php?action=asistenciaMensual&mes="+mes+"&ano="+ano+"&sede="+sede,
            dataType: 'json',
            success: function(response){
                if(response != null){
                    $("#container").fadeOut("fast");
                    $("table thead").html("");
                    $("table tbody").html("");

                    var thead = "<tr>"
                        + "<th>#</th>"
                        + "<th>Documento</th>"
                        + "<th>Nombre</th>";

                    for(let i=0; i < response["dias"].length; i++){
                        thead += "<th>"+ response["dias"][i]["dia"] +"</th>";
                    }
                        + "</tr>";
                    thead += "<tr> <th colspan='3'></th>";
                    for(let i=0; i < response["dias"].length; i++){
                        thead += "<th>"+ response["dias"][i]["fecha"] +"</th>";
                    }
                        thead += "</tr>";
                    var tbody;
                    for (let i = 0; i < response["empleados"].length; i++) {
                        tbody += "<tr>";
                        tbody += "<td>"+ (i+1) +"</td>"
                        + "<td>"+response["empleados"][i]["documento"]+"</td>"
                        + "<td>"+response["empleados"][i]["nombres"]+ " " +response["empleados"][i]["apellidos"]+"</td>";
                        index = 0
                        for(let j = 0; j < response["dias"].length; j++){
                            if(response["datos"][i] != null  && typeof response["datos"][i][index] != "undefined"){
                                if(response["datos"][i][index]["dia"] == response["dias"][j]["fecha"]){
                                    var color = "";
                                    var colorText = "#000000";
                                    if(response["datos"][i][index]["siglas"] == "TC"){
                                        color = "#B7E1CD";
                                    }else if(response["datos"][i][index]["siglas"] == "VAC"){
                                        color = "#E69138";
                                        colorText = "#ffffff";
                                    }else if(response["datos"][i][index]["siglas"] == "DP"){
                                        color = "#E06666";
                                        colorText = "#ffffff";
                                    }else if(response["datos"][i][index]["siglas"] == "DC"){
                                        color = "#FFE599";
                                    }else if(response["datos"][i][index]["siglas"] == "MT"){
                                        color = "#F4C7C3";
                                    }else if(response["datos"][i][index]["siglas"] == "INC"){
                                        color = "#A41785";
                                        colorText = "#ffffff";
                                    }else if(response["datos"][i][index]["siglas"] == "RT"){
                                        color = "#00B0F0";
                                    }else if(response["datos"][i][index]["siglas"] == "HE"){
                                        color = "#8064A2";
                                    }else if(response["datos"][i][index]["siglas"] == "SUSP"){
                                        color = "#C00000";
                                        colorText = "#ffffff";
                                    }else if(response["datos"][i][index]["siglas"] == "NE"){
                                        color = "#C23B00";
                                        colorText = "#ffffff";
                                    }else if(response["datos"][i][index]["siglas"] == "DF"){
                                        color = "#03FF7E";
                                    }else if(response["datos"][i][index]["siglas"] == "EL"){
                                        color = "#17a2b8";
                                    }else if(response["datos"][i][index]["siglas"] == "IT"){
                                        color = "#79553D";
                                        colorText = "#ffffff";
                                    }

                                    if(color != null){
                                        tbody += "<td style='background-color: "+ color +"; color: "+ colorText +"'>"+response["datos"][i][index]["siglas"]+"</td>";
                                    }else{
                                        tbody += "<td>"+response["datos"][i][index]["siglas"]+"</td>";
                                    }
                                        index++;
                                }else{
                                    tbody += "<td> </td>";
                                }
                            }else{
                                tbody += "<td> </td>";
                            }
                        }
                        tbody += "</tr>";
                    }
                    $("table thead").append(thead);
                    $("table tbody").append(tbody);
                    $("#container").fadeIn("slow", function(){
                        $("#pageLoader").fadeOut("slow");
                    });
                    $("caption").remove();
                    //ajustarTable();
                    exportarAExcel();
                    //ajustarScroll();
                    //floatHead();
                    tableDT();
                    localStorage.removeItem("evento");
                }else{
                    localStorage.removeItem("evento");
                }
            }
        });
    }

    $(document).ready(function(){
        $("header").load("/Jomar/users_control/views/header/header.php");
    });

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    /*function ajustarTable(){
        if(isMobile.any()){
            var container = document.getElementById("container");
            var table = document.getElementById("table");
            var divTable = document.getElementById("contentTable");
            if((container.clientWidth - 20) < table.clientWidth){
                
            }
        }
        
    }*/
    
</script>
<body style="background-color:#800D0D0D; zoom: 80%">
    <header></header>
    <?php
        $url = $_SERVER["REQUEST_URI"];        
        $urlneed = "/Jomar/users_control/controller/ControlAsisController.php?action=asistenciaMes";
        if($urlneed != $url){
            echo "<script> goPage() </script>";
        }
    ?>        
    <div class='container text-center shadow p-5 mb-5 mt-5 bg-white rounded'>
        <h3> Tabla Grafica de Asistencias </h3> 
        <br>
        <div class="row">
            <div class="col">
                <label for="sede" class="col-form-label align-self-center ">Sede:</label>
                <br>
                <select name="sede" id="sede" class="custom-select text-center align-self-center" onchange="filtroActivado()" style="height: 40px; width: 200px">
                <option value="0">Selecciona una sede</option>
                    <?php                         
                        for($i=0; $i < count($sedes); $i++){
                            echo "<option value='{$sedes[$i]["id_sede"]}'>{$sedes[$i]["sede"]}</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col">
                <label class="col-form-label">Fecha: </label>
                <br>
                <select name="mes" id="mes" class="custom-select" onchange="filtroActivado()" style="height: 40px; width: 130px">
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
                <select name="year" id="year" class="custom-select text-center" onchange="filtroActivado()" style="height: 40px; width: 90px">
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
            </div>
            <div class="col align-self-center">
                <a href="javascript: generarTabla()" class="btn btn-outline-dark mt-2 disabled" id="filtrar">Filtrar</a>
            </div>
        </div>
        <br> <br>
        <a href="/Jomar/users_control/controller/ControlAsisController.php?action=todos" class="btn btn-info centerContent">Volver al listado</a>
    </div>
    <br>
    <div class="loader divHidden" id="pageLoader"></div>
    <div class='container-fluid text-center shadow p-5 mb-5 bg-white rounded divHidden' id="container" style=''>
        <div class='justify-content-center' id="contentTable">
            <div class="justify-content-center row" id="export"></div><br>
            <table class='table striped row-border order-column display nowrap' style="width: 150%" border=1 id="table">
                    <thead class= 'thead-dark'>
                        
                    </thead>
                    <tbody>

                    </tbody>
            </table>
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
</body>
<script>
    function exportarAExcel(){
        $("table").tableExport({
            formats: ["xlsx"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
            fileName: localStorage.getItem("filename"), //Nombre del archivo 
            position: "top",
            trimWhitespace: true,
        });

        $("caption").appendTo("#export");
    }

</script>
</html>