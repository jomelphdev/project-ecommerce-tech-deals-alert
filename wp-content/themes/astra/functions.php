<?php
/**
 * Astra functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define Constants
 */
define( 'ASTRA_THEME_VERSION', '4.6.5' );
define( 'ASTRA_THEME_SETTINGS', 'astra-settings' );
define( 'ASTRA_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'ASTRA_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );

/**
 * Minimum Version requirement of the Astra Pro addon.
 * This constant will be used to display the notice asking user to update the Astra addon to the version defined below.
 */
define( 'ASTRA_EXT_MIN_VER', '4.6.4' );

/**
 * Setup helper functions of Astra.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-theme-options.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-theme-strings.php';
require_once ASTRA_THEME_DIR . 'inc/core/common-functions.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-icons.php';

define( 'ASTRA_PRO_UPGRADE_URL', astra_get_pro_url( 'https://wpastra.com/pro/', 'dashboard', 'free-theme', 'upgrade-now' ) );
define( 'ASTRA_PRO_CUSTOMIZER_UPGRADE_URL', astra_get_pro_url( 'https://wpastra.com/pro/', 'customizer', 'free-theme', 'upgrade' ) );

/**
 * Update theme
 */
require_once ASTRA_THEME_DIR . 'inc/theme-update/astra-update-functions.php';
require_once ASTRA_THEME_DIR . 'inc/theme-update/class-astra-theme-background-updater.php';

/**
 * Fonts Files
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-font-families.php';
if ( is_admin() ) {
	require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts-data.php';
}

require_once ASTRA_THEME_DIR . 'inc/lib/webfont/class-astra-webfont-loader.php';
require_once ASTRA_THEME_DIR . 'inc/lib/docs/class-astra-docs-loader.php';
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-fonts.php';

require_once ASTRA_THEME_DIR . 'inc/dynamic-css/custom-menu-old-header.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/container-layouts.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/astra-icons.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-walker-page.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-enqueue-scripts.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-gutenberg-editor-css.php';
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-wp-editor-css.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/block-editor-compatibility.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/inline-on-mobile.php';
require_once ASTRA_THEME_DIR . 'inc/dynamic-css/content-background.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-dynamic-css.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-global-palette.php';

/**
 * Custom template tags for this theme.
 */
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-attr.php';
require_once ASTRA_THEME_DIR . 'inc/template-tags.php';

require_once ASTRA_THEME_DIR . 'inc/widgets.php';
require_once ASTRA_THEME_DIR . 'inc/core/theme-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/admin-functions.php';
require_once ASTRA_THEME_DIR . 'inc/core/sidebar-manager.php';

/**
 * Markup Functions
 */
require_once ASTRA_THEME_DIR . 'inc/markup-extras.php';
require_once ASTRA_THEME_DIR . 'inc/extras.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog-config.php';
require_once ASTRA_THEME_DIR . 'inc/blog/blog.php';
require_once ASTRA_THEME_DIR . 'inc/blog/single-blog.php';

/**
 * Markup Files
 */
require_once ASTRA_THEME_DIR . 'inc/template-parts.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-loop.php';
require_once ASTRA_THEME_DIR . 'inc/class-astra-mobile-header.php';

/**
 * Functions and definitions.
 */
require_once ASTRA_THEME_DIR . 'inc/class-astra-after-setup-theme.php';

// Required files.
require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-helper.php';

require_once ASTRA_THEME_DIR . 'inc/schema/class-astra-schema.php';

/* Setup API */
require_once ASTRA_THEME_DIR . 'admin/includes/class-astra-api-init.php';

if ( is_admin() ) {
	/**
	 * Admin Menu Settings
	 */
	require_once ASTRA_THEME_DIR . 'inc/core/class-astra-admin-settings.php';
	require_once ASTRA_THEME_DIR . 'admin/class-astra-admin-loader.php';
	require_once ASTRA_THEME_DIR . 'inc/lib/astra-notices/class-astra-notices.php';
}

/**
 * Metabox additions.
 */
require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-boxes.php';

require_once ASTRA_THEME_DIR . 'inc/metabox/class-astra-meta-box-operations.php';

/**
 * Customizer additions.
 */
require_once ASTRA_THEME_DIR . 'inc/customizer/class-astra-customizer.php';

/**
 * Astra Modules.
 */
require_once ASTRA_THEME_DIR . 'inc/modules/posts-structures/class-astra-post-structures.php';
require_once ASTRA_THEME_DIR . 'inc/modules/related-posts/class-astra-related-posts.php';

/**
 * Compatibility
 */
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-gutenberg.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-jetpack.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/woocommerce/class-astra-woocommerce.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/edd/class-astra-edd.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/lifterlms/class-astra-lifterlms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/learndash/class-astra-learndash.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bb-ultimate-addon.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-contact-form-7.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-visual-composer.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-site-origin.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-gravity-forms.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-bne-flyout.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-ubermeu.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-divi-builder.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-amp.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-yoast-seo.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-surecart.php';
require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-starter-content.php';
require_once ASTRA_THEME_DIR . 'inc/addons/transparent-header/class-astra-ext-transparent-header.php';
require_once ASTRA_THEME_DIR . 'inc/addons/breadcrumbs/class-astra-breadcrumbs.php';
require_once ASTRA_THEME_DIR . 'inc/addons/scroll-to-top/class-astra-scroll-to-top.php';
require_once ASTRA_THEME_DIR . 'inc/addons/heading-colors/class-astra-heading-colors.php';
require_once ASTRA_THEME_DIR . 'inc/builder/class-astra-builder-loader.php';

// Elementor Compatibility requires PHP 5.4 for namespaces.
if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor.php';
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-elementor-pro.php';
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-web-stories.php';
}

// Beaver Themer compatibility requires PHP 5.3 for anonymous functions.
if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
	require_once ASTRA_THEME_DIR . 'inc/compatibility/class-astra-beaver-themer.php';
}

require_once ASTRA_THEME_DIR . 'inc/core/markup/class-astra-markup.php';

/**
 * Load deprecated functions
 */
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-filters.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-hooks.php';
require_once ASTRA_THEME_DIR . 'inc/core/deprecated/deprecated-functions.php';




// CURRENT CHANGES START



// Automatically activate "WPS Hide Login" plugin after migration
// function ensure_wps_hide_login_activated() {
//     // Check if WPS Hide Login is not active
//     if ( !is_plugin_active('wps-hide-login/wps-hide-login.php') ) {
//         // Activate the WPS Hide Login plugin
//         activate_plugin('wps-hide-login/wps-hide-login.php');
//     }
// }
// // Run the function on every page load
// add_action('wp_loaded', 'ensure_wps_hide_login_activated');



// Automatically activate "WPS Hide Login" plugin and flush rewrite rules after migration
function ensure_wps_hide_login_activated() {
    // Check if WPS Hide Login plugin is installed but not active
    if ( !is_plugin_active('wps-hide-login/wps-hide-login.php') && file_exists(WP_PLUGIN_DIR . '/wps-hide-login/wps-hide-login.php') ) {
        // Activate the plugin
        activate_plugin('wps-hide-login/wps-hide-login.php');

        // Flush rewrite rules to avoid 404 errors
        flush_rewrite_rules();
    }
}
// Run the function on every page load
add_action('wp_loaded', 'ensure_wps_hide_login_activated');







