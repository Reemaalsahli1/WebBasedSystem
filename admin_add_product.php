<?php
//Raghad- This code is a PHP script that allows an admin user to add a new product to the website.
session_start();

include('config.php');
include('header.php');

// This code checks if the user is logged in as an admin. If not, it redirects the user to the admin login page.

if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

$success = '';
$error = '';

// This code handles the form submission for adding a new product.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

// This code checks if the stock quantity is valid.

    if ($stock <= 0) {
        $error = "Stock quantity must be greater than 0.";
    } else {
        $imageName = $_FILES['image']['name'];
        $imagePath = 'images/' . basename($imageName);

// This code handles the image upload and inserts the product into the database.

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $stmt = $conn->prepare("INSERT INTO products (name, price, description, category, picture, stock) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $name, $price, $description, $category, $imageName, $stock);

            if ($stmt->execute()) {
                $success = "Product added successfully!";
            } else {
                $error = "Failed to add product. Try again.";
            }
        } else {
            $error = "Failed to upload image.";
        }
    }
}
?>

<div class="form-container">
    <h2>Add New Product</h2>

 <!-- This code displays the success or error message, if any. -->

    <?php if ($success): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

  <!-- This code creates the form for adding a new product. -->

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required class="input-field">
        <input type="text" name="price" placeholder="Product Price" required class="input-field">
        <textarea name="description" placeholder="Product Description" rows="4" required class="input-field"></textarea>

        <select name="category" required class="input-field">
            <option value="">Select Category</option>
            <option value="Face">Face</option>
            <option value="Eyes">Eyes</option>
            <option value="Lips">Lips</option>
            <option value="Brushes & Tools">Brushes & Tools</option>
            <option value="Nails">Nails</option>
            <option value="Perfume">Perfume</option>
        </select>

        <input type="number" name="stock" placeholder="Stock Quantity" required min="0" class="input-field">
        <input type="file" name="image" accept="image/*" required class="input-field">
        <button type="submit">Add Product</button>
    </form>
</div>

<?php include('footer.php'); ?>