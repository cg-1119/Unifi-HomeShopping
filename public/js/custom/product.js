// 총 상품 금액 업데이트 함수
function updateTotal(price) {
    const quantity = document.getElementById('quantity').value;
    const totalAmount = price * (quantity ? parseInt(quantity) : 0);

    // 총 금액 변경
    document.getElementById('total-amount').innerText = totalAmount.toLocaleString() + '원';
}

// 총 상품 개수 업데이트 함수
function updateQuantity() {
    const quantity = document.getElementById('quantity').value;
    const totalQuantityField = document.getElementById('total-quantity');
    totalQuantityField.value = quantity;
}

// 업데이트 실행 함수
function updateInfo(price) {
    updateTotal(price);
    updateQuantity();
}
// 페이지 로드 시 초기 금액 설정
document.addEventListener('DOMContentLoaded', function() {
    const price = parseInt(document.getElementById('quantity').getAttribute('oninput').match(/\d+/)[0]);
    updateTotal(price);
});

// 장바구니 페이지
function showModal() {
    document.getElementById('cart-modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('cart-modal').style.display = 'none';
}

function continueShopping() {
    closeModal();
}
document.getElementById('cart-form').addEventListener('submit', function (e) {
    e.preventDefault();

    // AJAX 요청 보내기
    const formData = new FormData(this);

    fetch(this.action, {
        method: this.method,
        body: formData,
    })
        .then(response => {
            if (response.ok) {
                showModal();
            } else {
                alert('장바구니 추가에 실패했습니다.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('서버 오류가 발생했습니다.');
        });
});

// 대표 이미지 변경 함수
function changeImage(newImageUrl) {
    const mainImage = document.getElementById('main-image');
    mainImage.src = newImageUrl;
}