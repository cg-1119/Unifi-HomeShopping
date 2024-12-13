document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.section');
    const texts = document.querySelectorAll('.headerText');

    let currentSectionIndex = 0; // 현재 섹션 번호
    let isAnimating = false;

    // 초기 transform 값을 0으로 설정
    sections.forEach((section) => {
        section.style.transform = `translateY(0vh)`;
    });

    // 섹션 스크롤 및 텍스트 페이드 처리 함수
    function scrollSections(direction) {
        if (isAnimating) return; // 애니메이션 중에는 이벤트 무시

        if (direction === 'down' && currentSectionIndex < sections.length - 1) {
            currentSectionIndex++;
        } else if (direction === 'up' && currentSectionIndex > 0) {
            currentSectionIndex--;
        } else {
            return;
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

        // 텍스트 페이드 처리
        fadeText(currentSectionIndex);

        // 애니메이션 종료 후 플래그 해제
        setTimeout(() => {
            isAnimating = false;
        }, 1500);
    }

    // 텍스트 페이드 인/아웃 함수
    function fadeText(index) {
        texts.forEach((text, i) => {
            if (i === 0) {
                // 첫 번째 섹션은 페이드 인/아웃 효과 제거
                text.style.opacity = '1';
                text.style.transition = 'none';
            } else if (i === index) {
                text.classList.remove('fade-out');
                text.classList.add('fade-in');
            } else {
                text.classList.remove('fade-in');
                text.classList.add('fade-out');
            }
        });
    }

    // 휠 이벤트 처리
    window.addEventListener('wheel', (event) => {
        if (event.deltaY > 0) {
            scrollSections('down');
        } else {
            scrollSections('up');
        }
    });

    // 첫 번째 텍스트 초기 설정
    fadeText(currentSectionIndex);
});
