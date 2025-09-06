<?php
// Author: Sarah Alotaibi

include('config.php');
include('header.php');

$error = '';
$success = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash the password before saving

    // Check if username or email already exists in user table
    $check_user = $conn->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $check_user->bind_param("ss", $username, $email);
    $check_user->execute();
    $result_user = $check_user->get_result();

    // Also check if email exists in admin table
    $check_admin = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $check_admin->bind_param("s", $email);
    $check_admin->execute();
    $result_admin = $check_admin->get_result();

    // If username or email already used
    if ($result_user->num_rows > 0 || $result_admin->num_rows > 0) {
        $error = "Username or Email already exists.";
    } else {
        // Insert new user to database
        $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $success = "Account created successfully! You can now login.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }

    // Close check statements
    $check_user->close();
    $check_admin->close();
}
?>

<!-- Form UI for signup -->
<div class="form-container">
    <h2>Customer Sign Up</h2>

    <!-- Show error if there's one -->
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Show success if signup worked -->
    <?php if (!empty($success)): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- The actual sign-up form -->
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required class="input-field">
        <input type="email" name="email" placeholder="Email" required class="input-field">
        
        <!-- Password with pattern validation -->
        <input 
            type="password" 
            name="password" 
            placeholder="Password" 
            required 
            class="input-field"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
            title="Password must be at least 8 characters and include uppercase, lowercase, number, and special character.">

        <button type="submit">Sign Up</button>
    </form>

    <!-- Extra links -->
    <p class="form-link">Already have an account? <a href="customer_login.php">Login here.</a></p>
    <p class="form-link"><a href="index.php">Back to Home</a></p>
</div>

<?php include('footer.php'); ?>
