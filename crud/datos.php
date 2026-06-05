<?php
header('Content-Type: application/json');

require("conexion.php");

$conexion = retornarConexion();

switch ($_GET['accion']) {
    case 'listar':
        $datos = mysqli_query($conexion, "SELECT codigo,nombre,carrera,grupo,alumprof,prestamoInfo,horaPrestamo,horaEntrega FROM base1.prestamos;");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;

    case 'agregar':
        $horaPrestamo = $_POST['horaPrestamo']; // Recibido del formulario
        $dateHP = new DateTime($horaPrestamo);
        $formatoSQLHP = $dateHP->format('Y-m-d H:i:s'); // Resultado: 2026-06-04 16:55:00
        
        $horaEntrega = $_POST['horaEntrega']; // Mismo para la hora de entrega
        $dateHE = new DateTime($horaEntrega);
        $formatoSQLHE = $dateHE->format('Y-m-d H:i:s'); 

        $query = "INSERT INTO prestamos (nombre, carrera, grupo, alumprof, prestamoInfo, horaPrestamo, horaEntrega) 
              VALUES ('$_POST[nombre]', '$_POST[carrera]', '$_POST[grupo]', '$_POST[alumprof]', '$_POST[prestamoInfo]', '$formatoSQLHP', '$formatoSQLHE')";
              
        $respuesta = mysqli_query($conexion, $query);
    
        // Responder al AJAX
        echo json_encode($respuesta);
        break;

    case 'borrar':
        $respuesta = mysqli_query($conexion, "delete from prestamos where codigo=$_GET[codigo]");
        echo json_encode($respuesta);
        break;

    case 'consultar':
        $datos = mysqli_query($conexion, "select codigo,nombre,carrera,grupo,alumprof,prestamoInfo,horaPrestamo,horaEntrega from prestamos where codigo=$_GET[codigo]");
        $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;

    case 'modificar':
        $respuesta = mysqli_query($conexion, "update prestamos set
                                                  nombre='$_POST[nombre]',
                                                  carrera='$_POST[carrera]',
                                                  grupo='$_POST[grupo]',
                                                  alumprof='$_POST[alumprof]',
                                                  prestamoInfo='$_POST[prestamoInfo]',
                                                  horaPrestamo='$_POST[horaPrestamo]',
                                                  horaEntrega='$_POST[horaEntrega]'
                                               where codigo=$_GET[codigo]");
        echo json_encode($respuesta);
        break;
}
