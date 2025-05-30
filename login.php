<?php
header('Content-Type: application/json');

$host = "sql7.freesqldatabase.com";
$user = "sql7780578";
$password = "keRF8Iadnc";
$database = "sql7780578";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB connection failed"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$username = $input["username"] ?? '';
$password = $input["password"] ?? '';

$sql = "SELECT * FROM cliente WHERE (email_cliente = ? OR nombre_cliente = ?) AND contrasena_cliente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "error", "message" => "Credenciales inválidas"]);
}

$stmt->close();
$conn->close();
?>
