<?php 


// Obtener el valor de $resultado después de la ejecución
echo "Resultado del login: " . $resultado;
if ($stmt){
    if ($resultado == 1){
        session_start();
        $_SESSION['valid_user'] = true;
        $_SESSION['logged_user'] = $nombre;
        $_SESSION['user_data'] = [];
        //$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        // header("Location: acceso.php");
    }
    else{
        // header("Location: acceso_error.php");
    }
}
else{
    include("sqlerror.php");
}
// Cerrar la conexión
sqlsrv_close($conectar);

?>