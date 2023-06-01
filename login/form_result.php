<?php
    include("getconex.php");
    if($_POST){
        $marca = $_POST['txtmarca'];
        $modelos = $_POST['txtmodelo'];
        $ano = $_POST['txtano'];
        $stock = $_POST['txtstock'];
        $fecha = $_POST["txtfecha"];
        $fecha = new DateTime(); 
        $fecha_formateada = $fecha->format('Y-m-d'); 
        

    }
    
    $ins_sql = "INSERT INTO [USUARIOS] VALUES('$marca', '$modelos', '$ano', '$stock', '$fecha_formateada')";
    $stmt = sqlsrv_query( $conectar, $ins_sql );
    if ($stmt){
        echo "<br> Datos ingresados correctamente <br>";
    }
    else{
        include("logs.php");
    }
    sqlsrv_free_stmt($stmt);
?>