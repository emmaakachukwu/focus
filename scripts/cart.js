let cart = get_cart();

function add_to_cart(id, name, price, image, quantity = 1) {
    let product = {
        id,
        name,
        price,
        image,
        quantity
    }
    cart.push(product)
    localStorage.setItem('cart', JSON.stringify(cart))

    modify_cart(cart)
}

function get_cart() {
    let cart = !localStorage.getItem('cart') ? [] : JSON.parse(localStorage.getItem('cart'))
    modify_cart(cart)

    return cart
}

function modify_cart(cart) {
    let css = `li#hot::before {content: '${cart.length}'}`
    let style = document.createElement('style')

    if (style.styleSheet) {
        style.styleSheet.cssText = css
    } else {
        style.appendChild(document.createTextNode(css))
    }
    document.getElementsByTagName('head')[0].appendChild(style)
}

function check_products_in_cart(products) {
    let in_cart = false
    products.forEach(e => {
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].id == e.id) {
                let add = document.querySelector('#add-' + e.id)
                add.innerText = 'Remove from cart'
                break
            }
        }
    })
}