
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
    const divComments = document.querySelector('.products');
    divComments.innerHTML = '';
  

   
    result.forEach(element => {
        var amount =     element.price;
        if(amount > 0)
            {
        var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
            }
            else{
                var formattedNumber = 'Liên hệ';
            }
      

        divComments.innerHTML += `
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

    const btnLoadmore = document.querySelector('.btn-loadmore');
    btnLoadmore.innerHTML= "";
  
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
        if(amount > 0)
            {
        var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
            }
            else{
                var formattedNumber = 'Liên hệ';
            }

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




const categoryhome = document.querySelectorAll('.category-home');
categoryhome.forEach(element => {
    element.addEventListener('click', (e) => {
       
        getProductchitiet(element.dataset.productId);
    });
});

async function getProductchitiet(productId) {
    const loader = document.querySelector(".loader");
    loader.classList.remove('d-none');

    const url = './api/product/showcategoryhome';
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
    loader.classList.add('d-none');
   
    const divComments = document.querySelector('.products');
    divComments.innerHTML = '';
  
    result.forEach(element => {
      
      

        divComments.innerHTML += `
        <div class="col-md-3 col-item-prod">
							
        <div class="line2 pageshow1">
            <div class="innermall square">
                <a href="${element.slug}.html">
                    <div class="mall_word">
                        <h3>${element.name}</h3>
                    </div>
                    <div class="mall_pic big_picture">
                        <img src="${element.image}" alt="" />
                    </div>
                </a>
            </div>
        </div>
        
        
        </div>
        `;

    });
   
  

  
  
}

// 2
const categoryhome2 = document.querySelectorAll('.category-home2');
categoryhome2.forEach(element => {
    element.addEventListener('click', (e) => {
       
        getProductchitiet2(element.dataset.productId);
    });
});

async function getProductchitiet2(productId) {
    const loader = document.querySelector(".loader2");
    loader.classList.remove('d-none');
    const url = './api/product/showcategoryhome';
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
    loader.classList.add('d-none');
    const divComments = document.querySelector('.products2');
    divComments.innerHTML = '';
  
    result.forEach(element => {
      
      

        divComments.innerHTML += `
        <div class="col-md-3 col-item-prod">
							
        <div class="line2 pageshow1">
            <div class="innermall square">
                <a href="${element.slug}.html">
                    <div class="mall_word">
                        <h3>${element.name}</h3>
                    </div>
                    <div class="mall_pic big_picture">
                        <img src="${element.image}" alt="" />
                    </div>
                </a>
            </div>
        </div>
        
        
        </div>
        `;

    });
   
  

  
  
}

// 2
const categoryhome3 = document.querySelectorAll('.category-home3');
categoryhome3.forEach(element => {
    element.addEventListener('click', (e) => {
       
        getProductchitiet3(element.dataset.productId);
    });
});

async function getProductchitiet3(productId) {
    const loader = document.querySelector(".loader3");
    loader.classList.remove('d-none');
    const url = './api/product/showcategoryhome';
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
    loader.classList.add('d-none');
    const divComments = document.querySelector('.products3');
    divComments.innerHTML = '';
  
    result.forEach(element => {
       
      

        divComments.innerHTML += `
        <div class="col-md-3 col-item-prod">
							
        <div class="line2 pageshow1">
            <div class="innermall square">
                <a href="${element.slug}.html">
                    <div class="mall_word">
                        <h3>${element.name}</h3>
                    </div>
                    <div class="mall_pic big_picture">
                        <img src="${element.image}" alt="" />
                    </div>
                </a>
            </div>
        </div>
        
        
        </div>
        `;

    });
   
  

  
  
}

// 2
const categoryhome4 = document.querySelectorAll('.category-home4');
categoryhome4.forEach(element => {
    element.addEventListener('click', (e) => {
       
        getProductchitiet4(element.dataset.productId);
    });
});

async function getProductchitiet4(productId) {
    const loader = document.querySelector(".loader4");
    loader.classList.remove('d-none');
    const url = './api/product/showcategoryhome';
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
    loader.classList.add('d-none');
    const divComments = document.querySelector('.products4');
    divComments.innerHTML = '';
  
    result.forEach(element => {
       
      

        divComments.innerHTML += `
        <div class="col-md-3 col-item-prod">
							
        <div class="line2 pageshow1">
            <div class="innermall square">
                <a href="${element.slug}.html">
                    <div class="mall_word">
                        <h3>${element.name}</h3>
                    </div>
                    <div class="mall_pic big_picture">
                        <img src="${element.image}" alt="" />
                    </div>
                </a>
            </div>
        </div>
        
        
        </div>
        `;

    });
   
  

  
  
}

// 2
const categoryhome5 = document.querySelectorAll('.category-home5');
categoryhome5.forEach(element => {
    element.addEventListener('click', (e) => {
       
        getProductchitiet5(element.dataset.productId);
    });
});

async function getProductchitiet5(productId) {
    const loader = document.querySelector(".loader5");
    loader.classList.remove('d-none');
    const url = './api/product/showcategoryhome';
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
    loader.classList.add('d-none');
    const divComments = document.querySelector('.products5');
    divComments.innerHTML = '';
  
    result.forEach(element => {
      
      

        divComments.innerHTML += `
        <div class="col-md-3 col-item-prod">
							
        <div class="line2 pageshow1">
            <div class="innermall square">
                <a href="${element.slug}.html">
                    <div class="mall_word">
                        <h3>${element.name}</h3>
                    </div>
                    <div class="mall_pic big_picture">
                        <img src="${element.image}" alt="" />
                    </div>
                </a>
            </div>
        </div>
        
        
        </div>
        `;

    });
   
  

  
  
}










