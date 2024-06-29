//設定閒置時間 單位ms
const idle = 900000; 
let timeout;

//重置計時器的函數
function resetTimer() {
    //先重製上一次的timout
    clearTimeout(timeout);
    //到達閒置時間，要求重新登入並刪除session、cookie
    timeout = setTimeout(() => {
        fetch('session_timeout.php')
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert(data.message); 
                window.location.href = 'login.html'; 
            }
        })
        .catch(error => console.error('Error:', error));
    }, idle);

    //重新設置 session 和 cookie 過期時間
    fetch('reset_session_cookie.php')
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Failed to reset session and cookie');
        }
    })
    .catch(error => console.error('Error:', error));
}

//監聽鼠標、鍵盤、刷新頁面事件
document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);
window.onload = resetTimer;
