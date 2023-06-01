
<?php


include('getconex.php');
if($_POST){
    $nombre = $_POST['txtNombre'];
    $pass = $_POST['txtPass'];
    $date = $_POST['date'];
    $correo = $_POST['txtCorreo'];
}


// Preparar la consulta del procedimiento almacenado
$sql = "{CALL Registro(?, ?, ?, ?)}";
$params = array(
    array($nombre, SQLSRV_PARAM_IN),
    array($pass, SQLSRV_PARAM_IN),
    array($date, SQLSRV_PARAM_IN),
    array($correo, SQLSRV_PARAM_IN)
);

// Ejecutar la consulta
$stmt = sqlsrv_query($conectar, $sql, $params);

if ($stmt){
    echo "<br> Datos ingresados correctamente <br>";
    // Redirigir al usuario a login.php
    header("Location: index.html");
    exit();
}

else{
    $mensaje = 'Conexión fallida<br>';
    echo "$mensaje";
    die( print_r(sqlsrv_errors(), true));
    
}

// Cerrar la conexión
sqlsrv_close($conectar);


?>