// Remove Privacy Policy link in login page
function remove_privacy_link() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var privacyPolicyLink = document.querySelector('a.privacy-policy-link');
            if (privacyPolicyLink) {
                privacyPolicyLink.style.display = 'none';
            }
        });
    </script>
    <?php
}
add_action('login_footer', 'remove_privacy_link');

// remove or change the "WordPress" label in the title bar of the login page
function change_login_title() {
    return 'Log In - ' . get_bloginfo('name');
}
add_filter('login_title', 'change_login_title');

// remove or change the "WordPress" label in the title bar of the Admin Dashboard
function change_admin_title($admin_title, $title) {
    return $title . ' - ' . get_bloginfo('name');
}
add_filter('admin_title', 'change_admin_title', 10, 2);

// Checkout one Product at a time
function only_one_item_in_cart( $passed, $product_id, $quantity, $variation_id = '', $variations= '' ) {
    $cart_items_count = WC()->cart->get_cart_contents_count();
    if( $cart_items_count > 0 ) {
        wc_add_notice( 'You can only purchase one item at a time.', 'error' );
        return false;
    }
    return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'only_one_item_in_cart', 10, 5 );

function limit_cart_to_one_product() {
    if( WC()->cart->get_cart_contents_count() > 1 ){
        wc_add_notice( 'You can only purchase one item at a time.', 'error' );
        foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            WC()->cart->remove_cart_item( $cart_item_key );
            break;
        }
    }
}
add_action( 'woocommerce_before_cart', 'limit_cart_to_one_product' );

// Disable quantity inputs in the cart
function disable_quantity_input_field( $product_quantity, $cart_item_key, $cart_item ) {
    $product_quantity = sprintf( '%d <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item['quantity'], $cart_item_key );
    return $product_quantity;
}
add_filter( 'woocommerce_cart_item_quantity', 'disable_quantity_input_field', 10, 3 );


// no one can buy if the gift card balance is insufficient to cover the product cost
function check_user_gift_card_balance() {
    if (is_user_logged_in()) {
        $user_email = wp_get_current_user()->user_email;
        global $wpdb;
        $gift_card_table = $wpdb->prefix . 'pimwick_gift_card';
        $activity_table = $wpdb->prefix . 'pimwick_gift_card_activity';

        // Get the gift card for the logged-in user
        $gift_card = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $gift_card_table WHERE recipient_email = %s AND active = 1 LIMIT 1",
                $user_email
            )
        );

        if ($gift_card) {
            // Calculate the balance from the activity table
            $balance = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT SUM(amount) FROM $activity_table WHERE pimwick_gift_card_id = %d",
                    $gift_card->pimwick_gift_card_id
                )
            );

            $balance = $balance ? $balance : 0; // Ensure balance is not null

            return array(
                'number' => $gift_card->number,
                'balance' => $balance
            );
        } else {
            return null;
        }
    }
    return null;
}

function validate_gift_card_balance_on_checkout() {
    if (is_user_logged_in()) {
        $gift_card_data = check_user_gift_card_balance();

        // If no gift card data found, block checkout
        if (is_null($gift_card_data)) {
            wc_add_notice('You must enter the coupon code to proceed to checkout.', 'error');
        } else {
            $balance = $gift_card_data['balance'];
            $cart_subtotal = WC()->cart->get_subtotal();

            // Check if balance is sufficient
            if ($balance < $cart_subtotal) {
                wc_add_notice('Your coupon code balance is insufficient to cover the product cost.', 'error');
            }
        }
    }
}
add_action('woocommerce_check_cart_items', 'validate_gift_card_balance_on_checkout');

function auto_apply_gift_card_script() {
    if (is_user_logged_in() && (is_cart() || is_checkout())) {
        $gift_card_data = check_user_gift_card_balance();

        if ($gift_card_data) {
            $gift_card_number = $gift_card_data['number'];
            ?>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function () {
                    var giftCardCode = '<?php echo esc_js($gift_card_number); ?>';

                    var couponField = document.getElementById('pwgc-redeem-gift-card-number');
                    var applyCouponButton = document.getElementById('pwgc-redeem-button');

                    if (couponField && applyCouponButton) {
                        couponField.value = giftCardCode;
                        applyCouponButton.click();
                    }

                });
            </script>
            <?php
        }
    }
}
add_action('wp_footer', 'auto_apply_gift_card_script');



// Add a new column to the Users Admin Dashboard
function add_date_created_column($columns) {
    $columns['date_created'] = 'Date Created';
    return $columns;
}
add_filter('manage_users_columns', 'add_date_created_column');

// Populate the Date Created column with the user registration date
function show_date_created_column($value, $column_name, $user_id) {
    if ('date_created' == $column_name) {
        $user = get_userdata($user_id);
        $date_format = 'F j, Y g:i a'; // Format: July 18, 2024 8:34 pm
        return date_i18n($date_format, strtotime($user->user_registered));
    }
    return $value;
}
add_action('manage_users_custom_column', 'show_date_created_column', 10, 3);

// Make the Date Created column sortable
function make_date_created_column_sortable($columns) {
    $columns['date_created'] = 'date_created';
    return $columns;
}
add_filter('manage_users_sortable_columns', 'make_date_created_column_sortable');

// Apply sorting to the Date Created column
function sort_users_by_date_created($query) {
    if (!is_admin()) {
        return;
    }

    $screen = get_current_screen();
    if ('users' === $screen->id) {
        if (isset($_GET['orderby']) && 'date_created' === $_GET['orderby']) {
            $query->query_vars['orderby'] = 'registered';
        }
    }
}
add_action('pre_get_users', 'sort_users_by_date_created');








