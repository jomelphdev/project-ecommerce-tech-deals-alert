<?php

defined( 'ABSPATH' ) or exit;

if ( ! class_exists( 'PW_Gift_Card_Emails_Designer' ) ) :

final class PW_Gift_Cards_Email_Designer {

    private $design_version = '2';
    private $designs;
    private $design_colors;
    private $default_designs;
    private $content_locations;

    function __construct() {
        add_action( 'pwgc_email_css', array( $this, 'pwgc_email_css' ) );
        add_action( 'pwgc_email_top', array( $this, 'pwgc_email_top' ) );
        add_action( 'pwgc_email_before_recipient', array( $this, 'pwgc_email_before_recipient' ) );
        add_action( 'pwgc_email_before_gift_card', array( $this, 'pwgc_email_before_gift_card' ) );
        add_action( 'pwgc_email_gift_card_top', array( $this, 'pwgc_email_inside_gift_card_top' ) );
        add_action( 'pwgc_email_gift_card_bottom', array( $this, 'pwgc_email_inside_gift_card_bottom' ) );
        add_action( 'pwgc_email_inside_gift_card_top', array( $this, 'pwgc_email_inside_gift_card_top' ) );
        add_action( 'pwgc_email_inside_gift_card_bottom', array( $this, 'pwgc_email_inside_gift_card_bottom' ) );
        add_action( 'pwgc_email_after_gift_card', array( $this, 'pwgc_email_after_gift_card' ) );
        add_action( 'pwgc_email_bottom', array( $this, 'pwgc_email_bottom' ) );

        $this->content_locations = array(
            'top' => __( 'Top', 'pw-woocommerce-gift-cards' ),
            'before_recipient' => __( 'Before recipient', 'pw-woocommerce-gift-cards' ),
            'before_gift_card' => __( 'Before Gift Card', 'pw-woocommerce-gift-cards' ),
            'inside_gift_card_top' => __( 'Gift Card Top', 'pw-woocommerce-gift-cards' ),
            'inside_gift_card_bottom' => __( 'Gift Card Bottom', 'pw-woocommerce-gift-cards' ),
            'after_gift_card' => __( 'After Gift Card', 'pw-woocommerce-gift-cards' ),
            'bottom' => __( 'Bottom', 'pw-woocommerce-gift-cards' ),
        );

        $this->design_colors = array(
            'amount_color' => array( '#pwgc-email-amount', 'color' ),
            'amount_label_color' => array( '#pwgc-email-amount-label', 'color' ),
            'additional_content_color' => array( '#pwgc-email-additional-content', 'color' ),
            'pdf_link_color' => array( '#pwgc-email-pdf-link', 'color' ),
            'expiration_date_color' => array( '#pwgc-email-expiration-date', 'color' ),
            'expiration_date_label_color' => array( '#pwgc-email-expiration-date-label', 'color' ),
            'gift_card_border_color' => array( '#pwgc-email-gift-card-table', 'border-color' ),
            'gift_card_color' => array( '#pwgc-email-gift-card-table', 'background-color' ),
            'gift_card_number_color' => array( '#pwgc-email-card-number', 'color' ),
            'gift_card_number_label_color' => array( '#pwgc-email-card-number-label', 'color' ),
            'message_color' => array( '#pwgc-email-message', 'color' ),
            'recipient_color' => array( '#pwgc-email-to', 'color' ),
            'from_color' => array( '#pwgc-email-from', 'color' ),
            'redeem_button_background_color' => array( '#pwgc-email-redeem-button', 'background-color' ),
            'redeem_button_color' => array( '#pwgc-email-redeem-button a', 'color' ),
            'title_color' => array( '#pwgc-email-title', 'color' ),
        );
    }

    function get_content_locations() {
        return $this->content_locations;
    }

