<?php
// Author: Raseel Alderaan
// This page allows the admin to edit existing products. The admin can update product information including name, price, category, and image.
// Changes are updated in the database using PHP and JavaScript form handling.


// Show all errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Start the session and include configuration file for database connection
session_start();
include('config.php');


// Handle AJAX update request BEFORE loading any HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    // Sanitize input values
    $id = intval($_POST['id']);  // Product ID
    $name = $_POST['name'];      // Product Name
    $price = floatval($_POST['price']);  // Product Price
    $category = $_POST['category'];  // Product Category
    $description = $_POST['description'];  // Product Description

    // Variable to hold image name
    $new_image_name = '';

    // Check if a new image is uploaded
    if (!empty($_FILES['new_image']['name'])) {
        // Set new image file name and target path
        $new_image_name = basename($_FILES['new_image']['name']);
        $target = 'images/' . $new_image_name;

        // Attempt to upload the image file
        if (!move_uploaded_file($_FILES['new_image']['tmp_name'], $target)) {
            echo json_encode([
                'success' => false,
                'error' => 'Failed to upload image.'
            ]);
            exit;
        }

        // Prepare SQL query to update product with new image
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category=?, description=?, picture=? WHERE id=?");
        $stmt->bind_param("sdsssi", $name, $price, $category, $description, $new_image_name, $id);
    } else {
        // Prepare SQL query to update product without changing image
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, category=?, description=? WHERE id=?");
        $stmt->bind_param("sdssi", $name, $price, $category, $description, $id);
    }

    // Execute the query and send back a JSON response
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'new_image' => $new_image_name
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => $stmt->error
        ]);
    }
    exit;
}

// Include the header
include('header.php');

// Fetch all products from the database
$products = $conn->query("SELECT * FROM products");
?>

<main class="shop-container">
    <!-- Success Message -->
    <div id="successMessage" style="display: none; background-color: #f3e5f5; color: #7b1fa2; font-weight: bold; text-align: center; padding: 10px; margin-bottom: 15px; border-radius: 6px;">
        Product updated successfully!
    </div>

    <!-- Title of the page -->
    <h2 class="shop-title">Edit Products</h2>

    <!-- Search Bar for products -->
    <input type="text" id="productSearch" placeholder="Search by product name..." class="input-field" style="max-width: 400px; margin: 20px auto; display: block;">

    <div class="edit-products-box">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through each product and display its data -->
                <?php while ($row = $products->fetch_assoc()): ?>
                <tr id="row-<?php echo $row['id']; ?>">
                    <td><img src="images/<?php echo $row['picture']; ?>" width="40" id="img-<?php echo $row['id']; ?>"></td>
                    <td class="p-name"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td class="p-price"><?php echo $row['price']; ?> SAR</td>
                    <td class="p-cat"><?php echo htmlspecialchars($row['category']); ?></td>
                    <td><button class="edit-btn" onclick="toggleForm(<?php echo $row['id']; ?>)">Edit</button></td>
                </tr>

                <!-- Hidden form for editing a product -->
                <tr id="form-<?php echo $row['id']; ?>" style="display:none;">
                    <td colspan="5">
                        <form onsubmit="submitProductEdit(event, <?php echo $row['id']; ?>)" enctype="multipart/form-data">
                            <!-- Hidden fields for action and product ID -->
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <!-- Form fields for product details -->
                            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                            <input type="number" name="price" value="<?php echo $row['price']; ?>" required>

                            <select name="category" required>
                                <?php
                                $categories = ['Face', 'Eyes', 'Lips', 'Brushes & Tools', 'Nails', 'Perfume'];
                                foreach ($categories as $cat) {
                                    $selected = ($row['category'] === $cat) ? 'selected' : '';
                                    echo "<option value='$cat' $selected>$cat</option>";
                                }
                                ?>
                            </select>

                            <textarea name="description" rows="2" placeholder="Enter product description"><?php echo htmlspecialchars($row['description']); ?></textarea>

                            <input type="file" name="new_image" accept="image/*">
                            <button type="submit" class="view-button">Save</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Success pop-up message -->
<div id="popupMessage" style="
    display: none;
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #f3e5f5;
    color: #5c2b3d;
    padding: 15px 30px;
    border: 2px solid #d7abc3;
    border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    font-size: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 10000;
">Edit is saved!</div>

<script>
// Toggle the visibility of the edit form
function toggleForm(id) {
    const row = document.getElementById('form-' + id);
    row.style.display = (row.style.display === 'none') ? 'table-row' : 'none';
}

// Handle form submission using AJAX to update the product
function submitProductEdit(e, id) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    // Send form data to the server
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        console.log("Server response:", data);

        if (data.success) {
            // Update the product details on the page
            const row = document.getElementById('row-' + id);
            row.querySelector('.p-name').textContent = form.name.value;
            row.querySelector('.p-price').textContent = form.price.value + ' SAR';
            row.querySelector('.p-cat').textContent = form.category.value;

            // Update image if a new one was uploaded
            if (data.new_image) {
                document.getElementById('img-' + id).src = 'images/' + data.new_image;
            }

            // Hide the edit form and show success message
            document.getElementById('form-' + id).style.display = 'none';
            const popup = document.getElementById("popupMessage");
            popup.style.display = "block";

            setTimeout(() => {
                popup.style.display = "none";
            }, 3000);
        } else {
            console.error("PHP Error:", data.error);
            alert("Something went wrong while saving.");
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
        alert("Something went wrong while saving.");
    });
}

// Handle search functionality for products
document.getElementById('productSearch').addEventListener('keyup', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('.cart-table tbody tr');

    rows.forEach(row => {
        if (row.id.startsWith('form-')) return;
        const nameCell = row.querySelector('.p-name');
        if (nameCell) {
            const name = nameCell.textContent.toLowerCase();
            row.style.display = name.includes(searchValue) ? '' : 'none';
            const formRow = document.getElementById('form-' + row.id.split('-')[1]);
            if (formRow) formRow.style.display = 'none';
        }
    });
});
</script>

<?php include('footer.php'); ?>