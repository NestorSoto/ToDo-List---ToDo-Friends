<?php

include('conexion.php');

if (isset($_POST['guardarTarea'])) {
  try{
    $title = htmlentities(addslashes($_POST['titulo']));
    $description = htmlentities(addslashes($_POST['descripcion']));
    $date = htmlentities(addslashes($_POST['fecha']));
    
    $hoy = date("Y-m-d");
    if($hoy <= $date){
      $query = "INSERT INTO `tareas` (`title`, `description`, `limit_date`) VALUES (:titulo, :descripcion, :fecha)";
      $resultadousuario = $conection->prepare($query);

      $resultadousuario->bindValue(":titulo", $title);
      $resultadousuario->bindValue(":descripcion", $description);
      $resultadousuario->bindValue(":fecha", $date);
      $resultadousuario->execute();
      
      header("location:TareasGrupales.php");
    }
    else{
      header("location:TareasGrupales.php?errm=$date");
    }
    

  }catch(Exception $ex){
    die("Error al conectar: ". $ex->getMessage());
  }

  
}
?>