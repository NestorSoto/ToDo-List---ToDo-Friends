﻿<?php
    session_start();    
    if(isset($_SESSION['grupo'])){      
       unset($_SESSION['grupo']);
    }       
    require "conexion.php";
    if(empty($_SESSION['user'])){
        header("location:../../index");
    }
    else{
        require "sacarDatos.php";
        list ($uID, $uNombre, $uCorreo, $uFoto) = getInfoSobre($_SESSION['user']);
    }
    $query = "SELECT * FROM temas WHERE Usuario = :id";
    $resultado_tema = $conection->prepare($query);
    $resultado_tema->bindValue(":id", $_SESSION['user']);
    $resultado_tema->execute();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Esta aplicacion fue creada para ayudar a una persona o a un grupo a orgnizar sus tareas.">
    <meta name="author"
        content="Gianela Mallqui, Alex Mamani, Nestor Soto, Renzo Marcos, Martin Rodriguez y Brayan Oroncuy">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../../res/favicon1.png" type="image/x-icon">
    <title>Todo List | Empieza a organizarte</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="../../src/styles/netWork.css">
    <link rel="stylesheet" href="../../src/styles/editar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">


        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link pushmen" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i></a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">

                </li>
            </ul>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        Todo Friends
                        <i class="fas fa-check-circle"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="#" class="brand-link">
                <img src="../../res/favicon1.png" alt="Todo List" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Todo List</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php print_r($uFoto)?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="perfilusuario" class="d-block">
                            <?php        
                                                     
                                print_r($uNombre);
                            ?>
                        </a>
                    </div>
                </div>

                <nav class="mt-2">

                    <ul class="nav-arbol">
                        <li class="nav-li">
                            <div class="nav-arbol-hoja">
                                <i class="fas fa-table"></i>
                                <a href="NetWork"> Tablero </a>
                                <i class="fas fa-angle-left right desplegador"></i>
                            </div>
                            <ul class="nav desplegable">
                                <li>
                                    <i class="far fa-circle nav-icon"></i>
                                    <a href="#" class="text-truncate">PrimeroPrimeroP(19)</a>
                                </li>
                                <li>
                                    <i class="far fa-circle nav-icon"></i>
                                    <a href="#" class="text-truncate">Primero</a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-li">
                            <div class="nav-arbol-hoja">
                                <i class="fas fa-users"></i>
                                <a href="MisEquipos"> Mis equipos </a>
                                <i class="fas fa-angle-left right desplegador"></i>
                            </div>
                            <ul class="nav desplegable">
                                <li>
                                    <i class="far fa-circle nav-icon"></i>
                                    <a href="#">PrimeroPrimeroP(19)</a>
                                </li>
                                <li>
                                    <i class="far fa-circle nav-icon"></i>
                                    <a href="#">Primero</a>
                                </li>

                            </ul>
                        </li>
                        <?php
                            if($_SESSION['nivel'] == 1){
                            ?>
                        <li class="nav-li">
                            <div class="nav-arbol-hoja">
                                <i class="fas fa-users-cog"></i>
                                <a href="panelAdmin"> Administrador </a>
                            </div>
                        </li>
                        <?php
                            }              
                                   
                        ?>

                        <li>
                            <div class="nav-arbol-hoja">
                                <i class="fas fa-door-open"></i>
                                <a href="../../"> Salir </a>

                            </div>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="overlay " id="overlay">
                        <div class="popup " id="popup">

                            <div class="col sm-4">
                                <a href="#" class=" btn-cerrar-popup"><i class="far fa-times-circle"></i></a>
                                <div class="row">
                                    <div class="card card-body col-12">

                                        <form action="" method="POST" id="CTema">
                                            <div class="form-group">
                                                <input type="text" name="Titulo3" maxlength="16" minlength="4"
                                                    class=" form-control" id="inTemaTitulo" required
                                                    placeholder=" T&iacute;tulo">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="Descripcion3" maxlength="64" rows="4"
                                                    class="form-control" id="inTemaDesc"
                                                    placeholder="Descripci&oacute;n"></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-config btn-light btn-block"
                                                id="btn-crear-tema" name="CrearTema" value="Crear Tema" />

                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!--Botón de editar Temas-->
                    <div class="overlay " id="overlay2">
                        <div class="popup " id="popup2">

                            <div class="col sm-4">
                                <a href="#" class=" btn-cerrar-popup2"><i class="far fa-times-circle"></i></a>
                                <div class="row">
                                    <div class="card card-body col-12">

                                        <form action="#" method="POST" id="formEditarTema">
                                            <div class="form-group">
                                                <input type="text" name="Titulo4" maxlength="16" minlength="4"
                                                    class=" form-control" id="editTemaTitulo"
                                                    placeholder="Nuevo Título">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="Descripcion4" maxlength="32" rows="4"
                                                    class="form-control" id="editTemaDesc"
                                                    placeholder="Nueva Descripcion"></textarea>
                                            </div>
                                            <input type="button"
                                                class="btn btn-config btn-editar-tema btn-light btn-block"
                                                name="EditarTema" value="Editar Tema" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-6 row">

                            <h1 class="text-dark titulo-principal"> Temas de Trabajo </h1>
                            <h3> &nbsp;( <?php print_r($resultado_tema->rowCount())?> )</h3>

                            <button class="btn-opciones btn btn-success mx-2"> Crear Tema </button>
                            <!--div class="color-picker"></div-->
                        </div>
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="NetWork"> Tablero </a></li>
                                <li class="breadcrumb-item active"> Tema </li>
                            </ol>
                        </div>



                    </div>
                </div>
                <div class="grupo-temas">

                    <?php                                           
                       
                        while($row = $resultado_tema->fetch(PDO::FETCH_ASSOC)) {                            
                        ?>

                    <div class="unidad-tema">
                        <div class="small-box bg-info miTema" id="tema-<?php print_r($row ["IDTEMA"]);?>">
                            <div class="inner">
                                <div class="popup-boton row">
                                    <h3><?php print_r($row['Titulo']); ?></h3>
                                    <a href="#" data-id1="<?php print_r($row['IDTEMA']);?>"
                                        class="btn-opcion2 btn btn-secondary text-center col-2"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <a href="#" id="<?php print_r($row ["IDTEMA"]);?>"
                                        class="btn-eliminar-tema btn btn-secondary text-center col-2"><i class="fa fa-times"
                                            aria-hidden="true"></i></a>
                                </div>

                                <p><?php print_r($row['Descripcion']); ?></p>
                            </div>

                            <a href="TareasGrupales" class="small-box-footer btn-ver-tema"
                                id="<?php print_r($row["IDTEMA"]);?>"> Ver
                                <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <?php } ?>

                </div>
            </div>

        </div>

        <footer class="main-footer">
            <strong> &copy; 2020-2021 <a href="#">Todo List</a>.</strong>
            Todos los derechos reservados.
            <div class="float-right d-none d-sm-inline-block">
                <b>Versi&oacute;n</b> 2.0
            </div>
        </footer>

    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>

    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <script src="../../plugins/sparklines/sparkline.js"></script>
    <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="../../dist/js/adminlte.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script src="../scripts/activadorPopUp.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

</body>

</html>