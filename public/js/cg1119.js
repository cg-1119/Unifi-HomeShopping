// valid
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
    })
})()

// changeIcon
function changeIcon() {
    const checkService = document.getElementById('checkService');
    const serviceIcon = document.getElementById('serviceIcon');

    const checkPrivacy = document.getElementById('checkPrivacy');
    const privacyIcon = document.getElementById('privacyIcon');

    const checkAll = document.getElementById('checkAll');
    const checkAllIcon = document.getElementById(' checkAllIcon');

    checkService.addEventListener('change', function () {
        if(checkService.checked) {
            serviceIcon.classList.remove('bi-check-circle');
            serviceIcon.classList.add('bi-check-circle-fill')
        }
        else {
            serviceIcon.classList.remove('bi-check-circle');
            serviceIcon.classList.add('bi-check-circle-fill')
        }
    });
    checkPrivacy.addEventListener('change', function () {
        if(checkPrivacy.checked) {
            privacyIcon.classList.remove('bi-check-circle');
            privacyIcon.classList.add('bi-check-circle-fill')
        }
        else {
            privacyIcon.classList.remove('bi-check-circle');
            privacyIcon.classList.add('bi-check-circle-fill')
        }
    });
    checkAll.addEventListener('change', function () {
        if(checkPrivacy.checked) {
            checkAllIcon.classList.remove('bi-check-circle');
            serviceIcon.classList.remove('bi-check-circle');
            privacyIcon.classList.remove('bi-check-circle');
            checkAllIcon.classList.add('bi-check-circle-fill');
            serviceIcon.classList.add('bi-check-circle-fill');
            privacyIcon.classList.add('bi-check-circle-fill')
        }
        else {
            checkAllIcon.classList.remove('bi-check-circle');
            serviceIcon.classList.remove('bi-check-circle');
            privacyIcon.classList.remove('bi-check-circle');
            checkAllIcon.classList.add('bi-check-circle-fill')
            serviceIcon.classList.add('bi-check-circle-fill')
            privacyIcon.classList.add('bi-check-circle-fill')
            privacyIcon.classList.add('bi-check-circle-fill')
        }
    });
}