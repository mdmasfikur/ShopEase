$(document).ready(function () {
    // Global Cart Management
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    const updateCartBadge = () => {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        $("#cartBadge")
            .text(totalItems)
            .toggle(totalItems > 0);
    };

    const saveCart = () => {
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartBadge();
    };

    const sendCartData = () => {
        // Check if the CSRF token is available
        if (!csrfToken) {
            console.error("CSRF token not found.");
            return;
        }

        $.ajax({
            url: "/api/cart", // Cart API route
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken, // Send CSRF token in header
            },
            contentType: "application/json", // Indicate that we're sending JSON
            data: JSON.stringify({
                cart: cart || [],
            }),
            success: function (response) {
                console.log("Response:", response.cart);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                console.error("Status:", status);
                console.log("Response:", xhr.responseText);
            },
        });
    };

    const renderCartItems = () => {
        const cartItems = $("#cartItems");
        cartItems.empty();
        if (cart.length <= 0) {
            $("#cartbody").html(`
            <div class="alert alert-warning fade show m-0" role="alert">
                Cart is empty
            </div>
        `);
            return;
        }

        let subTotal = 0;
        cart.forEach((item) => {
            subTotal += item.price * item.quantity;
            cartItems.append(`
                <tr>
                    <td><img src="${item.image}" width="50" alt="${item.name}"></td>
                    <td>${item.name}</td>
                    <td>$${item.price}</td>
                    <td>${item.quantity}</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="${item.id}">Remove</button>
                    </td>
                </tr>
            `);
        });
        $('#cartTotal').html('$'+subTotal);
    };

    updateCartBadge();

    // Add to Cart
    $(".add-to-cart").on("click", function () {
        const product = {
            id: $(this).data("id"),
            name: $(this).data("name"),
            price: $(this).data("price"),
            image: $(this).data("image"),
            quantity: 1,
        };

        const existingProduct = cart.find((item) => item.id === product.id);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push(product);
        }
        saveCart();
        infoFlashMessage(`${product.name} added to cart!`);
    });

    // Handle Cart Modal Show Event
    $("#cartModal").on("show.bs.modal", function () {
        renderCartItems();
    });

    // Handle Remove from Cart
    $(document).on("click", ".remove-from-cart", function () {
        const id = $(this).data("id");
        const product = cart.find((item) => item.id === id);

        if (product) {
            console.log(product);
            if (product.quantity > 1) {
                product.quantity -= 1; // Decrement quantity by 1
            } else {
                const index = cart.indexOf(product);
                if (index !== -1) {
                    cart.splice(index, 1); // Remove the item from the cart
                }
            }
            saveCart();
            renderCartItems();
        }
    });

    // Checkout Button
    $("#checkoutButton").on("click", function () {
        // Under Development
        sendCartData();
    });
});
