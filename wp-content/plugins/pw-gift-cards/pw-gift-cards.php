<?php
/**
 * Plugin Name: PW WooCommerce Gift Cards Pro
 * Plugin URI: https://www.pimwick.com/gift-cards/
 * Description: Sell gift cards in your WooCommerce store.
 * Version: 1.376
 * Author: Pimwick, LLC
 * Author URI: https://www.pimwick.com
 * Text Domain: pw-woocommerce-gift-cards
 * Domain Path: /languages
 * WC requires at least: 3.2.0
 * WC tested up to: 6.4
*/
define( 'PWGC_VERSION', '1.376' );

defined( 'ABSPATH' ) or exit;

if ( !function_exists( 'pimwick_define' ) ) :
function pimwick_define( $constant_name, $default_value ) {
    defined( $constant_name ) or define( $constant_name, $default_value );
}
endif;

pimwick_define( 'PWGC_REQUIRES_PRIVILEGE', 'manage_woocommerce' );
pimwick_define( 'PWGC_PRODUCT_NAME', 'PW WooCommerce Gift Cards Pro' );
pimwick_define( 'PWGC_PRODUCT_TYPE_SLUG', 'pw-gift-card' );
pimwick_define( 'PWGC_PRODUCT_TYPE_NAME', 'PW Gift Card' );
pimwick_define( 'PWGC_SESSION_KEY', 'pw-gift-card-data' );
pimwick_define( 'PWGC_WC_VERSION_MINIMUM', '3.2.0' );
pimwick_define( 'PWGC_FONT_AWESOME_VERSION', '5.0.10' );
pimwick_define( 'PWGC_PURCHASE_TAX_STATUS', 'none' ); // No tax when purchasing a gift card. Taxed when used.
pimwick_define( 'PWGC_MAX_MESSAGE_CHARACTERS', 500 );
pimwick_define( 'PWGC_RECIPIENT_LIMIT', 999 ); // Sanity check. Use -1 for no limit.
pimwick_define( 'PWGC_PLUGIN_FILE', __FILE__ );
pimwick_define( 'PWGC_PLUGIN_ROOT', plugin_dir_path( PWGC_PLUGIN_FILE ) );
pimwick_define( 'PWGC_RANDOM_CARD_NUMBER_SECTIONS', '4' );
pimwick_define( 'PWGC_RANDOM_CARD_NUMBER_SECTION_LENGTH', '4' );
pimwick_define( 'PWGC_RANDOM_CARD_NUMBER_CHARSET', 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789' );
pimwick_define( 'PWGC_DENOMINATION_ATTRIBUTE_SLUG', 'gift-card-amount' );
pimwick_define( 'PWGC_GIFT_CARD_NUMBER_META_KEY', 'pw_gift_card_number' );
pimwick_define( 'PWGC_RELOAD_GIFT_CARD_NUMBER_META_KEY', 'pw_gift_card_reload_number' );
pimwick_define( 'PWGC_RELOAD_GIFT_CARD_RELOADED_META_KEY', '_pw_gift_card_number_reloaded' );
pimwick_define( 'PWGC_AMOUNT_META_KEY', 'pw_gift_card_amount' );
pimwick_define( 'PWGC_TO_META_KEY', 'pw_gift_card_to' );
pimwick_define( 'PWGC_RECIPIENT_NAME_META_KEY', 'pw_gift_card_recipient_name' );
pimwick_define( 'PWGC_FROM_META_KEY', 'pw_gift_card_from' );
pimwick_define( 'PWGC_MESSAGE_META_KEY', 'pw_gift_card_message' );
pimwick_define( 'PWGC_DELIVERY_DATE_META_KEY', 'pw_gift_card_delivery_date' );
pimwick_define( 'PWGC_BONUS_AMOUNT_META_KEY', 'pw_gift_card_bonus_amount' );
pimwick_define( 'PWGC_BONUS_RECIPIENT_META_KEY', '_pw_gift_card_bonus_recipient' );
pimwick_define( 'PWGC_EMAIL_DESIGN_ID_META_KEY', 'pw_gift_card_email_design_id' );
pimwick_define( 'PWGC_GIFT_CARD_NOTIFICATIONS_META_KEY', '_pw_gift_cards_notifications' );
pimwick_define( 'PWGC_GIFT_CARD_CUSTOM_AMOUNT_META_KEY', 'pw_gift_cards_custom_amount' );
pimwick_define( 'PWGC_BALANCE_SHORTCODE', 'pw_gift_cards_balance' );
pimwick_define( 'PWGC_DELIVERY_PENDING_META_KEY', '_pw_gift_cards_delivery_pending' );
pimwick_define( 'PWGC_UTF8_SEARCH', true );
pimwick_define( 'PWGC_MULTISITE_SHARED_DATABASE', false );
pimwick_define( 'PWGC_ADMIN_MAX_ROWS', 500 );
pimwick_define( 'PWGC_FORCE_PLUGIN_I18N', false );
pimwick_define( 'PWGC_SORT_VARIATIONS', true );
pimwick_define( 'PWGC_HIDE_AMOUNT_META', true );
pimwick_define( 'PWGC_SHOW_PDF_IN_FRONTEND_PREVIEW', false );
pimwick_define( 'PWGC_SHOW_GIFT_CARD_APPLIED_MESSAGE_FROM_REDEEM_BUTTON', true );
pimwick_define( 'PWGC_SEND_HEADERS_PRIORITY', 1 );

final class PW_Gift_Cards {

    public $gift_card_meta;
    public $ignore_autocomplete_payment_methods;

    function __construct() {
        require_once( 'includes/pwgc-functions.php' );

        pwgc_set_table_names();

        require_once( 'includes/pwgc-database.php' );
        require_once( 'includes/class-pw-gift-card.php' );
        require_once( 'includes/class-pw-gift-card-activity.php' );
        require_once( 'includes/class-pw-gift-card-item-data.php' );
        require_once( 'includes/pw-gift-cards-email-designer.php' );
        require_once( 'includes/pw-gift-cards-email-manager.php' );

        register_activation_hook( PWGC_PLUGIN_FILE, array( $this, 'plugin_activate' ) );
        register_deactivation_hook( PWGC_PLUGIN_FILE, array( $this, 'plugin_deactivate' ) );

        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
        add_action( 'woocommerce_init', array( $this, 'woocommerce_init' ) );

        if ( PWGC_FORCE_PLUGIN_I18N ) {
            add_filter( 'load_textdomain_mofile', array( $this, 'load_textdomain_mofile' ), 10, 2 );
        }
    }

    function plugins_loaded() {
        load_plugin_textdomain( 'pw-woocommerce-gift-cards', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

    function load_textdomain_mofile( $mofile, $domain ) {
        if ( 'pw-woocommerce-gift-cards' == $domain ) {
            if ( dirname( $mofile ) != dirname( __FILE__ ) . '/languages' ) {
                return false;
            }
        }

        return $mofile;
    }

    function woocommerce_init() {
        // Show an alert on the backend if we don't have the minimum required version.
        if ( is_admin() && !$this->wc_min_version( PWGC_WC_VERSION_MINIMUM ) ) {
            add_action( 'admin_notices', array( $this, 'woocommerce_version_error' ) );
            return;
        }

        // TODO - make this a setting on the front end.
        $this->ignore_autocomplete_payment_methods = apply_filters( 'pwgc_ignore_autocomplete_payment_methods', array( 'bacs', 'cod' ) );

        $other_amount_prompt = __( 'Other amount', 'pw-woocommerce-gift-cards' );
        if ( defined( 'POLYLANG' ) || isset( $GLOBALS['sitepress'] ) ) {
            // For Polylang and WPML we don't want to translate first since it translates later in the stack.
            $other_amount_prompt = 'Other amount';
        }

        pimwick_define( 'PWGC_DENOMINATION_ATTRIBUTE_NAME', __( 'Gift Card Amount', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_OTHER_AMOUNT_PROMPT', $other_amount_prompt );
        pimwick_define( 'PWGC_GIFT_CARD_NUMBER_META_DISPLAY_NAME', __( 'Gift Card', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_BONUS_GIFT_CARD_NUMBER_META_DISPLAY_NAME', __( 'Gift Card', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_RELOAD_GIFT_CARD_NUMBER_META_DISPLAY_NAME', __( 'Adding to Gift Card', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_RELOAD_GIFT_CARD_RELOADED_DISPLAY_NAME', __( 'Reloaded', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_AMOUNT_META_DISPLAY_NAME', __( 'Amount', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_TO_META_DISPLAY_NAME', __( 'To', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_RECIPIENT_NAME_META_DISPLAY_NAME', __( 'Recipient', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_FROM_META_DISPLAY_NAME', __( 'From', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_MESSAGE_META_DISPLAY_NAME', __( 'Message', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_DELIVERY_DATE_META_DISPLAY_NAME', __( 'Delivery Date', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_BONUS_AMOUNT_META_DISPLAY_NAME', __( 'Bonus Amount', 'pw-woocommerce-gift-cards' ) );
        pimwick_define( 'PWGC_EMAIL_DESIGN_META_DISPLAY_NAME', __( 'Email Design', 'pw-woocommerce-gift-cards' ) );

        $this->gift_card_meta = apply_filters( 'pwgc_gift_card_meta', array(
            PWGC_RELOAD_GIFT_CARD_NUMBER_META_KEY   => PWGC_RELOAD_GIFT_CARD_NUMBER_META_DISPLAY_NAME,
            PWGC_AMOUNT_META_KEY                    => PWGC_AMOUNT_META_DISPLAY_NAME,
            PWGC_TO_META_KEY                        => PWGC_TO_META_DISPLAY_NAME,
            PWGC_RECIPIENT_NAME_META_KEY            => PWGC_RECIPIENT_NAME_META_DISPLAY_NAME,
            PWGC_FROM_META_KEY                      => PWGC_FROM_META_DISPLAY_NAME,
            PWGC_MESSAGE_META_KEY                   => PWGC_MESSAGE_META_DISPLAY_NAME,
            PWGC_DELIVERY_DATE_META_KEY             => PWGC_DELIVERY_DATE_META_DISPLAY_NAME,
            PWGC_EMAIL_DESIGN_ID_META_KEY           => PWGC_EMAIL_DESIGN_META_DISPLAY_NAME,
        ) );

        require_once( 'includes/pw-gift-cards-purchasing.php' );
        require_once( 'includes/pw-gift-cards-redeeming.php' );
        require_once( 'includes/pw-gift-cards-shortcodes.php' );
        require_once( 'includes/class-wc-product-pw-gift-card.php' );
        require_once( 'includes/class-wc-order-item-pw-gift-card.php' );
        require_once( 'includes/data-stores/class-wc-order-item-pw-gift-card-data-store.php' );

        if ( is_admin() ) {
            require_once( 'includes/class-pimwick-license-manager.php' );
            $this->license = new Pimwick_License_Manager( __FILE__ );

            require_once( 'admin/pw-gift-cards-admin.php' );
        }

        add_filter( 'script_loader_tag', array( $this, 'defer_scripts' ), 10, 3 );
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
        add_filter( 'woocommerce_hidden_order_itemmeta', array( $this, 'woocommerce_hidden_order_itemmeta' ) );
        add_filter( 'woocommerce_attribute_label', array( $this, 'woocommerce_attribute_label' ), 10, 3 );
        add_action( 'woocommerce_before_order_item_line_item_html', array( $this, 'woocommerce_before_order_item_line_item_html' ) );
        add_action( 'woocommerce_order_item_line_item_html', array( $this, 'woocommerce_order_item_line_item_html' ) );
        add_action( 'woocommerce_payment_complete', array( $this, 'maybe_mark_order_completed' ) );
        add_action( 'wcml_is_variable_product', array( $this, 'wcml_is_variable_product' ), 10, 2 );
        add_action( 'pw_gift_cards_delivery', array( $this, 'deliver_scheduled_gift_cards' ) );
        add_filter( 'woocommerce_order_data_store_cpt_get_orders_query', array( $this, 'handle_custom_query_var' ), 10, 2 );
        add_filter( 'pwgc_to_current_currency', array( $this, 'pwgc_to_current_currency' ) );
        add_filter( 'pwgc_to_default_currency', array( $this, 'pwgc_to_default_currency' ) );
        add_filter( 'pwgc_to_order_currency', array( $this, 'pwgc_to_order_currency' ), 10, 2 );
        add_filter( 'wcumcs_custom_item_price_final', array( $this, 'wcumcs_custom_item_price_final' ), 10, 3 );
        add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );

        if ( isset( $_REQUEST['pwgc_number'] ) ) {
            // Price Based on Country for WooCommerce by Oscar Gare
            if ( class_exists( 'WCPBC_Pricing_Zones' ) ) {
                add_filter( 'wc_price_based_country_stop_pricing', '__return_true' );
            }

            add_action( 'send_headers', array( $this, 'output_gift_card' ), PWGC_SEND_HEADERS_PRIORITY );
        }

        if ( isset( $_REQUEST['pwgc_export'] ) ) {
            global $pw_gift_cards_admin;
            if ( !isset( $pw_gift_cards_admin ) ) {
                require_once( 'admin/pw-gift-cards-admin.php' );
            }

            add_action( 'send_headers', array( $pw_gift_cards_admin, 'export_gift_card' ), PWGC_SEND_HEADERS_PRIORITY );
        }

        // Fix for a bug with the Antive Toolkit plugin used by some themes.
        add_filter( 'antive_toolkit_variation_attribute_options', array( $this, 'antive_toolkit_variation_attribute_options' ), 10, 3 );

        // Fixes a compatibility issue with the WooCommerce Availability Scheduler plugin by vanquish - https://codecanyon.net/item/woocommerce-availability-scheduler/11649604
        if ( class_exists( 'WAS_Remover' ) ) {
            add_action( 'woocommerce_before_single_product_summary', array( $this, 'woocommerce_availability_scheduler_fix' ) );
        }

        // Fixes compatibility issue with the Variation Swatches for WooCommerce plugin by Emran Ahmed.
        add_filter( 'default_wvs_variation_attribute_options_html', array( $this, 'default_wvs_variation_attribute_options_html' ), 10, 3 );

        if ( isset( $_GET['pw_gift_card_number'] ) ) {
            global $pw_gift_cards_redeeming;

            $card_number = wc_clean( $_GET['pw_gift_card_number'] );

            $result = $pw_gift_cards_redeeming->add_gift_card_to_session( $card_number );
            if ( $result === true ) {
                $gift_card = new PW_Gift_Card( $card_number );
                if ( $gift_card->get_balance() <= 0 ) {
                    wc_add_notice( __( 'This gift card has a zero balance.', 'pw-woocommerce-gift-cards' ), 'notice' );
                }

                if ( apply_filters( 'pwgc_show_gift_card_applied_message', PWGC_SHOW_GIFT_CARD_APPLIED_MESSAGE_FROM_REDEEM_BUTTON, $gift_card ) ) {
                    wc_add_notice( __( 'Gift card applied.', 'pw-woocommerce-gift-cards' ) );
                }
            } else {
                wc_add_notice( $result, 'error' );
            }
        }

        $next_scheduled = wp_next_scheduled( 'pw_gift_cards_delivery' );
        if ( 'yes' === get_option( 'pwgc_allow_scheduled_delivery', 'yes' ) ) {

            // This will cause the scheduler to fire on every page load. Don't uncomment this unless you are troubleshooting since it can hurt performance.
            // if ( $next_scheduled ) {
            //     wp_unschedule_event( $next_scheduled, 'pw_gift_cards_delivery' );
            //     $next_scheduled = false;
            // }

            if ( !$next_scheduled ) {
                $scheduled_time = apply_filters( 'pwgc_scheduled_start_time', pwgc_strtotime( 'today midnight' ) );
                wp_schedule_event( $scheduled_time, 'daily', 'pw_gift_cards_delivery' );
            }
        } else if ( $next_scheduled ) {
            wp_unschedule_event( $next_scheduled, 'pw_gift_cards_delivery' );
        }
    }

    function wp_enqueue_scripts() {
        global $post;

        $prerequisites = array( 'jquery' );
        if ( 'yes' === get_option( 'pwgc_allow_scheduled_delivery', 'yes' ) ) {
            $prerequisites[] = 'pikaday';
        }

        wp_register_script( 'pw-gift-cards', $this->relative_url( '/assets/js/pw-gift-cards.js' ), $prerequisites, PWGC_VERSION );
        wp_localize_script( 'pw-gift-cards', 'pwgc', array(
            'ajaxurl'                       => admin_url( 'admin-ajax.php', 'relative' ),
            'denomination_attribute_slug'   => PWGC_DENOMINATION_ATTRIBUTE_SLUG,
            'other_amount_prompt'           => pwgc_get_other_amount_prompt( $post ),
            'reload_key'                    => PWGC_RELOAD_GIFT_CARD_NUMBER_META_KEY,
            'decimal_places'                => wc_get_price_decimals(),
            'decimal_separator'             => wc_get_price_decimal_separator(),
            'thousand_separator'            => wc_get_price_thousand_separator(),
            'max_message_characters'        => PWGC_MAX_MESSAGE_CHARACTERS,
            'balance_check_icon'            => apply_filters( 'pwgc_balance_check_icon', '<i class="fas fa-cog fa-spin fa-3x"></i>' ),
            'allow_multiple_recipients'     => get_option( 'pwgc_allow_multiple_recipients', 'yes' ),
            'pikaday'                        => array(
                                                'format'    => get_option( 'pwgc_pikaday_format', 'YYYY-MM-DD' ),
                                                'firstDay'  => get_option( 'pwgc_pikaday_first_day', '0' ) == 1 ? 1 : 0, // 0 = Sunday, 1 = Monday
            ),
            'i18n'                          => array(
                'custom_amount_required_error'  => __( 'Required', 'pw-woocommerce-gift-cards' ),
                'debit_amount_prompt'           => __( 'Amount to debit?', 'pw-woocommerce-gift-cards' ),
                'debit_note_prompt'             => __( 'Note', 'pw-woocommerce-gift-cards' ),
                'min_amount_error'              => sprintf( __( 'Minimum amount is %s', 'pw-woocommerce-gift-cards' ), get_woocommerce_currency_symbol() ),
                'max_amount_error'              => sprintf( __( 'Maximum amount is %s', 'pw-woocommerce-gift-cards' ), get_woocommerce_currency_symbol() ),
                'invalid_recipient_error'       => __( 'The "To" field should only contain email addresses. The following recipients do not look like valid email addresses:', 'pw-woocommerce-gift-cards' ),
                'previousMonth'                 => apply_filters( 'pwgc_previous_month_string', '' ),
                'nextMonth'                     => apply_filters( 'pwgc_next_month_string', '' ),
                'jan'                           => __( 'January', 'pw-woocommerce-gift-cards' ),
                'feb'                           => __( 'February', 'pw-woocommerce-gift-cards' ),
                'mar'                           => __( 'March', 'pw-woocommerce-gift-cards' ),
                'apr'                           => __( 'April', 'pw-woocommerce-gift-cards' ),
                'may'                           => __( 'May', 'pw-woocommerce-gift-cards' ),
                'jun'                           => __( 'June', 'pw-woocommerce-gift-cards' ),
                'jul'                           => __( 'July', 'pw-woocommerce-gift-cards' ),
                'aug'                           => __( 'August', 'pw-woocommerce-gift-cards' ),
                'sep'                           => __( 'September', 'pw-woocommerce-gift-cards' ),
                'oct'                           => __( 'October', 'pw-woocommerce-gift-cards' ),
                'nov'                           => __( 'November', 'pw-woocommerce-gift-cards' ),
                'dec'                           => __( 'December', 'pw-woocommerce-gift-cards' ),
                'sun'                           => __( 'Sun', 'pw-woocommerce-gift-cards' ),
                'mon'                           => __( 'Mon', 'pw-woocommerce-gift-cards' ),
                'tue'                           => __( 'Tue', 'pw-woocommerce-gift-cards' ),
                'wed'                           => __( 'Wed', 'pw-woocommerce-gift-cards' ),
                'thu'                           => __( 'Thu', 'pw-woocommerce-gift-cards' ),
                'fri'                           => __( 'Fri', 'pw-woocommerce-gift-cards' ),
                'sat'                           => __( 'Sat', 'pw-woocommerce-gift-cards' ),
                'sunday'                        => __( 'Sunday', 'pw-woocommerce-gift-cards' ),
                'monday'                        => __( 'Monday', 'pw-woocommerce-gift-cards' ),
                'tuesday'                       => __( 'Tuesday', 'pw-woocommerce-gift-cards' ),
                'wednesday'                     => __( 'Wednesday', 'pw-woocommerce-gift-cards' ),
                'thursday'                      => __( 'Thursday', 'pw-woocommerce-gift-cards' ),
                'friday'                        => __( 'Friday', 'pw-woocommerce-gift-cards' ),
                'saturday'                      => __( 'Saturday', 'pw-woocommerce-gift-cards' ),
                'sunday'                        => __( 'Sunday', 'pw-woocommerce-gift-cards' ),
            ),
            'nonces' => array(
                'check_balance'                 => wp_create_nonce( 'pw-gift-cards-check-balance' ),
                'debit_balance'                 => wp_create_nonce( 'pw-gift-cards-debit-balance' ),
                'apply_gift_card'               => wp_create_nonce( 'pw-gift-cards-apply-gift-card' ),
                'remove_card'                   => wp_create_nonce( 'pw-gift-cards-remove-card' ),
            ),
            'preview_email_url'                 => pwgc_view_email_url(),
            'preview_email_pdf'                 => PWGC_SHOW_PDF_IN_FRONTEND_PREVIEW,
            'example_gift_card_number'          => pwgc_get_example_gift_card_number(),
            'auto_focus_other_amount'           => apply_filters( 'pwgc_auto_focus_other_amount', true ),
        ) );

        wp_enqueue_script( 'pw-gift-cards' );

        wp_register_script( 'pikaday', $this->relative_url( '/assets/js/pikaday-1.8.0.min.js' ), array( 'moment-with-locales' ), PWGC_VERSION );
        wp_register_style( 'pikaday', $this->relative_url( '/assets/css/pikaday-1.8.0.min.css' ), array(), PWGC_VERSION );

        wp_register_script( 'moment-with-locales', $this->relative_url( '/assets/js/moment-with-locales.min.js' ), array( ), PWGC_VERSION );

        if ( !wp_script_is( 'fontawesome-all' ) ) {
            wp_register_script( 'fontawesome-all', $this->relative_url( '/assets/js/fontawesome-all.min.js' ), array(), PWGC_FONT_AWESOME_VERSION );
        }

        // Compatibility with YITH Color and Label Variations for WooCommerce.
        if ( class_exists( 'YITH_WCCL' ) && isset( $GLOBALS['yith_wccl'] ) ) {
            $product = wc_get_product( $post );
            if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) && is_a( $GLOBALS['yith_wccl']->obj, 'YITH_WCCL_Frontend' ) ) {
                remove_action( 'wp_enqueue_scripts', array( $GLOBALS['yith_wccl']->obj, 'enqueue_static' ) );
                wp_dequeue_script( 'yith_wccl_frontend' );
                wp_dequeue_style( 'yith_wccl_frontend' );
            }
        }
    }

    function defer_scripts( $tag, $handle, $src ) {
        $defer_scripts = array(
            'fontawesome-all',
            'pw-gift-cards',
            'pw-gift-cards-admin'
        );

        if ( in_array( $handle, $defer_scripts ) ) {
            return "<script src=\"$src\" defer=\"defer\" type=\"text/javascript\"></script>\n";
        }

        return $tag;
    }

    function woocommerce_hidden_order_itemmeta( $meta_keys ) {
        $meta_keys[] = PWGC_BONUS_RECIPIENT_META_KEY;

        return $meta_keys;
    }

    function woocommerce_attribute_label( $label, $name, $product ) {
        if ( isset( $this->gift_card_meta[ $label ] ) ) {
            return $this->gift_card_meta[ $label ];
        }

        if ( $label == PWGC_BONUS_AMOUNT_META_KEY ) {
            return PWGC_BONUS_AMOUNT_META_DISPLAY_NAME;
        }

        if ( !is_admin() && sanitize_title( $label ) == PWGC_DENOMINATION_ATTRIBUTE_SLUG ) {
            return PWGC_DENOMINATION_ATTRIBUTE_NAME;
        }

        return $label;
    }

    function woocommerce_before_order_item_line_item_html() {
        add_filter( 'woocommerce_order_item_display_meta_value', array( $this, 'woocommerce_order_item_display_meta_value' ), 10, 3 );
    }

    function woocommerce_order_item_line_item_html() {
        remove_filter( 'woocommerce_order_item_display_meta_value', array( $this, 'woocommerce_order_item_display_meta_value' ), 10, 3 );
    }

    function woocommerce_order_item_display_meta_value( $meta_value, $meta, $order_item ) {
        if ( $meta->key == PWGC_GIFT_CARD_NUMBER_META_KEY ) {
            $card_number = $meta_value;
            $gift_card = new PW_Gift_Card( $card_number );
            if ( $gift_card->get_id() ) {
                $notifications = wc_get_order_item_meta( $order_item->get_id(), PWGC_GIFT_CARD_NOTIFICATIONS_META_KEY );

                $check_balance_url = $gift_card->check_balance_url();
                if ( !empty( $check_balance_url ) ) {
                    $meta_value = sprintf( '<a href="%s">%s</a>', $check_balance_url, $card_number );
                }

                if ( isset( $notifications[ $card_number ] ) ) {
                    $meta_value = sprintf( '%1$s (<a href="mailto: %2$s">%2$s</a>)', $meta_value, $notifications[ $card_number ] );
                } else {
                    $delivery_date = $order_item->get_meta( PWGC_DELIVERY_DATE_META_KEY );
                    $scheduled_date = pwgc_delivery_date_to_time( $delivery_date );
                    if ( !empty( $scheduled_date ) && $scheduled_date > strtotime( 'today midnight', current_time( 'timestamp' ) ) ) {
                        $meta_value = sprintf( '%s (%s %s)', $meta_value, __( 'Delivery Date', 'pw-woocommerce-gift-cards' ), $delivery_date );
                    }
                }
            }
        }

        return $meta_value;
    }

    function maybe_mark_order_completed( $order_id ) {
        if ( !$order_id ) {
            return;
        }

        // If the order only contains Gift Cards we can mark it complete automatically.
        if ( 'yes' === get_option( 'pwgc_autocomplete_gift_card_orders', 'yes' ) ) {
            $completed = true;

            $order = wc_get_order( $order_id );

            if ( in_array( $order->get_payment_method(), $this->ignore_autocomplete_payment_methods ) ) {
                return;
            }

            foreach ( $order->get_items( 'line_item' ) as $order_item_id => $order_item ) {
                if ( ! is_a( $order_item->get_product(), 'WC_Product' ) ) {
                    continue;
                }

                $product_id = !empty( $order_item->get_product()->get_parent_id() ) ? $order_item->get_product()->get_parent_id() : $order_item->get_product()->get_id();
                $product =  wc_get_product( $product_id );
                if ( !is_a( $product, 'WC_Product_PW_Gift_Card' ) || $product->get_pwgc_is_physical_card() ) {
                    $completed = false;
                    break;
                }
            }

            if ( $completed ) {
                $order->update_status( 'completed' );
            }
        }
    }

    function wcml_is_variable_product( $is_variable_product, $product_id ) {
        $product = wc_get_product( $product_id );
        if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) ) {
            $is_variable_product = true;
        }

        return $is_variable_product;
    }

    function woocommerce_version_error() {
        ?>
        <div class="error notice notice-error">
            <p><?php printf( __( '%s requires WooCommerce version %s or later.', 'pw-woocommerce-gift-cards' ), PWGC_PRODUCT_NAME, PWGC_WC_VERSION_MINIMUM ); ?></p>
        </div>
        <?php
    }

    function plugin_activate() {
        global $wpdb;

        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        if ( !term_exists( PWGC_PRODUCT_TYPE_SLUG, 'product_type' ) ) {
            wp_insert_term( PWGC_PRODUCT_TYPE_NAME, 'product_type', array( 'slug' => PWGC_PRODUCT_TYPE_SLUG ) );
        }
    }

    function plugin_deactivate() {
        global $wpdb;

        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $next_scheduled = wp_next_scheduled( 'pw_gift_cards_delivery' );
        if ( $next_scheduled ) {
            wp_unschedule_event( $next_scheduled, 'pw_gift_cards_delivery' );
        }

        delete_option( 'pwgc_hide_partner_message' );
        delete_option( 'pwgc_database_version' );
    }

    function wc_min_version( $version ) {
        return version_compare( WC()->version, $version, ">=" );
    }

    function relative_url( $url ) {
        return plugins_url( $url, PWGC_PLUGIN_FILE );
    }

    function only_numbers_and_decimal( $value ) {
        return preg_replace( '/[^0-9.]/', '', strip_tags( html_entity_decode( $value ) ) );
    }

    function pretty_price( $price ) {
        $amount = $this->only_numbers_and_decimal( $price );
        if ( $amount != '' ) {

            if ( 'yes' === get_option( 'pwgc_format_prices', 'yes' ) ) {
                $decimals = fmod( $amount, 1 ) > 0 ? wc_get_price_decimals() : 0;
                $amount = wc_price( $amount, array( 'decimals' => $decimals ) );
            }

            $amount = strip_tags( $amount );
            $amount = html_entity_decode( $amount );
            return $amount;
        } else {
            return $price;
        }
    }

    function sanitize_amount( $amount ) {
        $thousand_separator = wc_get_price_thousand_separator();
        $decimal_separator = wc_get_price_decimal_separator();

        $amount = strip_tags( html_entity_decode( $amount ) );
        $amount = str_replace( $thousand_separator, '', $amount );
        $amount = str_replace( $decimal_separator, '.', $amount );

        return apply_filters( 'pwgc_sanitize_amount', $amount );
    }

    function numeric_price( $price ) {
        $numbers = $this->only_numbers_and_decimal( $price );
        if ( $numbers != '' ) {
            return floatval( $numbers );
        } else {
            return $price;
        }
    }

    function equal_prices( $price_a, $price_b ) {
        // Compare prices numerically.
        $price_a = $this->numeric_price( $price_a );
        $price_b = $this->numeric_price( $price_b );

        return ( $price_a == $price_b );
    }

    function price_sort( $a, $b ) {
        if ( !$a || !$b ) {
            return 0;
        }

        $a_price = $this->numeric_price( $a->get_regular_price() );
        $b_price = $this->numeric_price( $b->get_regular_price() );

        if ( $a_price == $b_price ) {
            return 0;
        }

        // Make sure the "Custom Amount" floats to the bottom.
        if ( $a_price == 0 ) {
            return 1;
        } else if ( $b_price == 0 ) {
            return -1;
        }

        return ( $a_price < $b_price ) ? -1 : 1;
    }

    function get_published_gift_card_product_ids() {
        return $this->get_published_gift_card_products( true );
    }

    function get_published_gift_card_products( $ids_only = false ) {

        $args = array(
            'limit' => -1,
            'type' => PWGC_PRODUCT_TYPE_SLUG,
            'status' => 'publish'
        );

        if ( $ids_only ) {
            $args['return'] = 'ids';
        }

        return wc_get_products( $args );
    }

    function allow_custom_amount( $product_id, $variation_id = '' ) {
        if ( $product = wc_get_product( $product_id ) ) {
            if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) && $product->get_pwgc_custom_amount_allowed() ) {
                if ( empty( $variation_id ) ) {
                    return true;

                } else if ( $variation = wc_get_product( $variation_id ) ) {
                    if ( empty( $variation->get_price() ) || $variation->get_price() == 0 ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    function get_gift_card_product() {
        $query = new WC_Product_Query( array(
            'type' => PWGC_PRODUCT_TYPE_SLUG,
            'limit' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'status' => 'publish',
        ) );
        $products = $query->get_products();

        if ( !empty( $products ) ) {
            return $products[0];
        } else {
            return null;
        }
    }

    function get_balance_page() {
        global $wpdb;

        $balance_page = null;

        $balance_page_slug = get_option( 'pwgc_balance_page_slug' );
        if ( !empty( $balance_page_slug ) ) {
            $balance_page = get_page_by_path( $balance_page_slug );
        } else {
            $results = $wpdb->get_row( "
                SELECT
                    post.ID AS post_id
                FROM
                    {$wpdb->posts} AS post
                WHERE
                    post.post_status = 'publish'
                    AND post.post_type = 'page'
                    AND post.post_content LIKE '%[" . PWGC_BALANCE_SHORTCODE . "]%'
                ORDER BY
                    post.post_date DESC
                LIMIT 1
            " );
            if ( $results ) {
                $balance_page = get_page( $results->post_id );
            }
        }

        return apply_filters( 'pwgc_balance_page', $balance_page );
    }

    function deliver_scheduled_gift_cards() {
        $orders = wc_get_orders( array(
            PWGC_DELIVERY_PENDING_META_KEY => 'yes',
            'limit' => -1,
        ) );

        foreach ( $orders as $order ) {
            do_action( 'pw_gift_cards_send_emails', $order->get_id() );
        }
    }

    function handle_custom_query_var( $query, $query_vars ) {
        if ( ! empty( $query_vars[ PWGC_DELIVERY_PENDING_META_KEY ] ) ) {
            $query['meta_query'][] = array(
                'key' => PWGC_DELIVERY_PENDING_META_KEY,
                'value' => esc_attr( $query_vars[ PWGC_DELIVERY_PENDING_META_KEY ] ),
            );
        }

        return $query;
    }

    function pwgc_to_current_currency( $amount ) {
        // WooCommerce Currency Switcher by realmag777
        if ( isset( $GLOBALS['WOOCS'] ) && method_exists( $GLOBALS['WOOCS'], 'woocs_convert_price' ) ) {
            return $GLOBALS['WOOCS']->woocs_convert_price( $amount );
        }

        // Aelia Currency Switcher
        if ( class_exists( 'WC_Aelia_CurrencySwitcher' ) && isset( $GLOBALS['woocommerce-aelia-currencyswitcher'] ) ) {
            $cs = $GLOBALS['woocommerce-aelia-currencyswitcher'];
            return $cs->convert( $amount, $cs->base_currency(), $cs->get_selected_currency() );
        }

        // WooCommerce Ultimate Multi Currency Suite
        if ( class_exists( 'WooCommerce_Ultimate_Multi_Currency_Suite_Main' ) && isset( $GLOBALS['woocommerce_ultimate_multi_currency_suite'] ) ) {
            $cs = $GLOBALS['woocommerce_ultimate_multi_currency_suite'];
            if ( is_object( $cs ) && property_exists( $cs, 'frontend' ) && !empty( $cs->frontend ) ) {
                return $cs->frontend->convert_price( $amount );
            }
        }

        // WPML (WooCommerce Multilingual plugin)
        if ( isset( $GLOBALS['woocommerce_wpml'] ) ) {
            $wpml = $GLOBALS['woocommerce_wpml'];
            if ( is_object( $wpml ) && property_exists( $wpml, 'multi_currency' ) && is_object( $wpml->multi_currency ) && property_exists( $wpml->multi_currency, 'prices' ) ) {
                $cs = $wpml->multi_currency;
                return $cs->prices->convert_price_amount( $amount );
            }
        }

        // Multi Currency for WooCommerce by VillaTheme
        if ( function_exists( 'wmc_get_price' ) ) {
            return wmc_get_price( $amount );
        }

        // WooCommerce Price Based on Country by Oscar Gare
        if ( function_exists( 'wcpbc_the_zone' ) ) {
            $zone = wcpbc_the_zone();
            if ( !empty( $zone ) && method_exists( $zone, 'get_exchange_rate_price' ) ) {
                return $zone->get_exchange_rate_price( $amount );
            }
        }

        // Multi-Currency for WooCommerce by TIV.NET INC
        if ( class_exists( 'WOOMC\App' ) ) {
            $user = WOOMC\App::instance()->getUser();

            $currency_detector = new WOOMC\Currency\Detector();
            $rate_storage = new WOOMC\Rate\Storage();
            $price_rounder = new WOOMC\Price\Rounder();
            $price_calculator = new WOOMC\Price\Calculator( $rate_storage, $price_rounder );

            $to = $currency_detector->currency();
            $from = $currency_detector->getDefaultCurrency();

            return $price_calculator->calculate( (float) $amount, $to, $from );
        }

        // Currency Switcher for WooCommerce by WP Wham
        if ( function_exists( 'alg_get_current_currency_code' ) ) {
            $current_currency_code = alg_get_current_currency_code();
            $default_currency = get_option( 'woocommerce_currency' );
            if ( $current_currency_code != $default_currency ) {
                add_filter( 'alg_wc_currency_switcher_correction', array( $this, 'alg_wc_currency_switcher_correction' ), 10, 2 );

                $amount = alg_convert_price( array(
                    'price'         => $amount,
                    'currency_from' => $default_currency,
                    'currency'      => $current_currency_code,
                    'format_price'  => 'no'
                ) );

                remove_filter( 'alg_wc_currency_switcher_correction', array( $this, 'alg_wc_currency_switcher_correction' ), 10, 2 );

                return $amount;
            }
        }

        return $amount;
    }

    function pwgc_to_default_currency( $amount ) {
        // WooCommerce Currency Switcher by realmag777
        if ( isset( $GLOBALS['WOOCS'] ) && method_exists( $GLOBALS['WOOCS'], 'get_currencies' ) && method_exists( $GLOBALS['WOOCS'], 'back_convert' ) ) {
            $cs = $GLOBALS['WOOCS'];
            $default_currency = false;
            $currencies = $cs->get_currencies();

            foreach ( $currencies as $currency ) {
                if ( $currency['is_etalon'] === 1 ) {
                    $default_currency = $currency;
                    break;
                }
            }

            if ( $default_currency ) {
                if ( $cs->current_currency != $default_currency['name'] ) {
                    return (float) $cs->back_convert( $amount, $currencies[ $cs->current_currency ]['rate'] );
                }
            }
        }

        // Aelia Currency Switcher
        if ( class_exists( 'WC_Aelia_CurrencySwitcher' ) && isset( $GLOBALS['woocommerce-aelia-currencyswitcher'] ) ) {
            $cs = $GLOBALS['woocommerce-aelia-currencyswitcher'];

            $current_currency = $cs->get_selected_currency();
            $base_currency = $cs->base_currency();

            if ( $current_currency != $base_currency && !empty( $cs->current_exchange_rate() ) ) {
                return (float) number_format( ( 1 / $cs->current_exchange_rate() ) * $amount, 6, '.', '' );
            }
        }

        // WooCommerce Ultimate Multi Currency Suite
        if ( class_exists( 'WooCommerce_Ultimate_Multi_Currency_Suite_Main' ) && isset( $GLOBALS['woocommerce_ultimate_multi_currency_suite'] ) ) {
            $cs = $GLOBALS['woocommerce_ultimate_multi_currency_suite'];
            if ( is_object( $cs ) && property_exists( $cs, 'frontend' ) && !empty( $cs->frontend ) ) {
                return $cs->frontend->unconvert_price( $amount );
            }
        }

        // WPML (WooCommerce Multilingual plugin)
        if ( isset( $GLOBALS['woocommerce_wpml'] ) ) {
            $wpml = $GLOBALS['woocommerce_wpml'];
            if ( is_object( $wpml ) && property_exists( $wpml, 'multi_currency' ) && is_object( $wpml->multi_currency ) && property_exists( $wpml->multi_currency, 'prices' ) ) {
                $cs = $wpml->multi_currency->prices;
                return $cs->unconvert_price_amount( $amount );
            }
        }

        // Multi Currency for WooCommerce by VillaTheme
        if ( function_exists( 'wmc_get_price' ) ) {
            $exchange = wmc_get_price( '1' );
            return (float) number_format( ( 1 / $exchange ) * $amount, 6, '.', '' );
        }

        // WooCommerce Price Based on Country by Oscar Gare
        if ( function_exists( 'wcpbc_get_zone_by_country' ) ) {
            $zone = wcpbc_get_zone_by_country();
            if ( !empty( $zone ) && method_exists( $zone, 'get_exchange_rate' ) ) {
                $amount = ( $amount / $zone->get_exchange_rate() );
            }
        }

        // Multi-Currency for WooCommerce by TIV.NET INC
        if ( class_exists( 'WOOMC\App' ) ) {
            $currency_detector = new WOOMC\Currency\Detector();
            $rate_storage = new WOOMC\Rate\Storage();
            $price_rounder = new WOOMC\Price\Rounder();
            $price_calculator = new WOOMC\Price\Calculator( $rate_storage, $price_rounder );

            $to = $currency_detector->getDefaultCurrency();
            $from = $currency_detector->currency();

            return $price_calculator->calculate( (float) $amount, $to, $from );
        }

        // Currency Switcher for WooCommerce by WP Wham
        if ( function_exists( 'alg_get_current_currency_code' ) ) {
            $current_currency_code = alg_get_current_currency_code();
            $default_currency = get_option( 'woocommerce_currency' );
            if ( $current_currency_code != $default_currency ) {
                add_filter( 'alg_wc_currency_switcher_correction', array( $this, 'alg_wc_currency_switcher_correction' ), 10, 2 );

                $amount = alg_convert_price( array(
                    'price'         => $amount,
                    'currency_from' => $current_currency_code,
                    'currency'      => $default_currency,
                    'format_price'  => 'no'
                ) );

                remove_filter( 'alg_wc_currency_switcher_correction', array( $this, 'alg_wc_currency_switcher_correction' ), 10, 2 );

                $amount = round( $amount, wc_get_price_decimals() );

                return $amount;
            }
        }

        return $amount;
    }

    function pwgc_to_order_currency( $amount, $order ) {
        // WooCommerce Currency Switcher by realmag777
        if ( isset( $GLOBALS['WOOCS'] ) ) {
            return $this->pwgc_to_current_currency( $amount );
        }

        // Aelia Currency Switcher
        if ( class_exists( 'WC_Aelia_CurrencySwitcher' ) && isset( $GLOBALS['woocommerce-aelia-currencyswitcher'] ) ) {
            return $this->pwgc_to_current_currency( $amount );
        }

        // WooCommerce Ultimate Multi Currency Suite
        if ( class_exists( 'WooCommerce_Ultimate_Multi_Currency_Suite_Main' ) && isset( $GLOBALS['woocommerce_ultimate_multi_currency_suite'] ) ) {
            $cs = $GLOBALS['woocommerce_ultimate_multi_currency_suite'];
            if ( is_object( $cs ) && property_exists( $cs, 'frontend' ) && !empty( $cs->frontend ) ) {
                return $cs->frontend->convert_price( $amount );
            }
        }

        // WPML (WooCommerce Multilingual plugin)
        if ( isset( $GLOBALS['woocommerce_wpml'] ) ) {
            $wpml = $GLOBALS['woocommerce_wpml'];
            if ( is_object( $wpml ) && property_exists( $wpml, 'multi_currency' ) && is_object( $wpml->multi_currency ) && property_exists( $wpml->multi_currency, 'prices' ) ) {
                $cs = $wpml->multi_currency->prices;
                $currency_code = get_post_meta( $order->get_id(), '_order_currency', true );
                if ( !empty( $currency_code ) ) {
                    return $cs->convert_price_amount( $amount, $currency_code );
                }
            }
        }

        // Multi Currency for WooCommerce by VillaTheme
        if ( function_exists( 'wmc_get_price' ) ) {
            $wmc_order_info = get_post_meta( $order->get_id(), 'wmc_order_info', true );
            if ( is_array( $wmc_order_info ) ) {
                $order_currency = get_post_meta( $order->get_id(), '_order_currency', true );
                $rate = $wmc_order_info[ $order_currency ]['rate'];
                return $amount * $rate;
            }
        }

        // Price Based on Country for WooCommerce by Oscar Gare
        if ( class_exists( 'WCPBC_Pricing_Zones' ) && !empty( $order ) ) {
            $zone = WCPBC_Pricing_Zones::get_zone_from_order( $order );
            if ( !empty( $zone ) && method_exists( $zone, 'get_base_currency_amount' ) ) {
                return $zone->get_base_currency_amount( $amount );
            }
        }

        // Multi-Currency for WooCommerce by TIV.NET INC
        if ( class_exists( 'WOOMC\App' ) && !empty( $order ) ) {
            $currency_detector = new WOOMC\Currency\Detector();
            $rate_storage = new WOOMC\Rate\Storage();
            $price_rounder = new WOOMC\Price\Rounder();
            $price_calculator = new WOOMC\Price\Calculator( $rate_storage, $price_rounder );

            $to = get_post_meta( $order->get_id(), '_order_currency', true );
            $from = $currency_detector->getDefaultCurrency();

            return $price_calculator->calculate( (float) $amount, $to, $from );
        }

        // Currency Switcher for WooCommerce by WP Wham
        if ( is_a( $order, 'WC_Order' ) && function_exists( 'alg_convert_price' ) ) {
            $order_currency = get_post_meta( $order->get_id(), '_order_currency', true );
            $default_currency = get_option( 'woocommerce_currency' );
            if ( $order_currency != $default_currency ) {
                add_filter( 'alg_wc_currency_switcher_correction', array( $this, 'alg_wc_currency_switcher_correction' ), 10, 2 );

                $amount = alg_convert_price( array(
                    'price'         => $amount,
                    'currency_from' => $default_currency,
                    'currency'      => $order_currency,
                    'format_price'  => 'no'
                ) );

                remove_filter( 'alg_wc_currency_switcher_correction', array( $this, 'alg_wc_currency_switcher_correction' ), 10, 2 );

                return $amount;
            }
        }

        return $amount;
    }

    function set_current_currency_to_default() {
        // WooCommerce Currency Switcher by realmag777
        if ( isset( $GLOBALS['WOOCS'] ) && method_exists( $GLOBALS['WOOCS'], 'get_currencies' ) ) {
            $default_currency = false;
            foreach ( $GLOBALS['WOOCS']->get_currencies() as $currency ) {
                if ( $currency['is_etalon'] === 1 ) {
                    $default_currency = $currency;
                    break;
                }
            }

            if ( $default_currency ) {
                $GLOBALS['WOOCS']->current_currency = $default_currency['name'];
            }

            return;
        }

        // WooCommerce Ultimate Multi Currency Suite
        if ( class_exists( 'WooCommerce_Ultimate_Multi_Currency_Suite_Main' ) && isset( $GLOBALS['woocommerce_ultimate_multi_currency_suite'] ) ) {
            $cs = $GLOBALS['woocommerce_ultimate_multi_currency_suite'];
            if ( is_object( $cs ) && property_exists( $cs, 'frontend' ) && !empty( $cs->frontend ) ) {
                remove_filter('woocommerce_currency_symbol', array($cs->frontend, 'custom_currency_symbol'), 9999);
                remove_filter('wc_price_args', array($cs->frontend, 'price_formatting'), 9999);
                remove_filter('woocommerce_price_format', array($cs->frontend, 'custom_price_format'), 9999);
                remove_filter('raw_woocommerce_price', array($cs->frontend, 'custom_reference_price'), 9999);
                remove_filter('woocommerce_currency', array($cs->frontend, 'custom_currency'), 9999);
            }
        }

        // Aelia Currency Switcher
        if ( !has_filter( 'wc_aelia_cs_selected_currency', array( $this, 'wc_aelia_cs_selected_currency' ) ) ) {
            add_filter( 'wc_aelia_cs_selected_currency', array( $this, 'wc_aelia_cs_selected_currency' ) );
        }

        // WPML (WooCommerce Multilingual plugin)
        if ( isset( $GLOBALS['woocommerce_wpml'] ) ) {
            $wpml = $GLOBALS['woocommerce_wpml'];
            if ( is_object( $wpml ) && property_exists( $wpml, 'multi_currency' ) && is_object( $wpml->multi_currency ) && property_exists( $wpml->multi_currency, 'prices' ) && property_exists( $wpml->multi_currency, 'orders' ) ) {
                $prices = $wpml->multi_currency->prices;
                remove_filter( 'wc_price', array( $prices, 'price_in_specific_currency' ), 10, 3 );
                remove_filter( 'woocommerce_currency', array( $prices, 'currency_filter' ) );
                remove_filter( 'wc_price_args', array( $prices, 'filter_wc_price_args' ) );
                remove_filter( 'woocommerce_adjust_price', array( $prices, 'raw_price_filter' ), 10 );
                remove_filter( 'option_woocommerce_price_thousand_sep', array( $prices, 'filter_currency_thousand_sep_option' ) );
                remove_filter( 'option_woocommerce_price_decimal_sep', array( $prices, 'filter_currency_decimal_sep_option' ) );
                remove_filter( 'option_woocommerce_price_num_decimals', array( $prices, 'filter_currency_num_decimals_option' ) );
                remove_filter( 'option_woocommerce_currency_pos', array( $prices, 'filter_currency_position_option' ) );

                $orders = $wpml->multi_currency->orders;
                remove_filter( 'woocommerce_currency_symbol', array( $orders, '_use_order_currency_symbol' ) );
            }
        }

        // Multi-Currency for WooCommerce by TIV.NET INC
        if ( class_exists( 'WOOMC\App' ) ) {
            // Ensure this is only attached once.
            remove_filter( 'woocommerce_currency_symbol', array( $this, 'woomc_default_currency_symbol' ) );
            add_filter( 'woocommerce_currency_symbol', array( $this, 'woomc_default_currency_symbol' ) );
        }

        // Currency Switcher for WooCommerce by WP Wham
        if ( function_exists( 'alg_wc_cs_session_set' ) ) {
            $default_currency = get_option( 'woocommerce_currency' );
            alg_wc_cs_session_set( 'alg_currency', $default_currency );
        }
    }

    // Currency Switcher for WooCommerce by WP Wham
    function alg_wc_currency_switcher_correction( $options, $currency_code ) {
        // Turn off rounding when performing the conversions for gift cards.
        if ( ! isset( $_REQUEST['alg_wc_currency_switcher_correction_ignore'] ) || $_REQUEST['alg_wc_currency_switcher_correction_ignore'] === false ) {
            $options['rounding'] = 'round_no';
        }

        return $options;
    }

    function woomc_default_currency_symbol( $symbol ) {
        if ( class_exists( 'WOOMC\Currency\Detector' ) && class_exists( 'WOOMC\DAO\Factory' ) ) {
            $currency_detector = new WOOMC\Currency\Detector();
            $symbol = WOOMC\DAO\Factory::getDao()->getCustomCurrencySymbol( $currency_detector->getDefaultCurrency() );
        }

        return $symbol;
    }

    function wc_aelia_cs_selected_currency( $currency ) {
        if ( class_exists( 'WC_Aelia_CurrencySwitcher' ) && isset( $GLOBALS['woocommerce-aelia-currencyswitcher'] ) ) {
            $cs = $GLOBALS['woocommerce-aelia-currencyswitcher'];
            return $cs->base_currency();
        }

        return $currency;
    }

    function wcumcs_custom_item_price_final( $final_price, $price, $product ) {
        $product_id = !empty( $product->get_parent_id() ) ? $product->get_parent_id() : $product->get_id();
        $product =  wc_get_product( $product_id );
        if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) ) {
            return apply_filters( 'pwgc_to_current_currency', $price );
        }

        return $final_price;
    }

    function use_default_currency_in_cart() {
        // WooCommerce Currency Switcher by realmag777
        if ( isset( $GLOBALS['WOOCS'] ) ) {
            return true;
        }

        // Multi Currency for WooCommerce by VillaTheme
        if ( function_exists( 'wmc_get_price' ) ) {
            return true;
        }

        // WooCommerce Ultimate Multi Currency Suite
        if ( class_exists( 'WooCommerce_Ultimate_Multi_Currency_Suite_Main' ) ) {
            return true;
        }

        // Multi-Currency for WooCommerce by TIV.NET INC
        if ( class_exists( 'WOOMC\App' ) ) {
            return true;
        }

        // Currency Switcher for WooCommerce by WP Wham
        if ( function_exists( 'alg_get_current_currency_code' ) ) {
            return true;
        }

        return false;
    }

    function rest_api_init() {
        //
        // Initialize the PW Gift Cards REST Controller object.
        //
        require_once( 'includes/pw-gift-cards-rest-controller.php' );

        $rest_controller = new PW_Gift_Cards_REST_Controller();
        $rest_controller->register_routes();

        //
        // Append data to the WooCommerce Orders API.
        //
        register_rest_field( 'shop_order', 'pw_gift_cards_redeemed', array(
            'get_callback' => function( $arr ) {
                $order = wc_get_order( $arr['id'] );
                $gift_cards = array();
                foreach( $order->get_items( 'pw_gift_card' ) as $order_item_id => $line ) {
                    $gift_cards[] = array(
                        'number' => $line->get_card_number(),
                        'amount' => $line->get_amount(),
                    );
                }

                return $gift_cards;
            },
            'schema' => array(
                'description' => __( 'PW Gift Card Redeemed.' ),
                'type'        => 'array'
            ),
        ) );
    }

    function antive_toolkit_variation_attribute_options( $html, $html_default, $args ) {
        global $product;

        if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) ) {
            return $html_default;
        } else {
            return $html;
        }
    }

    // Fixes a compatibility issue with the WooCommerce Availability Scheduler plugin by vanquish - https://codecanyon.net/item/woocommerce-availability-scheduler/11649604
    function woocommerce_availability_scheduler_fix() {
        global $product;

        if ( class_exists( 'WAS_Remover' ) && is_a( $product, 'WC_Product_PW_Gift_Card' ) ) {
           add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        }
    }

    // Fixes compatibility issue with the Variation Swatches for WooCommerce plugin by Emran Ahmed.
    function default_wvs_variation_attribute_options_html( $flag, $args, $html ) {
        if ( defined( 'PWGC_WVS_ALLOW' ) && ! PWGC_WVS_ALLOW ) {
            if ( isset( $args['product'] ) ) {
                $product = $args['product'];
                if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) ) {
                    // "True" means the default dropdown menu will be displayed instead of swatches.
                    $flag = true;
                }
            }
        }

        return $flag;
    }

    function output_html_as_pdf( $html ) {

        require_once PWGC_PLUGIN_ROOT . '/vendor/autoload.php';

        $default_font_config = (new \Mpdf\Config\FontVariables())->getDefaults();
        $font_data = $default_font_config['fontdata'];

        $mpdf_config = apply_filters( 'pwgc_mpdf_config', array(
            'tempDir' => apply_filters( 'pwgc_mpdf_temp_dir', get_temp_dir() . 'pw-gift-cards/mpdf' ),
            'fontdata' => $font_data + [
                'roboto' => [
                    'R' => 'Roboto-Regular.ttf',
                    'B' => 'Roboto-Bold.ttf',
                ]
            ],
            'default_font' => 'roboto'
        ) );

        $filename = apply_filters( 'pwgc_pdf_filename', 'gift-card.pdf' );

        $mpdf = new \Mpdf\Mpdf( $mpdf_config );
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML( $html );
        $mpdf->Output( $filename, \Mpdf\Output\Destination::INLINE);

        die();
    }

    function output_gift_card() {
        global $pw_gift_cards_email_designer;

        $gift_card_number = isset( $_REQUEST['pwgc_number'] ) ? wc_clean( $_REQUEST['pwgc_number'] ) : '';
        $from = isset( $_REQUEST['from'] ) ? stripslashes( wc_clean( $_REQUEST['from'] ) ) : '';
        $message = isset( $_REQUEST['message'] ) ? stripslashes( wc_sanitize_textarea( $_REQUEST['message'] ) ) : '';
        $recipient_name = isset( $_REQUEST['recipient_name'] ) ? stripslashes( wc_clean( $_REQUEST['recipient_name'] ) ) : '';
        $other_amount = isset( $_REQUEST['other_amount'] ) ? wc_clean( $_REQUEST['other_amount'] ) : 0;
        $expiration_date = isset( $_REQUEST['expiration_date'] ) ? wc_clean( $_REQUEST['expiration_date'] ) : 0;
        $design_id = isset( $_REQUEST['design_id'] ) ? absint( $_REQUEST['design_id'] ) : 0;
        $variation_id = isset( $_REQUEST['variation_id'] ) ? absint( $_REQUEST['variation_id'] ) : 0;
        $pdf = isset( $_REQUEST['pdf'] ) ? boolval( $_REQUEST['pdf'] ) : false;

        // Fix the currency format by removing the thousands separator from the string.
        $other_amount = str_replace( wc_get_price_thousand_separator(), '', $other_amount );

        // Build out the data for the gift card email template.
        $item_data = new PW_Gift_Card_Item_Data();
        $item_data->from = $from;
        $item_data->message = $message;
        $item_data->recipient_name = $recipient_name;
        $item_data->design = $pw_gift_cards_email_designer->get_design_by_id( $design_id );
        $item_data->design_id = $design_id;
        $item_data->is_pdf = $pdf;
        $item_data->preview = true;

        // Attempt to locate the purchased Variation ID for this gift card number using the Orders data.
        if ( empty( $variation_id ) ) {
            $variation_id = pwgc_get_purchased_variation_id( $gift_card_number );
        }

        // Set the product and parent product.
        $product = false;
        $parent_product = false;
        if ( !empty( $variation_id ) ) {
            $product = wc_get_product( $variation_id );

            if ( is_a( $product, 'WC_Product' ) ) {
                $product_id = !empty( $product->get_parent_id() ) ? $product->get_parent_id() : $product->get_id();
                $parent_product = wc_get_product( $product_id );
            }
        }

        if ( empty( $parent_product ) ) {
            $parent_product = $product;
        }

        $item_data->product = $product;
        $item_data->parent_product = $parent_product;


        // Set the gift card number, amount, and expiration date.
        if ( $gift_card_number == pwgc_get_example_gift_card_number() ) {
            $item_data->gift_card_number = $gift_card_number;

            if ( !empty( $other_amount ) ) {
                $item_data->amount = $other_amount;
            } else if ( !empty( $product ) && method_exists( $product, 'get_price' ) && !empty( $product->get_price() ) ) {
                $item_data->amount = $product->get_regular_price();
            } else {
                $item_data->amount = '123.45';
            }

            if ( empty( $expiration_date ) ) {
                $expires_in_days = is_a( $parent_product, 'WC_Product_PW_Gift_Card' ) ? absint( $parent_product->get_pwgc_expire_days() ) : 0;
                if ( $expires_in_days > 0 ) {
                    $item_data->expiration_date = date_i18n( wc_date_format(), strtotime( current_time( 'Y-m-d' ) . " +$expires_in_days days" ) );
                } else {
                    $item_data->expiration_date = '';
                }
            } else {
                $item_data->expiration_date = $expiration_date;
            }
        } else {
            $gift_card = new PW_Gift_Card( $gift_card_number );
            if ( !$gift_card->get_id() ) {
                // Tar-pit to make brute-force guessing inefficient for "invalid card number" issues.
                sleep(30);

                wp_die( sprintf( __( 'Error: %s', 'pw-woocommerce-gift-cards' ), $gift_card->get_error_message() ) );
            }
            $item_data->gift_card_number = $gift_card->get_number();
            $item_data->amount = $gift_card->get_balance();
            $item_data->expiration_date = date_i18n( wc_date_format(), strtotime( $gift_card->get_expiration_date() ) );
        }


        // Output the gift card.
        ob_start();

        ?>
        <!doctype html>
        <html>
            <head>
                <style>
                    body {
                        background: <?php echo esc_attr( get_option( 'woocommerce_email_body_background_color' ) ); ?>;
                        color: <?php echo esc_attr( get_option( 'woocommerce_email_text_color' ) ); ?>;
                    }
                </style>
            </head>
            <body>
                <?php
                    wc_get_template( 'emails/customer-pw-gift-card.php', array( 'item_data' => $item_data ), '', PWGC_PLUGIN_ROOT . 'templates/woocommerce/' );
                ?>
            </body>
        </html>
        <?php

        $html = ob_get_clean();

        if ( $pdf ) {
            $this->output_html_as_pdf( $html );
        } else {
            echo $html;
        }

        die();
    }
}

global $pw_gift_cards;
$pw_gift_cards = new PW_Gift_Cards();
