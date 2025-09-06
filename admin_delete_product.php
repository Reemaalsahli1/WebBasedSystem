<?php
// Raghad - This code is a PHP script that allows an admin user to view and delete products from a database.
session_start();
include('config.php');
include('header.php');

// This code checks if the user is logged in as an admin. If not, it redirects the user to the admin login page.


if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $conn->query("DELETE FROM products WHERE id = $deleteId");
}

// Fetch products from database
$products = $conn->query("SELECT * FROM products");
?>

<div class="form-container wide-edit">
    <h2>Delete Product</h2>

    <table class="users-table" style="text-align: center;">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><img src="images/<?php echo htmlspecialchars($row['picture']); ?>" alt="Product Image" width="60" style="border-radius: 8px;"></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['price']; ?> SAR</td>
                    <td><a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>