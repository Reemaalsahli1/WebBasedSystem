<?php
// Author: Hoton Alqahtani
// Description: This page displays the main shop interface with product categories and product listings.

// Start session and check if user is a logged-in customer
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'customer') {
    header("Location: customer_login.php");
    exit();
}

// Include database config and header template
include('config.php');
include('header.php');

// Get selected category from the URL, default to 'All'
$selected_category = $_GET['category'] ?? 'All';
$categories = ['All', 'Face', 'Eyes', 'Lips', 'Brushes & Tools', 'Nails', 'Perfume'];
?>

<main class="shop-container">
    <!-- Display welcome message with username -->
    <h1 class="shop-title">
        <?php
            $user = $_SESSION['user'] ?? 'Guest';
            echo "Welcome back, <span class='highlight-user'>" . htmlspecialchars($user) . "</span>! Let’s glam up your day!";
        ?>
    </h1>

    <!-- Category Tabs -->
    <div class="category-tabs">
        <?php foreach ($categories as $cat): ?>
            <a href="shop.php?category=<?php echo urlencode($cat); ?>"
               class="category-tab <?php echo ($cat === $selected_category) ? 'active' : ''; ?>">
                <?php echo htmlspecialchars($cat); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Product Grid based on selected category -->
    <div class="category-grid">
        <?php
        // Fetch all products or filtered products by category
        if ($selected_category === 'All') {
            $stmt = $conn->prepare("SELECT * FROM products");
        } else {
            $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
            $stmt->bind_param("s", $selected_category);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        // Display each product as a card
        while ($product = $result->fetch_assoc()):
            $image = $product['picture'] ?: 'default.png';
        ?>
            <a href="product_details.php?id=<?php echo $product['id']; ?>" class="category-card">
                <div class="category-card-content">
                    <img src="images/<?php echo htmlspecialchars($image); ?>" alt="Product Image">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Price: <?php echo htmlspecialchars($product['price']); ?> SAR</p>
                    <button class="view-button">View Details</button>
                </div>
            </a>
        <?php endwhile; ?>
    </div>
</main>

<?php include('footer.php'); ?>
