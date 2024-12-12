<?php
// Habilitar la respuesta en JSON
header('Content-Type: application/json');
echo json_encode($solicitudes);

// Obtener los datos del formulario
$solicitud = isset($_POST['solicitud']) ? $_POST['solicitud'] : '';
$urgencia = isset($_POST['urgencia']) ? $_POST['urgencia'] : '';

// Verificar si se ha subido un archivo PDF
if (isset($_FILES['respuesta-pdf']) && $_FILES['respuesta-pdf']['error'] == 0) {
    // Verificar si el archivo es un PDF
    $file = $_FILES['respuesta-pdf'];
    if ($file['type'] != 'application/pdf') {
        echo json_encode(['success' => false, 'message' => 'El archivo debe ser un PDF.']);
        exit;
    }
    
    // Guardar el archivo en una carpeta (por ejemplo: 'uploads/')
    $uploadDir = 'uploads/';
    $filePath = $uploadDir . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        echo json_encode(['success' => false, 'message' => 'Error al subir el archivo.']);
        exit;
    }
    $filePath = $filePath;  // Guardamos la ruta del archivo subido
} else {
    $filePath = null;  // Si no se subió archivo
}

// Aquí puedes guardar los datos en la base de datos o en un archivo
// Vamos a suponer que guardamos las solicitudes en un archivo JSON por simplicidad
$solicitudesFile = 'solicitudes.json';

// Cargar las solicitudes existentes
if (file_exists($solicitudesFile)) {
    $solicitudes = json_decode(file_get_contents($solicitudesFile), true);
} else {
    $solicitudes = [];
}

// Crear una nueva solicitud
$newSolicitud = [
    'descripcion' => $solicitud,
    'urgencia' => $urgencia,
    'archivo' => $filePath
];

// Agregar la nueva solicitud a la lista
$solicitudes[] = $newSolicitud;

// Guardar el archivo de solicitudes actualizado
file_put_contents($solicitudesFile, json_encode($solicitudes, JSON_PRETTY_PRINT));

// Responder con un mensaje de éxito
echo json_encode(['success' => true]);
?>
