let cart = get_cart();

function add_to_cart(product) {
    cart.push(product);
    localStorage.setItem('cart', cart)
}

function get_cart() {
    return JSON.parse(localStorage.getItem('cart')) ? ? [];
}