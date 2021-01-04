let cart = get_cart();

function add_to_cart(id, name, price, image, quantity = 1) {
    check = check_product(id)
    console.log(check)
    if (!check) {
        let product = {
            id,
            name,
            price,
            image,
            quantity
        }
        cart.push(product)
    } else {
        remove_from_cart(id)
    }
    localStorage.setItem('cart', JSON.stringify(cart))

    modify_cart(cart)
    switch_text(id, !check)
}

function remove_from_cart(id) {
    for (let i = 0; i < cart.length; i++) {
        if (cart[i].id == id) {
            cart.splice(i, 1)
            break
        }
    }
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
ons    } else {
        style.appendChild(document.createTextNode(css))
    }
    document.getElementsByTagName('head')[0].appendChild(style)
}

function check_products_in_cart(products) {
    let in_cart = false
    products.forEach(e => {
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].id == e.id) {
                switch_text(cart[i].id)
                break
            }
        }
    })
}

function check_product(id) {
    let in_cart = false
    for (let i = 0; i < cart.length; i++) {
        if (cart[i].id == id) {
            in_cart = true
            break
        }
    }
    return in_cart
}

function switch_text(id, in_cart = true) {
    let add = document.querySelector('#add-' + id)
    add.innerText = in_cart ? 'Remove from cart' : 'Add to cart'
}