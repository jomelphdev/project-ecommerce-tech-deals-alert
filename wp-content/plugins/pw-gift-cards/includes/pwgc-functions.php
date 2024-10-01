<?php

defined( 'ABSPATH' ) or exit;

if ( ! function_exists( 'pwgc_add_gift_card_to_order' ) ) {
    function pwgc_add_gift_card_to_order( $order_item_id, $credit_amount, $product, $create_note, $credit_note ) {
        $gift_card = PW_Gift_Card::create_card( $create_note );
        $gift_card->credit( $credit_amount, $credit_note );

        $expires_in_days = absint( $product->get_pwgc_expire_days() );
        if ( $expires_in_days > 0 ) {
            $expiration_date = date( 'Y-m-d', strtotime( current_time( 'Y-m-d' ) . " +$expires_in_days days" ) );
            $gift_card->set_expiration_date( $expiration_date );
        }

        wc_add_order_item_meta( $order_item_id, PWGC_GIFT_CARD_NUMBER_META_KEY, $gift_card->get_number() );

        return $gift_card;
    }
}

if ( ! function_exists( 'pwgc_is_first_gift_card' ) ) {
    function pwgc_is_first_gift_card( $items, $parameter_item ) {
        foreach ( $items as $item ) {
            if ( isset( $item['product_id'] ) ) {
                $product = wc_get_product( absint( $item['product_id'] ) );
                if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) ) {
                    if ( $item == $parameter_item ) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        return false;
    }
}

if ( ! function_exists( 'pwgc_set_table_names' ) ) {
    function pwgc_set_table_names() {
        global $wpdb;

        if ( true === PWGC_MULTISITE_SHARED_DATABASE ) {
            $wpdb->pimwick_gift_card = $wpdb->base_prefix . 'pimwick_gift_card';
            $wpdb->pimwick_gift_card_activity = $wpdb->base_prefix . 'pimwick_gift_card_activity';
        } else {
            $wpdb->pimwick_gift_card = $wpdb->prefix . 'pimwick_gift_card';
            $wpdb->pimwick_gift_card_activity = $wpdb->prefix . 'pimwick_gift_card_activity';
        }
    }
}

if ( ! function_exists( 'pwgc_get_other_amount_prompt' ) ) {
    function pwgc_get_other_amount_prompt( $product ) {
        // If $product isn't a WooCommerce product, try and retrieve it.
        if ( !is_a( $product, 'WC_Product' ) ) {
            if ( is_numeric( $product ) ) {
                $product = wc_get_product( $product );
            } else if ( is_object( $product ) && property_exists( $product, 'ID' ) ) {
                $product = wc_get_product( $product->ID );
            } else {
                return PWGC_OTHER_AMOUNT_PROMPT;
            }
        }

        // We need to be working with a WooCommerce product.
        if ( !is_a( $product, 'WC_Product' ) ) {
            return PWGC_OTHER_AMOUNT_PROMPT;
        }

        // Make sure we have the parent product.
        if ( !empty( $product->get_parent_id() ) ) {
            $product = wc_get_product( $product->get_parent_id() );
        }

        // Only examine the Gift Card products.
        if ( is_a( $product, 'WC_Product_PW_Gift_Card' ) ) {
            $variations = array_map( 'wc_get_product', $product->get_children() );
            foreach ( $variations as $variation ) {
                if ( $variation && is_a( $variation, 'WC_Product' ) && $variation->get_price() == 0 ) {
                    $other_amount_prompt = $variation->get_attribute( PWGC_DENOMINATION_ATTRIBUTE_SLUG );
                    if ( !empty( $other_amount_prompt ) ) {
                        break;
                    }
                }
            }
        }

        if ( !empty( $other_amount_prompt ) ) {
            return $other_amount_prompt;
        } else {
            return PWGC_OTHER_AMOUNT_PROMPT;
        }
    }
}

if ( ! function_exists( 'pwgc_redeem_url' ) ) {
    function pwgc_redeem_url( $item_data ) {

        if ( isset( $item_data->design ) && isset( $item_data->design['redeem_url'] ) && !empty( $item_data->design['redeem_url'] ) ) {
            $redeem_url = $item_data->design['redeem_url'];
        } else {
            $redeem_url = pwgc_default_redeem_url();
        }

        $redeem_url = add_query_arg( 'pw_gift_card_number', urlencode( $item_data->gift_card_number ), $redeem_url );

        return apply_filters( 'pwgc_redeem_url', $redeem_url, $item_data );
    }
}

if ( ! function_exists( 'pwgc_default_redeem_url' ) ) {
    function pwgc_default_redeem_url() {
        $redeem_url = get_option( 'pwgc_default_redeem_url', '' );
        if ( empty( $redeem_url ) ) {
            $redeem_url = pwgc_shop_url();
        }

        return $redeem_url;
    }
}

if ( ! function_exists( 'pwgc_shop_url' ) ) {
    function pwgc_shop_url() {
        $shop_url = get_permalink( wc_get_page_id( 'shop' ) );
        if ( empty( $shop_url ) ) {
           $shop_url = site_url();
        }

        return $shop_url;
    }
}

if ( ! function_exists( 'pwgc_dashboard_helper' ) ) {
    // Optionally set the selected CSS for the appropriate section.
    function pwgc_dashboard_helper( $item, $output = 'pwgc-dashboard-item-selected' ) {
        $selected = false;
        if ( isset( $_REQUEST['section'] ) ) {
            $selected = ( $_REQUEST['section'] == $item );
        } else if ( $item == 'balances' ) {
            $selected = true;
        }

        echo ( $selected ) ? $output : '';
    }
}

if ( ! function_exists( 'pwgc_paypal_ipn_pdt_bug_exists' ) ) {
    function pwgc_paypal_ipn_pdt_bug_exists() {
        $bug_exists = false;
        $ipn_enabled = false;
        $pdt_enabled = false;
        $woocommerce_paypal_settings = get_option( 'woocommerce_paypal_settings' );

        if ( empty( $woocommerce_paypal_settings['ipn_notification'] ) || 'no' !== $woocommerce_paypal_settings['ipn_notification'] ) {
            $ipn_enabled = true;
        }

        if ( ! empty( $woocommerce_paypal_settings['identity_token'] ) ) {
            $pdt_enabled = true;
        }

        if ( $ipn_enabled && $pdt_enabled ) {
            $bug_exists = true;
        }

        return apply_filters( 'pwgc_paypal_ipn_pdt_bug_exists', $bug_exists );
    }
}

if ( !function_exists( 'pwgc_strtotime' ) ) {
    // Source: https://mediarealm.com.au/articles/wordpress-timezones-strtotime-date-functions/
    function pwgc_strtotime($str) {
      // This function behaves a bit like PHP's StrToTime() function, but taking into account the Wordpress site's timezone
      // CAUTION: It will throw an exception when it receives invalid input - please catch it accordingly
      // From https://mediarealm.com.au/

      $tz_string = get_option('timezone_string');
      $tz_offset = get_option('gmt_offset', 0);

      if (!empty($tz_string)) {
          // If site timezone option string exists, use it
          $timezone = $tz_string;

      } elseif ($tz_offset == 0) {
          // get UTC offset, if it isn’t set then return UTC
          $timezone = 'UTC';

      } else {
          $timezone = $tz_offset;

          if(substr($tz_offset, 0, 1) != "-" && substr($tz_offset, 0, 1) != "+" && substr($tz_offset, 0, 1) != "U") {
              $timezone = "+" . $tz_offset;
          }
      }

      $datetime = new DateTime($str, new DateTimeZone($timezone));
      return $datetime->format('U');
    }
}

if ( !function_exists( 'pwgc_delivery_date_to_time' ) ) {
    function pwgc_delivery_date_to_time( $delivery_date ) {

        $time = false;

        if ( !empty( $delivery_date ) ) {

            $format = get_option( 'pwgc_pikaday_format', 'YYYY-MM-DD' );

            if ( $format == 'YYYY-MM-DD') { @list( $year, $month, $day ) = explode( '-', $delivery_date ); }
            if ( $format == 'YYYY/MM/DD') { @list( $year, $month, $day ) = explode( '/', $delivery_date ); }
            if ( $format == 'YYYY.MM.DD') { @list( $year, $month, $day ) = explode( '.', $delivery_date ); }

            if ( $format == 'DD-MM-YYYY') { @list( $day, $month, $year ) = explode( '-', $delivery_date ); }
            if ( $format == 'DD/MM/YYYY') { @list( $day, $month, $year ) = explode( '/', $delivery_date ); }
            if ( $format == 'DD.MM.YYYY') { @list( $day, $month, $year ) = explode( '.', $delivery_date ); }

            if ( $format == 'MM-DD-YYYY') { @list( $month, $day, $year ) = explode( '-', $delivery_date ); }
            if ( $format == 'MM/DD/YYYY') { @list( $month, $day, $year ) = explode( '/', $delivery_date ); }
            if ( $format == 'MM.DD.YYYY') { @list( $month, $day, $year ) = explode( '.', $delivery_date ); }

            if ( isset( $month ) && isset( $day ) && isset( $year ) ) {
                $time = mktime( 0, 0, 0, $month, $day, $year );
            } else {
                if ( (bool) strtotime( $delivery_date ) ) {
                    $time = strtotime( $delivery_date );
                }
            }
        }

        return $time;
    }
}

if ( !function_exists( 'pwgc_view_email_url' ) ) {
    function pwgc_view_email_url( $args = array() ) {

        // Ensure we always have at least 1 argument to
        // make it easier to append arguments in the JS.
        $args = array( 'pwgc' => time() ) + $args;

        // Build the URL using the arguments.
        $url = add_query_arg( $args, get_home_url() );

        return apply_filters( 'pwgc_view_email_url', $url, $args );
    }
}

if ( !function_exists( 'pwgc_get_example_gift_card_number' ) ) {
    function pwgc_get_example_gift_card_number() {
        return apply_filters( 'pwgc_example_gift_card_number', '1234-WXYZ-5678-ABCD' );
    }
}

if ( ! function_exists( 'pwgc_get_purchased_variation_id' ) ) {
    function pwgc_get_purchased_variation_id( $gift_card_number ) {
        global $wpdb;

        $variation_id = null;

        $sql = $wpdb->prepare( "
            SELECT
                variation.meta_value AS variation_id
            FROM
                {$wpdb->prefix}woocommerce_order_itemmeta AS gift_card
            JOIN
                {$wpdb->prefix}woocommerce_order_itemmeta AS variation ON (variation.order_item_id = gift_card.order_item_id AND variation.meta_key = '_variation_id')
            WHERE
                gift_card.meta_key = %s
                AND gift_card.meta_value = %s
            LIMIT 1
        ", PWGC_GIFT_CARD_NUMBER_META_KEY, $gift_card_number );

        $results = $wpdb->get_results( $sql );
        if ( $results !== null && is_array( $results ) ) {
            foreach ( $results as $row ) {
                $variation_id = $row->variation_id;
            }
        }

        return $variation_id;
    }
}
