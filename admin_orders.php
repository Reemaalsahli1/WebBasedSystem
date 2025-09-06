<?php
// Author: Reema Alsahli
// Description: This code retrieves and displays all user orders from the database, including order details and associated products.
session_start();
include 'config.php';
include 'header.php';

$orders = $conn->query("
    SELECT o.order_id, o.user_id, o.order_date, u.username AS user_name
    FROM orders o
    JOIN user u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
");
?>

<main class="shop-container">
    <h2 class="shop-title">All User Orders</h2>

    <?php if ($orders->num_rows > 0): ?>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <div style="border:1px solid #e8cfd6; border-radius:10px; padding:20px; margin-bottom:30px;">
                <h3 style="color:#5c2b3d;">Order #<?php echo $order['order_id']; ?></h3>
                <p><strong>User:</strong> <?php echo htmlspecialchars($order['user_name']); ?> (ID: <?php echo $order['user_id']; ?>)</p>
                <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>

                <?php
                $orderId = $order['order_id'];
                $items = $conn->query("
                    SELECT oi.*, p.name AS product_name, p.stock
                    FROM order_items oi
                    JOIN products p ON oi.product_id = p.id
                    WHERE oi.order_id = $orderId
                ");
                ?>

                <table class="cart-table" style="margin-top:15px;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (Each)</th>
                            <th>Total</th>
                            <th>Current Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php while ($item = $items->fetch_assoc()):
                            $lineTotal = $item['price'] * $item['quantity'];
                            $total += $lineTotal;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $item['price']; ?> SAR</td>
                                <td><?php echo $lineTotal; ?> SAR</td>
                                <td><?php echo $item['stock']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr class="grand-total-row">
                            <td colspan="3" style="text-align:right;"><strong>Order Total:</strong></td>
                            <td colspan="2"><strong><?php echo $total; ?> SAR</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="empty-message">No orders found.</p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
