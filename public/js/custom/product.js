// 총 상품 금액 업데이트 함수
function updateTotal(price) {
    const quantity = document.getElementById('quantity').value;
    const totalAmount = price * (quantity ? parseInt(quantity) : 0);
    document.getElementById('total-amount').innerText = totalAmount.toLocaleString() + '원';
}

// 페이지 로드 시 초기 금액 설정
document.addEventListener('DOMContentLoaded', function() {
    const price = parseInt(document.getElementById('quantity').getAttribute('oninput').match(/\d+/)[0]);
    updateTotal(price);
});

// 대표 이미지 변경 함수
function changeImage(newImageUrl) {
    const mainImage = document.getElementById('main-image');
    mainImage.src = newImageUrl;
}