<?php
// Author: Raghad Al-Duwais
// File: product_details.php
// Description: Displays product details and allows the user to add the product to the cart.

session_start(); // Start session
include 'config.php'; // Include database configuration
include 'header.php'; // Include header content

// Check if product ID is provided
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Convert to integer for security

    // Query the product from the database
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result); // Fetch product data
        $outOfStock = $product['stock'] <= 0; // Check stock availability
    } else {
        echo "<p class='error'>Product not found.</p>";
        include 'footer.php';
        exit();
    }
} else {
    echo "<p class='error'>No product selected.</p>";
    include 'footer.php';
    exit();
}
?>

<main class="shop-container">
    <div class="product-details-container">
        
        <!-- Product image -->
        <div class="product-image">
            <img src="images/<?php echo htmlspecialchars($product['picture']); ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?> product image">
        </div>

        <!-- Product information -->
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="price"><?php echo htmlspecialchars($product['price']); ?> SR</p>

            <!-- Product description -->
            <div class="description-container">
                <p class="description">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </p>
            </div>

            <!-- Availability check -->
            <?php if ($outOfStock): ?>
                <p class="stock" style="color: red; font-weight: bold;">Out of Stock</p>
                <button class="view-button" disabled>Not Available</button>
            <?php else: ?>
                <p class="stock">
                    ✔️ In Stock
                    <span class="tooltip-icon" tabindex="0" style="position: relative; cursor: pointer;">
                        ❔
                        <span class="tooltip-text" style="visibility: hidden; background-color: #eee; color: #333; padding: 5px 8px; 
                            border-radius: 5px; position: absolute; bottom: 125%; left: 50%; transform: translateX(-50%);
                            white-space: nowrap; box-shadow: 0px 2px 6px rgba(0,0,0,0.2); font-size: 12px;">
                            Stock: <?php echo $product['stock']; ?> items
                        </span>
                    </span>
                </p>

                <!-- Add to Cart Form -->
                <form action="add_to_cart.php" method="post" class="product-form">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <label for="quantity">Quantity:</label>
                    <input type="number"
                           name="quantity"
                           id="quantity"
                           value="1"
                           min="1"
                           max="<?php echo $product['stock']; ?>"
                           required>

                    <button type="submit" class="view-button">Add to Cart</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Modal popup when item is added to cart -->
<div id="addedPopup" class="popup-modal" style="display:none;">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Product Added to Cart!</h2>
        <p>What would you like to do next?</p>
        <div class="cart-buttons">
            <a href="shop.php?category=All" class="view-button">Continue Shopping</a>
            <a href="cart.php" class="view-button">Go to Cart</a>
        </div>
    </div>
</div>

<!-- Modal CSS Styling -->
<style>
.popup-modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}
.popup-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.3);
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.cart-buttons {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    gap: 20px;
}
.cart-buttons .view-button {
    padding: 10px 20px;
    font-size: 16px;
}
</style>

<!-- Tooltip & Popup Script -->
<script>
document.querySelectorAll('.tooltip-icon').forEach(icon => {
    const tip = icon.querySelector('.tooltip-text');
    icon.addEventListener('mouseenter', () => tip.style.visibility = 'visible');
    icon.addEventListener('mouseleave', () => tip.style.visibility = 'hidden');
});

function openPopup() {
    document.getElementById("addedPopup").style.display = "block";
}

function closePopup() {
    document.getElementById("addedPopup").style.display = "none";
}

// AJAX to add product to cart without reloading the page
document.querySelector('.product-form').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const form = this;
    const formData = new FormData(form);

    fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        openPopup();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error adding the product to the cart.');
    });
});
</script>

<?php include 'footer.php'; ?>