// Initialize global variables for site settings
function init_global_site_settings() {
    $options = get_option('global_site_settings');

    // Define global variables
	$GLOBALS['SITE_HEADER_BACKGROUND'] = isset($options['site_header_background']) ? esc_html($options['site_header_background']) : '';
	$GLOBALS['SITE_HEADER_LOGO'] = isset($options['site_header_logo']) ? esc_url($options['site_header_logo']) : '';
	$GLOBALS['SITE_HEADER_LOGO_WIDTH'] = isset($options['site_header_logo_width']) ? esc_html($options['site_header_logo_width']) : '';
	$GLOBALS['SITE_HEADER_LOGO_HEIGHT'] = isset($options['site_header_logo_height']) ? esc_html($options['site_header_logo_height']) : '';
	$GLOBALS['SITE_HEADER_LINKS_COLOR'] = isset($options['site_header_links_color']) ? esc_html($options['site_header_links_color']) : '';
	$GLOBALS['SITE_HEADER_ICONS_COLOR'] = isset($options['site_header_icons_color']) ? esc_html($options['site_header_icons_color']) : '';
	$GLOBALS['SCROLL_TO_TOP_BUTTON_BACKGROUND'] = isset($options['scroll_to_top_button_background']) ? esc_html($options['scroll_to_top_button_background']) : '';
    
    $GLOBALS['SITE_FOOTER_BACKGROUND'] = isset($options['site_footer_background']) ? esc_html($options['site_footer_background']) : '';
	$GLOBALS['SITE_FOOTER_LOGO'] = isset($options['site_footer_logo']) ? esc_url($options['site_footer_logo']) : '';
    $GLOBALS['SITE_FOOTER_LOGO_WIDTH'] = isset($options['site_footer_logo_width']) ? esc_html($options['site_footer_logo_width']) : '';
	$GLOBALS['SITE_FOOTER_LOGO_HEIGHT'] = isset($options['site_footer_logo_height']) ? esc_html($options['site_footer_logo_height']) : '';
	$GLOBALS['SITE_FOOTER_LINKS_COLOR'] = isset($options['site_footer_links_color']) ? esc_html($options['site_footer_links_color']) : '';
	$GLOBALS['SITE_FOOTER_COPYRIGHT_COLOR'] = isset($options['site_footer_copyright_color']) ? esc_html($options['site_footer_copyright_color']) : '#ffffff';
	$GLOBALS['SITE_FOOTER_HORIZONTAL_LINE_COLOR'] = isset($options['site_footer_horizontal_line_color']) ? esc_html($options['site_footer_horizontal_line_color']) : '';

    $GLOBALS['SITE_LOGIN_BACKGROUND'] = isset($options['site_login_background']) ? esc_html($options['site_login_background']) : '';
	$GLOBALS['SITE_LOGIN_LOGO'] = isset($options['site_login_logo']) ? esc_url($options['site_login_logo']) : '';
    $GLOBALS['SITE_LOGIN_LOGO_WIDTH'] = isset($options['site_login_logo_width']) ? esc_html($options['site_login_logo_width']) : '';
	$GLOBALS['SITE_LOGIN_LOGO_HEIGHT'] = isset($options['site_login_logo_height']) ? esc_html($options['site_login_logo_height']) : '';
	$GLOBALS['SITE_LOGIN_BUTTON_COLOR'] = isset($options['site_login_button_color']) ? esc_html($options['site_login_button_color']) : '';
    $GLOBALS['SITE_LOGIN_BUTTON_TEXT_COLOR'] = isset($options['site_login_button_text_color']) ? esc_html($options['site_login_button_text_color']) : '';
    $GLOBALS['SITE_LOGIN_BACKGROUND_IMAGE'] = isset($options['site_login_background_image']) ? esc_url($options['site_login_background_image']) : '';
	
	// Cart and Checkout pages
    $GLOBALS['CART_CHECKOUT_REMOVE_TEXT_COLOR'] = isset($options['cart_checkout_remove_text_color']) ? esc_html($options['cart_checkout_remove_text_color']) : '';
    $GLOBALS['CART_CHECKOUT_HAVE_A_COUPON_CODE_TEXT_COLOR'] = isset($options['cart_checkout_have_a_coupon_code_text_color']) ? esc_html($options['cart_checkout_have_a_coupon_code_text_color']) : '';
	
	
	$GLOBALS['EMAIL_TEMPLATE_HEADER_BACKGROUND'] = isset($options['email_template_header_background']) ? esc_html($options['email_template_header_background']) : '';
	$GLOBALS['EMAIL_TEMPLATE_LOGO'] = isset($options['email_template_logo']) ? esc_url($options['email_template_logo']) : '';
	$GLOBALS['EMAIL_TEMPLATE_LOGO_WIDTH'] = isset($options['email_template_logo_width']) ? esc_html($options['email_template_logo_width']) : '';
	$GLOBALS['EMAIL_TEMPLATE_LOGO_HEIGHT'] = isset($options['email_template_logo_height']) ? esc_html($options['email_template_logo_height']) : '';
	$GLOBALS['EMAIL_TEMPLATE_BUTTON_COLOR'] = isset($options['email_template_button_color']) ? esc_html($options['email_template_button_color']) : '';
	$GLOBALS['EMAIL_TEMPLATE_BUTTON_TEXT_COLOR'] = isset($options['email_template_button_text_color']) ? esc_html($options['email_template_button_text_color']) : '';
	$GLOBALS['EMAIL_TEMPLATE_FONT_FAMILY'] = isset($options['email_template_font_family']) ? esc_html($options['email_template_font_family']) : '';

	$GLOBALS['THEME_COLOR'] = isset($options['theme_color']) ? esc_html($options['theme_color']) : '';
	$GLOBALS['BUTTON_TEXT_COLOR'] = isset($options['button_text_color']) ? esc_html($options['button_text_color']) : '';
	$GLOBALS['SITE_TITLE'] = isset($options['site_title']) ? esc_html($options['site_title']) : '';
	$GLOBALS['SITE_LINK'] = isset($options['site_link']) ? esc_html($options['site_link']) : '';
    $GLOBALS['SUPPORT_EMAIL'] = isset($options['support_email']) ? esc_html($options['support_email']) : '';
	$GLOBALS['FAVICON'] = isset($options['favicon']) ? esc_url($options['favicon']) : '';

}
add_action('init', 'init_global_site_settings');

// Shortcode for site title
function shortcode_site_title() {
    return isset($GLOBALS['SITE_TITLE']) ? $GLOBALS['SITE_TITLE'] : '';
}
add_shortcode('website_title', 'shortcode_site_title');

// Shortcode for site link
function shortcode_site_link() {
    return isset($GLOBALS['SITE_LINK']) ? $GLOBALS['SITE_LINK'] : '';
}
add_shortcode('site_link', 'shortcode_site_link');

// Shortcode for support email
function shortcode_support_email() {
    return isset($GLOBALS['SUPPORT_EMAIL']) ? $GLOBALS['SUPPORT_EMAIL'] : '';
}
add_shortcode('support_email', 'shortcode_support_email');


// Change the header logo
function change_header_logo() {
    global $SITE_HEADER_LOGO, $SITE_TITLE;
    ?>
    <style>
		/* initially hide the old logo in desktop view  */
		@media only screen and (min-width: 921px) {
			header img {
				display: none;
			}
		}
		/* initially hide the old logo in mobile view  */
		#ast-mobile-header img {
			display: none;
		}
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
			// show the new logo in desktop view
            let headerLogo = document.querySelector("header img");
            if (headerLogo) {
                headerLogo.src = "<?php echo $SITE_HEADER_LOGO; ?>";
                headerLogo.srcset = "<?php echo $SITE_HEADER_LOGO; ?>";
				headerLogo.alt = "<?php echo esc_js($SITE_TITLE); ?>";
                headerLogo.style.display = "block";
            }
			// show the new logo in mobile view
			let mobileHeaderLogo = document.querySelector("#ast-mobile-header img");
            if (mobileHeaderLogo) {
                mobileHeaderLogo.src = "<?php echo $SITE_HEADER_LOGO; ?>";
                mobileHeaderLogo.srcset = "<?php echo $SITE_HEADER_LOGO; ?>";
				mobileHeaderLogo.alt = "<?php echo esc_js($SITE_TITLE); ?>";
                mobileHeaderLogo.style.display = "block";
            }
        });
    </script>
    <?php
}
add_action('wp_head', 'change_header_logo');


