<?php
session_start();

// Check if the cart session variable is set, if not, initialize it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve product information from the form submission
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    // Create an array to represent the product being added to cart
    $product = [
        'product_code' => $product_code,
        'product_name' => $product_name,
        'price' => $price,
        'quantity' => 1 // You can start with quantity 1 or add quantity input in the form
    ];

    // Add the product to the cart session variable
    $_SESSION['cart'][] = $product;

    // Redirect back to the products page or wherever you want after adding to cart
    header("Location: users_dashboard.php");
    exit;
}
?>
