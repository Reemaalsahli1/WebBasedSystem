<?php
// Author: Reema Alsahli
// Description: This code displays a confirmation message with the order number after a successful order and provides a button to continue shopping.
include 'header.php';
$order_id = $_GET['order_id'] ?? 0;
?>

<main class="shop-container">
    <h2 class="shop-title">Thank you for your order!</h2>
    <p style="text-align:center; font-size:18px;">
        Your order number is <strong>#<?php echo htmlspecialchars($order_id); ?></strong><br>
        We will contact you soon to confirm the delivery.
    </p>
    <div style="text-align:center; margin-top:20px;">
        <a href="shop.php?category=All" class="view-button">Continue Shopping</a>
    </div>
</main>

<?php include 'footer.php'; ?>