// Change the footer logo
function change_footer_logo() {
    global $SITE_FOOTER_LOGO, $SITE_TITLE;
    ?>
	<style>
        footer img {
            display: none;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let footerLogo = document.querySelector("footer img");
            if (footerLogo) {
                footerLogo.src = "<?php echo $SITE_FOOTER_LOGO; ?>";
                footerLogo.srcset = "<?php echo $SITE_FOOTER_LOGO; ?>";
				footerLogo.alt = "<?php echo esc_js($SITE_TITLE); ?>";
				footerLogo.style.display = "block";
            }
        });
    </script>
    <?php
}
add_action('wp_head', 'change_footer_logo');


// Remove default RSS feed link
remove_action('wp_head', 'feed_links', 2);

// Change the RSS feed title and output the custom link
function change_rss_feed_title() {
    global $SITE_TITLE;

    // Set the dynamic site title
    $dynamic_title = $SITE_TITLE;
    $comments_feed_url = esc_url(get_bloginfo('comments_rss2_url'));

    // Capture the output of get_bloginfo('rss2_url') to construct the <link> tag manually
    $rss_url = esc_url(get_bloginfo('rss2_url'));

    echo '<link rel="alternate" type="application/rss+xml" title="' . esc_attr($dynamic_title) . ' &raquo; Feed' . '" href="' . $rss_url . '" />' . PHP_EOL;

    echo '<link rel="alternate" type="application/rss+xml" title="' . esc_attr($dynamic_title . ' &raquo; Comments Feed') . '" href="' . $comments_feed_url . '" />' . PHP_EOL;

    echo '<meta property="og:site_name" content="' . esc_attr($dynamic_title) . '" />' . PHP_EOL;
}
add_action('wp_head', 'change_rss_feed_title', 1);


// change site title 
add_filter('admin_title', 'custom_admin_title', 10, 2);
function custom_admin_title($admin_title, $title) {
    // Set a custom site title for the admin dashboard
	global $SITE_TITLE;
    return $title . ' - ' . $SITE_TITLE;
}
add_filter('bloginfo', 'custom_bloginfo', 10, 2);
function custom_bloginfo($output, $show) {
	// Set a custom site title for the blog pages
	global $SITE_TITLE;
    if ($show === 'name') {
        $output = $SITE_TITLE;
    }
    return $output;
}
add_action('admin_bar_menu', 'customize_admin_bar_site_title', 999);
function customize_admin_bar_site_title($wp_admin_bar) {
    // Get the existing site title node
    $node = $wp_admin_bar->get_node('site-name');

	global $SITE_TITLE;

    // Update the node with the custom title
    $wp_admin_bar->add_node([
        'id' => 'site-name',
        'title' => $SITE_TITLE,
        'href' => $node->href, // Preserve the link to the front-end
    ]);
}
add_filter('login_title', 'custom_login_page_title', 10, 2);
function custom_login_page_title($login_title, $title) {
    // Customize the title on the login page
	global $SITE_TITLE;
    return "Log In - $SITE_TITLE";
}
function custom_update_site_title() {
	// Set a custom site title in Customize>Site Title & Logo Settings
    global $SITE_TITLE;

    // Update the 'blogname' option with your custom title
    update_option( 'blogname', $SITE_TITLE );
}
add_action( 'init', 'custom_update_site_title' );


