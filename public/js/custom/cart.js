// product/detail.php

// 상품 정보 업데이트
function updateTotal(price) {
    const quantityInput = document.getElementById('quantity');
    const totalPriceElement = document.getElementById('total-price');

    const quantity = parseInt(quantityInput.value) || 0; // 수량 가져오기
    const totalPrice = price * quantity; // 총 금액 계산

    // 총 금액 업데이트
    totalPriceElement.textContent = `${totalPrice.toLocaleString()}원`;
}

// 장바구니에 상품 추가
function addToCart(productId, quantity) {
    if (!productId || quantity <= 0) {
        alert("올바른 상품 정보가 필요합니다.");
        return;
    }

    const productName = document.querySelector("h4").innerText;
    const productPrice = parseInt(document.querySelector(".price strong").innerText.replace(/[^0-9]/g, ""), 10);
    const thumbnailImage = document.getElementById("main-image").src.split('localhost:8080')[1];

    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    // 기존 장바구니 데이터 업데이트
    if (cart[productId]) {
        cart[productId].quantity += quantity;
    } else {
        cart[productId] = {
            id: productId,
            name: productName,
            price: productPrice,
            thumbnail: thumbnailImage,
            quantity: quantity,
        };
    }

    // AJAX 요청
    fetch('/controllers/CartController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action: 'updateCart', cart: cart }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // 세션 데이터로 로컬스토리지 동기화
                localStorage.setItem('cart', JSON.stringify(data.cart));
                openModal();
            } else {
                alert('서버와의 통신에 실패했습니다.');
            }
        })
        .catch((error) => console.error('AJAX 요청 오류:', error));
}

// cart/index.php
function updateQuantity(productId, quantity) {
    if (quantity < 1) {
        alert("수량은 1개 이상이어야 합니다.");
        return;
    }

    fetch("/controllers/CartController.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "updateQuantity",
            product_id: productId,
            quantity: quantity,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // 세션 데이터로 로컬스토리지 동기화
                localStorage.setItem('cart', JSON.stringify(data.cart));
                location.reload();
            } else {
                alert("수량 업데이트 실패");
            }
        })
        .catch((error) => console.error("Error:", error));
}

function removeFromCart(productId) {
    fetch("/controllers/CartController.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "remove",
            product_id: productId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // 세션 데이터로 로컬스토리지 동기화
                localStorage.setItem('cart', JSON.stringify(data.cart));
                location.reload();
            } else {
                alert("상품 삭제 실패");
            }
        })
        .catch((error) => console.error("Error:", error));
}

function clearCart() {
    fetch("/controllers/CartController.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "clear",
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // 세션 데이터로 로컬스토리지 동기화
                localStorage.setItem('cart', JSON.stringify(data.cart));
                location.reload();
            } else {
                alert("장바구니 비우기 실패");
            }
        })
        .catch((error) => console.error("Error:", error));
}

//views/home/header.php

function updateCart() {
    const cartData = JSON.parse(localStorage.getItem('cart')) || [];

    fetch('/views/user/cart/index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ cart: cartData })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Cart synced with server:', data.cart);
                localStorage.setItem('cart', JSON.stringify(data.cart));
            } else {
                console.error('Error syncing cart:', data.error);
            }
        });
}