    function get_default_designs() {
        global $pw_gift_cards;

        if ( empty( $this->default_designs ) ) {
            $this->default_designs = array();

            $default_design = apply_filters( 'pwgc_default_design', array(
                'order' => '1',
                'amount_color' => '#000000',
                'amount_label_color' => '#666666',
                'background_image' => '', // Deprecated.
                'logo_image' => $pw_gift_cards->relative_url( 'assets/images/email/default.png' ),
                'logo_image_location' => 'top',
                'logo_image_align' => 'center',
                'logo_image_max_width' => '75px',
                'logo_image_max_height' => '75px',
                'additional_content' => '',
                'additional_content_location' => 'top',
                'additional_content_align' => 'left',
                'additional_content_color' => '#000000',
                'expiration_date_color' => '#000000',
                'expiration_date_label_color' => '#666666',
                'gift_card_border_color' => '#333333',
                'gift_card_color' => get_option( 'woocommerce_email_background_color', '#F7F7F7' ),
                'gift_card_number_color' => '#000000',
                'gift_card_number_label_color' => '#666666',
                'name' => __( 'Default', 'pw-woocommerce-gift-cards' ),
                'redeem_button_text' => __( 'Redeem', 'pw-woocommerce-gift-cards' ),
                'redeem_button_background_color' => get_option( 'woocommerce_email_base_color', '#96588a' ),
                'redeem_button_color' => '#ffffff',
                'redeem_button_visibility' => 'visible',
                'redeem_url' => '',
                'pdf_link_visibility' => 'visible',
                'pdf_link_text' => __( 'View or print your gift card.', 'pw-woocommerce-gift-cards' ),
                'pdf_link_color' => '#3871AC',
                'custom_css' => '',
                'title' => sprintf( __( '%s Gift Card', 'pw-woocommerce-gift-cards' ), get_option( 'blogname' ) ),
                'title_color' => '#000000',
                'from_color' => get_option( 'woocommerce_email_text_color', '#3c3c3c' ),
                'recipient_color' => get_option( 'woocommerce_email_text_color', '#3c3c3c' ),
                'message_color' => get_option( 'woocommerce_email_text_color', '#3c3c3c' ),
            ) );
            $this->default_designs[] = $default_design;

            $design = $default_design;
            $design['order'] = '2';
            $design['name'] = __( 'Happy Birthday', 'pw-woocommerce-gift-cards' );
            $design['title'] = __( 'Happy Birthday!', 'pw-woocommerce-gift-cards' );
            $design['amount_color'] = '#FFFFFF';
            $design['amount_label_color'] = '#FFFFFF';
            $design['expiration_date_color'] = '#FFFFFF';
            $design['expiration_date_label_color'] = '#FFFFFF';
            $design['gift_card_border_color'] = '#647EE8';
            $design['gift_card_color'] = '#647EE8';
            $design['gift_card_number_color'] = '#FFFFFF';
            $design['gift_card_number_label_color'] = '#FFFFFF';
            $design['redeem_button_background_color'] = '#FBCC38';
            $design['redeem_button_color'] = '#010101';
            $design['title_color'] = '#FFFFFF';
            $design['logo_image'] = $pw_gift_cards->relative_url( 'assets/images/email/happy-birthday.png' );
            $design['logo_image_max_width'] = '100%';
            $design['logo_image_max_height'] = '275px';
            $design['pdf_link_color'] = '#647EE8';
            $this->default_designs[] = $design;

            $design = $default_design;
            $design['order'] = '3';
            $design['name'] = __( 'Happy Anniversary', 'pw-woocommerce-gift-cards' );
            $design['title'] = __( 'Happy Anniversary!', 'pw-woocommerce-gift-cards' );
            $design['amount_color'] = '#FFFFFF';
            $design['amount_label_color'] = '#FFFFFF';
            $design['expiration_date_color'] = '#FFFFFF';
            $design['expiration_date_label_color'] = '#FFFFFF';
            $design['gift_card_border_color'] = '#6DA7AC';
            $design['gift_card_color'] = '#0AA69C';
            $design['gift_card_number_color'] = '#FFFFFF';
            $design['gift_card_number_label_color'] = '#FFFFFF';
            $design['redeem_button_background_color'] = '#E85555';
            $design['redeem_button_color'] = '#FFFFFF';
            $design['title_color'] = '#FFFFFF';
            $design['logo_image'] = $pw_gift_cards->relative_url( 'assets/images/email/happy-anniversary.png' );
            $design['logo_image_max_width'] = '100%';
            $design['logo_image_max_height'] = '275px';
            $design['pdf_link_color'] = '#0AA69C';
            $this->default_designs[] = $design;

            $design = $default_design;
            $design['order'] = '4';
            $design['name'] = __( 'Congratulations', 'pw-woocommerce-gift-cards' );
            $design['title'] = __( 'Congratulations!', 'pw-woocommerce-gift-cards' );
            $design['amount_color'] = '#FFFFFF';
            $design['amount_label_color'] = '#FFFFFF';
            $design['expiration_date_color'] = '#FFFFFF';
            $design['expiration_date_label_color'] = '#FFFFFF';
            $design['gift_card_border_color'] = '#00006F';
            $design['gift_card_color'] = '#502BED';
            $design['gift_card_number_color'] = '#FFFFFF';
            $design['gift_card_number_label_color'] = '#FFFFFF';
            $design['redeem_button_background_color'] = '#FF4F67';
            $design['redeem_button_color'] = '#FFFFFF';
            $design['title_color'] = '#FFFFFF';
            $design['logo_image'] = $pw_gift_cards->relative_url( 'assets/images/email/congratulations.png' );
            $design['logo_image_max_width'] = '100%';
            $design['logo_image_max_height'] = '275px';
            $design['pdf_link_color'] = '#502BED';
            $this->default_designs[] = $design;

            $design = $default_design;
            $design['order'] = '5';
            $design['name'] = __( 'Happy Holidays', 'pw-woocommerce-gift-cards' );
            $design['title'] = __( 'Happy Holidays!', 'pw-woocommerce-gift-cards' );
            $design['amount_color'] = '#FFFFFF';
            $design['amount_label_color'] = '#FFFFFF';
            $design['expiration_date_color'] = '#FFFFFF';
            $design['expiration_date_label_color'] = '#FFFFFF';
            $design['gift_card_border_color'] = '#50474F';
            $design['gift_card_color'] = '#839E99';
            $design['gift_card_number_color'] = '#FFFFFF';
            $design['gift_card_number_label_color'] = '#FFFFFF';
            $design['redeem_button_background_color'] = '#EE634A';
            $design['redeem_button_color'] = '#FFFFFF';
            $design['title_color'] = '#FFFFFF';
            $design['logo_image'] = $pw_gift_cards->relative_url( 'assets/images/email/happy-holidays.png' );
            $design['logo_image_max_width'] = '100%';
            $design['logo_image_max_height'] = '275px';
            $design['pdf_link_color'] = '#839E99';
            $this->default_designs[] = $design;

            $design = $default_design;
            $design['order'] = '6';
            $design['name'] = __( 'Merry Christmas', 'pw-woocommerce-gift-cards' );
            $design['title'] = __( 'Merry Christmas!', 'pw-woocommerce-gift-cards' );
            $design['amount_color'] = '#FFFFFF';
            $design['amount_label_color'] = '#FFFFFF';
            $design['expiration_date_color'] = '#FFFFFF';
            $design['expiration_date_label_color'] = '#FFFFFF';
            $design['gift_card_border_color'] = '#333333';
            $design['gift_card_color'] = '#F05065';
            $design['gift_card_number_color'] = '#FFFFFF';
            $design['gift_card_number_label_color'] = '#FFFFFF';
            $design['redeem_button_background_color'] = '#FBB14B';
            $design['redeem_button_color'] = '#FFFFFF';
            $design['title_color'] = '#ffffff';
            $design['logo_image'] = $pw_gift_cards->relative_url( 'assets/images/email/merry-christmas.png' );
            $design['logo_image_max_width'] = '100%';
            $design['logo_image_max_height'] = '275px';
            $design['pdf_link_color'] = '#F05065';
            $this->default_designs[] = $design;
        }

        return $this->default_designs;
    }

