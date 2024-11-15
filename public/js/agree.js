(() => {
    // 변수 선언
    const checkService = document.getElementById('checkService');
    const serviceIcon = document.getElementById('serviceIcon');
    const checkPrivacy = document.getElementById('checkPrivacy');
    const privacyIcon = document.getElementById('privacyIcon');
    const checkAll = document.getElementById('checkAll');
    const checkAllIcon = document.getElementById('checkAllIcon');
    const submitButton = document.querySelector('.form-control[type="submit"]');

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

    // 제출 버튼 상태 업데이트
    function updateSubmitButton() {
        const allChecked = checkService.checked && checkPrivacy.checked;
        submitButton.disabled = !allChecked;

        if (allChecked) {
            submitButton.classList.add('bg-secondary', 'btn-secondary');
            submitButton.classList.remove('btn-outline-secondary');
        } else {
            submitButton.classList.remove('bg-secondary', 'btn-secondary');
            submitButton.classList.add('btn-outline-secondary');
        }
    }

    checkService.addEventListener('change', () => {
        updateIcon(checkService, serviceIcon);
        updateCheckAll();
        updateSubmitButton();
    });

    checkPrivacy.addEventListener('change', () => {
        updateIcon(checkPrivacy, privacyIcon);
        updateCheckAll();
        updateSubmitButton();
    });

    checkAll.addEventListener('change', () => {
        const isChecked = checkAll.checked;
        checkService.checked = isChecked;
        checkPrivacy.checked = isChecked;

        updateIcon(checkService, serviceIcon);
        updateIcon(checkPrivacy, privacyIcon);
        updateIcon(checkAll, checkAllIcon);
        updateSubmitButton();
    });

    // 초기 상태 업데이트
    document.addEventListener('DOMContentLoaded', () => {
        updateIcon(checkService, serviceIcon);
        updateIcon(checkPrivacy, privacyIcon);
        updateCheckAll();
        updateSubmitButton();
    });
})();
