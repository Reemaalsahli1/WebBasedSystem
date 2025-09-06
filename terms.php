<?php
// Author: Fatimah AlMumtan
// This page displays the Terms & Conditions of the Glamour Shop website.
// It includes details on usage, orders, returns, account responsibilities, and possible changes to the terms.

session_start(); // Start the session to manage user data
include('header.php'); // Include the header layout for the page
?>

<main class="shop-container">
    <h2 class="shop-title">Terms & Conditions</h2> <!-- Display the title of the page -->

    <div class="policy-box">
        <ol>
            <!-- List of terms and conditions -->
            <li><strong>Usage:</strong> This site is intended for personal, non-commercial use.</li> <!-- Term on site usage -->
            <li><strong>Orders:</strong> All orders are subject to product availability and confirmation.</li> <!-- Term on order conditions -->
            <li><strong>Returns:</strong> Products can be returned within 7 days of purchase if unused and in original packaging.</li> <!-- Term on return policy -->
            <li><strong>Account:</strong> Users are responsible for maintaining the confidentiality of their login credentials.</li> <!-- Term on account security -->
            <li><strong>Changes:</strong> We may update these terms at any time without prior notice.</li> <!-- Term on updating terms -->
        </ol>

        <p>
            <!-- Disclaimer about accepting terms -->
            By using our site, you agree to comply with these terms. For questions, please contact us at 
            <a href="mailto:support@glamourshop.com">support@glamourshop.com</a>. <!-- Email link for support -->
        </p>
    </div>
</main>

<?php include('footer.php'); ?> <!-- Include the footer layout for the page -->