<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/Jomar/users_control/controller/AdminController.php?action=menu">JOMAR CONTROL</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="/Jomar/users_control/controller/AdminController.php?action=menu">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Control de Asistencia
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/Jomar/users_control/controller/ControlAsisController.php?action=todos">Asistencia</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/ControlAsisController.php?action=registrar">Registro</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/ControlAsisController.php?action=eliminados">Registros Eliminados</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/ControlAsisController.php?action=conteos">Conteo de Asistencias</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/ControlAsisController.php?action=asistenciaMes">Tabla Grafica de Asistencias</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administrador
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/Jomar/users_control/controller/AdminController.php?action=todos">Listado</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/AdminController.php?action=registrar">Registrar</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/AdminController.php?action=eliminados">Eliminados</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Empleados
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/Jomar/users_control/controller/EmpleadoController.php?action=todos">Listado</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/EmpleadoController.php?action=registrar">Registrar</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/EmpleadoController.php?action=eliminados">Eliminados</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Asistencias
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/Jomar/users_control/controller/AsistenciaController.php?action=todos">Listado</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/AsistenciaController.php?action=insertar">Insertar</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cargos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/Jomar/users_control/controller/CargoController.php?action=todos">Listado</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/CargoController.php?action=insertar">Insertar</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/CargoController.php?action=eliminados">Eliminados</a>
                </div>
            </li>
            <li class="nav-item dropdown pull-left">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sedes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/Jomar/users_control/controller/SedeController.php?action=todos">Listado</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/SedeController.php?action=insertar">Insertar</a>
                    <a class="dropdown-item" href="/Jomar/users_control/controller/SedeController.php?action=todos">Eliminados</a>
                </div>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="btn btn-danger btn-sm" href="/Jomar/users_control/controller/AdminController.php?action=logout">Salir</a>
            </li>
        </ul>
    </div>
</nav>

