<?php
session_start();

//檢查 session 是否存在
if (isset($_SESSION['username'])) {
    //更新session
    $_SESSION['last_activity'] = time();
    
    //更新cookie
    setcookie("username", $_SESSION['username'], time() + (15 * 60), "/");

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Session not found']);
}

?>