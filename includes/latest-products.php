<?php


// custom-swiper-script.php
function custom_swiper_enqueue_script() {
    // Enqueue your script here
 wp_enqueue_script('custom-script', plugin_dir_url(__FILE__) . '../script/script.js', array('swiper'), null, true);
}

// Add an action to enqueue the script
add_action('wp_enqueue_scripts', 'custom_swiper_enqueue_script');



function custom_swiper_shortcode($atts) {
    ob_start();

    $atts = shortcode_atts(
        array(
            'category' => '', // Default to no specific category
            'count'    => -1,   // Default number of products to display
        ),
        $atts,
        'custom_swiper'
    );

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => intval($atts['count']),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'tax_query'      => array(),
    );

    // If a specific category is provided in the shortcode, add it to the query
    if ($atts['category']) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($atts['category']),
			
        );
    }

    $latest_product_query = new WP_Query($args);
	


    if ($latest_product_query->have_posts()) : ?>
        <div class="swiper-container">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php
                    while ($latest_product_query->have_posts()) : $latest_product_query->the_post();
                        $product_id = get_the_ID();
                        $featured_image = get_the_post_thumbnail_url($product_id, 'full');
                        $fallback_image = plugin_dir_url(__FILE__) . 'dummy-product-image.jpg'; // Replace with the actual path to your fallback image
                        $product_permalink = get_permalink($product_id);
                        $product_categories = get_the_terms($product_id, 'product_cat');
                        $first_category_name = $first_category_link = '';

                        if ($product_categories && !is_wp_error($product_categories)) {
                            $first_category = reset($product_categories);
                            $first_category_name = $first_category->name;
                            $first_category_link = get_term_link($first_category);
			

                        }
						// Get the product price
    $product_price = wc_get_product($product_id)->get_price_html();
                        ?>

                        <div class="swiper-slide swiper-slide--one product-<?php echo $product_id; ?>" style="background-image: url('<?php echo esc_url($featured_image ? $featured_image : $fallback_image); ?>'); background-repeat: no-repeat; background-position: 50% 50%; background-size: cover;">
                            <?php if ($first_category_name) : ?>
                                <span class="category"><a style="color: #ffff;" href="<?php echo esc_url($first_category_link); ?>"><?php echo esc_html($first_category_name); ?></a></span>
                            <?php endif; ?>
                            
                           
                            <div class="slide-content">
                                <a href="<?php echo esc_url($product_permalink); ?>">
                                    <h3><?php the_title(); ?></h3>
                                
       
                                </a>
                            </div>
                        </div>

                    <?php endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    <?php else :
        echo 'No products found';
    endif;

    return ob_get_clean();
}

add_shortcode('product_carousel', 'custom_swiper_shortcode');