    function maybe_add_new_default_designs() {
        if ( get_option( 'pwgc_email_design_version' ) == $this->design_version ) {
            return;
        }

        if ( empty( $this->designs ) ) {
            return;
        }

        foreach ( $this->get_default_designs() as $index => $default_design ) {
            $default_design['name'] .= ' ' . $this->design_version;
            $this->designs[] = $default_design;
        }

        update_option( 'pw_gift_card_designs', $this->designs );
        update_option( 'pwgc_email_design_version', $this->design_version );
    }

    function get_designs( $force_refresh = false ) {
        if ( empty( $this->designs ) || $force_refresh ) {
            $this->designs = maybe_unserialize( get_option( 'pw_gift_card_designs', array() ) );
            if ( empty( $this->designs ) ) {
                $this->designs = $this->get_default_designs();

                // Bring over the design elements from the free version if it exists.
                $free_designs = maybe_unserialize( get_option( 'pw_gift_card_designs_free', array() ) );
                if ( !empty( $free_designs ) ) {
                    $this->designs[0]['gift_card_color'] = $free_designs[0]['gift_card_color'];
                    $this->designs[0]['redeem_button_background_color'] = $free_designs[0]['redeem_button_background_color'];
                    $this->designs[0]['redeem_button_color'] = $free_designs[0]['redeem_button_color'];
                }

                // Do not append the new designs since these are up to date already.
                update_option( 'pwgc_email_design_version', $this->design_version );
            } else {
                $this->maybe_add_new_default_designs();
            }

            // Ensure that all saved designs have the current keys in case we've added new things.
            $default_designs = $this->get_default_designs();
            $default_design = reset( $default_designs );
            foreach ( $this->designs as $index => &$design ) {
                foreach( $default_design as $key => $value ) {
                    if ( !isset( $design[ $key ] ) ) {
                        // The "order" key was added in v1.362. Prior to that, the array index was used for sorting.
                        if ( $key == 'order' ) {
                            $design['order'] = $index;
                        } else {
                            $design[ $key ] = $default_design[ $key ];
                        }
                    }
                }
            }
        }

        // Sort the designs by the "Order" property.
        uasort( $this->designs, function( $a, $b ) {
            if ( isset( $a['order'] ) && isset( $b['order'] ) ) {
                if ( $a['order'] != $b['order'] ) {
                    return $a['order'] - $b['order'];
                } else {
                    // If the "order" value is the same, sort alphabetically by name (case sensitive).
                    return strcmp( $a['name'], $b['name'] );
                }
            } else {
                // If there is no "Order" value, fall back to no sort (shouldn't happen).
                return 0;
            }
        });

        return apply_filters( 'pwgc_get_designs', $this->designs );
    }

