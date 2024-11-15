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

        // idInput
        const idInput = document.querySelector('#idValidation');
        idInput.addEventListener('input', () => {
            // ID 규칙: 6~20자리 내 알파벳과 숫자를 포함
            const idRegex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d._-]{6,20}$/;
            const feedback = document.querySelector('#idValidationFeedback'); // 피드백 메시지

            if (idRegex.test(idInput.value)) {
                idInput.classList.remove('is-invalid');
                idInput.classList.add('is-valid');
                feedback.style.visibility = 'hidden';
                form.querySelector('#idValidation').style.cssText = 'margin-bottom:25px';
            } else {
                idInput.classList.remove('is-valid');
                idInput.classList.add('is-invalid');
                // 조건에 맞는 feedback text
                if(!idInput.value){
                    feedback.textContent = '아이디를 입력하세요.';
                    idInput.style.cssText = '';
                }
                else{
                    feedback.textContent = 'ID는 6~20자 사이의 알파벳과 숫자, `-`, `_`, `.` 만 포함가능.';
                    idInput.style.cssText = '';
                }
                feedback.style.visibility = 'visible';
            }
        });

        // passwordInput
        const pwInput = document.querySelector('#pwValidation');
        pwInput.addEventListener('input', () => {
            // PW 규칙:규칙은 8~16자리 내 알파벳, 숫자, 특수문자를 포함
            const pwRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z\d!@#$%^&*]{8,16}$/;
            const feedback = document.querySelector('#pwValidationFeedback'); // 피드백 메시지

            if (pwRegex.test(pwInput.value)) {
                pwInput.classList.remove('is-invalid');
                pwInput.classList.add('is-valid');
                feedback.style.visibility = 'hidden';
                pwInput.style.cssText = 'margin-bottom:25px';
            } else {
                pwInput.classList.remove('is-valid');
                pwInput.classList.add('is-invalid');
                // 조건에 맞는 feedback text
                if(!pwInput.value) {
                    feedback.textContent = '비밀번호를 입력하세요.';
                    pwInput.style.cssText = '';
                }
                else {
                    feedback.textContent = '비밀번호는 8~16자리 내 알파벳, 숫자, 특수문자를 포함해야함.';
                    pwInput.style.cssText = '';
                }
                feedback.style.visibility = 'visible';
            }
        });

        // passwordInput
        const nameInput = document.querySelector('#nameValidation');
        nameInput.addEventListener('input', () => {
            // 이름 규칙 : 2~4자리 한글
            const nameRegex = /^[가-힣]{2,4}$/;
            const feedback = document.querySelector('#nameValidationFeedback'); // 피드백 메시지

            if (nameRegex.test(nameInput.value)) {
                nameInput.classList.remove('is-invalid');
                nameInput.classList.add('is-valid');
                feedback.style.visibility = 'hidden';
                nameInput.style.cssText = 'margin-bottom:25px';
            } else {
                nameInput.classList.remove('is-valid');
                nameInput.classList.add('is-invalid');
                // 조건에 맞는 feedback text
                if(!nameInput.value) {
                    feedback.textContent = '이름을 입력하세요.';
                    nameInput.style.cssText = '';
                }
                else {
                    feedback.textContent = '유효한 이름을 입력하세요(2~4자리)';
                    nameInput.style.cssText = '';
                }
                feedback.style.visibility = 'visible';
            }
        });

        const phoneInput = document.querySelector('#phoneValidation');
        nameInput.addEventListener('input', () => {
            // 이름 규칙 : 2~4자리 한글
            const phoneRegex = /^010-\d{3,4}-\d{4}$/;
            const feedback = document.querySelector('#phoneValidationFeedback'); // 피드백 메시지

            if (phoneRegex.test(phoneInput.value)) {
                phoneInput.classList.remove('is-invalid');
                phoneInput.classList.add('is-valid');
                feedback.style.visibility = 'hidden';
                phoneInput.style.cssText = 'margin-bottom:25px';
            } else {
                phoneInput.classList.remove('is-valid');
                phoneInput.classList.add('is-invalid');
                // 조건에 맞는 feedback text
                if(!phoneInput.value) {
                    feedback.textContent = '전화번호를 입력하세요.';
                    phoneInput.style.cssText = '';
                }
                else {
                    feedback.textContent = '유효한 전화번호를 입력하세요.';
                    phoneInput.style.cssText = '';
                }
                feedback.style.visibility = 'visible';
            }
        });

    });
})()

