// Manages the process of submitting the form
// and showing errors/sucess messages

document.getElementById('form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const messageDiv = document.getElementById('message');

    // Clear all errors in all fields and messages
    clearErrors();    

    // Error check
    if (!validateForm()) {        
        return;
    }

    // spinner
    messageDiv.classList.add('loading');  
    // ******* ONLY FOR DEBUGGING ***********        
    //  delay to test spinner
    // await new Promise(resolve => setTimeout(resolve, 2000));
    // ************************************** 

    // Execute submit
    try {
        submitBtn.disabled = true;        

        const response = await fetch('register.php', {
            method: 'POST',
            body: formData
        });

        // ******* ONLY FOR DEBUGGING ***********        
        // const rawText = await response.text();
        // console.log('Raw response:', rawText);
        // let data2;
        // try {
        //     data2 = JSON.parse(rawText);
        // } catch (err) {
        //     console.error('Failed to parse JSON:', err);
        //     throw new Error("Invalid JSON response from server.");
        // }
        // ************************************** 

        const data = await response.json();        

        if (!response.ok) {             
            
            document.querySelectorAll('.error-field').forEach(el => {
                el.classList.remove('error-field');                
            });                
            
            if (data.errors.general) {
                messageDiv.classList.remove('loading');
                messageDiv.innerHTML = `<div class="form-message error">${data.errors.general}</div>`;
            }

            // Display field-specific errors
            Object.entries(data.errors).forEach(([field, error]) => {
                if (field !== 'general') {
                    const errorDiv = document.getElementById(`${field}-error`);
                    const input = document.querySelector(`[name="${field}"]`);
                    
                    if (errorDiv) {
                        errorDiv.textContent = error;  
                        const formGroup = errorDiv.closest('.form-group');
                        if (formGroup) {
                            formGroup.classList.add('form-group-with-error');
                        } 
                        if (field == 'password') {
                            formGroup.classList.add('form-group-with-error-password');
                        }
                    }
                    if (input) input.classList.add('error-field');
                }
            });               
            return;
        }

        //  Success
            messageDiv.classList.remove('loading');
            messageDiv.innerHTML = `
            <div class="form-message success">${data.message}</div>
            `;     
            
            // Reset form
            document.querySelectorAll('.checkmark').forEach(checkmark => {
                checkmark.classList.remove('visible');
            });
            form.reset();

        
    } catch (error) {   
        messageDiv.classList.remove('loading');    
        // console.log(error);         
        messageDiv.innerHTML = `
        <div class="form-message error">Service temporarily unavailable.<br>Please try again later.</div>
        `;       

    } finally {   
        messageDiv.classList.remove('loading');     
        submitBtn.disabled = false;
    }
});