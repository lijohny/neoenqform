jQuery(function ($) {
    function formValidation(event) {
        event.preventDefault();

        // Reset previous errors and styles
        resetForm();

        let name = $('#name').val().trim();
        let email = $('#email').val().trim();
        let phone = $('#phone').val().trim();
        let message = $('#message').val().trim();


        // Validate name
        if (name === '') {
            handleValidationError('#name', 'Name is required');
            return;
        }

        // Validate email
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            handleValidationError('#email', 'Enter a valid email address');
            return;
        }

        // Validate phone
        let phoneRegex = /^\d{10}$/;
        if (!phoneRegex.test(phone)) {
            handleValidationError('#phone', 'Enter a valid phone number (10 digits)');
            return;
        }

        // Validate message
        if (message === '') {
            handleValidationError('#message', 'Message is required');
            return;
        }

        
        // If all validations pass, proceed with form submission
        const formData = {
            name: name,
            email: email,
            phone: phone,
            message: message

            // name:"John Doe",
            // email:"john@example.com",
            // phone:"1234567890",
            // messag: "Hello, this is a test message",
        };
        // console.log(formData);
        $.ajax({
            url: emailSending_ajax.ajax_url,
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            // contentType:'text/plain',
            data: {
                action: 'neo_send_email',
                form_data: formData
            },
            success: function (response) {
                name = $('#name').val("");
                email = $('#email').val("");
                phone = $('#phone').val("");
                message = $('#message').val("");
                
                window.location.href = "http://localhost/neoenqFrom/thankyou-page/";
                console.log(response);
            },
            error: function () {
                // Handle error if needed
                alert('An error occurred while submitting the form.');
            }
        });
        
    }

    function handleValidationError(element, errorMessage) {
        // Display error message and highlight the input field
        $(element).css('border', '1px solid red');
        $(element + 'Error').text(errorMessage);
    }

    function resetForm() {
        // Reset previous errors and styles
        $('#name, #email, #phone, #message').css('border', '1px solid #ced4da');
        $('#nameError, #emailError, #phoneError, #messageError').text('');
    }

    // Assuming the form has an ID of 'contactForm'
    $('#contactForm').submit(formValidation);
});