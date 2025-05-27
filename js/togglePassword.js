//   Toggles Password visibility

function togglePassword() {
    const passwordField = document.getElementById("password");
    const passwordRepeatField = document.getElementById("repeat_password");
    const toggleIcon = passwordField.nextElementSibling.querySelector('i');
    const toggleIconRepeat = passwordRepeatField.nextElementSibling.querySelector('i');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordRepeatField.type = 'text';
        toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
        toggleIconRepeat.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordRepeatField.type = 'password';
        toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
        toggleIconRepeat.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

//  Keyboard support for accesibility
document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggle.click();
        }
    });
});