<!-- Author: Fatimah AlMumtan
     This page displays the 'About Us' section of Glamour Shop, providing information about the shop, its offerings, and its mission.
-->

<?php
session_start(); // Start the session to manage user data
include('header.php'); // Include the header file for consistent page structure
?>

<main class="shop-container" style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-start;"> <!-- Main container for the page content -->
    <div style="flex: 1; min-width: 300px;"> <!-- Section for 'About Us' text content -->
        <h2 class="shop-title">About Us</h2> <!-- Title of the section -->

        <div class="policy-box"> <!-- Container for the 'About Us' content -->
            <p>
                Discover the beauty of online shopping with <strong>Glamour Shop</strong> – your destination for premium makeup, skincare, haircare, and body care products.
            </p> <!-- Brief introduction to the Glamour Shop brand and its offerings -->

            <p>
                Our user-friendly website makes it easy to browse through a wide range of beauty essentials. You can check product prices, select quantities, and manage your shopping cart before checkout.
            </p> <!-- Description of the shopping experience on the website -->

            <p>
                We are continuously working to enhance your shopping experience and bring you the best in beauty and self-care.
            </p> <!-- Statement about continuous improvement and commitment to customer satisfaction -->
         
        
        </div>
    </div>

    <div style="flex: 1; min-width: 300px;"> <!-- Section for the image related to 'About Us' -->
        <img src="images/about_us.png" alt="Beauty Products Display" style="width: 100%; border-radius: 8px;"> <!-- Image showcasing beauty products -->
    </div>
</main>

<?php include('footer.php'); ?> <!-- Include footer layout -->