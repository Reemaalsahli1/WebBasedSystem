<!-- 
Author: Joury Alamri
This file is used to add a product to the cart when user clicks "Add to Cart"
It checks product stock and updates session cart.
-->

<?php 
session_start();
include 'config.php'; // connect to database

// if there's no cart in the session, create an empty one
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// check if the request is POST and has product_id and quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = intval($_POST['product_id']); // make sure it's an integer
    $quantity = max(1, intval($_POST['quantity'])); // at least 1 item

    // get product from database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // check if product exists
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // check if there is enough stock
        if ($quantity <= $product['stock']) {

            // if product already in cart, increase quantity
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                // if not, add it as new item
                $_SESSION['cart'][$product_id] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'picture' => $product['picture'],
                    'quantity' => $quantity
                ];
            }

            // success message
            $_SESSION['success'] = "Product added to cart successfully!";
        } else {
            // if quantity is more than available stock
            $_SESSION['error'] = "Sorry, not enough stock.";
        }
    } else {
        // if product doesn't exist in database
        $_SESSION['error'] = "Product not found.";
    }
}

// after all, redirect to popup or cart page
header("Location: added_popup.php");
exit();