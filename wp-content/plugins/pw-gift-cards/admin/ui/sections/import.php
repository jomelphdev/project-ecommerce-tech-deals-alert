<?php

defined( 'ABSPATH' ) or exit;

?>
<div id="pwgc-section-import" class="pwgc-section" style="<?php pwgc_dashboard_helper( 'import', 'display: block;' ); ?>">
    <form id="pwgc-import-gift-cards-form" method="POST" enctype="multipart/form-data">
        <div class="pwgc-import-gift-cards-container">
            <div>
                <div class="pwgc-import-header">
                    <?php esc_html_e( 'Import CSV File', 'pw-woocommerce-gift-cards' ); ?>
                </div>
                <input type="file" name="pwgc_import_file" id="pwgc-import-file" accept="text/csv" required>
                <br /><br />
                <input type="submit" id="pwgc-import-file-submit-button" class="button button-primary" value="<?php esc_attr_e( 'Upload CSV File', 'pw-woocommerce-gift-cards' ); ?>">
            </div>
            <div class="pwgc-import-gift-cards-instructions">
                <div class="pwgc-import-header">
                    <?php esc_html_e( 'Import Instructions', 'pw-woocommerce-gift-cards' ); ?>
                </div>
                <div>
                    <?php esc_html_e( 'Import a comma-separated value file (CSV) of existing gift card numbers. This is useful for importing physical gift cards sold to customers. You will see a preview of the results before anything is saved to the database.', 'pw-woocommerce-gift-cards' ); ?>
                    <br />
                    <br />
                    <?php esc_html_e( 'The CSV should NOT have a header and the columns must be in this order:', 'pw-woocommerce-gift-cards' ); ?>
                </div>
                <div style="margin: 12px 16px;">
                    <pre><?php esc_html_e( 'Gift Card Number, Balance, Expiration Date (optional), Recipient Email (optional)', 'pw-woocommerce-gift-cards' ); ?></pre>
                </div>
                <div>
                    <a href="<?php echo plugins_url( '/assets/gift-cards-sample.csv', PWGC_PLUGIN_FILE ); ?>" class="button"><i class="far fa-file-excel"></i> Download a sample CSV file</a>
                </div>
            </div>
        </div>
        <div id="pwgc-import-results"></div>
    </form>
    <div class="pwgc-export-gift-cards-container">
        <?php
            $export_url = add_query_arg( 'pwgc_export', '1', get_site_url() );
            $export_url = add_query_arg( 'page', 'pw-gift-cards', $export_url );
            $export_url = add_query_arg( 'security', wp_create_nonce( 'pw-gift-cards-export' ), $export_url );
        ?>
        <div>
            <div class="pwgc-import-header">
                <?php esc_html_e( 'Export your gift card data', 'pw-woocommerce-gift-cards' ); ?>
            </div>
            <div style="margin-top: 1em;">
                <a href="<?php esc_attr_e( $export_url ); ?>" class="button"><i class="far fa-file-excel"></i> <?php esc_html_e( 'Download CSV File', 'pw-woocommerce-gift-cards' ); ?></a>
            </div>
        </div>
    </div>
</div>
