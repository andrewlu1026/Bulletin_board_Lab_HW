<?php
header('Content-Type: application/json');
$request = json_decode(file_get_contents('php://input'), true);

$username = $request['username'];
$password = $request['password'];

// 假設存在一個數據庫連接
$conn = new mysqli('localhost', 'root', 'xd405060', 'dbt');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already exists.']);
} else {
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed.']);
    }
}

$stmt->close();
$conn->close();
?>
