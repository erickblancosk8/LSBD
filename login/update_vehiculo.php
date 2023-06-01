<?php 
include_once("verify_session.php");
include("getconex.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($_POST) {
        $marca = $_POST["txtmarca"];
        $modelo = $_POST["txtmodelo"];
        $ano = $_POST["txtano"];
        $trans = $_POST["txttrans"];
        $tipo = $_POST["txttipo"];
        $fechallegada = $_POST["txtfechallegada"];       

        if (is_numeric($marca)) {
            $errorMsg = "El valor ingresado para la marca del vehiculo es inválido. Por favor, ingresa una cadena de caracteres.";
            header("Location: vehiculos_form.php?error=".urlencode($errorMsg));
            exit();
        }
    
        // Validar la fecha de llegada
        if (!checkdate(date('m', strtotime($fecha_llegada)), date('d', strtotime($fecha_llegada)), date('Y', strtotime($fecha_llegada)))) {
            $errorMsg = "La fecha seleccionada es incorrecta. Por favor, elige una fecha válida.";
            header("Location: editar_vehiculo.php?error=".urlencode($errorMsg));
            exit();
        }

        $upd_sql = "UPDATE [Inventario_auto] SET marcaVehiculo = ?, modeloVehiculo = ?, anoVehiculo = ?, transVehiculo = ?, tipoVehiculo = ?, fecha_llegada = ? WHERE id = ?";
        $params = array($marca, $modelo, $ano, $trans, $tipo, $fechallegada, $_POST["id"]);
        $stmt = sqlsrv_query($conectar, $upd_sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header("Location: acceso.php");
        }
    }
}

?>