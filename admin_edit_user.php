<?php
// Author: Raseel Alderaan
// This page allows the admin to edit existing products. The admin can update product information including name, price, category, and image.
// Changes are updated in the database using PHP and JavaScript form handling.

// Start a session to maintain the user login status
session_start();

// Include configuration file for database connection
include('config.php');

// Handle the AJAX request to update the user details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax']) && $_POST['ajax'] == '1') {
    // Sanitize and store input values
    $id = intval($_POST['id']); // User ID
    $username = trim($_POST['username']); // Username
    $email = trim($_POST['email']); // Email

    // Prepare the SQL query to update the user record
    $stmt = $conn->prepare("UPDATE user SET username = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $username, $email, $id);
    $success = $stmt->execute(); // Execute the query
    $stmt->close(); // Close the statement

    // Return a JSON response indicating whether the update was successful
    echo json_encode(['success' => $success]);
    exit; // Exit the script after processing the AJAX request
}

// Check if the user is logged in as an admin, if not, redirect to the login page
if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

// Include the header file (for navigation, logo, etc.)
include('header.php');

// Retrieve all users from the database
$users = $conn->query("SELECT * FROM user");
?>

<div class="form-container wide-edit">
    <!-- Display the title for the user editing page -->
    <h2>Edit Users</h2>

    <!-- Create a table to display users' information -->
    <table class="users-table" id="userTable">
        <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Email</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1;
            // Loop through each user and display their data
            while ($row = $users->fetch_assoc()): ?>
                <tr data-id="<?php echo $row['user_id']; ?>">
                    <td><?php echo $counter++; ?></td>
                    <td class="username"><?php echo htmlspecialchars($row['username']); ?></td>
                    <td class="email"><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><button class="edit-btn" onclick="editUser(this)">Edit</button></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Popup message that appears when edit is saved -->
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
// Function to enable editing of user data
function editUser(button) {
    const row = button.closest("tr");
    const userId = row.dataset.id;
    const usernameCell = row.querySelector(".username");
    const emailCell = row.querySelector(".email");

    const currentUsername = usernameCell.textContent.trim();
    const currentEmail = emailCell.textContent.trim();

    // Corrected input assignment using template literals
    usernameCell.innerHTML = `<input type="text" value="${currentUsername}" class="form-inline">`;
    emailCell.innerHTML = `<input type="email" value="${currentEmail}" class="form-inline">`;

    button.textContent = "Save";

    button.onclick = function () {
        const updatedUsername = usernameCell.querySelector("input").value;
        const updatedEmail = emailCell.querySelector("input").value;

        const formData = new FormData();
        formData.append("ajax", "1");
        formData.append("id", userId);
        formData.append("username", updatedUsername);
        formData.append("email", updatedEmail);

        fetch("admin_edit_user.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                usernameCell.textContent = updatedUsername;
                emailCell.textContent = updatedEmail;

                button.textContent = "Edit";
                button.onclick = () => editUser(button);

                const popup = document.getElementById("popupMessage");
                popup.style.display = "block";
                setTimeout(() => {
                    popup.style.display = "none";
                }, 3000);
            } else {
                alert("Failed to update user.");
            }
        });
    };
}
</script>

<?php 
// Include the footer file (for footer content)
include('footer.php'); 
?>
