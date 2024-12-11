// 커서 이벤트
document.addEventListener('DOMContentLoaded', () => {
    const welcomeText = document.querySelector('.welcome-container');
    const typingDuration = 2000; // 타이핑 애니메이션 지속 시간 (ms)

    // 타이핑 완료 후 커서 제거
    setTimeout(() => {
        welcomeText.classList.add('typing-done');
    }, typingDuration);
});
// 마우스 휠 이벤트
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.section');
    const texts = [
        'Cg1119에 오신 것을 환영합니다',
        '상품 소개',
        '상품 추천'
    ];
    const welcomeText = document.getElementById('welcomeText');

    let currentSectionIndex = 0; // 현재 섹션 번호
    let isAnimating = false; // 애니메이션 중 여부
    let isFirstLoad = true; // 초기 로딩 상태 관리

    // 초기 transform 값을 0으로 설정
    sections.forEach((section) => {
        section.style.transform = `translateY(0vh)`;
    });

    // 섹션 스크롤 및 텍스트 업데이트 함수
    function scrollSections(direction) {
        if (isAnimating) return; // 애니메이션 중에는 이벤트 무시

        // 인덱스 범위 제한
        if (direction === 'down' && currentSectionIndex < sections.length - 1) {
            currentSectionIndex++;
        } else if (direction === 'up' && currentSectionIndex > 0) {
            currentSectionIndex--;
        } else {
            return; // 범위를 벗어나면 종료
        }

        isAnimating = true;

        // 섹션 이동
        sections.forEach((section, i) => {
            const currentTranslateY = parseFloat(
                section.style.transform.replace(/[^-?\d.]/g, '') || 0
            );

            const newTranslateY =
                direction === 'down'
                    ? currentTranslateY - 100
                    : currentTranslateY + 100;

            section.style.transform = `translateY(${newTranslateY}vh)`;
        });

        // 텍스트 업데이트
        updateText(currentSectionIndex);

        // 애니메이션 종료 후 플래그 해제
        setTimeout(() => {
            isAnimating = false;
        }, 1500);
    }

    // 텍스트 업데이트 함수
    function updateText(index) {
        if (index >= 0 && index < texts.length) {
            if (isFirstLoad) {
                // 초기 로딩 시 애니메이션 없이 설정
                welcomeText.textContent = texts[index];
                isFirstLoad = false; // 초기 로딩 상태 해제
            } else {
                // 페이드 아웃
                welcomeText.classList.add('fade-out');

                setTimeout(() => {
                    // 텍스트 변경
                    welcomeText.textContent = texts[index];
                    // 페이드 인
                    welcomeText.classList.remove('fade-out');
                    welcomeText.classList.add('fade-in');
                }, 500);

                // 애니메이션 완료 후 클래스 제거
                setTimeout(() => {
                    welcomeText.classList.remove('fade-in');
                }, 1000);
            }
        }
    }

    // 휠 이벤트 처리
    window.addEventListener('wheel', (event) => {
        if (event.deltaY > 0) {
            // 아래로 스크롤
            scrollSections('down');
        } else {
            // 위로 스크롤
            scrollSections('up');
        }
    });

    // 초기 텍스트 설정
    updateText(currentSectionIndex);
});
