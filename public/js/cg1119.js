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

// agree.php
const checkService = document.getElementById('checkService');
const serviceIcon = document.getElementById('serviceIcon');
const checkPrivacy = document.getElementById('checkPrivacy');
const privacyIcon = document.getElementById('privacyIcon');
const checkAll = document.getElementById('checkAll');
const checkAllIcon = document.getElementById(' checkAllIcon');
const submitButton = document.querySelector('.form-control');

function changeIcon() {
    function updateIcon(checkbox, icon) {
        if (checkbox.checked) {
            icon.classList.remove('bi-check-circle');
            icon.classList.add('bi-check-circle-fill');
        } else {
            icon.classList.remove('bi-check-circle-fill');
            icon.classList.add('bi-check-circle');
        }
    }
    function updateCheckAll() {
        if (checkService.checked && checkPrivacy.checked) {
            checkAllIcon.classList.remove('bi-check-circle');
            checkAllIcon.classList.add('bi-check-circle-fill');
            checkAll.checked = true;
        } else {
            checkAllIcon.classList.remove('bi-check-circle-fill');
            checkAllIcon.classList.add('bi-check-circle');
            checkAll.checked = false;
        }
    }
    checkService.addEventListener('change', function () {
        updateIcon(checkService, serviceIcon);
        updateCheckAll();
    });
    checkPrivacy.addEventListener('change', function () {
        updateIcon(checkPrivacy, privacyIcon);
        updateCheckAll();
    });

    // 전체 동의 체크박스 이벤트 리스너
    checkAll.addEventListener('change', function () {
        if (checkAll.checked) {
            checkService.checked = true;
            checkPrivacy.checked = true;

            updateIcon(checkService, serviceIcon);
            updateIcon(checkPrivacy, privacyIcon);
        } else {
            checkService.checked = false;
            checkPrivacy.checked = false;

            updateIcon(checkService, serviceIcon);
            updateIcon(checkPrivacy, privacyIcon);
        }
        updateIcon(checkAll, checkAllIcon);
    });
}
function formValidation() {
    function updateSubmitButton() {
        const allChecked = checkService.checked && checkPrivacy.checked;
        submitButton.disabled = !allChecked;

        if (allChecked) {
            submitButton.classList.remove('btn-outline-secondary');
            submitButton.classList.add('btn-primary');
            submitButton.classList.add('bg-secondary');
        } else {
            submitButton.classList.remove('bg-secondary');
            submitButton.classList.remove('btn-primary');
            submitButton.classList.add('btn-outline-secondary');
        }
    }
    updateSubmitButton()

    checkService.addEventListener('change', updateSubmitButton);
    checkPrivacy.addEventListener('change', updateSubmitButton);
    checkAll.addEventListener('change', updateSubmitButton);
}