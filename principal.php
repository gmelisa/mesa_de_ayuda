<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal - Mesa de Ayuda</title>
</head>
<body>
    <h2>Bienvenido a la Mesa de Ayuda, <?php echo $_SESSION['usuario_nombre']; ?></h2>

    <form id="solicitud-form" action="solicitudes.php" method="POST" enctype="multipart/form-data">
        <label for="solicitud">Descripción de la solicitud:</label><br>
        <textarea id="solicitud" name="solicitud" rows="4" required></textarea><br><br>

        <label for="urgencia">Nivel de urgencia:</label>
        <select id="urgencia" name="urgencia" required>
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baja">Baja</option>
        </select><br><br>

        <label for="respuesta-pdf">Adjuntar PDF como respuesta:</label>
        <input type="file" id="respuesta-pdf" name="respuesta-pdf" accept=".pdf"><br><br>

        <button type="submit">Enviar solicitud</button>
    </form>

    <br><br>

    <button onclick="location.href='logout.php'">Cerrar sesión</button>
</body>
</html>
