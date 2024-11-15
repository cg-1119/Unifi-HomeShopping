(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)

        // Add event listeners to inputs to remove invalid feedback when values are entered
        const inputs = form.querySelectorAll('input[required]')
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const feedback = input.nextElementSibling;
                if (input.checkValidity()) {
                    input.classList.remove('is-invalid')
                    input.classList.add('is-valid')
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.style.opacity = '0';
                    }
                } else {
                    input.classList.remove('is-valid')
                    input.classList.add('is-invalid')
                    const feedback = input.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.style.opacity = '1';
                    }
                }
            })
        })
    })
})()