// custom global settings
function custom_site_global_variables() {
    global $SITE_HEADER_BACKGROUND, $SITE_HEADER_LINKS_COLOR, $SITE_HEADER_ICONS_COLOR, $THEME_COLOR, $SITE_FOOTER_BACKGROUND, $SITE_FOOTER_LINKS_COLOR, $SITE_HEADER_LOGO_WIDTH, $SITE_HEADER_LOGO_HEIGHT, $SITE_FOOTER_LOGO_WIDTH,$SITE_FOOTER_LOGO_HEIGHT, $SITE_FOOTER_COPYRIGHT_COLOR, $SCROLL_TO_TOP_BUTTON_BACKGROUND, $BUTTON_TEXT_COLOR, $SITE_FOOTER_HORIZONTAL_LINE_COLOR, $CART_CHECKOUT_REMOVE_TEXT_COLOR, $CART_CHECKOUT_HAVE_A_COUPON_CODE_TEXT_COLOR;

    echo '<style>
		/* Header */
		.ast-primary-header-bar {
            background-color: ' . $SITE_HEADER_BACKGROUND . ' !important;
        }
		.ast-builder-menu-3 .menu-item > .menu-link {
			color: ' . $SITE_HEADER_LINKS_COLOR . ' !important;
		}

		[data-section="section-header-mobile-trigger"] .ast-button-wrap .mobile-menu-toggle-icon .ast-mobile-svg {
			fill: ' . $SITE_HEADER_ICONS_COLOR . ' !important;
		}
		.ast-icon-shopping-basket svg {
			fill: ' . $SITE_HEADER_ICONS_COLOR . ' !important;
		}
		header .custom-logo-link img {
			width: ' . $SITE_HEADER_LOGO_WIDTH . ' !important;
			height: ' . $SITE_HEADER_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}

		

		/* Footer */
        .site-primary-footer-wrap[data-section="section-primary-footer-builder"], .site-below-footer-wrap[data-section="section-below-footer-builder"] {
            background-color: ' . $SITE_FOOTER_BACKGROUND . ';
        }
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-4"].footer-widget-area-inner a,
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-3"].footer-widget-area-inner a,
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-2"].footer-widget-area-inner a {
			color: ' . $SITE_FOOTER_LINKS_COLOR . ' !important;
		}
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-2"] h5,
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-3"] h5,
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-4"] h5 {
			color: ' . $SITE_FOOTER_LINKS_COLOR . ' !important;
		}
		footer img {
			width: ' . $SITE_FOOTER_LOGO_WIDTH . ' !important;
			height: ' . $SITE_FOOTER_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}
		footer .ast-builder-grid-row-container-inner .footer-widget-area[data-section="section-fb-divider-1"] .ast-divider-layout-horizontal {
			border-color: ' . $SITE_FOOTER_HORIZONTAL_LINE_COLOR . ' !important;
		}

		/* Home */
		/* Order Now button */
		.elementor-4498 .elementor-element.elementor-element-92644b1 .elementor-button {
			background-color: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}
		/* See more link */
		.elementor-4498 .elementor-element.elementor-element-caef240 .elementor-button,
		.elementor-4498 .elementor-element.elementor-element-0c8926f .elementor-button,
		.elementor-4498 .elementor-element.elementor-element-7db3535 .elementor-button {
			color: ' . $THEME_COLOR . ' !important;
		}

		/* Shop Now button on section 1 */
		.elementor-4498 .elementor-element.elementor-element-cfeee14 .elementor-button {
			background-color: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}

		/* Shop page */
		.woocommerce ul.products li.product .button {
			background-color: ' . $THEME_COLOR . ';
		}
		.woocommerce-js .astra-cart-drawer .astra-cart-drawer-content .woocommerce-mini-cart__buttons .button:not(.checkout):not(.ast-continue-shopping):hover {
			background-color: ' . $THEME_COLOR . ';
		}
		.woocommerce-js .astra-cart-drawer .astra-cart-drawer-content .woocommerce-mini-cart__buttons a.checkout:hover {
			background-color: ' . $THEME_COLOR . ';
		}
		.woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover { 
			background-color: ' . $THEME_COLOR . ';
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}
		.woocommerce ul.products li.product .button, .woocommerce-page ul.products li.product .button {
			background-color: ' . $THEME_COLOR . ';
		}
		.woocommerce ul.products li.product .button:hover, .woocommerce-page ul.products li.product .button:hover {
			background-color: ' . $SITE_HEADER_BACKGROUND . ';
		}

		/* My Account */
		.woocommerce-MyAccount-navigation li.is-active a {
			color: ' . $THEME_COLOR . ' !important;
		}
		.woocommerce-MyAccount-navigation li > a:hover {
			color: ' . $THEME_COLOR . ' !important;
		}

		/* Navigation line color */
		.woocommerce-MyAccount-navigation-link:after {
			background-color: ' . $THEME_COLOR . ' !important;
		}

		.woocommerce-MyAccount-content > p > a {
			color: ' . $THEME_COLOR . ' !important;
		}
		.woocommerce .addresses .title .edit, .woocommerce-account .addresses .title .edit {
			color: ' . $THEME_COLOR . ' !important;
		}
		.ast-modern-woo-account-page .entry-content:before {
			color: ' . $THEME_COLOR . ';
		}
		.woocommerce .button, .woocommerce-page .button {
			background-color: ' . $THEME_COLOR . ' !important;
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}
        .woocommerce-LostPassword.lost_password a {
            color: ' . $THEME_COLOR . ' !important;
        }
			

		/* Footer Links */
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-2"].footer-widget-area-inner a:hover {
			color: ' . $THEME_COLOR . ';
		}
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-3"].footer-widget-area-inner a:hover {
			color: ' . $THEME_COLOR . ';
		}
		.footer-widget-area[data-section="sidebar-widgets-footer-widget-4"].footer-widget-area-inner a:hover {
			color: ' . $THEME_COLOR . ';
		}

		/* Cart Page */
		.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover {
			background-color: ' . $THEME_COLOR . ';
		}
		.woocommerce .woocommerce-cart-form__cart-item .product-name .ast-product-name>a {
			color: ' . $THEME_COLOR . ';
		}
		.woocommerce-shipping-calculator > a {
			color: ' . $THEME_COLOR . ';
		}

		/* Checkout */
		.woocommerce-privacy-policy-text > p > a {
			color: ' . $THEME_COLOR . ';
		}

		/* Cart and Checkout */
		#pwgc-redeem-button:hover {
			background-color: ' . $THEME_COLOR . ';
		}
		.page .entry-header .entry-title {
			color: ' . $THEME_COLOR . ';
		}

		body.woocommerce-cart #pwgc-redeem-gift-card-form label {
			color: ' . $CART_CHECKOUT_HAVE_A_COUPON_CODE_TEXT_COLOR . ' !important;
		}

		body.woocommerce-checkout #pwgc-redeem-gift-card-form label {
			color: ' . $CART_CHECKOUT_HAVE_A_COUPON_CODE_TEXT_COLOR . ' !important;
		}

		.pwgc-remove-card {
			color: ' . $CART_CHECKOUT_REMOVE_TEXT_COLOR . ';
		}

		/* all pages */
		#ast-scroll-top {
			background-color: ' . $SCROLL_TO_TOP_BUTTON_BACKGROUND . ';
			color: ' . $BUTTON_TEXT_COLOR . ' !important;
		}
    </style>';

	echo '<script>
        document.addEventListener("DOMContentLoaded", function() {

			// change the color of Copyright text in footer
			const spans = document.querySelectorAll("footer span");
            spans.forEach(span => {
                if (span.textContent.includes("Copyright")) {
                    span.style.color = "' . $SITE_FOOTER_COPYRIGHT_COLOR . '";
                }
            });
			
        });
	</script>';
}
add_action('wp_head', 'custom_site_global_variables');

// function to replace the favicon
function add_favicon_inline_script() {
    global $FAVICON;
    
    if ($FAVICON) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                let link = document.querySelector("link[rel~=\'icon\']");
                if (!link) {
                    link = document.createElement("link");
                    link.rel = "icon";
                    document.getElementsByTagName("head")[0].appendChild(link);
                }
                link.href = "' . esc_url($FAVICON) . '";
            });
        </script>';
    }
}
add_action('wp_print_scripts', 'add_favicon_inline_script');


// function for login template 1
function login_template1() {
	global $THEME_COLOR, $SITE_LOGIN_BUTTON_COLOR, $SITE_LOGIN_BUTTON_TEXT_COLOR, $SITE_LOGIN_LOGO, $SITE_LOGIN_BACKGROUND, $SITE_LOGIN_BACKGROUND_IMAGE, $SITE_LOGIN_LOGO_WIDTH, $SITE_LOGIN_LOGO_HEIGHT;

	echo '<style type="text/css">
        .ml-container .ml-form-container {
            background-color: ' .$SITE_LOGIN_BACKGROUND. ' !important;
        }
		.login:not(.clc-both-logo) h1 a {
			background-image: url(' .$SITE_LOGIN_LOGO. ') !important;
			width: ' . $SITE_LOGIN_LOGO_WIDTH . ' !important;
			height: ' . $SITE_LOGIN_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}
		.ml-form-container .submit input[type="submit"] {
			background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			border: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			color: ' . $SITE_LOGIN_BUTTON_TEXT_COLOR . ' !important;
		} 
		.ml-form-container .submit input[type="submit"]:hover {
            background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
        }
		.ml-container .ml-extra-div {
			background-image: url(' .$SITE_LOGIN_BACKGROUND_IMAGE. ');
		}
		.login .button.wp-hide-pw .dashicons {
			color: ' . $THEME_COLOR . ' !important;
		}

		@media (max-width: 576px) {
			.ml-container .ml-extra-div {
				background-image: none !important; 
				background-color: ' .$SITE_LOGIN_BACKGROUND. ' !important;
			}
		}
    </style>';
}

// function for login template 2
function login_template2() {
	global $THEME_COLOR, $SITE_LOGIN_BUTTON_COLOR, $SITE_LOGIN_BUTTON_TEXT_COLOR, $SITE_LOGIN_LOGO, $SITE_LOGIN_BACKGROUND, $SITE_LOGIN_BACKGROUND_IMAGE, $SITE_LOGIN_LOGO_WIDTH, $SITE_LOGIN_LOGO_HEIGHT;

	echo '<style type="text/css">
        .ml-container .ml-form-container {
            background-color: ' .$SITE_LOGIN_BACKGROUND. ' !important;
        }
		.login:not(.clc-both-logo) h1 a {
			background-image: url(' .$SITE_LOGIN_LOGO. ') !important;
			width: ' . $SITE_LOGIN_LOGO_WIDTH . ' !important;
			height: ' . $SITE_LOGIN_LOGO_HEIGHT . ' !important;
			max-height: 100% !important;
		}
		.ml-form-container .submit input[type="submit"] {
			background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			border: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
			color: ' . $SITE_LOGIN_BUTTON_TEXT_COLOR . ' !important;
		} 
		.ml-form-container .submit input[type="submit"]:hover {
            background-color: ' . $SITE_LOGIN_BUTTON_COLOR . ' !important;
        }
		.ml-container .ml-extra-div {
			background-image: url(' .$SITE_LOGIN_BACKGROUND_IMAGE. ');
		}
		.login .button.wp-hide-pw .dashicons {
			color: ' . $THEME_COLOR . ' !important;
		}

		@media (max-width: 576px) {
			.ml-container .ml-extra-div {
				background-image: none !important; 
				background-color: ' .$SITE_LOGIN_BACKGROUND. ' !important;
			}
		}

		/* reverse the position of login form */
		.ml-container .ml-extra-div {
			order: 2
		}
		.ml-container .ml-form-container {
			order: 1
		}
		#loginform {
			position: relative;
			padding: 120px 24px 46px 24px;
			height: 380px !important;
		}
		#login h1 {
			position: absolute;
			top: 50px;
			left: 50%;
			transform: translateX(-50%);
			z-index: 1;
		}
		.login .notice {
			margin-top: -75px;
		}
    </style>';
}

