<?php 
include_once("verify_session.php");
include("getconex.php");
$userId = $_SESSION['user_data']['id'];


if ($_POST) {
    $marca = $_POST["txtmarca"];
    $modelo = $_POST["txtmodelo"];
    $ano = $_POST["txtano"];
    $trans = $_POST["txttrans"];
    $tipo = $_POST["txttipo"];
    $fecha_llegada = $_POST["txtfechallegada"];
    $fechaActual = new DateTime();
    $fechallegada = $fechaActual->format('Y-m-d');

    
    // Validar la marca del vehiculo
    if (is_numeric($marca)) {
        $errorMsg = "El valor ingresado para la marca del vehiculo es inválido. Por favor, ingresa una cadena de caracteres.";
        header("Location: vehiculos_form.php?error=".urlencode($errorMsg));
        exit();
    }

    // Validar la fecha de llegada
    if (!checkdate(date('m', strtotime($fecha_llegada)), date('d', strtotime($fecha_llegada)), date('Y', strtotime($fecha_llegada)))) {
        $errorMsg = "La fecha seleccionada es incorrecta. Por favor, elige una fecha válida.";
        header("Location: vehiculos_form.php?error=".urlencode($errorMsg));
        exit();
    }

    $sql = "INSERT INTO Inventario_auto (marcaVehiculo, modeloVehiculo, anoVehiculo, transVehiculo, tipoVehiculo, fecha_llegada, usuarioId) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($marca, $modelo, $ano, $trans, $tipo, $fecha_llegada, $userId);
    $stmt = sqlsrv_query($conectar, $sql, $params);

    if ($stmt === false) {
        // Verifica si el error es causado por la restricción de fecha
        $errors = sqlsrv_errors();
        $errorCode = $errors[0]['code'];

        if ($errorCode === '547') {
            $errorMsg = "Ha ocurrido un error.";
        } else {
            $errorMsg = "Ha ocurrido un error en la inserción de datos.";
        }

        // Redirige al usuario de vuelta al formulario con el mensaje de error
        header("Location: vehiculos_form.php?error=".urlencode($errorMsg));
        exit();
    } else {
        header("Location: acceso.php");
    }
}
?>
