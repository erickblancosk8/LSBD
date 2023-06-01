<?php
include_once("verify_session.php");
include("getconex.php");
echo "<p class='welcome-message'>Acceso al usuario correcto, bienvenido: </p> <p class='ot'>" . $_SESSION['logged_user'] . "</p></tr>";
echo "<form action='logout.php' method='POST'>";
echo "<input type='submit' name='logout' value='Logout' class='logout-button'>";
echo "</form>";

$userId = $_SESSION['user_data']['id'];

$sql = "SELECT * FROM Inventario_auto where usuarioId = ?";
$params = array($userId);
$stmt = sqlsrv_query($conectar, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .content {
            transition: opacity 1s;
        }
        h1 {
            text-align: center;
        }
        .logout-button {
            position: relative;
            left:90%;
            background-color: orange;
            color: white;
            border: none;
            padding: 10px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-left: 10px;
}

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .btn-container {
            
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .editar-link,
        .borrar-link {
            display: inline-block;
            margin-left: 5px;
        }
        .error-message{
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .welcome-message{
            font-family: Arial, sans-serif;
            font-size: 23px;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
    
        }
        .success-message{
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .ot{
            font-size: 32px;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .editar-link{
            background-color: #1b31e9;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 10px;
        }
        .editar-link:hover {
            background-color: #5466ff ;
        }
        .borrar-link{
            background-color: #f40404;
            color: #fff;
            border: none;
            padding: 10px 16px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
        }
        .borrar-link:hover {
            background-color: #f54242;
        }
        .q{
            font-size: 32px;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .cont{
            position: absolute;
            align-items: right;    
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmarEliminar(event) {
            event.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.href;
                }
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <p class="q"> Bienvenido a RedMotors </p>
        <table>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Transmisión</th>
                <th>Tipo de vehiculo</th>
                <th>Fecha de Llegada</th>
                <th>Acciones</th>
            </tr>
            <div class="btn-container">
                <button class="btn" onclick="location.href='vehiculos_form.php';">Agregar un vehiculo</button>
            </div>
            <?php
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $row['id']  ?></td>
                            <td><?= $row['marcaVehiculo']  ?></td>
                            <td><?= $row['modeloVehiculo']  ?></td>
                            <td><?= $row['anoVehiculo']  ?></td>
                            <td><?= $row['transVehiculo']  ?></td>
                            <th><?= $row['tipoVehiculo']  ?></th>
                            <td><?= $row['fecha_llegada']->format('Y-m-d')  ?></td>
                            <td>
                                <a class='editar-link' href='editar_vehiculo_view.php?id=<?=$row['id']?>'>Editar</a>
                                <a class='borrar-link' href='delete_vehiculo.php?id=<?=$row['id']?>' onclick='confirmarEliminar(event)'>Borrar</a>
                            </td>
                        </tr>      
                    <?php
                }
            ?>
        </table>
        </div>
    </body>
</html>
