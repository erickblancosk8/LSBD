<?php
$serverName = 'DESKTOP-FJ0K1J4';
$connectionInfo = array( 'Database'=>'Produccion', 'UID'=>'LSBDUSER', 'PWD'=>'Contra123!');

$conectar = sqlsrv_connect( $serverName, $connectionInfo); /*Aquí esta la instrucción para la conexión NOTA que es SQLSRV */

if ($conectar){


}else{

echo 'Hubo un error al conectarse a la base de datos. A continuación, los errores: <br>';

die( print_r(sqlsrv_errors(),true));

}

?>