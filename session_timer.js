
// 設定閒置時間閾值（例如15分鐘，即900000毫秒）
const idle = 20000; 
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
}

// 監聽鼠標和鍵盤事件
document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);

// 頁面加載時也初始化計時器
window.onload = resetTimer;
