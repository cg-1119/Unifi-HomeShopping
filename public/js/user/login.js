(() => {
    'use strict'

    const forms = document.querySelectorAll('.needs-validation')

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

function confirmLogout() {
    if (window.confirm('정말 로그아웃 하시겠습니까?')) window.location.href = '/controllers/LoginController.php?action=logout';
    else history.back();
}