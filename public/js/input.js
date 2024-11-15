(() => {
    'use strict';

    const forms = document.querySelectorAll('.needs-validation');

    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Input Validation Logic
        const validateInput = (input, regex, feedback, validMessage, invalidMessage) => {
            input.addEventListener('input', () => {
                if (regex.test(input.value)) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    feedback.textContent = validMessage;
                    feedback.style.visibility = 'hidden';
                } else {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                    feedback.textContent = input.value ? invalidMessage : `${input.placeholder}를 입력하세요.`;
                    feedback.style.visibility = 'visible';
                }
            });
        };

        // ID Validation
        const idInput = document.querySelector('#idValidation');
        validateInput(
            idInput,
            /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d._-]{6,20}$/,
            document.querySelector('#idValidationFeedback'),
            '',
            'ID는 6~20자 사이의 알파벳과 숫자, `-`, `_`, `.` 만 포함 가능합니다.'
        );

        // Password Validation
        const pwInput = document.querySelector('#pwValidation');
        validateInput(
            pwInput,
            /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z\d!@#$%^&*]{8,16}$/,
            document.querySelector('#pwValidationFeedback'),
            '',
            '비밀번호는 8~16자리 내 알파벳, 숫자, 특수문자를 포함해야 합니다.'
        );

        // Name Validation
        const nameInput = document.querySelector('#nameValidation');
        validateInput(
            nameInput,
            /^[가-힣]{2,4}$/,
            document.querySelector('#nameValidationFeedback'),
            '',
            '유효한 이름을 입력하세요 (2~4자리 한글).'
        );

        // Phone Validation
        const phoneInput = document.querySelector('#phoneValidation');
        validateInput(
            phoneInput,
            /^010-\d{3,4}-\d{4}$/,
            document.querySelector('#phoneValidationFeedback'),
            '',
            '유효한 전화번호를 입력하세요 (예: 010-1234-5678).'
        );

        // PassWordCheck Validation
        const pwCheckInput = document.querySelector('#pwCheckValidation');
        const pwCheckFeedback = document.querySelector('#pwCheckValidationFeedback');
        function validatePasswordCheck() {
            if (pwCheckInput.value === pwInput.value && pwInput.classList.contains('is-valid')) {
                pwCheckInput.classList.remove('is-invalid');
                pwCheckInput.classList.add('is-valid');
                pwCheckFeedback.style.visibility = 'hidden';
            } else {
                pwCheckInput.classList.remove('is-valid');
                pwCheckInput.classList.add('is-invalid');
                pwCheckFeedback.textContent = pwCheckInput.value
                    ? '비밀번호가 일치하지 않습니다.'
                    : '비밀번호를 입력하세요.';
                pwCheckFeedback.style.visibility = 'visible';
            }
        }

        pwInput.addEventListener('input', () => validatePasswordCheck());
        pwCheckInput.addEventListener('input', () => validatePasswordCheck());


    });
})();
