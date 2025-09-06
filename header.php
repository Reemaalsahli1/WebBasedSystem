<?php
// Author: Fatimah AlMumtan
// This section starts the session and checks the user role.
// If the user is already logged in, it redirects them to the appropriate page based on their role.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name

// Check if a user role is set in the session
if (isset($_SESSION['user_role'])) {
    // Redirect customers to the shop page if they're on the index page
    if ($_SESSION['user_role'] === 'customer' && $current_page === 'index.php') {
        header('Location: shop.php'); // Redirect to shop page for customers
        exit();
    }
    // Redirect admins to the admin dashboard if they're on the index page
    elseif ($_SESSION['user_role'] === 'admin' && $current_page === 'index.php') {
        header('Location: admin_dashboard.php'); // Redirect to admin dashboard for admins
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadata for the page and external stylesheet links -->
    <meta charset="UTF-8">
    <title>Glamour Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <!-- Display the shop logo -->
    <div class="logo">Glamour Shop</div>

    <nav class="nav-links">
    <!-- If the user is logged in, display the appropriate navigation menu based on their role -->
    <?php if (isset($_SESSION['user'])): ?>
        <!-- If the user is an admin, show the admin-specific menu -->
        <?php if ($_SESSION['user_role'] == 'admin'): ?>
            <a href="admin_dashboard.php">Home</a>
            <a href="my_account_admin.php">My Account</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php elseif ($_SESSION['user_role'] == 'customer'): ?>
            <!-- If the user is a customer, show the customer-specific menu -->
            <a href="shop.php">Home</a>
            <a href="cart.php">Cart</a>
            <a href="contact_us.php">Contact Us</a>
            <a href="customer_account.php">My Account</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php endif; ?>
    <?php endif; ?>
    </nav>
</header>

<main class="main-content">