<?php

require 'conexion.php';
session_start();      
if (!empty(filter_input(INPUT_POST, 'guardarTarea'))) {
  try{    
    $title = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
    $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_SPECIAL_CHARS);    
    
    if(!empty($date)){
      $hoy = date("Y-m-d");
      if($hoy <= $date){
        $query = "INSERT INTO `tareas` (`title`, `description`, `limit_date`, `eltema`, `estado`) VALUES (:titulo, :descripcion, :fecha, :tema, :estado)";
        $resultadousuario = $conection->prepare($query);
  
        $resultadousuario->bindValue(":titulo", $title);
        $resultadousuario->bindValue(":descripcion", $description);
        $resultadousuario->bindValue(":fecha", $date);
        $resultadousuario->bindValue(":tema", $_SESSION['tema']);
        $resultadousuario->bindValue(":estado", $estado);
        $resultadousuario->execute();      
       
      }
      else{
        header("location:TareasGrupales?errm=$date");
      }
    }
    else{
      $query = "INSERT INTO `tareas` (`title`, `description`, `limit_date`, `eltema`, `estado`) VALUES (:titulo, :descripcion, :fecha, :tema, :estado)";
      $resultadousuario = $conection->prepare($query);

      $resultadousuario->bindValue(":titulo", $title);
      $resultadousuario->bindValue(":descripcion", $description);
      $resultadousuario->bindValue(":fecha", $date);
      $resultadousuario->bindValue(":tema", $_SESSION['tema']);
      $resultadousuario->bindValue(":estado", $estado);
      $resultadousuario->execute();
    }
  }
  else{
    $query = "INSERT INTO `tareas` (`title`, `description`, `limit_date`, `eltema`) VALUES (:titulo, :descripcion, :fecha, :tema)";
    $resultadousuario = $conection->prepare($query);

    $resultadousuario->bindValue(":titulo", $title);
    $resultadousuario->bindValue(":descripcion", $description);
    $resultadousuario->bindValue(":fecha", "Sin fecha límite");
    $resultadousuario->bindValue(":tema", $_SESSION['tema']);
    $resultadousuario->execute();      
  }
  
  
  
}catch(Exception $ex){
  
}
  
?>