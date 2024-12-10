document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let timeout;

    // 검색 결과 표시
    function showSearchResults(products) {
        searchResults.style.display = 'block';
        searchResults.innerHTML = '';

        if (products.length > 0) {
            products.forEach(product => {
                const item = document.createElement('a');
                item.classList.add('list-group-item', 'list-group-item-action');
                item.href = `/views/product/detail.php?id=${product.id}`;
                item.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <img src="${product.product_image || '/default-thumbnail.jpg'}" 
                                         alt="${product.name}" 
                                         style="width: 50px; height: 50px; margin-right: 10px;">
                                    <span>${product.name}</span>
                                </div>`;
                searchResults.appendChild(item);
            });
        } else {
            searchResults.innerHTML = `<div class="list-group-item text-center">검색 결과가 없습니다.</div>`;
        }
    }

    // 검색 결과 숨김
    function hideSearchResults() {
        searchResults.style.display = 'none';
    }

    // 검색 요청
    function searchProducts(query) {
        if (query.length === 0) {
            hideSearchResults();
            return;
        }

        fetch(`/controllers/ProductController.php?action=search&query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) throw new Error('서버 응답 오류');
                return response.json();
            })
            .then(data => {
                showSearchResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
                searchResults.innerHTML = `<div class="list-group-item text-center text-danger">오류가 발생했습니다. 다시 시도해 주세요.</div>`;
                searchResults.style.display = 'block';
            });
    }

    // 입력 이벤트 처리
    searchInput.addEventListener('input', () => {
        clearTimeout(timeout);
        const query = searchInput.value.trim();

        timeout = setTimeout(() => {
            searchProducts(query);
        }, 300);
    });

    // 검색 영역 외부 클릭 시 검색 결과 숨김
    document.addEventListener('click', (e) => {
        if (!document.querySelector('.search-container').contains(e.target)) {
            hideSearchResults();
        }
    });
});
