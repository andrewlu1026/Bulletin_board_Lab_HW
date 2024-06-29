<?php
session_start();

//清除 session
session_unset();
session_destroy();

//清除 cookie
setcookie("username", "", time() - 3600, "/");

//回傳false，alert訊息
echo json_encode(['success' => false, 'message' => 'Session expired. Please log in again.']);
?>