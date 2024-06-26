<?php
session_start();

// 銷毀 session
session_unset();
session_destroy();

// 返回一個表示 session 已經過期的 JSON 響應
echo json_encode(['success' => false, 'message' => 'Session expired. Please log in again.']);
?>