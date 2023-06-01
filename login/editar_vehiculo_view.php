<?php
// Verificar si se ha proporcionado un ID
include("getconex.php");
include_once("verify_session.php");
if (isset($_GET['error'])) {
    $errorMsg = $_GET['error'];
    // Muestra el mensaje de error al usuario
    echo '<script>alert("'.$errorMsg.'");</script>';
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Realizar una consulta para obtener los datos del vehículo
    $sql = "SELECT * FROM Inventario_auto WHERE id = ?";
    $params = array($id);
    $stmt = sqlsrv_query($conectar, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Verificar si se encontró el vehículo
    if (sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $marca = $row['marcaVehiculo'];
        $modelo = $row['modeloVehiculo'];
        $ano = $row['anoVehiculo'];
        $trans = $row['transVehiculo'];
        $tipo = $row['tipoVehiculo'];
        $fecha_llegada = $row['fecha_llegada'];
    } else {
        // No se encontró el vehículo, puedes mostrar un mensaje de error o redireccionar a otra página
        echo "El vehículo no existe";
        exit;
    }
} else {
    // No se ha proporcionado un ID, puedes mostrar un mensaje de error o redireccionar a otra página
    echo "ID de vehículo no especificado";
    exit;
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los valores del formulario
    $id = $_POST["id"];
    $marca = $_POST["txtmarca"];
    $modelo = $_POST["txtmodelo"];
    $ano = $_POST["txtano"];
    $trans = $_POST["txttrans"];
    $tipo = $_POST["txttipo"];
    $fecha = $_POST["txtfechallegada"];
    $fechaActual = new DateTime();
    $fecha = $fechaActual->format('Y-m-d');

    // Realizar la actualización en la base de datos
    $sql = "UPDATE Inventario_auto SET marcaVehiculo = ?, modeloVehiculo = ?, anoVehiculo = ?, transVehiculo = ?, tipoVehiculo = ? fecha_llegada = ? WHERE id = ?";
    $params = array($marca, $modelo, $ano, $trans, $tipo, $fecha, $id);
    $stmt = sqlsrv_query($conectar, $sql, $params); 

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Verificar si la actualización fue exitosa
    $rowsAffected = sqlsrv_rows_affected($stmt);
    if ($rowsAffected > 0) {
        // Redireccionar a acceso.php
        header("Location: acceso.php");
        exit;
    } else {
        echo "Error al actualizar el vehículo";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar vehiculo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .btn-group input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group input[type="button"] {
            background-color: #db3412;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            display: inline-block;
        }

        .form-group input[type="button"]:hover {
            background-color: #45a049;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-group .btn-back {
            background-color: #db3412;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-group .btn-back:hover {
            background-color: #ff665a;
        }

        .custom-select {
            position: relative;
            display: inline-block;
            width: 100%;
                }
        
        .custom-select select {
            display: inline-block;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
        
        .custom-select select:focus {
            outline: none;
        }
        
        .custom-select::after {
            content: '\25BC';
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            pointer-events: none;
        }
        
        .custom-select::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 8px;
            width: 10px;
            height: 10px;
            background-color: #ccc;
            transform: translateY(-50%) rotate(45deg);
            pointer-events: none;
        }
        
        .custom-select select[disabled] {
            background-color: #f2f2f2;
            cursor: not-allowed;
        }
        
        .custom-select select[disabled]::before {
            background-color: #999;
        }
        
        .custom-select select[disabled]::after {
            color: #999;
        }
        

    </style>
</head>
<body>
<div class="container">
        <h1>Editar vehiculo</h1>
        <form action="update_vehiculo.php" method="POST">
            <div class="form-group">
                <label for="Marca">Marca del vehiculo:</label>
                <input type="text" name="txtmarca" value="<?php echo $marca; ?>" required>
            </div>
            <div class="form-group">
                <label for="Modelo">Modelo del vehiculo (submarca):</label>
                <input type="text" name="txtmodelo"value="<?php echo $modelo;?>" required>
            </div>
            <div class="form-group">
                <label for="Año">Año del vehiculo (2005 - 2024):</label>
                <input type="text" name="txtano" value="<?php echo $ano; ?>" required>
            </div>
            <div class="form-group">
                <label for="Transmision">Transmisión del vehiculo:</label>
                <div class="custom-select">
                    <select name="txttrans" value="<?php echo $trans; ?>" required>
                        <option value="">Seleccionar</option>
                        <option value="A">A</option>
                        <option value="CVT">CVT</option>
                        <option value="M">M</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="Tipo">Tipo de vehiculo:</label>
                <div class="custom-select">
                    <select name="txttipo" value="<?php echo $tipo; ?>" required>
                        <option value="">Seleccionar</option>
                        <option value="Cabrio">Cabrio</option>
                        <option value="Coupe">Coupe</option>
                        <option value="Deportivo">Deportivo</option>
                        <option value="Hatchback">Hatchback</option>
                        <option value="Microauto">Microauto</option>
                        <option value="Sedan">Sedan</option>
                        <option value="SUV">SUV</option>
                        <option value="Todoterreno">Todoterreno</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="Fecha">Fecha de llegada:</label>
                <input type="text" name="txtfechallegada" value="<?php echo $fecha_llegada->format('Y-m-d'); ?>" required>
            </div>
            <div class="btn-group">
                <input type="submit" value="Editar vehiculo">
                <a href="acceso.php" class="btn-back">Regresar</a>
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        </form>
    </div>
</body>
</html>