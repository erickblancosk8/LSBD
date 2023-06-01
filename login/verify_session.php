<?php
session_start();

if (!isset($_SESSION['valid_user']) || $_SESSION['valid_user'] !== true) {
    // No se ha iniciado sesión, redirigir al usuario a la página de inicio de sesión
    header("Location: index.html");
    exit();
}