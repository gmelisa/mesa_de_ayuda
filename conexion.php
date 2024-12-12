<?php
$servidor = "localhost";
$usuario = "root";  // En XAMPP el usuario por defecto es "root"
$contraseña = "";    // En XAMPP, no hay contraseña por defecto
$base_de_datos = "mesa_de_ayuda";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $contraseña, $base_de_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
