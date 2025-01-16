const productPhoto = document.querySelectorAll('.product-photo');
productPhoto.forEach(element => {
    element.addEventListener('click', (e) => {
        getProductDetail(element.dataset.productId);
    });
});

async function getProductDetail(productId) {
    const url = './api/product/show';
    const data = { productId: productId };
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    const response = await fetch(url, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify(data)
    });

    // Nhan kq & giao dien

    const result = await response.json();
    var amount =     result.price;
    var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    const divComments = document.querySelector('.products');
    divComments.innerHTML = '';

        divComments.innerHTML += `
        <div class="item-product">
                            <a href="${result.slug}.html">
                                <div class="product-img">
                                    <img src="${result.image}" alt="" />
                                </div>
                            </a>
                            <div class="item-product-body">
                                <h3><a href="${result.slug}.html">${result.name}</a></h3>
                                <div class="price-cart">
                              
                                   <span> ${formattedNumber} </span>
                                        
                                        
                                    <img src="img/cart.png" alt="" />
                                </div>
                            </div>
                        </div>
        `;
  
}







const btnLoadmore = document.querySelector('.btn-loadmore');
let url = "api/product/loadmore?page=2";

if (btnLoadmore) {
    btnLoadmore.addEventListener('click', function() {
        loadMore();
    });
}

async function loadMore() {
    const response = await fetch(url);
    const result = await response.json();
    url = result.next_page_url;

    // Hien thi giao dien
    const productList = document.querySelector('.products');
    result.data.forEach(element => {
        var amount =     element.price;
        var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);

        productList.innerHTML += `
        <div class="item-product">
                            <a href="${element.slug}.html">
                                <div class="product-img">
                                    <img src="${element.image}" alt="" />
                                </div>
                            </a>
                            <div class="item-product-body">
                                <h3><a href="${element.slug}.html">${element.name}</a></h3>
                                <div class="price-cart">
                              
                                   <span>  ${formattedNumber}</span>
                                        
                                        
                                    <img src="img/cart.png" alt="" />
                                </div>
                            </div>
                        </div>
        `;

    });
    if (url == null) {
        btnLoadmore.remove();
    }
}

