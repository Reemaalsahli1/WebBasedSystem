<?php
// --------------------------------------
//  Layan Alqahtani
// Description: My Account Page (Displays current user's info)
// --------------------------------------

session_start();
include('config.php');

// Redirect to login page if no user is logged in
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's role
$role = $_SESSION['user_role'];

// Get user info based on their role
if ($role === 'admin') {
    $email = $_SESSION['admin_email'] ?? '—';
    $username = $_SESSION['admin_username'] ?? '—';
} else {
    $email = $_SESSION['user_email'] ?? '—';
    $username = $_SESSION['user_username'] ?? '—';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
</head>
<body>
<?php include('header.php'); ?> <!-- Include site header -->

<!-- Account info display container -->
<div class="form-container wide-edit">
    <h2>My Account</h2>

    <table class="users-table">
        <thead>
            <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Safely display user data -->
                <td><?php echo htmlspecialchars($email); ?></td>
                <td><?php echo htmlspecialchars($username); ?></td>
                <td><?php echo ucfirst($role); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?> <!-- Include site footer -->
</body>
</html>
