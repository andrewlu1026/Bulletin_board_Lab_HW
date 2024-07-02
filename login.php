<?php
session_start();
header('Content-Type: application/json');

//取得與php關聯的數據組
$request = json_decode(file_get_contents('php://input'), true);

//登入資料關聯到fetch發送的JSON格式資料
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
    $user = $result->fetch_assoc();

    //檢查密碼
    if ($password === $user['password']) {

        //設置session和cookie
        $_SESSION['username'] = $username;
        
        //更新活動時間
        $_SESSION['last_activity'] = time(); 
        setcookie("username", $username, time() + (15 * 60), "/"); 
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}


$conn->close();
?>
