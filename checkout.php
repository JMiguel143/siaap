<?php
session_start();

// Check if the cart is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Establish a connection to your database (Replace placeholders with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sia1";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL to insert checkout items into a database table (Replace 'your_table_name' with your actual table name)
    $total = 0;
    foreach ($_SESSION['cart'] as $cartItem) {
        $productName = $cartItem['product_name'];
        $price = $cartItem['price'];
        $total += $price;

        $sql = "INSERT INTO checkout_products (product_name, price) VALUES ('$productName', '$price')";

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Display checkout summary
    echo '<h2>Checkout Summary</h2>';
    echo '<ul>';
    foreach ($_SESSION['cart'] as $cartItem) {
        echo '<li>' . $cartItem['product_name'] . ' - $' . $cartItem['price'] . '</li>';
    }
    echo '<li><strong>Total: $' . number_format($total, 2) . '</strong></li>';
    echo '</ul>';

    // Clear the cart after processing
    $_SESSION['cart'] = array();

    // Close the database connection
    $conn->close();

    echo '<p>Thank you for your order!</p>';
} else {
    echo '<p>Your cart is empty. Please add items before checking out.</p>';
}
?>
