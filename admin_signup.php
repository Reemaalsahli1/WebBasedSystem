<?php
// --------------------------------------
//  Layan Alqahtani
// Description: Admin Sign-Up Page with Access Code Protection
// --------------------------------------

session_start();

// Include database connection and page header
include('config.php');
include('header.php');

// Secret access code for admin registration
$secret_code = "glamour123";

// Check if the admin has not entered the access code yet
if (!isset($_SESSION['admin_signup_allowed'])) {
    // If form is submitted to check the secret code
    if (isset($_POST['check_code'])) {
        $entered_code = $_POST['secret'];
        
        // Validate entered secret code
        if ($entered_code === $secret_code) {
            $_SESSION['admin_signup_allowed'] = true;
            header("Location: admin_signup.php");
            exit();
        } else {
            $error = "Unauthorized. Invalid admin access code.";
        }
    }
    ?>
    <!-- Admin Access Verification Form -->
    <div class="form-container">
        <h2>Admin Access Verification</h2>
        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="post">
            <input type="password" name="secret" placeholder="Enter Admin Code" required class="input-field">
            <button type="submit" name="check_code" class="submit-button">Continue</button>
        </form>
    </div>
    <?php
    include('footer.php');
    exit();
}

// Initialize error and success messages
$error = '';
$success = '';

// Handle form submission for registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_raw = $_POST['password'];

    // Validate password strength
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $password_raw)) {
        $error = "Password must be at least 8 characters with uppercase, lowercase, number, and symbol.";
    } else {
        // Hash the password securely
        $password = password_hash($password_raw, PASSWORD_DEFAULT);

        // Check if username or email already exists in admin table
        $check_admin = $conn->prepare("SELECT admin_id FROM admin WHERE username = ? OR email = ?");
        $check_admin->bind_param("ss", $username, $email);
        $check_admin->execute();
        $result_admin = $check_admin->get_result();

        // Also check if email exists in user table
        $check_user = $conn->prepare("SELECT user_id FROM user WHERE email = ?");
        $check_user->bind_param("s", $email);
        $check_user->execute();
        $result_user = $check_user->get_result();

        // If user already exists in either table
        if ($result_admin->num_rows > 0 || $result_user->num_rows > 0) {
            $error = "Username or email already exists.";
        } else {
            // Insert new admin into admin table
            $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                $success = "Account created successfully! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
            $stmt->close();
        }

        // Close prepared statements
        $check_admin->close();
        $check_user->close();
    }
}
?>

<!-- Admin Sign-Up Form -->
<div class="form-container">
    <h2>Admin Sign Up</h2>

    <!-- Show error message if any -->
    <?php if (!empty($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Show success message if any -->
    <?php if (!empty($success)): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Admin registration input form -->
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required class="input-field">
        <input type="email" name="email" placeholder="Email" required class="input-field">
        <input 
            type="password" 
            name="password" 
            placeholder="Password" 
            required 
            class="input-field"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
            title="Password must be at least 8 characters and include uppercase, lowercase, number, and special character.">
        <button type="submit" class="submit-button">Sign Up</button>
    </form>

    <!-- Additional navigation links -->
    <p class="form-link">Already have an account? <a href="admin_login.php">Login here.</a></p>
    <p class="form-link"><a href="index.php">Back to Home</a></p>
</div>

<?php include('footer.php'); ?>
