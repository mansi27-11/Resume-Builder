<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "project2db";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["type" => "error", "message" => "Database connection failed."]);
    exit;
}

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = clean_input($_POST['email'] ?? '');
    $password = clean_input($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo json_encode(["type" => "error", "message" => "Email and password are required."]);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE tbl_user SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["type" => "success", "message" => "Password updated successfully."]);
    } else {
        echo json_encode(["type" => "error", "message" => "Email not found."]);
    }

    $stmt->close();
}

$conn->close();
?>