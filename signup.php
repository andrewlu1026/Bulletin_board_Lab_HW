<?php
header('Content-Type: application/json');

//取得與php關聯的數據組
$request = json_decode(file_get_contents('php://input'), true);

//註冊資料關聯到fetch發送的JSON格式資料
$username = $request['username'];
$password = $request['password'];

//new一個object資料庫連接
$conn = new mysqli('localhost', 'root', 'xd405060', 'dbt');

//連接錯誤就終止腳本
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//定義sql查詢，找到指定username
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //檢查帳號是否已被使用
    echo json_encode(['success' => false, 'message' => 'Username already exists.']);
} else {
    //插入新用戶帳號密碼
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed.']);
    }
}

$conn->close();

?>
