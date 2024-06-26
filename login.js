function toggleForm() {
    const loginForm = document.getElementById('signin');
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
    
    if (loginForm.classList.contains('d-none')) {
        signupForm.classList.add('d-none');
        loginForm.classList.remove('d-none', 'fade-in');
        setTimeout(() => loginForm.classList.add('fade-in'), 10);
    } else {
        loginForm.classList.add('d-none');
        signupForm.classList.remove('d-none', 'fade-in');
        setTimeout(() => signupForm.classList.add('fade-in'), 10);
    }


}

function handleSignin(event) {
    event.preventDefault();
    const username = document.getElementById('signin-username').value;
    const password = document.getElementById('signin-password').value;
    const errorMessage = document.getElementById('signin-error-message');
    const successMessage = document.getElementById('signin-success-message');

    if (!username || !password) {
        errorMessage.textContent = "Please fill in all fields.";
        return false;
    }

    fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            successMessage.textContent = "login success"
            setTimeout(function() {
                window.location.href = 'index.html';
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

function handleSignup(event) {
    event.preventDefault();
    const username = document.getElementById('signup-username').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const message = document.getElementById('signup-message');
    const successMessage = document.getElementById('signin-success-message');

    if (!username || !password || !confirmPassword) {
        message.textContent = "Please fill in all fields.";
        return false;
    }

    if (password !== confirmPassword) {
        message.textContent = "Passwords do not match.";
        return false;
    }

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (!passwordRegex.test(password)) {
        message.textContent = "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
        return false;
    }

    fetch('signup.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            toggleForm();
            successMessage.textContent = "Registration successful! Please sign in.";
            setTimeout(() => {
                successMessage.textContent = '';
            }, 500000); 
        } else {
            message.textContent = data.message;
        }
    });

    return false;
}



