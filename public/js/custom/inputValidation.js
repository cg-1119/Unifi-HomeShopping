(() => {
    'use strict';

    const forms = document.querySelectorAll('.needs-validation');

    // 커스텀 유효성 검사 함수
    const validateInput = (input, regex, feedback, validMessage, invalidMessage) => {
        const validate = () => {
            if (regex.test(input.value)) {
                input.setCustomValidity('');
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                feedback.textContent = validMessage || '';
                feedback.style.visibility = 'hidden';
            } else {
                input.setCustomValidity(invalidMessage);
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                feedback.textContent = invalidMessage;
                feedback.style.visibility = 'visible';
            }
        };

        input.addEventListener('input', validate);
        return validate;
    };

    // 각 폼에 대해 처리
    Array.from(forms).forEach(form => {
        // ID Validation
        const idInput = form.querySelector('#idValidation');
        const idFeedback = form.querySelector('#idValidationFeedback');
        if (idInput && idFeedback) {
            validateInput(
                idInput,
                /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d._-]{6,20}$/,
                idFeedback,
                '',
                'ID는 6~20자 사이의 알파벳과 숫자, `-`, `_`, `.` 만 포함 가능합니다.'
            );
        }

        // Password Validation
        const pwInput = form.querySelector('#pwValidation');
        const pwFeedback = form.querySelector('#pwValidationFeedback');
        if (pwInput && pwFeedback) {
            validateInput(
                pwInput,
                /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z\d!@#$%^&*]{8,16}$/,
                pwFeedback,
                '',
                '비밀번호는 8~16자리 내 알파벳, 숫자, 특수문자를 포함해야 합니다.'
            );
        }

        // Name Validation
        const nameInput = form.querySelector('#nameValidation');
        const nameFeedback = form.querySelector('#nameValidationFeedback');
        if (nameInput && nameFeedback) {
            validateInput(
                nameInput,
                /^[가-힣]{2,4}$/,
                nameFeedback,
                '',
                '유효한 이름을 입력하세요 (2~4자리 한글).'
            );
        }

        // Email Validation
        const emailInput = form.querySelector('#emailValidation');
        const emailFeedback = form.querySelector('#emailValidationFeedback');
        let emailValidate = null;
        if (emailInput && emailFeedback) {
            emailValidate = validateInput(
                emailInput,
                /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                emailFeedback,
                '',
                '유효한 이메일을 입력하세요.'
            );
        }

        // Phone Validation
        const phoneInput = form.querySelector('#phoneValidation');
        const phoneFeedback = form.querySelector('#phoneValidationFeedback');
        if (phoneInput && phoneFeedback) {
            validateInput(
                phoneInput,
                /^010\d{8}$/,
                phoneFeedback,
                '',
                '유효한 전화번호를 입력하세요 (예: 01012345678, - 제외).'
            );
        }

        // Password Check Validation
        const pwCheckInput = form.querySelector('#pwCheckValidation');
        const pwCheckFeedback = form.querySelector('#pwCheckValidationFeedback');
        if (pwCheckInput && pwCheckFeedback) {
            const validatePasswordCheck = () => {
                if (pwInput && pwCheckInput.value === pwInput.value && pwInput.checkValidity()) {
                    pwCheckInput.setCustomValidity('');
                    pwCheckInput.classList.remove('is-invalid');
                    pwCheckInput.classList.add('is-valid');
                    pwCheckFeedback.style.visibility = 'hidden';
                } else {
                    pwCheckInput.setCustomValidity('비밀번호가 일치하지 않습니다.');
                    pwCheckInput.classList.remove('is-valid');
                    pwCheckInput.classList.add('is-invalid');
                    pwCheckFeedback.textContent = pwCheckInput.value
                        ? '비밀번호가 일치하지 않습니다.'
                        : '비밀번호를 입력하세요.';
                    pwCheckFeedback.style.visibility = 'visible';
                }
            };

            pwInput && pwInput.addEventListener('input', validatePasswordCheck);
            pwCheckInput.addEventListener('input', validatePasswordCheck);
        }

        // 폼 제출 시 동작
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // 이메일 자동완성 관련 추가된 로직
        const autocompleteList = document.getElementById('autocomplete-list');
        const emailDomains = ['naver.com', 'gmail.com', 'daum.net', 'nate.com', 'outlook.com'];

        emailInput.addEventListener('input', function() {
            const value = emailInput.value;
            autocompleteList.innerHTML = '';

            if (value.includes('@')) {
                autocompleteList.classList.add('d-none');
                return;
            }

            if (value.trim() !== '') {
                const fragment = document.createDocumentFragment();
                emailDomains.forEach(domain => {
                    const item = document.createElement('div');
                    item.classList.add('autocomplete-item');
                    item.textContent = `${value}@${domain}`;
                    item.addEventListener('click', function() {
                        emailInput.value = item.textContent;
                        autocompleteList.innerHTML = '';
                        autocompleteList.classList.add('d-none');

                        // 이메일 자동완성 선택 후 유효성 검사 실행
                        if (emailValidate) {
                            emailValidate();
                        }
                    });
                    fragment.appendChild(item);
                });

                autocompleteList.appendChild(fragment);
                autocompleteList.classList.remove('d-none');
            } else {
                autocompleteList.classList.add('d-none');
            }
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.form-group')) {
                autocompleteList.classList.add('d-none');
            }
        });
    });
})();