    function get_design_by_id( $design_id ) {
        $designs = $this->get_designs();
        if ( isset( $designs[ $design_id ] ) ) {
            return $designs[ $design_id ];
        } else if ( count( $designs ) > 0 ) {
            return $designs[0];
        } else {
            return false;
        }
    }

    function color_picker_field( $design, $key, $label ) {
        if ( !empty( $design[ $key ] ) ) {
            $color = $design[ $key ];
        } else {
            $color = get_option( 'woocommerce_email_text_color', '#3c3c3c' );
        }
        $id = 'pwgc-designer-' . str_replace( '_', '-', $key );

        $preview_element = $this->design_colors[ $key ][0];
        $preview_element_css = $this->design_colors[ $key ][1];

        ?>
        <p class="form-field">
            <label class="pwgc-designer-label"><?php echo $label; ?></label>
            <input type="text" name="<?php echo $key; ?>" id="<?php echo $id; ?>" value="<?php echo $color; ?>" style="color: <?php echo $color; ?>; background-color: <?php echo $color; ?>; max-width: 75px;">
        </p>
        <script>
            jQuery(function() {
                pwgcAssignColorPicker('#<?php echo $id; ?>', '<?php echo $preview_element; ?>', '<?php echo $preview_element_css; ?>');
            });
        </script>
        <?php
    }

