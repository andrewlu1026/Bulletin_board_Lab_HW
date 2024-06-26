<?php
session_start();
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
    $user = $result->fetch_assoc();
    if ($password === $user['password']) {
        // 設置session和cookie
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time(); // 更新最近活動時間
        
        setcookie("username", $username, time() + (15 * 60), "/"); // 15分鐘
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}

$stmt->close();
$conn->close();
?>
