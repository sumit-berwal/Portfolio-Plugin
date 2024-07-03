<?php
/*
 * Plugin Name: Custom Post Type
 * Description: Description for the custome post type plugin. This is the plugin for create custom portfolio.
 * Version: 1.0
 * Author: Sumit Berwal
 */

function create_custom_post_type() {
    $labels = array(
        'name' => 'Portfolios',
        'singular_name' => 'Portfolio',
        'menu_name' => 'Portfolios',
        'name_admin_bar' => 'Portfolio',
        'add_new'       => 'Add New',
        'add_new_item'  => 'Add New Portfolio',
        'new_item'  => 'New Portfolio',
        'edit_item' => 'Edit Portfolio',
        'view_item' => 'View Portfolio',
        'all_items' => 'All Portfolios',
        'search_items' => 'Search Portfolios',
        'parent_item_colon'  => 'Parent Portfolios:',
        'not_found'     => 'No portfolios found.',
        'not_found_in_trash' => 'No portfolios found in Trash.'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical'  => false,
        'menu_position' => null,
        'supports'  => array('title','editor','author','thumbnail', 'excerpt', 'comments')
    );

    register_post_type('portfolio', $args);
}
add_action('init', 'create_custom_post_type');

// For Meta Box

function add_portfolio_meta_boxes() {
    add_meta_box(
        'portfolio_details',
        'Portfolio Details',
        'portfolio_meta_box_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_portfolio_meta_boxes');

function portfolio_meta_box_callback($post) {
    $client = get_post_meta($post->ID, '_portfolio_client', true);
    $date = get_post_meta($post->ID, '_portfolio_date', true);
    ?>
    <p>
        <label for="portfolio_client">Client:</label>
        <input type="text" id="portfolio_client" name="portfolio_client" value="<?php echo $client; ?>" />
    </p>
    <p>
        <label for="portfolio_date">Date:</label>
        <input type="date" id="portfolio_date" name="portfolio_date" value="<?php echo $date; ?>" />
    </p>
    <?php
}

function save_portfolio_meta_box_data($post_id) {
    if (isset($_POST['portfolio_client'])) {
        update_post_meta($post_id, '_portfolio_client', $_POST['portfolio_client']);
    }
    if (isset($_POST['portfolio_date'])) {
        update_post_meta($post_id, '_portfolio_date', $_POST['portfolio_date']);
    }
}
add_action('save_post', 'save_portfolio_meta_box_data');

// For shortcode. We can use shortcode for show the portfolio

function portfolio_shortcode() {

    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => -1
    );
    $portfolio_query = new WP_Query($args);
    if ($portfolio_query->have_posts()) {
        echo '<div class="portfolio-items">';
        while ($portfolio_query->have_posts()) { $portfolio_query->the_post(); ?>
            <div class="portfolio-item">
                <h2><?php the_title(); ?></h2>
                <div class="portfolio-content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php }
        echo '</div>';
        wp_reset_postdata();
    }else{
        echo '<p>No portfolios found</p>';
    }

}
add_shortcode('portfolio', 'portfolio_shortcode');

?>