    function pwgc_email_css( $item_data ) {
        $design = $item_data->design;
        foreach ( $this->design_colors as $key => $map ) {
            $value = '';

            if ( isset( $design[ $key ] ) ) {
                $value = $design[ $key ];
            } else if ( isset( $map[2] ) ) {
                $value = $map[2];
            }

            if ( !empty( $value ) ) {
                echo "$map[0] { $map[1]: $value; }\n";
            }
        }

        if ( isset( $design['additional_content_align'] ) && !empty( $design['additional_content_align'] ) ) {
            ?>
            #pwgc-email-additional-content {
                text-align: <?php echo $design['additional_content_align']; ?>;
            }
            <?php
        }

        if ( $design['redeem_button_visibility'] != 'visible' || $item_data->is_pdf ) {
            ?>
            #pwgc-email-redeem-button {
                display: none;
            }
            <?php
        }

        if ( $design['pdf_link_visibility'] != 'visible' || $item_data->is_pdf ) {
            ?>
            #pwgc-email-pdf-link-container {
                display: none;
            }
            <?php
        }

        // Background images are no longer recommended due to Outlook issues. Left here for backwards compatibility.
        if ( isset( $design['background_image'] ) && !empty( $design['background_image'] ) ) {
            ?>
            #pwgc-email-gift-card-table {
                background-image: url('<?php echo $design['background_image']; ?>');
                background-position: center;
                background-repeat: no-repeat;
                background-size: auto 100%;
                padding-left: 0;
                padding-right: 0;
            }

            #pwgc-email-gift-card-table {
                min-height: 275px;
                width: 500px;
            }

            #pwgc-email-gift-card-bottom-cell, #pwgc-email-gift-card-top-cell {
                display: none;
            }

            #pwgc-email-container {
                width: 500px;
            }
            <?php
        }

        echo $design['custom_css'];
    }

    function output_by_location( $location, $item_data ) {
        if ( empty( $item_data ) || !property_exists( $item_data, 'design' ) ) { return; }

        if ( $location === $item_data->design['logo_image_location'] ) {
            wc_get_template( 'emails/email-pw-gift-card-image.php', array( 'item_data' => $item_data ), '', PWGC_PLUGIN_ROOT . 'templates/woocommerce/' );
        }

        if ( $location === $item_data->design['additional_content_location'] ) {
            echo '<div id="pwgc-email-additional-content">' . wp_kses_post( wpautop( $item_data->design['additional_content'] ) ) . '</div>';
        }
    }

    function pwgc_email_top( $item_data ) {
        $this->output_by_location( 'top', $item_data );
    }

    function pwgc_email_before_recipient( $item_data ) {
        $this->output_by_location( 'before_recipient', $item_data );
    }

    function pwgc_email_before_gift_card( $item_data ) {
        $this->output_by_location( 'before_gift_card', $item_data );
    }

    function pwgc_email_inside_gift_card_top( $item_data ) {
        $this->output_by_location( 'inside_gift_card_top', $item_data );
    }

    function pwgc_email_inside_gift_card_bottom( $item_data ) {
        $this->output_by_location( 'inside_gift_card_bottom', $item_data );
    }

    function pwgc_email_after_gift_card( $item_data ) {
        $this->output_by_location( 'after_gift_card', $item_data );
    }

    function pwgc_email_bottom( $item_data ) {
        $this->output_by_location( 'bottom', $item_data );
    }
}

global $pw_gift_cards_email_designer;
$pw_gift_cards_email_designer = new PW_Gift_Cards_Email_Designer;

endif;
