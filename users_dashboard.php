    <?php
    session_start();

    // Check if the employee is not authenticated, redirect to login
    if (!isset($_SESSION['email_username'])) {
        header("Location: users_login_form.php");
        exit;
    }

    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page after logout
        header("Location: users_login_form.php");
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>users Dashboard</title>
        <style>
    body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
            }

            /* Header styles */
            header {
                background-color: #333;
                color: #fff;
                padding: 20px;
                text-align: center;
            }

            /* Main content area */
            .container {
                display: flex;
                flex-direction: column; /* Stack elements vertically */
                align-items: center; /* Center horizontally */
            }
            .user-dashboard {
                width: 100%; /* Take full width */
                background-color: #333;
                color: white;
                padding: 20px;
                text-align: center;
            }
            .content {
                display: flex;
                width: 100%;
                justify-content: space-between;
                margin-top: 20px; /* Adjust top margin as needed */
            }
            .products-section {
                width: 70%; /* Adjust the width of the products section */
            }
            .cart-section {
                width: 25%; /* Adjust the width of the cart section */
                background-color: #f9f9f9;
                padding: 10px;
                border-radius: 5px;
            }

            /* Adjust the position of the cart section */
            @media (max-width: 768px) {
                /* Adjust for smaller screens if needed */
                .content {
                    flex-direction: column;
                    align-items: center;
                }

                .products-section,
                .cart-section {
                    width: 50%; /* Take full width on smaller screens */
                    margin-bottom: 10px; /* Add space between sections */
                }
            }
            .products-section {
    width: 70%;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Adjust item width as needed */
    grid-gap: 5px; /* Adjust spacing between items */
    margin: 0 auto; /* Center items */
}

.products-section div {
    background-color: #fff;
    width: 50%;
    padding: 5px;
    border-radius: 5%;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    text-align: center;
}


            /* Logout button */
            .logout-btn {
                background-color: #d9534f;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
            }

            .logout-btn:hover {
                background-color: #c9302c;
            }  
            .order-btn {
                padding: 5px 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            </style>
    </head>
    <body>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Users Dashboard</title>
        <style>
            /* Your CSS styles remain unchanged */
            /* ... */
        </style>
    </head>
    <body>

        <div class="container">
            <fieldset>
                <h1>Users Dashboard</h1>
            </fieldset>
            <div>
            <h2>Menu Category</h2>
        </div>
            <!-- Display Menu Items as Buttons -->
            <!-- Display Products with Add-to-Cart Buttons -->
    <div class="products-section">
        <?php
        // Fetch and display products from the database
        include('connection_db.php');

        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo '<div>';
            echo '<h3>' . $row['product_name'] . '</h3>';
            echo '<p>Price: $' . $row['price'] . '</p>';
            
            // Form to add item to cart
            echo '<form method="post" action="add_to_cart.php">';
            echo '<input type="hidden" name="product_code" value="' . $row['product_code'] . '">';
            echo '<input type="hidden" name="product_name" value="' . $row['product_name'] . '">';
            echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
            echo '<button type="submit" class="order-btn">Add to Cart</button>';
            echo '</form>';
            
            echo '</div>';
        }
        ?>
    </div>

            </div>
            <div class="container">
        <div class="products-section">
            <!-- Display Products Code -->
            <!-- ... -->
        </div>
        <!-- Display Cart Items -->
        <div class="cart-section">
    <h2>Cart Items</h2>
    <ul>
        <?php
$total = 0;

// ... (rest of your HTML and PHP code)

echo '<ul>';
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $index => $cartItem) {
        echo '<li>' . $cartItem['product_name'] . ' - $' . $cartItem['price'] . ' 
        <form method="post" action="remove_from_cart.php">
            <input type="hidden" name="index" value="' . $index . '">
            <button type="submit">Remove</button>
        </form></li>';

        // Increment total for each item
        $total += $cartItem['price'];
    }
    echo '<li><strong>Total: $' . number_format($total, 2) . '</strong></li>';
} else {
    echo '<li>Your cart is empty</li>';
}
echo '</ul>';

        ?>
        <form method="post" action="checkout.php">
    <button type="submit" class="order-btn">Checkout</button>
</form>
    </ul>
</div>





            <!-- Logout Button with smaller size and spacing -->
            <div class="logout-btn-container">
                <form method="post" action="login.php">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

    </body>
    </html>
