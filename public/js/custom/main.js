document.addEventListener('DOMContentLoaded', () => {
    const welcomeText = document.querySelector('.welcome-container');
    const typingDuration = 4000; // 타이핑 애니메이션 지속 시간 (ms)

    setTimeout(() => {
        welcomeText.classList.add('typing-done');
    }, typingDuration);
});