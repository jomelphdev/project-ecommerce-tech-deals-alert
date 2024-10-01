<?php

defined( 'ABSPATH' ) or exit;

if ( empty( $_POST['confirm'] ) ) {
    ?>
    <div class="pwgc-import-preview-message">
        <div class="pwgc-import-summary-preview-header"><?php _e( 'THIS IS ONLY A PREVIEW', 'pw-woocommerce-gift-cards' ); ?></div>
        <p>
            <?php _e( 'No cards have been imported yet. If the results look good, click on the "Import cards" button below to actually create the gift cards.', 'pw-woocommerce-gift-cards' ); ?>
        </p>
        <p>
            <label for="pwgc-admin-import-overwrite"><input type="checkbox" id="pwgc-admin-import-overwrite" value="yes"><?php _e( 'Overwrite data for existing gift card numbers.', 'pw-woocommerce-gift-cards' ); ?></label>
        </p>
        <p>
            <label for="pwgc-admin-send-email"><input type="checkbox" id="pwgc-admin-send-email" value="yes"><?php _e( 'Email the gift card to the recipient if email address is included in the import.', 'pw-woocommerce-gift-cards' ); ?></label>
        </p>
        <div id="pwgc-admin-import-send-email-container" class="pwgc-hidden">
            <div>
                <label for="pwgc-admin-import-from">
                    <?php _e( 'From', 'pw-woocommerce-gift-cards' ); ?>
                </label>
                <br />
                <input type="text" id="pwgc-admin-import-from" value="<?php echo get_option( 'admin_email' ); ?>">
            </div>

            <div style="margin-top: 12px;">
                <label for="pwgc-admin-import-send-email-design">
                    <?php _e( 'Email Design', 'pw-woocommerce-gift-cards' ); ?>
                </label>
                <br />
                <select id="pwgc-admin-import-send-email-design">
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
        <p>
            <a href="#" id="pwgc-import-file-confirm" onClick="pwgcImportGiftCards(true); return false;" class="button button-primary"><?php esc_html( _e( 'Import cards', 'pw-woocommerce-gift-cards' ) ); ?></a>
        </p>
    </div>
    <script>
        jQuery('#pwgc-admin-send-email').on('change', function() {
            jQuery('#pwgc-admin-import-send-email-container').toggle(jQuery(this).checked);
        });
    </script>
    <?php
}

?>
<table class="pwgc-admin-table">
    <tr>
        <th><?php _e( 'Row', 'pw-woocommerce-gift-cards' ); ?></th>
        <th><?php _e( 'Card Number', 'pw-woocommerce-gift-cards' ); ?></th>
        <th><?php _e( 'Balance', 'pw-woocommerce-gift-cards' ); ?></th>
        <th class="pwgc-expiration-date-element" <?php if ( 'no' !== get_option( 'pwgc_no_expiration_date', 'no' ) ) { echo 'style="display: none;"'; } ?>><?php _e( 'Expiration Date', 'pw-woocommerce-gift-cards' ); ?></th>
        <th><?php _e( 'Recipient', 'pw-woocommerce-gift-cards' ); ?></th>
        <th><?php _e( 'Result', 'pw-woocommerce-gift-cards' ); ?></th>
    </tr>
    <?php

        foreach ( $import_results as $index => $row ) {
            ?>
            <tr>
                <td><?php echo ( $index + 1 ); ?></td>
                <td><?php echo esc_html( $row['number'] ); ?></td>
                <td><?php echo wc_price( $row['balance'] ); ?></td>
                <td class="pwgc-expiration-date-element" <?php if ( 'no' !== get_option( 'pwgc_no_expiration_date', 'no' ) ) { echo 'style="display: none;"'; } ?>><?php echo $row['expiration_date']; ?></td>
                <td><?php echo $row['recipient']; ?></td>
                <td>
                    <?php
                        if ( $row['result'] === true ) {
                            ?>
                            <span style="color: green;"><i class="fas fa-check-circle"></i> <?php _e( 'OK', 'pw-woocommerce-gift-cards' ); ?></span>
                            <?php
                        } else {
                            ?>
                            <span style="color: red;"><i class="fas fa-exclamation-circle"></i> <?php printf( __( 'ERROR: %s', 'pw-woocommerce-gift-cards' ), $row['result'] ); ?></span>
                            <?php
                        }
                    ?>
                </td>
            </div>
            <?php
        }

    ?>
</table>
<div class="pwgc-import-summary">
    <div style="color: green;">
        <?php
            printf( __( '%s valid', 'pw-woocommerce-gift-cards' ), number_format( $success_count ) );
        ?>
    </div>
    <div style="color: red;">
        <?php
            printf( __( '%s invalid', 'pw-woocommerce-gift-cards' ), number_format( $failure_count ) );
        ?>
    </div>
    <div style="font-weight: 600;">
        <?php
            printf( __( '%s total records processed', 'pw-woocommerce-gift-cards' ), number_format( $success_count + $failure_count ) );
        ?>
    </div>
</div>
<?php
