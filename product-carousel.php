<?php
/*
Plugin Name: Loop Carousel for Woocommerce Products
Description: Adds a featured product carousel to your site.
Version: 1.0
Author: Hassan Naqvi
*/

// Enqueue scripts and styles
require_once(plugin_dir_path(__FILE__) . 'includes/latest-products.php');



function enqueue_featured_product_carousel_scripts() {
    // Your custom stylesheet (loaded first)
    wp_enqueue_style('custom-style', plugin_dir_url(__FILE__) . 'style.css');

    // Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');

    // Font Awesome CSS
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');

    // Swiper JavaScript (loaded after custom stylesheet)
    wp_enqueue_script('swiper', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js', array('jquery'), null, true);

    // Your custom JavaScript (depends on Swiper, loaded after Swiper)
 /* wp_enqueue_script('custom-script', plugin_dir_url(__FILE__) . 'script.js', array('swiper'), null, true);*/
}

add_action('wp_enqueue_scripts', 'enqueue_featured_product_carousel_scripts');





// Function to display the settings page content
function custom_swiper_settings_page() {
    ?>
    <div class="wrap">
        <h1>Free Product Carousel Shortcodes</h1>
        <p>Welcome to the Custom Swiper plugin settings page.</p>
        <h2>How to Use Shortcode</h2>
        <p>Here are a couple of shortcode examples for the modified custom_swiper function:</p>

        <p>Display all products with the default settings:</p>
        <pre>[product_carousel]</pre>

        <p>Display 3 latest products from the "electronics" category:</p>
        <pre>[product_carousel category="electronics" count="3"]</pre>

        <p>Display 8 latest products with no specific category:</p>
        <pre>[product_carousel count="8"]</pre>

        <p>Feel free to customize the shortcode attributes based on your specific needs. Adjust the category attribute to specify a particular product category, and use the count attribute to control the number of products displayed.</p>
    </div>
    <?php
}

// Function to add the settings page to the admin menu
function custom_swiper_add_menu() {
    add_options_page('Custom Swiper Settings', 'Products Carousel', 'manage_options', 'custom-swiper-settings', 'custom_swiper_settings_page');
}

// Hook to add the settings page
add_action('admin_menu', 'custom_swiper_add_menu');