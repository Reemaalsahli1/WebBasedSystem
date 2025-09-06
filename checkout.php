<?php
// Student: Hoton Alqahtani - ID: 2220004707
// Description: Checkout page that displays selected cart items, calculates totals, and allows user to choose a payment method.

session_start(); // Start the session to access cart and checkout data
include 'header.php'; // Include header layout

$items = [];

// Check if user selected specific items to checkout, otherwise use full cart
if (isset($_GET['selected_only']) && $_GET['selected_only'] == 1 && isset($_SESSION['checkout_items'])) {
    $items = $_SESSION['checkout_items']; // Load selected items
} elseif (isset($_SESSION['cart'])) {
    $items = $_SESSION['cart']; // Load full cart
}
?>

<main class="shop-container" aria-labelledby="checkout-title">
    <h2 class="shop-title" id="checkout-title" tabindex="0">Checkout Summary</h2>

    <?php if (!empty($items)): ?>
        <!-- Checkout form to submit selected items and payment method -->
        <form method="post" action="place_order.php" aria-label="Order summary and payment form">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Image</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grandTotal = 0; ?>
                    <?php foreach ($items as $item):
                        // Calculate total price for each item
                        $total = $item['price'] * $item['quantity'];
                        $grandTotal += $total; // Accumulate to grand total
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>
                            <img src="images/<?php echo htmlspecialchars($item['picture']); ?>" 
                                 class="cart-img" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>">
                        </td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['price']; ?> SAR</td>
                        <td><?php echo $total; ?> SAR</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="grand-total-row">
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td><strong><?php echo $grandTotal; ?> SAR</strong></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Payment method selection -->
            <div class="payment-container">
                <label class="payment-label"><strong>Choose Payment Method:</strong></label>
                <div class="payment-options">
                    <!-- Option: Cash on Delivery -->
                    <label class="payment-option" for="payment-cash">
                        <input type="radio" name="payment_method" id="payment-cash" value="Cash on Delivery" required>
                        <img src="images/cash.png" alt="Cash icon">
                        <div>Cash</div>
                    </label>
                    <!-- Option: Credit Card -->
                    <label class="payment-option" for="payment-card">
                        <input type="radio" name="payment_method" id="payment-card" value="Credit Card" required>
                        <img src="images/creditcard.jpeg" alt="Credit Card icon">
                        <div>Card</div>
                    </label>
                    <!-- Option: Apple Pay -->
                    <label class="payment-option" for="payment-apple">
                        <input type="radio" name="payment_method" id="payment-apple" value="Apple Pay" required>
                        <img src="images/applepay.png" alt="Apple Pay icon">
                        <div>Apple Pay</div>
                    </label>
                </div>
            </div>

            <!-- Buttons to place order or return to cart -->
            <div class="cart-buttons">
                <button type="submit" class="view-button">Place Order</button>
                <a href="cart.php" class="view-button">Back to Cart</a>
            </div>
        </form>
    <?php else: ?>
        <!-- Message shown if no items are in the checkout list -->
        <p class="empty-message">No items to checkout.</p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; // Include footer layout ?>
