<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}   else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$date = date( '[Y/m/d H:i:s] ');
echo "<br>";
$dirip = " [" . $ip . "] ";
$sqlerror = print_r( sqlsrv_errors(), true);
error_log($date . $dirip . "Error en SQL SERVER: " . $sqlerror,3,'./error.log');
echo "<br>";
?>
<script>
    alert("La pagina a la cual intentas acceder, no se encuentra disponible, intentalo de nuevo");
    setTimeout(function(){
        location.href = "./index.html";
    },10)
</script>

