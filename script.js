const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if(bar){
    bar.addEventListener('click',() => {
        nav.classList.add('active');
    } )
}
if(close){
    close.addEventListener('click',() => {
        nav.classList.remove('active');
    } )
}

// code to fetch and display product data(single product page)
document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product');
    
    fetch('products.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (productId && data[productId]) {
                loadProductDetails(data[productId]);
            } else {
                console.error("Product not found or invalid product ID");
            }
        })
        .catch(error => console.error('Error loading product data:', error));
});

function loadProductDetails(product) {
    // update product details based on product object
    document.getElementById("product-category").innerText = product.category;
    document.getElementById("product-name").innerText = product.name;
    document.getElementById("product-price").innerText = product.price;
    document.getElementById("product-description").innerText = product.description;

    // set main image
    const mainImg = document.getElementById("MainImg");
    mainImg.src = product.images[0];

    // clear and populate small image group
    const smallImgGroup = document.getElementById("small-img-group");
    if (smallImgGroup) {
        smallImgGroup.innerHTML = ''; // Clear existing content
        product.images.forEach((imgSrc, index) => {
            const imgDiv = document.createElement("div");
            imgDiv.classList.add("small-img-col");
            imgDiv.innerHTML = `<img src="${imgSrc}" width="100%" class="small-img" alt="">`;
            imgDiv.addEventListener('click', function() {
                mainImg.src = imgSrc; // Change main image on small image click
            });
            smallImgGroup.appendChild(imgDiv);
        });
    } else {
        console.error("Element with ID 'small-img-group' not found");
    }
}