<?php
    if ( ! isset( $item_data->preview ) ) {
        do_action( 'woocommerce_email_header', $email_heading, $email );
    }
?>
<style type="text/css">
    @font-face {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 400;
        src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v15/CrYjSnGjrRCn0pd9VQsnFOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
    }

    @font-face {
        font-family: 'Roboto';
        font-style: normal;
        font-weight: 700;
        src: local('Roboto Bold'), local('Roboto-Bold'), url(https://fonts.gstatic.com/s/roboto/v15/d-6IYplOFocCacKzxwXSOLO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
    }

    #pwgc-email-container {
        font-family: 'Roboto', Helvetica, Arial, sans-serif;
        font-size: 14px;
    }

    .pwgc-email-section {
        margin: 24px 0;
    }

    #pwgc-email-title {
        font-size: 150%;
        font-weight: bold;
        line-height: 1.4;
        text-align: center;
    }

    #pwgc-email-message {
        margin-top: 0px;
    }

    .pwgc-email-label {
        font-size: 80%;
        line-height: 1.4;
    }

    #pwgc-email-gift-card-table {
        padding-left: 12px;
        padding-right: 12px;
        border-style: solid;
        border-width: 1px;
        border-radius: 16px;
        max-width: 1000px;
    }

    #pwgc-email-gift-card-table-table {
        width: 100%;
    }

    #pwgc-email-gift-card-table td {
        padding-top: 12px;
        vertical-align: top;
    }

    #pwgc-email-gift-card-container {
        min-height: 275px;
    }

    #pwgc-email-amount {
        font-size: 250%;
        line-height: 1.0;
    }

    #pwgc-email-card-number {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 600;
        font-size: 125%;
        line-height: 1.0;
    }

    #pwgc-email-expiration-date {
        font-size: 90%;
        line-height: 1.0;
    }

    #pwgc-email-expiration-date-section {
        float: right;
    }

    #pwgc-email-redeem-button {
        border: none;
        padding: 15px 32px;
        text-align: center;
        border-radius: 6px;
        display: inline-block;
    }

    #pwgc-email-redeem-button a {
        font-size: 16px;
        text-decoration: none;
        display: inline-block;
    }

    #pwgc-email-logo-image {
        max-width: <?php echo $item_data->design['logo_image_max_width']; ?>;
        max-height: <?php echo $item_data->design['logo_image_max_height']; ?>;
    }

    <?php
        do_action( 'pwgc_email_css', $item_data );
    ?>
