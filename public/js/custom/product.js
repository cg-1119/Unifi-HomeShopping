// 대표 이미지 변경 함수
function changeImage(newImageUrl) {
    const mainImage = document.getElementById('main-image');
    mainImage.src = newImageUrl;
}
// 로그인 경고 및 페이지 이동 함수
function promptLogin() {
    const confirmLogin = confirm("로그인 후 사용 가능합니다. 로그인 하시겠습니까?");
    if (confirmLogin) {
        window.location.href = '/views/user/login.php';
    }
}

// 찜하기 AJAX 요청
function addToWishlist(productId) {
    fetch('/controllers/WishlistController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'add',
            product_id: productId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('찜 목록에 추가되었습니다.');
                location.reload();
            } else {
                alert(data.message || '오류가 발생했습니다.');
            }
        })
        .catch(error => console.error('Error:', error));
}

// 찜 취소 AJAX 요청
function removeFromWishlist(productId) {
    fetch('/controllers/WishlistController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'remove',
            product_id: productId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('찜 목록에서 제거되었습니다.');
                location.reload();
            } else {
                alert(data.message || '오류가 발생했습니다.');
            }
        })
        .catch(error => console.error('Error:', error));
}