// Function to switch login templates
function switch_login_template() {
	$options = get_option('global_site_settings');
    $template = isset($options['site_login_template']) ? $options['site_login_template'] : '1';

    if ($template == '1') {
        login_template1();
    } 
	else {
        login_template2();
    }
}
add_action('login_enqueue_scripts', 'switch_login_template');



/**
 * credentials function - this is from woocommerce rest api 
 * generate a new one for new site
 */
function creds() {
	global $SITE_TITLE;

	return array(
		'username' => 'ck_fdf3c5c09d2e2f6a83145492a60fc4204cb0e3b2',
		'password' => 'cs_f1d9b0792450f1bd51631b8b5f1634fee7be59ff',
		'domain_name' => $SITE_TITLE,
		'base_url' => str_replace(array('https://', 'http://', 'www'), array('', '', ''), get_base_url())
	);
}


/**
 * Bypass Force Login to allow for exceptions.
 *
 * @param bool $bypass Whether to disable Force Login. Default false.
 * @param string $visited_url The visited URL.
 * @return bool
 */
function my_forcelogin_bypass( $bypass, $visited_url ) {

	// Allow 'My Page' to be publicly accessible
	if ( is_page(array(4392, 6808, 6821,'my-account', 'my-account-lost-password')) ) {
		$bypass = true;
	}

	if (strpos($_SERVER['REQUEST_URI'], '/wp-json/wp/v2/users/register') != "") {
		$bypass = true;
	} 

	if (strpos($_SERVER['REQUEST_URI'], '/wp-json/wp/v2/customer/rebill') != "") {
		$bypass = true;
	} 

	return $bypass;
}
add_filter( 'v_forcelogin_bypass', 'my_forcelogin_bypass', 10, 2 );


/**
 * ADD NEW USER COLUMN FOR ACTIVE STATUS
 */
function new_active_status( $active_status ) {
    $active_status['active_status'] = 'Active Status';
    return $active_status;
}
add_filter( 'user_contactmethods', 'new_active_status', 10, 1 );


function new_modify_user_table( $column ) {
    $column['active_status'] = 'Active Status';
	if (isset($column['posts'])) unset($column['posts']);
	if (isset($column['locked'])) unset($column['locked']);
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'active_status' :
            return get_user_meta($user_id, 'active_status', true) == "1" ? "Active" : "Inactive";
            // return get_user_meta($user_id, 'active_status', true);
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );

/**
 * POSTBACK ENDPOINTS
 */

add_action( 'rest_api_init', function () {
	register_rest_route( 'wp/v2', '/customer/rebill', array(
		'methods'  => 'POST',
		'callback' => 'customer_rebill',
		'permission_callback' => '__return_true',
	) );
} );

function customer_rebill($request) {
	$reponseCode = 200;
	$response = array();
	$parameters = $request->get_params();
	
	$isActive = sanitize_text_field($parameters['is_active']);
	$email = sanitize_text_field($parameters['email']);

	//auth checking
	if (auth_checking() === false) {
		$reponseCode = 401;
		$response['code'] = 401;
		$response['message'] = __("Unauthorized", 'wp-rest-user');
		return new WP_REST_Response($response, $reponseCode);
	}

	if (empty($email)) {
		$reponseCode = 400;
		$response['code'] = 400;
		$response['message'] = __("Email field 'email' is required.", 'wp-rest-user');
		return new WP_REST_Response($response, $reponseCode);
	}

	if ((isset($email) && $email != "") && (isset($isActive) && $isActive != "")) {
		$user = get_user_by_email($email);
		if (empty($user)) {
			$reponseCode = 400;
			$response['code'] = 400;
			$response['message'] = __("Invalid email please try a new email", 'wp-rest-user');
			return new WP_REST_Response($response, $reponseCode);
		}

		$userId = $user->get('ID');
 
		if (isset($userId) && $userId != "") {
			$giftCardNumber = get_user_meta($userId, 'gift_card_id', true); // true = string
			$getGiftCardDetails = get_customer_gift_card(get_base_url(), $giftCardNumber);
			$getGiftCardId = $getGiftCardDetails[0]->pimwick_gift_card_id;

			// $balance = $isActive ? "125" : "0";
			// $note = $isActive ? "status : active rebill" : "status : inactive rebill";

			
			if ($isActive == "1") {
				// unlock the customer
				delete_user_meta($userId, 'baba_user_locked');
				update_user_meta($userId, 'active_status', '1');

				$balance = "125";
				$note = "status : active rebill";
				
				$updateGiftCardDetails = update_customer_gift_card(get_base_url(), $getGiftCardId, $balance, $note);
			} elseif ($isActive == "0") {
				// lock the customer
				add_user_meta($userId, 'baba_user_locked', 'yes');
				delete_user_meta($userId, 'active_status');
			}

			$response['code'] = 200;
			$response['message'] = __("User '" . $email . "' update rebill was Successful", "wp-rest-user");


			/*if (empty($updateGiftCardDetails) || $updateGiftCardDetails == "") {
				// add meta field for active status
				$reponseCode = 400;
				$response['code'] = 400;
				$response['message'] = __("Unsuccessful to update this gift card details.", 'wp-rest-user');
			} else {
				add_user_meta($userId, 'active_status', $isActive, true);
				$response['code'] = 200;
				$response['message'] = __("User '" . $email . "' update rebill was Successful", "wp-rest-user");
			}*/
		} else {
			$reponseCode = 400;
			$response['code'] = 400;
			$response['message'] = __("Can't find the user ID", 'wp-rest-user');
		}
	} else {
		$reponseCode = 400;
		$response['code'] = 400;
		$response['message'] = __("Parameter mismatch", 'wp-rest-user');
	}

	return new WP_REST_Response($response, $reponseCode);
}

