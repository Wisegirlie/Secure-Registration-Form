// Form Real-time field validation

// Initialize form validation
document.addEventListener('DOMContentLoaded', function () {    
    document.getElementById('username').addEventListener('change', validateUsername);
    document.getElementById('full_name').addEventListener('input', validateFullName);
    document.getElementById('email').addEventListener('input', validateEmail);
    document.getElementById('password').addEventListener('input', function () {
        validatePassword();
        validateRepeatPassword(); 
    });
    document.getElementById('repeat_password').addEventListener('input', validateRepeatPassword);
    document.getElementById('phone').addEventListener('change', validatePhone);
    document.getElementById('phone').addEventListener('keyup', validatePhone);
});


// --------------------------
// Field validation functions
// --------------------------

const messageDiv = document.getElementById('message');

// username
function validateUsername() {
    const username = document.getElementById("username").value.trim();    
    if (!username) {
        showError("username", "Please enter a Username");
        return false;
    }    
    if (username.length < 3) {
        showError("username", "Username must be at least 3 characters");
        return false;
    }   
    const usernameRegex = /^[a-zA-Z0-9_\-]+$/;
    if (!usernameRegex.test(username)) {
        showError('username', "Please enter a valid username");
        return false;
    }
    clearError("username");
    return true;
}

// Full Name
function validateFullName() {
    const fullName = document.getElementById('full_name').value.trim();
    if (!fullName) {
        showError("full_name", "Please enter your full name");
        return false;
    }        
    
    const nameRegex = /^([\p{L}][\p{L}'\-]{1,} )+[\p{L}][\p{L}'\-]{1,}$/u;
    // Allows:
    // - Letters (including accents and ñ)
    // - At least two words (e.g., First and Last name)
    // - Hyphens (-)
    // - Apostrophes (')
    // - Spaces between names
    

    if (!nameRegex.test(fullName)) {
      showError("full_name", "Please enter a valid full name (e.g. José O'Connor).");
      return false;
    }
    clearError("full_name");
    return true;
}

// Email
function validateEmail() {
    const email = document.getElementById('email').value.trim();    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;        
    if (!email) {
        showError('email', "Please enter your email address");
        return false;
    }    
    if (!emailRegex.test(email)) {
        showError('email', "Please enter a valid email");
        return false;
    }
    clearError('email');
    return true;
}

// Password
function validatePassword() {
    const password = document.getElementById('password').value;    
    const passwordCheckmark = document.querySelector('#password + .checkmark');
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;    
    if (!password) {
        showError("password", "Password is required");
        passwordCheckmark.classList.remove('visible');        
        return false;
    }    
    if (!passwordRegex.test(password)) {
        showError("password", "Password must meet all requirements");
        passwordCheckmark.classList.remove('visible');
        return false;        
    }    
    clearError("password");
    passwordCheckmark.classList.add('visible');    
    return true;
}

// Repeat Password
function validateRepeatPassword() {
    const password = document.getElementById('password').value;    
    const repeatPassword = document.getElementById('repeat_password').value; 
    const repeatCheckmark = document.querySelector('#repeat_password + .checkmark');
    if (password) {
        if (password !== repeatPassword) {
            repeatCheckmark.classList.remove('visible');
            showError('repeat_password', "Passwords do not match");        
            return false;
        }    
        clearError('repeat_password');
        repeatCheckmark.classList.add('visible');
        return true;
    }  
}

// Phone -  Get phone with full country code into hidden field 
function validatePhone() {
    const phone = document.querySelector("#phone").value;    
    const errorField = document.getElementById(`phone-error`);
    const output = document.querySelector("#full_phone");

     if (!phone) {
        showError("phone", "Please enter your phone number");
        return false;
    }    
    if (!iti.isValidNumber()) {
        showError("phone", "Please enter a valid phone number");
        return false;
    }
    // Update hidden field with full number
    output.value = iti.getNumber();
    clearError("phone");
    return true;
}

// Show Error - specific field
function showError(element, message) {
    if (!element) return;
    const errorDiv = document.getElementById(`${element}-error`);   
    const input = document.getElementById(element);       
    if (errorDiv) {
        errorDiv.textContent = message;  
        const formGroup = errorDiv.closest('.form-group');        
        if (element == 'password') {
            formGroup.classList.add('form-group-with-error-password');
        } else if (formGroup) {
            formGroup.classList.add('form-group-with-error');
        } 
        
    }
     if (input) { 
        input.classList.add('error-field-border') 
        // input.classList.add('error-field');
    };
}

// clear specific error
function clearError(element) {    
    if (!element) return;
    const input = document.getElementById(element);   
    const errorDiv = document.getElementById(`${element}-error`);            
    errorDiv.textContent = '';
    const formGroup2 = errorDiv.closest('.form-group');    
    if (element == 'password') {
        formGroup2.classList.remove('form-group-with-error-password');
    }  else if (formGroup2) {
        formGroup2.classList.remove('form-group-with-error');
    }     
    if (input) { 
        input.classList.remove('error-field-border') 
        input.classList.remove('error-field');
    };
    checkAndClearGeneralMessage();
}

//  Clear all errors
function clearErrors() {        
    document.querySelectorAll('.error-field-text').forEach(el => {
        el.textContent = '';  
        const formGroup = el.closest('.form-group');
        if (formGroup) {
            formGroup.classList.remove('form-group-with-error');
        } 
        if (el == 'password') {
            formGroup.classList.remove('form-group-with-error-password');
        }
    });
    document.querySelectorAll('.error-field').forEach(el => {
        el.classList.remove('error-field');
    });   
    messageDiv.innerHTML = ``;     
    
    // clear checkmarks    
    document.querySelectorAll('.checkmark').forEach(checkmark => {
        checkmark.classList.remove('visible');
    });
}

// Form submission validation
function validateForm() {   
    clearErrors();    
    
    // Validate all fields
    const isFormValid = 
        validateUsername() &&
        validateFullName() &&
        validateEmail() &&
        validatePassword() &&
        validateRepeatPassword() &&
        validatePhone();             
    if (isFormValid) {
        return true;
    } else {
        messageDiv.innerHTML = `<div class="form-message error">Please fill in all the required fields</div>`;
        return false
    }
}

// This is to clear general message when there are no errors
function checkAndClearGeneralMessage() {
    const errorMessages = document.querySelectorAll('.error-field-text');
    const hasErrors = Array.from(errorMessages).some(el => el.textContent.trim() !== '');
    
    if (!hasErrors) {
        document.getElementById('message').innerHTML = '';
    }
}