<?php
session_start();

// 檢查 session 是否存在
if (isset($_SESSION['username'])) {
    // 重置 session 的活動時間
    $_SESSION['last_activity'] = time(); // 更新最近活動時間
    
    // 重置 cookie 的過期時間
    setcookie("username", $_SESSION['username'], time() + (15 * 60), "/");

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Session not found']);
}
?>