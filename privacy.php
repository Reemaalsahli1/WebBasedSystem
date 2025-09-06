<!-- Author: Fatimah AlMumtan
     This page displays the privacy policy for Glamour Shop, explaining how personal information is collected, used, and protected.
-->

<?php
session_start(); // Start the session to manage user data
include('header.php'); // Include the header file for consistent page structure
?>

<main class="shop-container">
    <h2 class="shop-title">Privacy Policy</h2> <!-- Title of the page -->

    <div class="policy-box"> <!-- Container for the privacy policy content -->
        <p>
            At <strong>Glamour Shop</strong>, we value your privacy. We only collect the necessary personal information required 
            to process your orders and improve your shopping experience.
        </p>

        <ul> <!-- List of privacy practices -->
            <li>We do not share your information with third parties.</li> <!-- Assurance of privacy -->
            <li>Your account and payment details are securely stored.</li> <!-- Data security statement -->
            <li>Cookies are used to personalize your visit and remember your preferences.</li> <!-- Cookies policy -->
            <li>You can contact us anytime to request deletion of your data.</li> <!-- Data deletion option -->
        </ul>

        <p>
            If you have any questions, feel free to contact us at
            <a href="mailto:privacy@glamourshop.com">privacy@glamourshop.com</a>. <!-- Contact email for privacy-related inquiries -->
          </div>
</main>

<?php include('footer.php'); ?> <!-- Include footer layout -->