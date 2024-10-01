<?php

// This template only needed if we have an image or if we're in the Designer (preview mode).
if ( ! isset( $item_data->preview ) && empty( $item_data->design['logo_image'] ) ) {
    return;
}

do_action( 'pwgc_email_before_logo', $item_data );

?>
<table id="pwgc-email-logo-image-table" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td id="pwgc-email-logo-image-cell" align="<?php echo $item_data->design['logo_image_align']; ?>" valign="top">
            <?php
                if ( !empty( $item_data->design['logo_image'] ) ) {
                    ?>
                    <img src="<?php echo esc_url( $item_data->design['logo_image'] ); ?>" id="pwgc-email-logo-image" />
                    <?php
                }
            ?>
        </td>
    </tr>
</table>
<?php

do_action( 'pwgc_email_after_logo', $item_data );
