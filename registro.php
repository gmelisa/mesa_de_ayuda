<?php
$conn = new mysqli('localhost', 'root', '', 'mesa_de_ayuda');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['new-password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (first_name, last_name, username, password) VALUES ('$firstName', '$lastName', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
