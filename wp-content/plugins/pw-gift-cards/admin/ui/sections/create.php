<?php

defined( 'ABSPATH' ) or exit;

global $pw_gift_cards_email_designer;

?>
<div id="pwgc-section-create" class="pwgc-section" style="<?php pwgc_dashboard_helper( 'create', 'display: block;' ); ?>">
    <form id="pwgc-create-gift-card-form">
        <div>
            <div style="display: inline-block;">
                <p class="form-field pwgc-create-quantity_field">
                    <label for="pwgc-create-quantity"><?php _e( 'Number of cards', 'pw-woocommerce-gift-cards' ); ?></label>
                    <input type="number" class="short" name="pwgc-create-quantity" id="pwgc-create-quantity" value="1" placeholder="" step="1" min="1" required>
                </p>
            </div>
        </div>
        <div>
            <div style="display: inline-block;">
                <p class="form-field pwgc-create-amount_field">
                    <label for="pwgc-create-amount"><?php _e( 'Initial balance', 'pw-woocommerce-gift-cards' ); ?> (<?php echo get_woocommerce_currency_symbol(); ?>)</label>
                    <input type="text" class="short wc_input_price" name="pwgc-create-amount" id="pwgc-create-amount" value="" placeholder="" required>
                </p>
            </div>
        </div>
        <div class="pwgc-expiration-date-element" style="display: <?php if ( 'no' === get_option( 'pwgc_no_expiration_date', 'no' ) ) { echo 'inline-block'; } else { echo 'none'; } ?>;">
            <div>
                <p class="form-field pwgc-create-expiration_date">
                    <label for="pwgc-create-expiration-date"><?php _e( 'Expiration date (optional)', 'pw-woocommerce-gift-cards' ); ?></label>
                    <input type="text" class="short " name="pwgc-create-expiration-date" id="pwgc-create-expiration-date" value="" placeholder="" autocomplete="off">
                </p>
            </div>
        </div>
        <div>
            <div style="display: inline-block;">
                <p class="form-field pwgc-recipient">
                    <label for="pwgc-recipient"><?php _e( 'Recipient Email (optional) - Will be emailed the gift card immediately.', 'pw-woocommerce-gift-cards' ); ?></label>
                    <input type="text" name="pwgc-recipient" id="pwgc-recipient">
                </p>
            </div>
        </div>
        <div>
            <div style="display: inline-block;">
                <p class="form-field pwgc-design-id">
                    <label for="pwgc-design-id">
                        <?php _e( 'Email Design - Only used if Recipient Email has been specified.', 'pw-woocommerce-gift-cards' ); ?><br />
                        <select id="pwgc-create-design-id" name="design_id" style="margin-right: 16px;">
                            <?php
                                $designs = $pw_gift_cards_email_designer->get_designs();
                                $design = reset( $designs );
                                $design_id = key( $designs );

                                foreach ( $designs as $id => $design_option ) {
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo esc_html( $design_option['name'] ); ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </label>
                </p>
            </div>
        </div>
        <div>
            <div style="display: inline-block;">
                <p class="form-field pwgc-from">
                    <label for="pwgc-from"><?php _e( 'From (optional) - Shown to the Recipient in the gift card email.', 'pw-woocommerce-gift-cards' ); ?></label>
                    <input type="text" name="pwgc-from" id="pwgc-from">
                </p>
            </div>
        </div>
        <div>
            <div style="display: inline-block;">
                <p class="form-field pwgc-create-note">
                    <label for="pwgc-create-note"><?php _e( 'Note (optional) - Shown to the Recipient in the gift card email.', 'pw-woocommerce-gift-cards' ); ?></label>
                    <input type="text" name="pwgc-create-note" id="pwgc-create-note">
                </p>
            </div>
        </div>
        <div>
            <div style="display: inline-block;">
                <p class="form-field pwgc-create-number">
                    <label for="pwgc-create-number"><?php _e( 'Gift Card Number (optional) - Existing gift card number to insert.', 'pw-woocommerce-gift-cards' ); ?></label>
                    <input type="text" name="pwgc-create-number" id="pwgc-create-number">
                </p>
            </div>
        </div>
        <div>
            <div style="display: inline-block; margin-top: 12px;">
                <div id="pwgc-create-gift-card-message"></div>
                <input type="submit" id="pwgc-create-gift-card-button" class="button button-primary" value="<?php _e( 'Create', 'pw-woocommerce-gift-cards' ); ?>">
            </div>
        </div>
    </form>

    <div style="margin-top: 32px;">
        <div id="pwgc-create-search-results"></div>
    </div>
</div>
<script>
    jQuery(function() {
        jQuery('#pwgc-create-expiration-date').datepicker({
            defaultDate: '',
            dateFormat: 'yy-mm-dd',
            numberOfMonths: 1,
            showButtonPanel: true
        });
    });
</script>