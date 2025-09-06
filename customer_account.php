<?php
// Author: Sarah Alotaibi - ID: 2220004812
// File: customer_account.php
// Purpose: Displays customer account information and their past orders using cookies.

session_start(); // Start the session to access user data
include 'config.php'; // Include database configuration
include 'header.php'; // Include site header

// Check if the user is logged in, otherwise redirect to login
if (!isset($_SESSION['user_id'])) {
    echo "<p class='error'>You must be logged in to view this page.</p>";
    include 'footer.php';
    exit;
}

// Retrieve the logged-in user's info from the database
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc(); // Fetch user data as an associative array
?>

<main class="shop-container">
    <!-- Account section title -->
    <h2 class="shop-title">My Account</h2>

    <!-- Display user account details -->
    <div class="account-info-box">
        <h3>Account Information</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <!-- Past purchases section title -->
    <h3 class="shop-title">Your Past Purchases</h3>

    <?php 
    // Define cookie name using user ID to make it unique per user
    $cookie_name = "past_purchases_" . $_SESSION['user_id'];

    // Check if the past purchases cookie exists
    if (isset($_COOKIE[$cookie_name])) {
        $past_orders = json_decode($_COOKIE[$cookie_name], true); // Decode JSON cookie into array

        // Loop through each past order stored in the cookie
        foreach ($past_orders as $order):
            $grand_total = 0;
            $order_date = $order['date']; // Retrieve order date
    ?>
        <!-- Display each order box -->
        <div class="order-box">
            <div class="order-header">
                <!-- Display order date -->
                <span class="order-date"><?php echo $order_date; ?></span>
            </div>

            <!-- Table to display items in this order -->
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Loop through each item in the order
                    foreach ($order['items'] as $item): 
                        $total = $item['price'] * $item['quantity']; // Calculate total for item
                        $grand_total += $total; // Add to grand total
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><img src="images/<?php echo htmlspecialchars($item['picture']); ?>" width="40" style="border-radius:5px;"></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['price']; ?> SAR</td>
                        <td><?php echo $total; ?> SAR</td>
                    </tr>
                    <?php endforeach; ?>
                    <!-- Show total row for this order -->
                    <tr class="grand-total-row">
                        <td colspan="4" style="text-align:right;"><strong>Total:</strong></td>
                        <td><strong><?php echo $grand_total; ?> SAR</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php 
        endforeach;
    } else {
        // If no cookie is found, show this message
        echo "<p class='empty-message'>No past purchases found.</p>";
    }
    ?>
</main>

<?php include 'footer.php'; // Include footer of the site ?>