add_action( 'rest_api_init', function () {
	register_rest_route('wp/v2', 'users/register', array(
		'methods' => 'POST',
		'callback' => 'wc_rest_user_endpoint_handler',
		'permission_callback' => '__return_true'
	));
} );

function wc_rest_user_endpoint_handler($request = null) {
	$reponseCode = 200;
	$response = array();
	$parameters = $request->get_params();
	
	$username = sanitize_text_field($parameters['email']); // use email as username
	$firstname = sanitize_text_field($parameters['firstname']);
	$lastname = sanitize_text_field($parameters['lastname']);
	$email = sanitize_text_field($parameters['email']);
	$order_id = sanitize_text_field($parameters['order_id']);
	$limit = sanitize_text_field($parameters['limit']);

	//shipping address
	$shippingDetails = array(
		'shipping_first_name' => $firstname,
		'shipping_last_name' => $lastname,
		'shipping_phone' => sanitize_text_field($parameters['phone']),
		'shipping_city' => sanitize_text_field($parameters['shippingCity']),
		'shipping_state' => sanitize_text_field($parameters['shippingState']),
		'shipping_country' => sanitize_text_field($parameters['shippingCountry']),
		'shipping_address_1' => sanitize_text_field($parameters['address']),
		'shipping_postcode' => sanitize_text_field($parameters['zipcode'])
	);

	$password = getRandomString(12);

	$emailArr = explode("@", $email);

	//auth checking
	if (auth_checking() === false) {
		$reponseCode = 401;
		$response['code'] = 401;
		$response['message'] = __("Unauthorized", 'wp-rest-user');
		return new WP_REST_Response($response, $reponseCode);
	}
	

	if (isset($limit) && $limit != "") {
		for($i = 1; $i <= $limit; $i++) {
			$usernameLoop  = $username.''.$i;
			$email     = $emailArr[0] . $i . "@" . $emailArr[1];
			$resSingle = register_user($usernameLoop, $firstname, $lastname, $email, $password, $order_id, $shippingDetails);
			if ($resSingle['code'] != 200) $reponseCode = $resSingle['code'];
			$response[] = $resSingle;
		}
	} else {
		$resSingle = register_user($username, $firstname, $lastname, $email, $password, $order_id, $shippingDetails);
		if ($resSingle['code'] != 200) $reponseCode = $resSingle['code'];
		$response[] = $resSingle;
	}

	return new WP_REST_Response($response, $reponseCode);
}

function register_user($username, $firstname, $lastname, $email, $password, $order_id, $shippingDetails) {
	$response = array();
	$error = new WP_Error();

	if (empty($username)) {
		$response['code'] = 400;
		$response['message'] = __("Username field is required.", "wp-rest-user");
		return $response;
	}
	if (empty($email)) {
		$response['code'] = 400;
		$response['message'] = __("Email field is required.", 'wp-rest-user');
		return $response;
	} else {
		if (!is_email($email)) {
			$response['code'] = 400;
			$response['message'] = __("Email field is invalid.", 'wp-rest-user');
			return $response;
		}
	}

	$user_id = username_exists($username);

	if (!$user_id && email_exists($email) == false) {
		$user_id = wp_create_user($username, $password, $email);
		if (!is_wp_error($user_id)) {
			// Ger User Meta Data (Sensitive, Password included. DO NOT pass to front end.)
			$user = get_user_by('id', $user_id);
			$user->set_role('customer');
			
			// generate gift card
			$giftCard = customer_gift_card(get_base_url(), $email);

			$emailConfirmationSub = "Customer Account Confirmation";
			$emailCouponSub = "Your Coupon Code Details";
			$giftCardNumber = $giftCard[0]->gift_card->number;

			// add user meta data
			add_user_meta($user_id, 'gift_card_id', $giftCardNumber, true);
			add_user_meta($user_id, 'order_id', $order_id, true);
			add_user_meta($user_id, 'active_status', "1", true);
			
			// send email for coupon details
			customer_account_coupon_email($emailCouponSub, $firstname, $lastname, get_base_url(), $giftCardNumber, $email, $password);


			$postFields = array('discount_type' => 'fixed_cart',
			'amount' => '125',
			'email_restrictions' => $email,
			'code' => $giftCardNumber,
			'description' => 'Coupon for '. $firstname . ' '. $lastname . ' - ' .$email);
			
			// generate coupon 
			// customer_account_coupon_generation(get_base_url(), $postFields);

			wp_update_user([
				'ID' => $user_id, // this is the ID of the user you want to update.
				'first_name' => $firstname,
				'last_name' => $lastname,
			]);

			// update shipping address
			foreach ($shippingDetails as $meta_key => $meta_value ) {
				update_user_meta( $user_id, $meta_key, $meta_value );
			}

			// WooCommerce specific code
			if (class_exists('WooCommerce')) {
				$user->set_role('customer');
			}
			// Ger User Data (Non-Sensitive, Pass to front end.)
			$response['code'] = 200;
			$response['message'] = __("User '" . $username . "' Registration was Successful", "wp-rest-user");
		}
	} else {
		$response['code'] = 400;
		$response['message'] = __("Email already exists, please try 'Reset Password'", 'wp-rest-user');
		// $error->add(406, __("Email already exists, please try 'Reset Password'", 'wp-rest-user'), array('status' => 400));
		return $response;
	}

	return $response;
	// return new WP_REST_Response($response, 123);
}


