<!-- 
Author: Joury Alamri
This file removes a specific product from the user's cart.
Used when the user clicks the 🗑️ icon next to an item.
-->

<?php
session_start();

// check if there’s an item id in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // convert it to integer for safety

    // if the item exists in the cart, remove it
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

// redirect back to the cart page
header("Location: cart.php");
exit();
