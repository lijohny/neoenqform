<?php
function neo_contact_form_shortcode() {
    ob_start();
    ?>

    <form id="contactForm" class="bg-white p-8 rounded shadow-md max-w-md w-full" method="post">
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            <div id="nameError" class="text-red-500"></div>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            <div id="emailError" class="text-red-500"></div>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
            <input type="tel" name="phone" id="phone" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-[#f36d45]">
            <div id="phoneError" class="text-red-500"></div>
        </div>
        <div class="mb-4">
            <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message:</label>
            <textarea name="message" id="message" rows="4" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-[#f36d45]"></textarea>
            <div id="messageError" class="text-red-500"></div>
        </div>
        <div class="mt-6">
            <?php wp_nonce_field('neo_contact_form', 'neo_contact_form_nonce'); ?>
            <input type="submit" value="Submit"  class="w-full ease-in duration-300 bg-[#f36d45] hover:bg-white text-white hover:text-[#f36d45] border border-[#f36d45] p-2 rounded cursor-pointer">
        </div>
    </form>

    <?php
    return ob_get_clean();
}
add_shortcode('neo-contact-form', 'neo_contact_form_shortcode');
?>



