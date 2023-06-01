<?php
/*
include("getconex.php");
if($_POST){
    $nombre = $_POST["txtUsuario"];
    $pass = $_POST["txtPass"];
    $varControl = 'Formulario';
}
$tsql = "EXEC Comprobarlogin '$nombre','$pass','$varControl'";
$stmt = sqlsrv_query( $conectar, $tsql );
$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$result = sqlsrv_query( $conectar, $tsql, $params, $options );


if ($result){
    $nresult = sqlsrv_num_rows($result);
    if ($nresult > 0){
        session_start();
        $_SESSION['valid_user'] = true;
        $_SESSION['logged_user'] = $nombre;
        header("Location: acceso.php");

    }
    else{
        header("Location: acceso_error.php");
    }
}
else{
    include("sqlerror.php");
}
*/

include("getconex.php");
if($_POST){
    $nombre = $_POST["txtUsuario"];
    $pass = $_POST["txtPass"];
    $varControl = 'Formulario';
}
// $tsql = "EXEC Comprobarlogin '$nombre','$pass','$varControl'";
// $stmt = sqlsrv_query( $conectar, $tsql );
// $params = array();
// $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
// $result = sqlsrv_query( $conectar, $tsql, $params, $options );
// Parámetros del procedimiento almacenado
$resultado = 0;

// Preparar la consulta del procedimiento almacenado
$sql = "{CALL Login_usr(?, ?, ?)}";
$params = array(
    array($nombre, SQLSRV_PARAM_IN),
    array($pass, SQLSRV_PARAM_IN),
    array(&$resultado, SQLSRV_PARAM_OUT)
);

// Ejecutar la consulta
$stmt = sqlsrv_query($conectar, $sql, $params);

if ($stmt){
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if($row) {
        session_start();
        $_SESSION['valid_user'] = true;
        $_SESSION['logged_user'] = $nombre;
        $_SESSION['user_data'] = $row;
        header("Location: acceso.php");
    } else {
        header("Location: acceso_error.php");
    }
}
else{
    include("sqlerror.php");
}
// Cerrar la conexión
sqlsrv_close($conectar);



?>

