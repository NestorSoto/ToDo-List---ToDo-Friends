<?php
include("conexion.php");

//Registrar usuario

if(isset($_POST["registrar"])){
    $correo = mysqli_real_escape_string($conection, $_POST['correo']);
    $usuario = mysqli_real_escape_string($conection, $_POST['user']);
    $contraseña = mysqli_real_escape_string($conection, $_POST['pass']);
    $contraseña_encriptada = sha1($contraseña);
    $sqluser = "SELECT iduser FROM usuarios WHERE username = '$usuario'";

    $resultado_user = $conection->query($sqluser);
    $filas = $resultado_user->num_rows;
    if($filas > 0) {
        echo "<script>
            alert('El usuario ya existe');
            window.location = 'login.html';
        </script>";
    }else {
        //insertar información del usuario
        $sqlusuario = "INSERT INTO usuarios
                            (correo, username, password)
                                VALUES('$correo', '$usuario', '$contraseña_encriptada')";
        $resultadousuario = $conection->query($sqlusuario);
        if($resultadousuario > 0){
            echo "<script>
            alert('Registro exitoso');
            window.location = 'login.html';
        </script>";
        } else{
            echo "<script>
            alert('Error al registrarse');
            window.location = 'registro.php';
        </script>";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> To-Do Friends | Registrate en nuestra p&aacute;gina </title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="stylesheet" href="../styles/cabecera.css">

    <link rel="shortcut icon" href="../../res/favicon1.png" type="image/x-icon">    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>    
    <link rel="stylesheet" href="../../res/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <script src="../../res/jquery/jquery-3.5.1.min.js"></script>
    
    <link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.css">    
    <script src="../scripts/main.js"></script>
</head>
<body>
    <div class="container-md">
        <header class="row cabecera">
            <div class="home">
                <a class="logo" href="../../index.html">
                    <img src="../../res/favicon1.png" alt="logo">
                    <h1> To-Do Friends </h1>
                </a>
            </div>
            <span class="btn-burger"><i class="fa fa-bars"></i></span>
            <nav class="navbar nav mynav">
                <li class="nav-item text-center"><a class="nav-link" href="nosotros.html"> Nosotros </a></li>
                <li class="nav-item text-center"><a class="nav-link" href="tutorial.html"> Tutorial </a></li>
                <li class="nav-item text-center"><a class="nav-link" href="equipos.html"> Equipos </a></li>
                <li class="nav-item text-center"><a class="nav-link" href="login.html"> Iniciar Sesi&oacute;n </a></li>
                <li class="nav-item text-center"><a class="nav-link" href="registro.html">Registrarse </a> </li>
            </nav>
        </header>

    </div>
    <div class="login">
        <h1> Registrarse </h1>
        <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="email" name="correo" placeholder="Correo Electrónico" required="required" />
            <input type="text" name="user" placeholder="Nombre de usuario" required="required" />
            <input type="password" name="pass" placeholder="Contraseña" required="required" />
            <input type="password" name="passr" placeholder="Repetir contraseña" required="required" />
            <button type="submit" name = "registrar" class="btn btn-primary btn-block btn-large"> Crear Cuenta </button>
        </form>
    </div>
</body>
</html>