<?php 
include_once("verify_session.php");
include("getconex.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $del_sql = "DELETE FROM [Inventario_auto] WHERE [id] = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conectar, $del_sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        header("Location: acceso.php");
    }
}