<?php
// Author: Fatimah AlMumtan
// This page allows the user to choose whether to log in or sign up as a customer or admin.
// If the user is already logged in, they will be redirected to the appropriate page (shop for customers, dashboard for admins).

session_start(); // Start the session to manage user data

$currentPage = basename($_SERVER['PHP_SELF']); // Get the current page's filename

// Check if a user role is set in the session
if (isset($_SESSION['user_role'])) {
    // If the user is a customer, redirect them to the shop page if they are not already there
    if ($_SESSION['user_role'] === 'customer' && $currentPage !== 'shop.php') {
        header('Location: shop.php'); // Redirect to shop page for customers
        exit();
    }
    // If the user is an admin, redirect them to the admin dashboard if they are not already there
    elseif ($_SESSION['user_role'] === 'admin' && $currentPage !== 'admin_dashboard.php') {
        header('Location: admin_dashboard.php'); // Redirect to admin dashboard for admins
        exit();
    }
}

include 'header.php'; // Include the header layout for the page
?>

<main class="login-selection">
    <h1>Welcome to Glamour Shop</h1> <!-- Display the welcome message -->

    <div class="card-options">
        <!-- Card for customer login and signup options -->
        <div class="card">
            <h2>Customer</h2> <!-- Title for the customer section -->
            <a href="customer_login.php" class="btn">Login</a> <!-- Link to customer login page -->
            <a href="customer_signup.php" class="btn">Sign Up</a> <!-- Link to customer signup page -->
        </div>

        <!-- Card for admin login and signup options -->
        <div class="card">
            <h2>Admin</h2> <!-- Title for the admin section -->
            <a href="admin_login.php" class="btn">Login</a> <!-- Link to admin login page -->
            <a href="admin_signup.php" class="btn">Sign Up</a> <!-- Link to admin signup page -->
        </div>

    </div>
</main>

<?php include 'footer.php'; ?> <!-- Include the footer layout for the page -->