<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/Jomar/users_control/images/favicon.png">
    <link REL=StyleSheet HREF="\Jomar\users_control\config\estilos.css" TYPE="text/css" MEDIA=screen>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <title>Error 404</title>
</head>
<script type="text/javascript">
    $(document).ready(function(){
        $("header").load("/Jomar/users_control/views/header/header.php");
    });
</script>
<body style="background-color:#800D0D0D">
    <header></header>
    <div class='container text-center shadow p-5 mb-5 mt-3 bg-white rounded'>
        <img src="\Jomar\users_control\images\error.png" alt="error" width="300">
        <h1 class="display-1">Error 404</h1>
        <br>
        <h2>No se ha podido encontrar la pagina que solicitas.</h2>
    </div>
</body>
</html>