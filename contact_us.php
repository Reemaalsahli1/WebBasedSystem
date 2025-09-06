<!-- Author: Fatimah AlMumtan
     This page allows users to contact the Glamour Shop team. It displays the shop's address, phone, email, and a map for easy navigation. Users can also view help information by toggling a help box.
-->

<?php include 'header.php'; ?> <!-- Include the header layout for the page -->

<main class="shop-container">
    <h2 class="shop-title">Contact Us</h2> <!-- Display the title of the page -->

    <!-- Button to toggle the help information visibility -->
    <div style="text-align:center; margin-bottom: 20px;">
        <button onclick="toggleHelp()" class="view-button">Help</button>
    </div>

    <!-- Help information box that is initially hidden -->
    <div id="helpBox" class="policy-box hidden">
        <h3>Need Help?</h3>
        <ul>
            <!-- List of help information to assist users -->
            <li>This page allows you to get in touch with our team for any questions, feedback, or concerns.</li>
            <li>You can contact us through phone or email, or visit us at the provided address.</li>
            <li>Use the map below to locate our shop easily.</li>
            <li>Please make sure to provide correct contact details so we can respond to you quickly.</li>
            <li>We usually respond to all messages within 24–48 hours.</li>
        </ul>
    </div>

    <!-- Contact information section with styled container -->
    <div style="max-width: 900px; margin: auto; background-color: #fff6f8; padding: 30px; border-radius: 12px; box-shadow: 0 8px 16px rgba(198, 142, 159, 0.1); font-family: 'Poppins', sans-serif;">
        
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; text-align: center; margin-bottom: 40px; gap: 20px;">
            <!-- Address section -->
            <div style="flex: 1; min-width: 200px;">
                <p><strong>Address</strong></p>
                <p style="color:#5c2b3d;">Saudi Arabia - Dammam</p> <!-- Shop address -->
            </div>
            <!-- Phone section with a clickable link -->
            <div style="flex: 1; min-width: 200px;">
                <p><strong>Phone</strong></p>
                <p><a href="tel:+96655555555" style="color:#a0516d; text-decoration: none;">+966 55555555</a></p> <!-- Phone number link -->
            </div>
            <!-- Email section with a clickable email link -->
            <div style="flex: 1; min-width: 200px;">
                <p><strong>Email</strong></p>
                <p><a href="mailto:contact@glamourshop.com" style="color:#a0516d; text-decoration: none;">contact@glamourshop.com</a></p> <!-- Email link -->
            </div>
        </div>

        <!-- Map section with a title and embedded Google Map iframe -->
        <h3 style="text-align:center; margin-bottom: 20px;">Find Us on the Map</h3>
        <div style="border-radius: 12px; overflow: hidden;">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57183.800238351156!2d50.11381465136717!3d26.39159099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e49fdfb5de72b1d%3A0x5259f68a99907b6a!2z2KfZhNmG2K7ZitmEINmF2YjZhCDYp9mE2K_Zhdin2YU!5e0!3m2!1sar!2ssa!4v1745788278923!5m2!1sar!2ssa" 
              width="100%" 
              height="400" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe> <!-- Embedded Google Map showing the shop's location -->
        </div>
    </div>
</main>

<script>
// Function to toggle the visibility of the help information box
function toggleHelp() {
    const helpBox = document.getElementById("helpBox");
    helpBox.classList.toggle("hidden"); // Show or hide the help box when the button is clicked
}
</script>

<?php include 'footer.php'; ?> <!-- Include the footer layout for the page -->