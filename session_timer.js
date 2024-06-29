
// 設定閒置時間閾值（例如15分鐘，即900000毫秒）
const idle = 9000; 
let timeout;

// 重置計時器的函數
function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        // 如果用戶15分鐘內沒有活動，發送請求到服務器端處理
        fetch('session_timeout.php')
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message); // 提示 session 過期
                window.location.href = 'login.html'; // 重定向到登錄頁面
            }
        })
        .catch(error => console.error('Error:', error));
    }, idle);

    // 發送請求到伺服器，重新設置 session 和 cookie 過期時間
    fetch('reset__session_cookie.php')
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Failed to reset session and cookie');
        }
    })
    .catch(error => console.error('Error:', error));
}

// 監聽鼠標和鍵盤事件
document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);

// 頁面加載時也初始化計時器
window.onload = resetTimer;