</style>
<div id="pwgc-email-container">
    <div id="pwgc-email-top">
        <?php do_action( 'pwgc_email_top', $item_data ); ?>
    </div>
    <div id="pwgc-email-before-recipient">
        <?php do_action( 'pwgc_email_before_recipient', $item_data ); ?>
    </div>
    <div id="pwgc-email-message-container">
        <?php
            if ( !empty( $item_data->recipient_name ) ) {
                ?>
                <div id="pwgc-email-to" class="pwgc-email-section pwgc-email-to-message">
                    <?php echo apply_filters( 'pwgc_email_template_to_label', esc_html( __( 'To', 'pw-woocommerce-gift-cards' ) ), $item_data ); ?>: <?php echo apply_filters( 'pwgc_email_template_to', esc_html( $item_data->recipient_name ), $item_data ); ?>
                </div>
                <?php
            }

            do_action( 'pwgc_email_before_from', $item_data );

            if ( !empty( $item_data->from ) ) {
                ?>
                <div id="pwgc-email-from" class="pwgc-email-section pwgc-email-to-message">
                    <?php echo apply_filters( 'pwgc_email_template_from_label', __( 'From', 'pw-woocommerce-gift-cards' ), $item_data ); ?>: <?php echo apply_filters( 'pwgc_email_template_from', esc_html( $item_data->from ), $item_data ); ?>
                </div>
                <?php
            }

            do_action( 'pwgc_email_before_message', $item_data );

            if ( !empty( $item_data->message ) ) {
                ?>
                <div id="pwgc-email-message" class="pwgc-email-section pwgc-email-to-message">
                    <?php echo apply_filters( 'pwgc_email_template_message', nl2br( esc_html( $item_data->message ) ), $item_data ); ?>
                </div>
                <?php
            }
        ?>
    </div>
    <div id="pwgc-email-before-gift-card">
        <?php do_action( 'pwgc_email_before_gift_card', $item_data ); ?>
    </div>
    <div id="pwgc-email-gift-card-container">
        <div id="pwgc-email-gift-card-table">
            <table id="pwgc-email-gift-card-table-table">
                <tr>
                    <td id="pwgc-email-gift-card-top-cell"><?php
                        do_action( 'pwgc_email_inside_gift_card_top', $item_data );
                    ?></td>
                </tr>
                <tr>
                    <td id="pwgc-email-title">
                        <?php echo apply_filters( 'pwgc_email_template_title', esc_html( $item_data->design['title'] ), $item_data ); ?>
                    </td>
                </tr>
                <tr>
                    <td id="pwgc-email-gift-card-after-title-cell"></td>
                </tr>
                <tr>
                    <td id="pwgc-email-gift-card-amount-cell">
                        <div id="pwgc-email-amount-label" class="pwgc-email-label"><?php echo apply_filters( 'pwgc_email_template_amount_label', esc_html( __( 'Amount', 'pw-woocommerce-gift-cards' ) ), $item_data ); ?></div>
                        <div id="pwgc-email-amount"><?php echo apply_filters( 'pwgc_email_template_amount', wc_price( $item_data->amount, $item_data->wc_price_args ), $item_data ); ?></div>
                    </td>
                </tr>
                <tr>
                    <td id="pwgc-email-gift-card-number-cell">
                        <div id="pwgc-email-card-number-label" class="pwgc-email-label"><?php echo apply_filters( 'pwgc_email_template_number_label', esc_html( __( 'Gift Card Number', 'pw-woocommerce-gift-cards' ) ), $item_data ); ?></div>
                        <div id="pwgc-email-card-number"><?php echo apply_filters( 'pwgc_email_template_number', esc_html( $item_data->gift_card_number ), $item_data ); ?></div>
                    </td>
                </tr>
                <tr>
                    <td id="pwgc-email-gift-card-redeem-cell">
                        <?php
                            if ( !empty( $item_data->expiration_date ) ) {
                                ?>
                                <div id="pwgc-email-expiration-date-section" class="pwgc-email-section pwgc-expiration-date-element" <?php if ( 'no' !== get_option( 'pwgc_no_expiration_date', 'no' ) ) { echo 'style="display: none;"'; } ?>>
                                    <div id="pwgc-email-expiration-date-label" class="pwgc-email-label"><?php echo apply_filters( 'pwgc_email_template_expiration_date_label', esc_html( __( 'Expires', 'pw-woocommerce-gift-cards' ) ), $item_data ); ?></div>
                                    <div id="pwgc-email-expiration-date"><?php echo apply_filters( 'pwgc_email_template_expiration_date', esc_html( $item_data->expiration_date ), $item_data ); ?></div>
                                </div>
                                <?php
                            }
                        ?>
                        <div id="pwgc-email-redeem-button">
                            <a href="<?php echo apply_filters( 'pwgc_email_template_redeem_url', esc_attr( pwgc_redeem_url( $item_data ) ), $item_data ); ?>"><?php echo apply_filters( 'pwgc_email_template_redeem_button_text', esc_html( $item_data->design['redeem_button_text'] ), $item_data ); ?></a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td id="pwgc-email-gift-card-bottom-cell"><?php
                        do_action( 'pwgc_email_inside_gift_card_bottom', $item_data );
                    ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div id="pwgc-email-after-gift-card">
        <?php do_action( 'pwgc_email_after_gift_card', $item_data ); ?>
    </div>
    <div id="pwgc-email-pdf-link-container" class="pwgc-email-section">
        <?php
            $email_args = array(
                'pwgc_number'       => $item_data->gift_card_number,
                'design_id'         => isset( $item_data->design_id ) ? $item_data->design_id : '0',
                'recipient_name'    => urlencode( $item_data->recipient_name ),
                'from'              => urlencode( $item_data->from ),
                'message'           => urlencode( $item_data->message ),
                'pdf'               => 1,
            );

            if ( $item_data->gift_card_number == pwgc_get_example_gift_card_number() ) {
                $email_args['other_amount'] = $item_data->amount;
                $email_args['amount'] = $item_data->amount;
                $email_args['expiration_date'] = $item_data->expiration_date;
            }

            $view_email_url = pwgc_view_email_url( $email_args );
        ?>
        <a href="<?php echo apply_filters( 'pwgc_email_template_view_email_url', esc_attr( $view_email_url ), $item_data ); ?>" id="pwgc-email-pdf-link" target="_blank"><?php echo apply_filters( 'pwgc_email_template_pdf_link_text', esc_html( $item_data->design['pdf_link_text'] ), $item_data ); ?></a>
    </div>
    <div id="pwgc-email-bottom">
        <?php do_action( 'pwgc_email_bottom', $item_data ); ?>
    </div>
</div>
<?php

    if ( ! isset( $item_data->preview ) ) {
        do_action( 'woocommerce_email_footer', $email );
    }
?>
