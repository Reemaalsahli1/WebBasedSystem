<?php
// --------------------------------------
//  Layan Alqahtani
// Description: Admin Login Script
// --------------------------------------

session_start();
include('config.php'); 
include('header.php');

$error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if both fields are filled
    if (!empty($_POST['username']) && !empty($_POST['password'])) {

        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Prepare SQL query to check if admin exists
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        // If admin exists and password is correct
        if ($admin && password_verify($password, $admin['password'])) {
            
            // Store admin data in session variables
            $_SESSION['user'] = $admin['username'];
            $_SESSION['user_role'] = 'admin';
            $_SESSION['admin_name'] = $admin['name'];          
            $_SESSION['admin_email'] = $admin['email'];        
            $_SESSION['admin_username'] = $admin['username'];

            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // If login fails
            $error = "Invalid Admin username or password.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // If any field is empty
        $error = "Please fill in all fields.";
    }
}
?>

<!-- Admin Login Form -->
<div class="form-container">
    <h2>Admin Login</h2>

    <!-- Display error if any -->
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Login form -->
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <!-- Navigation links -->
    <p class="form-link">Don't have an account? <a href="admin_signup.php">Sign Up</a></p>
    <p class="form-link"><a href="index.php">Back to Home</a></p>
</div>

<?php include('footer.php'); ?>
