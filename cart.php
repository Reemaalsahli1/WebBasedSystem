<!-- 
Author: Joury Alamri
This page is for showing the user's cart.
The user can change quantities, remove items, empty the cart, or go to checkout.
-->

<?php
session_start();
include 'config.php'; // connect to database
include 'header.php'; // show header part of the website

// if user clicked "Empty Cart", this removes everything from session
if (isset($_POST['action']) && $_POST['action'] === 'empty_cart') {
    unset($_SESSION['cart']);
    header("Location: cart.php"); // refresh the page
    exit();
}

// if cart doesn't exist in session, create an empty one
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// this is just a flag, we can use it later if we want to show "added successfully"
$showSuccess = false;

// if there’s more than one product, we show the checkboxes
$showCheckbox = count($_SESSION['cart']) > 1;
?>

<main class="shop-container">
    <?php if ($showSuccess): ?>
        <!-- just in case we want to show this success message -->
        <div class="success-message" id="success-msg">
            Product added to cart successfully!
        </div>
    <?php endif; ?>

    <h2 class="shop-title">Your Shopping Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-actions-wrapper" style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
            
            <!-- form for updating cart, removing selected items, or checkout -->
            <form method="post" action="update_cart.php" class="cart-form" id="cart-form" style="width: 100%;">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <?php if ($showCheckbox): ?><th>Select</th><?php endif; ?>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $grandTotal = 0; // total price of everything
                    foreach ($_SESSION['cart'] as $id => $item):
                        $total = $item['price'] * $item['quantity'];
                        $grandTotal += $total;
                    ?>
                        <tr>
                            <?php if ($showCheckbox): ?>
                                <!-- checkbox for selecting items -->
                                <td><input type="checkbox" name="selected_products[]" value="<?php echo $id; ?>"></td>
                            <?php endif; ?>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><img src="images/<?php echo htmlspecialchars($item['picture']); ?>" alt="Product Image" class="cart-img"></td>
                            <td>
                                <!-- user can change quantity here -->
                                <input type='number'
                                    name='quantity[<?php echo $id; ?>]'
                                    value='<?php echo $item['quantity']; ?>'
                                    min='1'
                                    class='auto-submit'>
                            </td>
                            <td><?php echo $item['price']; ?> SAR</td>
                            <td><?php echo $total; ?> SAR</td>
                            <td>
                                <!-- remove one item -->
                                <a href='remove_from_cart.php?id=<?php echo $id; ?>' 
                                    class="trash-icon" 
                                    title="Remove"
                                    onclick="return confirm('Are you sure you want to remove this item?');">
                                    🗑️
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <!-- show grand total price -->
                        <tr class="grand-total-row">
                            <td colspan="<?php echo $showCheckbox ? '5' : '4'; ?>" style="text-align:right;"><strong>Total:</strong></td>
                            <td colspan="2"><strong><?php echo $grandTotal; ?> SAR</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- buttons for checkout or remove selected items -->
                <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
                    <?php if ($showCheckbox): ?>
                        <button type="submit" name="action" value="checkout_selected" class="view-button">Checkout Selected</button>
                        <button type="submit" name="action" value="remove_selected" class="view-button" onclick="return confirm('Are you sure you want to remove selected items?');">Remove Selected</button>
                    <?php else: ?>
                        <a href="checkout.php" class="view-button" style="width: 180px; text-align: center;">Proceed to Checkout</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- second form just for emptying the cart -->
            <form method="post" action="cart.php" onsubmit="return confirm('Are you sure you want to empty your cart?');">
                <input type="hidden" name="action" value="empty_cart">
                <button type="submit" class="view-button" style="width: 180px;">Empty Cart</button>
            </form>
        </div>

    <?php else: ?>
        <!-- message if the cart is empty -->
        <p class="empty-message">Your cart is empty.</p>
    <?php endif; ?>
</main>

<!-- when quantity changes, the form auto submits -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.auto-submit').forEach(input => {
        input.addEventListener('change', () => {
            document.getElementById('cart-form').submit();
        });
    });
});
</script>

<?php include 'footer.php'; ?>
