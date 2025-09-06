<?php
// Author: Hoton AlQahtani - ID: 2220004707
// File: place_order.php
// Description: Places an order, updates product stock, and stores each new order as a separate entry in a user-specific cookie.

session_start(); // Start the session to access cart and user data
include 'config.php'; // Include the database configuration

// Redirect to cart page if no payment method or empty cart
if (!isset($_POST['payment_method']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$payment_method = $_POST['payment_method']; // Retrieve selected payment method
$cart = $_SESSION['cart']; // Get cart items from session
$user_id = $_SESSION['user_id']; // Get the current user's ID

// Insert a new order into the orders table with current date and user ID
$stmt = $conn->prepare("INSERT INTO orders (user_id, order_date) VALUES (?, NOW())");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$order_id = $stmt->insert_id; // Get the ID of the newly created order

// Insert each cart item into the order_items table and update product stock
foreach ($cart as $item) {
    // Insert product into the order_items table
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt_item->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
    $stmt_item->execute();

    // Reduce stock in the products table
    $update = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $update->bind_param("ii", $item['quantity'], $item['id']);
    $update->execute();
}

// Prepare to store past purchases in a cookie, unique per user
$cookie_name = 'past_purchases_' . $user_id;
$past_orders = [];

// If the user has existing purchase history in a cookie, decode it
if (isset($_COOKIE[$cookie_name])) {
    $past_orders = json_decode($_COOKIE[$cookie_name], true);
}

// Create a new order record to store in cookie
$new_order = [
    'date' => date('Y-m-d H:i:s'), // Save the order timestamp
    'items' => [] // Placeholder for purchased items
];

// Loop through cart and copy product details to the new order
foreach ($_SESSION['cart'] as $item) {
    $new_order['items'][] = [
        'name' => $item['name'],
        'picture' => $item['picture'],
        'price' => $item['price'],
        'quantity' => $item['quantity']
    ];
}

// Add the new order to the beginning of the past_orders array
array_unshift($past_orders, $new_order);

// Store the updated purchase history in a cookie for 30 days
setcookie($cookie_name, json_encode($past_orders), time() + (86400 * 30), "/");

// Clear the cart session since the order has been placed
unset($_SESSION['cart']);

// Redirect to success page with the order ID
header("Location: order_success.php?order_id=" . $order_id);
exit();
?>
