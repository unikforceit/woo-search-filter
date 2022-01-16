<?php
/**
 * Plugin Name:       Rakib Woo Search
 * Plugin URI:        https://unikforce.com
 * Description:       Simple search addons
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            UnikForce IT
 * Author URI:        https://unikforce.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Create Shortcode woo-search-box
// Shortcode: [woo-search-box search="yes" category="yes" tag="yes"]
function create_woosearchbox_shortcode($atts) {

    $atts = shortcode_atts(
        array(
            'search' => 'yes',
            'category' => 'yes',
            'tag' => 'yes',
        ),
        $atts,
        'woo-search-box'
    );
    $search = $atts['search'];
    $category = $atts['category'];
    $tag = $atts['tag'];
?>
    <form name="woosearchbox" method="GET" action="<?php echo esc_url(home_url('/')); ?>">

        <?php if (class_exists('WooCommerce')) {
            if ($category == 'yes') {
                echo '<h3>Filter By Category</h3>';
                if (isset($_REQUEST['product_cat']) && !empty($_REQUEST['product_cat'])) {
                    $optsetlect = $_REQUEST['product_cat'];
                } else {
                    $optsetlect = 0;
                }
                $args = array(
                    'show_option_all' => esc_html__('All Categories', 'woo-search-box'),
                    'hierarchical' => 1,
                    'echo' => 1,
                    'value_field' => 'slug',
                    'taxonomy' => 'product_cat',
                    'name' => 'product_cat',
                    'class' => 'cate-dropdown hidden-xs',
                    'selected' => $optsetlect
                );
                wp_dropdown_categories($args);
            }
            if ($tag == 'yes') {
                echo '<h3>Filter By Tag</h3>';
                if (isset($_REQUEST['product_tag']) && !empty($_REQUEST['product_tag'])) {
                    $optsetlect2 = $_REQUEST['product_tag'];
                } else {
                    $optsetlect2 = 0;
                }
                $args2 = array(
                    'show_option_all' => esc_html__('All Tags', 'woo-search-box'),
                    'hierarchical' => 1,
                    'echo' => 1,
                    'value_field' => 'slug',
                    'taxonomy' => 'product_tag',
                    'name' => 'product_tag',
                    'class' => 'cate-dropdown hidden-xs',
                    'selected' => $optsetlect2
                );
                wp_dropdown_categories($args2);
            }
            ?>
            <input type="hidden" value="product" name="post_type">
            <?php } ?>
        <?php if ($search == 'yes'){?>
                <h3>Product Search</h3>
            <input type="text"  name="s" class="searchbox" maxlength="128" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e('Search entire store here...', 'woo-search-box'); ?>">
        <?php }?>
        <button type="submit" title="<?php esc_attr_e('Search', 'woo-search-box'); ?>" class="search-btn-bg"><span><?php esc_attr_e('Search','woo-search-box');?></span></button>
    </form>
<?php
}
add_shortcode( 'woo-search-box', 'create_woosearchbox_shortcode' );