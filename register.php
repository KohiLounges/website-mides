<?php
header('Content-Type: application/json');

$uri = "";

$parsedUrl = parse_url($uri);

$servername = $parsedUrl['host'];
$username = $parsedUrl['user'];
$password = $parsedUrl['pass'];
$dbname = ltrim($parsedUrl['path'], '/'); 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]));
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "El usuario ya existe."]);
} else {
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registro exitoso."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al registrar: " . $stmt->error]);
    }
}

$stmt->close();
$conn->close();
?>
