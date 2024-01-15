<?php 
  function neo_contact_form_shortcode() {
    ob_start(); // Start output buffering

    // Your HTML form code goes here
    ?>
 <form action="" method="post" class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" name="name" id="name" required
                   class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" name="email" id="email" required
                   class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
        </div>

        <!-- Phone Field -->
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
            <input type="tel" name="phone" id="phone" required
                   class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
        </div>

        <!-- Message Field -->
        <div class="mb-4">
            <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message:</label>
            <textarea name="message" id="message" rows="4" required
                      class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500"></textarea>
        </div>

        <div class="mt-6">
            <input type="submit" value="Submit" class="w-full bg-blue-500 text-white p-2 rounded cursor-pointer">
        </div>
    </form>
    <?php

    return ob_get_clean(); // Return buffered content
  }
    // Register the shortcode
    add_shortcode('neo-contact-form', 'neo_contact_form_shortcode');
?>



