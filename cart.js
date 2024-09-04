function getCartCount(){
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    return cart.reduce((count, product) => count + product.quantity, 0);
}

function updateCartDisplay(){
    const cartCountEl = document.getElementById('cart-count');
    const cartCount = getCartCount();
    cartCountEl.textContent = cartCount;
    const cartState = document.getElementById('cart-state');
    const checkoutBtn = document.getElementById('checkout-button');
    const cart = document.getElementById('cart-table');
    const customerDetails = document.getElementById('customer-details');
    const finalizare = document.getElementById('finalizare');
    if(isCartEmpty()){
        cartState.style.display = 'block';
        checkoutBtn.style.display = 'none';
        cart.style.display = 'none';
        finalizare.style.display = 'none';
        customerDetails.style.display ='none';  
    } else {
        cartState.style.display = 'none';
        checkoutBtn.style.display = 'inline-block';
        cart.style.display = 'table';
        finalizare.style.display = 'block';
        customerDetails.style.display ='flex';
    }
}

document.addEventListener('DOMContentLoaded', updateCartDisplay);

function isCartEmpty(){
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    return cart.length === 0;
}

function adaugaProdus(){
    const size = document.getElementById('product-size').value;
    if(!size){
        alert('Te rugam sa selectezi o marime!');
        return;
    }

    const product = {
        name: document.getElementById('product-name').innerText,
        size: size,
        price: parseFloat(document.getElementById('product-price').innerText),
        quantity:parseInt(document.getElementById('product-quantity').value)
    };

    //verifica daca exista produse in cos, iar daca nu adauga produsul in lista
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let text = "Cosul dumneavoastra de cumparaturi este gol!"
    let existingProduct = cart.find(p=>p.name===product.name && p.size ===product.size);
    if(existingProduct){
        existingProduct.quantity++;
    } else {
        cart.push(product);
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    let cartCount = getCartCount();
    cartCount++;
    localStorage.setItem('cart-count',cartCount); //salvare in localStorage
    updateCartDisplay();
}

function loadCartItems(){
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cart-items');
    cartItemsContainer.innerHTML = '';
    let total = 0;

    cart.forEach(product => {
        const subtotal = product.price * product.quantity;
        total  = total + subtotal;
        localStorage.setItem('total', total);

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.name} (Marime: ${product.size})</td>
            <td>${product.quantity}</td>
            <td>${product.price.toFixed(2)} RON </td>
            <td>${subtotal.toFixed(2)} RON </td>
            <td><button onclick="stergeProdus('${product.name}', '${product.size}')">Sterge</button></td>
        `
        cartItemsContainer.append(row);
    })

    document.getElementById('cart-total').innerText = total.toFixed(2);
}

function stergeProdus(name,size){
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(product => !(product.name===name && product.size===size));
    localStorage.setItem('cart', JSON.stringify(cart));
    loadCartItems();
    updateCartDisplay();
    localStorage.clear();
    cart = [];
}
document.addEventListener('DOMContentLoaded', function() {
    updateCartDisplay();
    loadCartItems();
});

let orderForm = document.getElementById("order-form");
orderForm.addEventListener("submit", (e) => {
    e.preventDefault();

    let nume = document.getElementById('nume').value;
    let prenume = document.getElementById('prenume').value;
    let adresa = document.getElementById('adresa').value;
    let judet = document.getElementById('judet').value;
    let localitate = document.getElementById('localitate').value;


    localStorage.setItem('nume', nume);
    localStorage.setItem('prenume', prenume);
    localStorage.setItem('adresa', adresa);
    localStorage.setItem('judet', judet);
    localStorage.setItem('localitate', localitate);

    window.location.href = "order.html";
});
