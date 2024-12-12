<?php
// Habilitar la respuesta en JSON
header('Content-Type: application/json');

// Leer las solicitudes desde el archivo JSON (si existe)
$solicitudesFile = 'solicitudes.json';
if (file_exists($solicitudesFile)) {
    $solicitudes = json_decode(file_get_contents($solicitudesFile), true);
    echo json_encode($solicitudes);
} else {
    echo json_encode([]);  // Si no hay solicitudes, responder un array vacío
}
?>
