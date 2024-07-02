<?php
$servername = "localhost";
$username = "root";
$password = "xd405060";
$dbname = "dbt";
session_start();
//new一個object資料庫連接
$conn = new mysqli($servername, $username, $password, $dbname);
$un=isset($_SESSION['username'])?$_SESSION['username']:'';
if(empty($un)){
     header("Location: login.html");
}

if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $files = "";

    //處理文件上傳
    if (!empty($_FILES['files']['name'][0])) {
        $uploadedFiles = [];
        foreach ($_FILES['files']['name'] as $key => $name) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($name);
            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFile)) {
                $uploadedFiles[] = $targetFile;
            }
        }
        $files = implode(",", $uploadedFiles);
    }

    //插入留言信息
    $sql = "INSERT INTO messages (content, files,users) VALUES ('$content', '$files','$un')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
