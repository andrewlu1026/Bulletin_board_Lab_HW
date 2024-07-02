<?php
session_start();
session_unset();
session_destroy();
session_start();
 $_SESSION['username'] = '';
 
//清除cookie
setcookie("username", "", time() - 3600, "/");

echo json_encode(['success' => true]);
 header("Location: login.html");
?>
