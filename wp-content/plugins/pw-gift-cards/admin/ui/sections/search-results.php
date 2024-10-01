<?php

defined( 'ABSPATH' ) or exit;

if ( count( $gift_cards ) == 0 ) {
    ?>
    <h1><?php _e( 'No results', 'pw-woocommerce-gift-cards' ); ?></h1>
    <p><?php _e( 'There are no gift cards found matching your search terms.', 'pw-woocommerce-gift-cards' ); ?></p>
    <?php
} else {
    ?>
    <table id="pwgc-search-results-table" class="pwgc-admin-table">
        <tr>
            <th><?php _e( 'Card Number', 'pw-woocommerce-gift-cards' ); ?></th>
            <th><?php _e( 'Balance', 'pw-woocommerce-gift-cards' ); ?></th>
            <th class="pwgc-expiration-date-element" <?php if ( 'no' !== get_option( 'pwgc_no_expiration_date', 'no' ) ) { echo 'style="display: none;"'; } ?>><?php _e( 'Expiration Date', 'pw-woocommerce-gift-cards' ); ?></th>
            <th><?php _e( 'Recipient', 'pw-woocommerce-gift-cards' ); ?></th>
            <th>&nbsp;</th>
        </tr>
        <?php
            require_once( 'search-results-rows.php' );
        ?>
    </table>
    <form id="pwgc-search-results-email-form" class="pwgc-search-results-email-form pwgc-hidden">
        <div>
            <label>
                <?php esc_html_e( 'Recipient Email Address', 'pw-woocommerce-gift-cards' ); ?><br />
                <input type="text" name="to" autocomplete="off" required>
            </label>
        </div>
        <div>
            <label>
                <?php esc_html_e( 'From (optional)', 'pw-woocommerce-gift-cards' ); ?><br />
                <input type="text" name="from" autocomplete="off">
            </label>
        </div>
        <div>
            <label>
                <?php esc_html_e( 'Note (optional)', 'pw-woocommerce-gift-cards' ); ?><br />
                <textarea name="note" autocomplete="off"></textarea>
            </label>
        </div>
        <div>
            <label>
                <?php esc_html_e( 'Email Design', 'pw-woocommerce-gift-cards' ); ?><br />
                <select name="email_design" autocomplete="off">
                    <?php
                        $designs = $GLOBALS['pw_gift_cards_email_designer']->get_designs();
                        foreach ( $designs as $id => $design_option ) {
                            ?>
                            <option value="<?php echo $id; ?>"><?php echo esc_html( $design_option['name'] ); ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div>
            <input type="submit" class="button button-primary pwgc-search-results-send-email-button" value="<?php esc_attr_e( 'Send', 'pw-woocommerce-gift-cards' ); ?>">
            <a href="#" class="button button-secondary pwgc-search-results-send-email-cancel-button"><?php esc_html_e( 'Cancel', 'pw-woocommerce-gift-cards' ); ?></a>
        </div>
    </form>
    <?php
}
