<?php
// Establecer la conexión a la base de datos SQL Server
$serverName = "DESKTOP-FJ0K1J4";
$connectionOptions = array( 'Database'=>'prueba_1756734', 'UID'=>'LSBDUSER', 'PWD'=>'C0ntr4s3n4*#');
$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}   else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


$date = date('[Y/m/d H:i:s] ');
$dirip = " [" . $ip . "] ";

$sqlerror = print_r(sqlsrv_errors(), true);

error_log($date . $dirip . "Error de SQL SERVER: " . $sqlerror,3,'
    C:\xampp\apache\logs\error');

echo '<script type="text/javascript">';
echo ' alert("¡Pagina no disponible!")';
echo "<script>setTimeout(\"location.href = 'javascript:history.go(-1)';\",1);</script>";

die();
// Verificar si la conexión fue exitosa
if ($conn === false) {
    // Obtener información detallada sobre el error de conexión
    $errors = sqlsrv_errors();
    
    // Crear un mensaje de error para guardar en el archivo de logs
    $errorMessage = "Error de conexión a SQL Server: " . print_r($errors, true);
    
    // Guardar el mensaje de error en un archivo de logs
    error_log($errorMessage, 3, "C:\xampp\apache\logs\error.log");
}

// Ejecutar una consulta en la base de datos
$query = "SELECT * FROM tbFormuario";
$result = sqlsrv_query($conn, $query);

// Verificar si la consulta fue exitosa
if ($result === false) {
    // Obtener información detallada sobre el error de la consulta
    $errors = sqlsrv_errors();
    
    
    // Crear un mensaje de error para guardar en el archivo de logs
    $errorMessage = "Error en la consulta SQL: " . print_r($errors, true);
    
    // Guardar el mensaje de error en un archivo de logs

    error_log($date . $dirip . "Error de SQL SERVER: " . $sqlerror,3,'
    C:\xampp\apache\logs\error');
}

// Cerrar la conexión a la base de datos
sqlsrv_close($conn);
?>
