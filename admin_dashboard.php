<?php

// Author: Raseel Alderaan
// This page is the Admin Dashboard. It lets the admin manage products, customers, and view orders.
// Only logged-in admins can access this page.

session_start();
include('header.php');

if (!isset($_SESSION['user']) || $_SESSION['user_role'] != 'admin') {
    header('Location: admin_login.php');
    exit();
}
?>

<main class="main-content">
    <div class="dashboard-wrapper">

        <div class="dashboard-heading spaced">
            <!-- Display a personalized greeting to the logged-in admin -->
            <h2>Welcome back, <?php echo ucfirst($_SESSION['user']); ?>!</h2>
        </div>

        <div class="dashboard-cards">
            <!-- Admin dashboard cards for managing the store -->

            <!-- Link to add a new product to the catalog -->
            <div class="dashboard-card">
                <a href="admin_add_product.php">Add New Product</a>
            </div>

            <!-- Link to remove an existing product -->
            <div class="dashboard-card">
                <a href="admin_delete_product.php">Delete Product</a>
            </div>

            <!-- Link to update/edit product information -->
            <div class="dashboard-card">
                <a href="admin_edit_product.php">Edit Product</a>
            </div>

            <!-- Link to manage or edit customer details -->
            <div class="dashboard-card">
                <a href="admin_edit_user.php">Edit Customer</a>
            </div>

            <!-- Link to view all customer orders -->
            <div class="dashboard-card">
                <a href="admin_orders.php">View Customer Orders</a>
            </div>

        </div>
    </div>
</main>

<!-- Include footer layout -->
<?php include('footer.php'); ?>