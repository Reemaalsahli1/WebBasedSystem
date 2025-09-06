<!-- Author: Fatimah AlMumtan
     This script updates the shopping cart by modifying product quantities, removing selected items, or proceeding to checkout with selected items. 
-->

<?php
session_start(); // Start the session to manage cart and user data

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Update product quantities in the cart when the user changes them
    if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $productId => $newQty) {
            $productId = intval($productId); // Ensure product ID is an integer
            $newQty = intval($newQty); // Ensure new quantity is an integer

            // If quantity is less than 1, remove the product from the cart
            if ($newQty < 1) {
                unset($_SESSION['cart'][$productId]);
            } elseif (isset($_SESSION['cart'][$productId])) {
                // Update the quantity of the product in the cart
                $_SESSION['cart'][$productId]['quantity'] = $newQty;
            }
        }
    }

    // Handle actions like removing selected items or proceeding to checkout
    if (isset($_POST['action'])) {
        // Get selected products from the form
        $selected = $_POST['selected_products'] ?? []; 

        // Action to remove selected products from the cart
        if ($_POST['action'] === 'remove_selected') {
            if (!empty($selected)) {
                foreach ($selected as $id) {
                    unset($_SESSION['cart'][$id]); // Remove each selected product from the cart
                }
                $_SESSION['success'] = "Selected products removed successfully."; // Success message
            } else {
                $_SESSION['error'] = "No products were selected for removal."; // Error message if no items are selected
            }

            header("Location: cart.php"); // Redirect back to cart page
            exit();
        }

        // Action to proceed to checkout with selected products
        if ($_POST['action'] === 'checkout_selected') {
            if (!empty($selected)) {
                $_SESSION['checkout_items'] = []; // Initialize checkout items array
                foreach ($selected as $id) {
                    if (isset($_SESSION['cart'][$id])) {
                        $_SESSION['checkout_items'][$id] = $_SESSION['cart'][$id]; // Add selected items to checkout session
                    }
                }
                header("Location: checkout.php?selected_only=1"); // Redirect to checkout page with selected items only
                exit();
            } else {
                $_SESSION['error'] = "Please select at least one product to checkout."; // Error message if no items are selected for checkout
                header("Location: cart.php"); // Redirect back to cart page
                exit();
            }
        }
    }
}

header("Location: cart.php"); // Default redirect if no POST action is triggered
exit();