// product/detail.php

// 상품 정보 업데이트
function updateTotal(price) {
    const quantityInput = document.getElementById('quantity');
    const totalAmountElement = document.getElementById('total-amount');

    const quantity = parseInt(quantityInput.value) || 0; // 수량 가져오기
    const totalAmount = price * quantity; // 총 금액 계산

    // 총 금액 업데이트
    totalAmountElement.textContent = `${totalAmount.toLocaleString()}원`;
    }
// 장바구니에 상품 추가
function addToCart(productId, quantity) {
    if (!productId || quantity <= 0) {
        alert("올바른 상품 정보가 필요합니다.");
        return;
    }

    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    // 기존 장바구니 데이터 업데이트
    if (cart[productId]) {
        cart[productId].quantity += quantity;
    } else {
        cart[productId] = {
            id: productId,
            name: document.querySelector("h4").innerText,
            price: parseInt(document.getElementById('total-amount').dataset.price, 10),
            quantity: quantity,
        };
    }

    // localStorage에 업데이트된 장바구니 저장
    localStorage.setItem('cart', JSON.stringify(cart));

    console.log("After saving to localStorage:", localStorage.getItem('cart'));

    // 서버로 AJAX 요청 보내기
    fetch('/controllers/CartController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: 'updateCart', cart: cart }),
    })
        .then((response) => {
            if (response.ok) {
                openModal();
            } else {
                alert('서버와의 통신에 실패했습니다.');
            }
        })
        .catch((error) => {
            console.error('AJAX 요청 오류:', error);
        });
}


// 모달 열기
function openModal() {
    const modal = document.getElementById('cart-modal');
    modal.style.display = 'block';
}

// 모달 닫기
function closeModal() {
    const modal = document.getElementById('cart-modal');
    modal.style.display = 'none';
}

// "계속 쇼핑" 버튼 클릭 시
function continueShopping() {
    closeModal();
}

// cart/index.php
// 로컬스토리지에서 장바구니 데이터 가져오기
function getCart() {
    const cart = localStorage.getItem('cart');
    return cart ? JSON.parse(cart) : {}; // 데이터가 없으면 빈 객체 반환
}
// 장바구니가 비어있는지 확인
function isCartEmpty() {
    const cart = getCart();
    return Object.keys(cart).length === 0; // 데이터가 없으면 true 반환
}
