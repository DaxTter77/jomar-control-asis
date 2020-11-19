<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <!--<script src="https://unpkg.com/floatthead"></script>-->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <link href="https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <title>Asistencias</title>    
</head>
<style>
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

</style>
<script type="text/javascript">
    function goToPage(){
        self.location.replace('/Jomar/users_control/controller/AsistenciaController.php?action=todos');
    }

    function ajustarScroll(){
        var divTable = document.getElementById("contentTable");
        var table = document.getElementById("table");
        
        if(divTable.clientHeight > 425){
            divTable.className += " divScroll";
            floatHead();
        }
    }

    function tableDT(){
        tableData = $('#table').DataTable( {
            scrollY: "400px",
            scrollCollapse: true,
            paging: false,
            searching: false,
            columnDefs:[{
                targets: "_all",
                sortable: false
            }],
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

    function consultarDatos(){
        var datos = {
            'confirm' : true
        };
        $.ajax({
            data: datos,
            type: 'post',
            url: "/Jomar/users_control/controller/AsistenciaController.php?action=todos",
            dataType: 'json',
            success: function(response){
                    if(response != null){
                        var rutaEd = "/Jomar/users_control/controller/AsistenciaController.php?action=editar&id_asis="+this.id_asistencia;
                        $("table tbody").html("");
                        $.each(response, function(i){                        
                            $("table tbody").append("<tr><td>"+ (i+1) +"</td>"
                            + "<td>"+ this.asistencia+"</td>"
                            + "<td>"+ this.siglas+"</td>"                            
                            + "<td> <a href='"+rutaEd+"' class='badge badge-primary'>Editar </a> <a href='javascript: eliminarAsistencia(\""+this.id_asistencia+"\")' class='badge badge-warning'>Eliminar </a> </td></tr>");
                        });
                    }else{
                        $("#contentTable").html("");
                        $("#contentTable").removeClass("divScroll");
                        $("#vacio").fadeIn("slow");
                    }
            }
        });
    }

    function eliminarAsistencia(id){
        //floatDestroy()
        eliminar = confirm("¿Desea eliminar esta asistencia? (Recuerde que no será posible recuperarlo)");
        if(eliminar){
            $.ajax({                        
                url: "/Jomar/users_control/controller/AsistenciaController.php?action=eliminar&id_asis="+id,
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
                        $("#mensaje").html("<h4>No se puede eliminar</h4>");
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

    $(document).ready(function(){
        $("header").load("/Jomar/users_control/views/header/header.php");
    });
</script>
<body style="background-color:#800D0D0D">
    <header></header>
    <div class='container text-center shadow p-5 mb-5 mt-3 bg-white rounded'>
        <h1> Listado de Asistencias </h1>
    </div>
    <div class='alert-success container w-75 text-center mb-5' id="mensaje"></div>
    <?php
        $url = $_SERVER["REQUEST_URI"];
        $urlneed = "/Jomar/users_control/controller/AsistenciaController.php?action=todos";
        if($url != $urlneed){
            echo "<script> goToPage() </script>";
        }
    ?>
    <div class='container text-center shadow p-5 mb-5 bg-white rounded'>
        <a class='btn btn-success btn-lg btn-block' href="/Jomar/users_control/controller/AsistenciaController.php?action=insertar">Ingresar</a>
        <div id="vacio" class="divHidden">
            <br> <h3> No hay registros eliminados <h3>
            <br> <img src='\Jomar\users_control\images\clean.png' alt='vacio' width='200' />
        </div>
        <?php        
            if($datos == null){
                echo "<br> <h3> No hay asistencias en el sistema <h3>";
                echo "<br> <img src='\Jomar\users_control\images\clean.png' alt='vacio' width='200' />";
            }else{
        ?>
                <div class='d-flex justify-content-center' id="contentTable">
                    <table class='table table-stripped' border=1 id="table">
                        <thead class= 'thead-dark'>
                            <tr>
                                <th>#</th>
                                <th>Asistencia</th>
                                <th>Siglas</th>     
                                <th>Acciones</th>                                       
                            </tr>
                        </thead>
                        <tbody>
                            <a href="/Jomar/users_control/controller/AsistenciaController.php?action=todos"></a>
                            <?php
                                for($i = 0; $i < count($datos); $i++){
                                    $id = $datos[$i]['id_asistencia'];
                                    $rutaEd = "/Jomar/users_control/controller/AsistenciaController.php?action=editar&id_asis=$id";
                                    echo "<tr>";
                                    echo "<td>". ($i+1) ."</td>";
                                    echo "<td> {$datos[$i]['asistencia']} </td>";
                                    echo "<td> {$datos[$i]['siglas']} </td>";                                                        
                                    echo "<td>
                                    <a href='$rutaEd' class='badge badge-primary'>Editar </a>
                                    <a href='javascript: eliminarAsistencia(\"$id\")' class='badge badge-warning'>Eliminar </a>
                                    </td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
        <?php
            }
        ?>
            <script>//ajustarScroll();</script>
            <div class="row">
                <a class="btn btn-info" href="/Jomar/users_control/controller/AdminController.php?action=menu">Menu principal</a>
            </div>
        </div>
</body>
<script type="text/javascript">
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

    tableDT();
</script>
</html>