function customer_account_coupon_email($subject, $firstname, $lastname, $baseUrl, $giftCard, $email, $password) {
	$domainName = creds()['domain_name'];

	global $EMAIL_TEMPLATE_LOGO, $EMAIL_TEMPLATE_LOGO_WIDTH, $EMAIL_TEMPLATE_LOGO_HEIGHT, $EMAIL_TEMPLATE_HEADER_BACKGROUND, $EMAIL_TEMPLATE_BUTTON_COLOR, $EMAIL_TEMPLATE_BUTTON_TEXT_COLOR, $EMAIL_TEMPLATE_FONT_FAMILY, $SUPPORT_EMAIL;

	// <strong>Login URL</strong>: <a href='$baseUrl/shop/?pw_gift_card_number=$giftCard'>$baseUrl/shop/?pw_gift_card_number=$giftCard</a></p>
	
	$html = "
		<div style='margin:0 auto; max-width: 500px;font-family: $EMAIL_TEMPLATE_FONT_FAMILY;'>
			<div style='
				margin-left: auto;
				margin-right: auto;
				padding: 10px 10px;
				background-color: $EMAIL_TEMPLATE_HEADER_BACKGROUND;
				margin-bottom: 30px;
			'>
			<center><img src='$EMAIL_TEMPLATE_LOGO' style='
				margin-left: auto;
				margin-right: auto;
				padding:15px 0 8px;
				width: $EMAIL_TEMPLATE_LOGO_WIDTH;
				height: $EMAIL_TEMPLATE_LOGO_HEIGHT;
				max-height: 100% !important;
			'></center></div>
			<p style='margin-bottom:20px;font-size:18px;font-weight:700;text-align:center'>Welcome to <span style='text-transform:uppercase;'>$domainName</span></p>
			<br>
			<p style='font-size: 14px;'>Hi <strong>$firstname $lastname</strong>,</p>
			<p style='font-size: 14px;'>You've activated your customer account. Here are your login details to use a $125 Coupon Code on $domainName, the #1 online store for consumer gadgets, health and wellness goods and so much more!</p>
			<p style='font-size: 14px; margin-bottom: 0;'>
			<strong>Login URL</strong>: <a style='color: blue' href='$baseUrl/login'>$baseUrl/login</a></p>
			</p>
			<p style='font-size: 14px; margin: 0;'>
			<strong>Coupon Code</strong>: $giftCard
			</p>
			<p style='font-size: 14px; margin: 0;'>
			<strong>Email</strong>: <a style='color: blue' href='mailto:$email'>$email</a>
			</p>
			<p style='font-size: 14px; margin: 0;'>
			<strong>Password</strong>: $password
			</p>
			<p style='font-size: 12px;margin-top: 2em;text-align: justify;'>To use your Coupon Code, add the items you want to purchase to your shopping cart and checkout. Then enter your code in the 'Coupon Code' field on the first page of checkout.</p>
			<br>
			<a href='$baseUrl' style='
				color: $EMAIL_TEMPLATE_BUTTON_TEXT_COLOR;
				background-color: $EMAIL_TEMPLATE_BUTTON_COLOR;
				border-color: $EMAIL_TEMPLATE_BUTTON_COLOR;
				display: inline-block;
				text-align: center;
				white-space: nowrap;
				vertical-align: middle;
				border: 1px solid transparent;
				padding: 8px 25px;
				font-weight: 900;
				font-size: 1rem;
				line-height: 1.5;
				border-radius: .25rem;
				text-decoration: none;
				transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
		'>Visit Our Store</a>
			<br>
			<br>
			<p style='font-size: 14px;'>If you have any questions, reply to this email or contact us at <a style='color: blue' href='mailto:$SUPPORT_EMAIL'>$SUPPORT_EMAIL</a>
				</p>
			<p style='font-size: 14px;'>Good luck! Enjoy shopping at $domainName.</p>
		</div>
	";

	return wp_mail($email, $subject, $html, email_headers());
}


/**
 * Instraction: change Reply-To based on the email reply availble per site
 */
function email_headers() {
	global $SITE_TITLE, $SUPPORT_EMAIL;

	$headers = array(
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: $SITE_TITLE <$SUPPORT_EMAIL>"
    );

	return $headers;
}
/**
 * Instraction: generate woocommerce API KEY and change the authorization
 */
function customer_account_coupon_generation($baseUrl, $postFields) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => $baseUrl.'/wp-json/wc/v3/coupons',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	// CURLOPT_POSTFIELDS => array('discount_type' => 'fixed_cart','amount' => '125','email_restrictions' => 'customer@gmail.com','code' => 'abcd123test','description' => ''),
	CURLOPT_POSTFIELDS => $postFields,
	CURLOPT_HTTPHEADER => array(
		'Authorization: Basic Y2tfNWYxZjYxNjZlMWFhYzdkZWFhOTExN2MzODhkZWNkOTllNWQ5Y2YwNTpjc18zYmFjOWU5NjZkZWY0Y2JmZTcyMjkwNDY1MGRmNzI5YTI3YTRlNzUz'
	),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return json_decode($response);
}

function customer_gift_card($baseUrl, $email) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => $baseUrl.'/wp-json/wc-pimwick/v1/pw-gift-cards',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_USERPWD => creds()['username'] . ":" . creds()['password'],
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS =>'{
		"recipient_email": "'.$email.'",
		"sender": "Awesome Sender",
		"amount": 125,
		"balance": 125,
		"note": "Gift card for '.$email.'",
		"send_email": false,
		"from": "'.$_SERVER['HTTP_HOST'].'"
	}',
	CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		// 'Authorization: Basic Y2tfNWYxZjYxNjZlMWFhYzdkZWFhOTExN2MzODhkZWNkOTllNWQ5Y2YwNTpjc18zYmFjOWU5NjZkZWY0Y2JmZTcyMjkwNDY1MGRmNzI5YTI3YTRlNzUz'
	),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	// echo $response;
	return json_decode($response);
}

function update_customer_gift_card($baseUrl, $getGiftCardId, $balance, $note) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => $baseUrl.'/wp-json/wc-pimwick/v1/pw-gift-cards/'.$getGiftCardId,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_USERPWD => creds()['username'] . ":" . creds()['password'],
	CURLOPT_CUSTOMREQUEST => 'PATCH',
	CURLOPT_POSTFIELDS =>'{
		"amount": "'.$balance.'",
		"balance": "'.$balance.'",
		"note": "'.$note.'"
	}',
	CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		// 'Authorization: Basic Y2tfNWYxZjYxNjZlMWFhYzdkZWFhOTExN2MzODhkZWNkOTllNWQ5Y2YwNTpjc18zYmFjOWU5NjZkZWY0Y2JmZTcyMjkwNDY1MGRmNzI5YTI3YTRlNzUz'
	),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	// echo $response;
	return json_decode($response);
}

function get_customer_gift_card($baseUrl, $cardNumber) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	CURLOPT_URL => $baseUrl.'/wp-json/wc-pimwick/v1/pw-gift-cards?number='.$cardNumber,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_USERPWD => creds()['username'] . ":" . creds()['password'],
	CURLOPT_CUSTOMREQUEST => 'GET',
	CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		// 'Authorization: Basic Y2tfNWYxZjYxNjZlMWFhYzdkZWFhOTExN2MzODhkZWNkOTllNWQ5Y2YwNTpjc18zYmFjOWU5NjZkZWY0Y2JmZTcyMjkwNDY1MGRmNzI5YTI3YTRlNzUz'
	),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	// echo $response;
	return json_decode($response);
}

function getRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function get_base_url() {
	$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] 
                === 'on' ? "https" : "http") . 
                "://" . $_SERVER['HTTP_HOST'];

	return $link;
}

// Make Disable/Read only by customer on some fields in My Account > Account details page
function add_readonly_to_display_name_field() {
    if (is_account_page()) {
        $user = wp_get_current_user();
        
        // Check if the user has the 'customer' role
        if (in_array('customer', $user->roles)) {
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $('#account_display_name').prop('readonly', true);
                    $('#account_last_name').prop('readonly', true);
                    $('#account_first_name').prop('readonly', true);
                    $('#account_email').prop('readonly', true);
                });
            </script>
            <?php
        }
    }
}
add_action('wp_footer', 'add_readonly_to_display_name_field');

// redirect the admin to dashboard after login
function redirect_to_dashboard() {
    // Check if the user is an administrator
    if (current_user_can('administrator')) {
        // Redirect to the admin dashboard
        wp_redirect(admin_url());
        exit;
    }
}
add_action('wp_login', 'redirect_to_dashboard');

function auth_checking() {
	$final_username = "dsfadminuser";
	$final_password = "PO3rOE2h4K";

	$server_username = $_SERVER['PHP_AUTH_USER'];
	$server_password = $_SERVER['PHP_AUTH_PW'];

	if ($final_username != $server_username || $final_password != $server_password) {
		return false;
	}

	return true;
}


function dump_now($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}