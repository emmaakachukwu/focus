if (findGetParameter('ccart') == 'true') {
    clear_cart();
}

let cart = get_cart();

function add_to_cart(id, name, price, image, quantity = 1) {
    check = check_product(id)
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
    write_to_cookie(JSON.stringify(cart))

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

function clear_cart() {
    localStorage.clear()
    deleteAllCookies()
    erase_cookie()
}

function modify_cart(cart) {
    let css = `li#hot::before {content: '${cart.length}'}`
    let style = document.createElement('style')

    if (style.styleSheet) {
        ons
    } else {
        style.appendChild(document.createTextNode(css))
    }
    document.getElementsByTagName('head')[0].appendChild(style)
}

function check_products_in_cart(products) {
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

function write_to_cookie(cart) {
    document.cookie = `cart=${cart}`
}

function read_cookie() {
    var nameEQ = "cart=";
    let ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return JSON.parse(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function erase_cookie() {
    document.cookie = 'cookie=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

function removeAll() {
    clear_cart()
    location.reload()
}