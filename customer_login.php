<?php
// Author: Sarah Alotaibi

include('config.php');
include('header.php'); 

$error = '';

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if both username and password fields are filled
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Prepare SQL query to fetch user by username
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();

        // Check if user exists and password is correct
        if ($customer && password_verify($password, $customer['password'])) {
            
            // Set user data in session
            $_SESSION['user'] = $customer['username'];
            $_SESSION['user_id'] = $customer['user_id']; 
            $_SESSION['user_role'] = 'customer'; 

            // Redirect to shop page
            header("Location: shop.php"); 
            exit();
        } else {
            // Wrong username or password
            $error = "Invalid username or password.";
        }
        $stmt->close();
    } else {
        // If fields are empty
        $error = "Please fill in both fields.";
    }
}
?>

<!-- Login form container -->
<div class="form-container">
    <h2>Customer Login</h2>

    <!-- Display error message if any -->
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- The login form itself -->
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <!-- Links for signup or going back -->
    <p class="form-link">
        Don't have an account? <a href="customer_signup.php">Sign up here.</a>
    </p>
    <p class="form-link"><a href="index.php">Back to Home</a></p>
</div>

<?php include('footer.php'); ?>
