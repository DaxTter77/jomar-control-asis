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
    <title>Editar Sede</title>
</head>
<script type="text/javascript">
    function editarSede() {        
        if(validarCampos()){
            var datos = $("#formEditar").serialize();                        
            $.ajax({
                data: datos,
                url: '/Jomar/users_control/controller/SedeController.php?action=guardarEdit',
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
                        msg = "<h4> Se ha editado correctamente </h4>";                        
                        localStorage.setItem("msg", msg);
                        location.href = "/Jomar/users_control/controller/SedeController.php?action=todos";
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
        <h1>Editar <br> Sede</h1>
    </div>
    <div id="respuesta" class="container w-50 text-center mb-5 alert-danger divHidden"></div>
    <form name="formEditar" id="formEditar" method="POST">
        <div class='container shadow p-5 mb-1 mt-n1 bg-white rounded' style= "width: 800px">            
            <div id="errores" class="alert-danger divHidden"></div>
            <input type="hidden" name="id" value="<?php echo ($sede[0]["id_sede"]); ?>">
            <div class="form-group row justify-content-center"> 
                <label class=" col-form-label" style="margin-right: 0px" for="sede">Sede:</label>
                <div class="col-5">
                    <input type="text" class="form-control" autocomplete="off" name="sede" id="sede" value="<?php echo ($sede[0]["sede"]); ?>" />
                </div>
            </div>
            <br>                            
            <div class="form-group row justify-content-center">
                <div class="justify-content-center">                
                    <button class="btn btn-primary mr-4 btn-md" style="width: 150px" id="submit" onclick="editarSede()" type="button">Editar</button>            
                    <a class="btn btn-danger btn-md" role="button" style="width: 150px" href="/Jomar/users_control/controller/SedeController.php?action=todos" >Cancelar</a>
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
        var sede = document.forms["formEditar"]["sede"].value;        
        var antSede = "<?php echo $sede[0]["sede"] ?>";        
        var datosExist = <?php echo json_encode($datos) ?>;

        var msg = "<ul>";
        var formOk = true;

        if(sede == ""){
            msg += "<li> Sede no puede ir vacío </li>";
            formOk = false;
        }else if(sede.toLowerCase() != antSede.toLowerCase()){
            for(i=0; i < datosExist.length; i++){
                if(sede.toLowerCase() === datosExist[i]["sede"].toLowerCase()){
                    msg += "<li> Sede ya existente </li>";                    
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

    $("#formEditar").submit(function(e){
        e.preventDefault();
    });

    $("input").keyup(function(e){
        if(e.key == "Enter"){
            editarSede();
        }
    });
</script>
</html>