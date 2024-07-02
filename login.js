function switchForm() {

    //重製message、input欄位
    const signinForm = document.getElementById('signin');
    const signupForm = document.getElementById('signup');
    const errorMessage = document.getElementById('signin-error-message');
    const successMessage = document.getElementById('signin-error-message');
    const signupMessage = document.getElementById('signup-message');
    document.getElementById('signin-username').value = '';
    document.getElementById('signin-password').value = '';
    document.getElementById('signup-username').value = '';
    document.getElementById('signup-password').value = '';
    document.getElementById('confirm-password').value = '';
    if (successMessage) {
        successMessage.textContent = '';
    }
    if (errorMessage) {
        errorMessage.textContent = '';
    }
    if (signupMessage) {
        signupMessage.textContent = '';
    }

    //切換
    if (signinForm.classList.contains('d-none')) {
        signupForm.classList.add('d-none');
        signinForm.classList.remove('d-none');
    } else {
        signinForm.classList.add('d-none');
        signupForm.classList.remove('d-none');
    }
}

//登入func
function controlSignin(event) {
    
    //防止一些預設事件，避免js被中斷
    event.preventDefault();

    const username = document.getElementById('signin-username').value;
    const password = document.getElementById('signin-password').value;
    const errorMessage = document.getElementById('signin-error-message');
    const successMessage = document.getElementById('signin-success-message');

    //格子內沒東西
    if (!username || !password) {
        errorMessage.textContent = "Please fill in all fields.";
        return false;
    }

    //登入驗證
    //使用fetchAPI，請求發送JSON格式的帳號密碼到login.php
    fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    })
    
    //將回應設為JSON
    .then(response => response.json()) 
    
    //處理回應的data
    .then(data => {
        if (data.success) {
            successMessage.textContent = "login success"
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1500);
            document.getElementById('signin-username').value = '';
            document.getElementById('signin-password').value = '';
            errorMessage.textContent = '';
            setTimeout(function() {
                successMessage.textContent = '';
            }, 1500);
        } else {
            errorMessage.textContent = data.message;
        }
    });

    return false;
}

//註冊func
function controlSignup(event) {

    //防止一些預設事件，避免js被中斷
    event.preventDefault();

    const username = document.getElementById('signup-username').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const message = document.getElementById('signup-message');
    const successMessage = document.getElementById('signin-success-message');

    //格子內沒東西
    if (!username || !password || !confirmPassword) {
        message.textContent = "Please fill in all fields.";
        return false;
    }

    //確認密碼
    if (password !== confirmPassword) {
        message.textContent = "Password do not match.";
        return false;
    }

    //密碼強度
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (!passwordRegex.test(password)) {
        message.textContent = "Password must contain at least 8 characters long and contain one each of A-Z, a-z, 0-9";
        return false;
    }

    //註冊驗證
    //使用fetchAPI，請求發送JSON格式的註冊帳號密碼到signup.php
    fetch('signup.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    })

    //將回應設為JSON
    .then(response => response.json())

    //處理回應的data
    .then(data => {
        if (data.success) {
            switchForm();
            successMessage.textContent = "Sign up successful! Please sign in.";
            setTimeout(() => {
                successMessage.textContent = '';
            }, 3000); 
        } else {
            message.textContent = data.message;
        }
    });

    return false;
}



