document.getElementById('loginForm')?.addEventListener('submit', function (e) {
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var err = document.getElementById('jsError');
    if (!email.value.trim() || !password.value.trim()) {
        e.preventDefault();
        err.textContent = 'Please fill in all fields.';
        err.classList.remove('hidden');
    }
});
