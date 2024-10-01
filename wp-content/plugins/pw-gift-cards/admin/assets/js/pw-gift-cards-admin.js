document.addEventListener("DOMContentLoaded", function(event) {

    pwgcAdminBalanceSearch();

    jQuery('#pwgc-balance-search-form').on('submit', function(e) {
        pwgcAdminBalanceSearch();

        e.preventDefault();
        return false;
    });

    if (jQuery('#pwgc-balance-search').val()) {
        pwgcAdminBalanceSearch();
    }

    jQuery('#pwgc-create-gift-card-form').on('submit', function(e) {

        var form = jQuery(this);
        var submitButton = jQuery('#pwgc-create-gift-card-button');
        var amount = jQuery('#pwgc-create-amount').val();
        var quantity = jQuery('#pwgc-create-quantity').val();
        var expirationDate = jQuery('#pwgc-create-expiration-date').val();
        var note = jQuery('#pwgc-create-note').val();
        var number = jQuery('#pwgc-create-number').val();
        var fromString = jQuery('#pwgc-from').val();
        var recipient = jQuery('#pwgc-recipient').val();
        var designId = jQuery('#pwgc-create-design-id').val();
        var messageContainer = jQuery('#pwgc-create-gift-card-message');

        submitButton.prop('disabled', true);
        messageContainer.html('<i class="fas fa-cog fa-spin fa-3x"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-create_gift_card', 'amount': amount, 'quantity': quantity, 'expiration_date': expirationDate, 'note': note, 'number': number, 'from': fromString, 'recipient': recipient, 'design_id': designId, 'security': pwgc.nonces.create_gift_card}, function(result) {
            jQuery('#pwgc-create-search-results').html(result.html);
            submitButton.prop('disabled', false);
            messageContainer.html('');
            pwgcAdminLoadBalanceSummary();
            form.trigger('reset');

        }).fail(function(xhr, textStatus, errorThrown) {
            submitButton.prop('disabled', false);
            messageContainer.html('');

            if (errorThrown) {
                alert(errorThrown);
            } else {
                alert('Unknown Error');
            }
        });

        e.preventDefault();
        return false;
    });

    jQuery('#pwgc-import-gift-cards-form').on('submit', function(e) {
        pwgcImportGiftCards(false);

        e.preventDefault();
        return false;
    });

    jQuery('#pwgc-save-settings-form').on('submit', function(e) {
        var messageContainer = jQuery('#pwgc-save-settings-message');
        var saveButton = jQuery('#pwgc-save-settings-button');
        var form = jQuery('#pwgc-save-settings-form').serialize();

        saveButton.hide();
        messageContainer.html('<i class="fas fa-cog fa-spin fa-3x"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-save_settings', 'form': form, 'security': pwgc.nonces.save_settings }, function(result) {
            saveButton.show();
            messageContainer.html(result.data.html);
            jQuery('.pwgc-summary-item-date').toggle(document.getElementById('pwgc_show_balances_by_date').checked);
        }).fail(function(xhr, textStatus, errorThrown) {
            saveButton.show();
            if (errorThrown) {
                messageContainer.html(errorThrown);
            } else {
                messageContainer.text('Unknown ajax error');
            }
        });

        e.preventDefault();
        return false;
    });

    if (jQuery('#pwgc-setup-container').length == 0) {
        jQuery('#pwgc-balance-search').trigger('focus');
    }

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-check-license'}, function(registration) {
        if (!registration.active) {
            jQuery('.pwgc-main-content').css('display', 'none');
            jQuery('#pwgc-activation-main').css('display', 'inline-block');
            jQuery('#pwgc-license-key').trigger('focus');

            if (registration.error !== '') {
                jQuery('.pwgc-activation-error').text(registration.error).removeClass('pwgc-hidden');
            }
        }
    });

    // Hide the default meta fields and prevent Enter from submitting the form.
    jQuery('#pwgc-license-key').on('keydown', function(e){
        if (e.keyCode == 13) {
            pwgcActivate();
            e.preventDefault();
            return false;
        }
    });

    jQuery('#pwgc-activate-license').on('click', function(e) {
        pwgcActivate();
        e.preventDefault();
        return false;
    });

    jQuery('#pwgc-renew-dismiss').on('click', function(e) {
        jQuery('#pwgc-renew-container').hide();
        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-hide_renew_notice'});
    });

    jQuery('#pwgc-setup-create-product').on('click', function(e) {
        var button = jQuery(this);
        button.html('<i class="fas fa-cog fa-spin"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-create_product', 'security': pwgc.nonces.create_product }, function(result) {
            if (result.success) {
                button.hide();
                jQuery('#pwgc-setup-create-product-success').show();
            } else {
                button.text(button.attr('data-text'));
                jQuery('#pwgc-setup-error').text('Unknown error');
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            button.text(button.attr('data-text'));
            if (errorThrown) {
                jQuery('#pwgc-setup-error').text(errorThrown);
            } else {
                jQuery('#pwgc-setup-error').text('Unknown ajax error');
            }
        });

        e.preventDefault();
        return false;
    });

    jQuery('#pwgc-setup-create-balance-page').on('click', function(e) {
        var button = jQuery(this);
        button.html('<i class="fas fa-cog fa-spin"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-create_balance_page', 'security': pwgc.nonces.create_balance_page }, function(result) {
            if (result.success) {
                button.hide();
                jQuery('#pwgc-setup-create-balance-page-success').show();
            } else {
                button.text(button.attr('data-text'));
                jQuery('#pwgc-setup-error').text('Unknown error');
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            button.text(button.attr('data-text'));
            if (errorThrown) {
                jQuery('#pwgc-setup-error').text(errorThrown);
            } else {
                jQuery('#pwgc-setup-error').text('Unknown ajax error');
            }
        });

        e.preventDefault();
        return false;
    });

    jQuery('.pwgc-dashboard-item').on('click', function(e) {
        jQuery('.pwgc-dashboard-item').removeClass('pwgc-dashboard-item-selected');
        jQuery(this).addClass('pwgc-dashboard-item-selected');
        var section = jQuery(this).attr('data-section');
        jQuery('.pwgc-section').hide();
        jQuery('#pwgc-section-' + section).show();
    });

    jQuery('#pwgc-design-selector').on('change', function(e) {
        pwgcSelectDesign();
        e.preventDefault();
        return false;
    });

    jQuery('#pwgc-add-design-button').on('click', function(e) {
        pwgcCreateDesign();
        e.preventDefault();
        return false;
    });

    jQuery('#pwgc_no_expiration_date').on('change', function() {
        if (this.checked) {
            jQuery('.pwgc-expiration-date-element').hide();
        } else {
            jQuery('.pwgc-expiration-date-element').show();
        }
    });
});

function pwgcDatePickerSelect( datepicker ) {
    var option         = jQuery( datepicker ).next().is( '.hasDatepicker' ) ? 'minDate' : 'maxDate',
        otherDateField = 'minDate' === option ? jQuery( datepicker ).next() : jQuery( datepicker ).prev(),
        date           = jQuery( datepicker ).datepicker( 'getDate' );

    jQuery( otherDateField ).datepicker( 'option', option, date );
    jQuery( datepicker ).on('change', );
}

var pwgcPickrOptions = {
    theme: 'nano',

    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 0.95)',
        'rgba(156, 39, 176, 0.9)',
        'rgba(103, 58, 183, 0.85)',
        'rgba(63, 81, 181, 0.8)',
        'rgba(33, 150, 243, 0.75)',
        'rgba(3, 169, 244, 0.7)',
        'rgba(0, 188, 212, 0.7)',
        'rgba(0, 150, 136, 0.75)',
        'rgba(76, 175, 80, 0.8)',
        'rgba(139, 195, 74, 0.85)',
        'rgba(205, 220, 57, 0.9)',
        'rgba(255, 235, 59, 0.95)',
        'rgba(255, 193, 7, 1)'
    ],

    useAsButton: true,
    defaultRepresentation: 'HEX',

    components: {

        // Main components
        preview: true,
        opacity: true,
        hue: true,

        // Input / output Options
        interaction: {
            hex: false,
            rgba: false,
            hsla: false,
            hsva: false,
            cmyk: false,
            input: true,
            clear: false,
            cancel: true,
            save: true
        }
    }
};

function pwgcAssignColorPicker(formElement, designerElement, designerCssAttribute) {
    pwgcPickrOptions.el = document.querySelector(formElement);
    pwgcPickrOptions.default = pwgcPickrOptions.el.value;

    const giftCardColorPickr = Pickr.create(pwgcPickrOptions);
    giftCardColorPickr.on('save', (color, instance) => {
        instance.hide();
    }).on('change', (color, instance) => {
        jQuery(designerElement).css(designerCssAttribute, color.toRGBA() );
        jQuery(instance.options.el).val(color.toHEXA().toString(0));
        jQuery(instance.options.el).css('background-color', color.toHEXA().toString(0));
        jQuery(instance.options.el).css('color', color.toHEXA().toString(0));
        instance.applyColor(true);
    }).on('cancel', instance => {
        jQuery(designerElement).css(designerCssAttribute, instance.getSelectedColor().toRGBA() );
        instance.hide();
    });
}

function pwgcActivate() {
    jQuery('.pwgc-activation-error').text('');
    jQuery('#pwgc-activate-license').prop('disabled', true).val('Activating, please wait...');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-activation', 'license-key': jQuery('#pwgc-license-key').val() }, function(result) {
        if (result.active === true) {
            location.reload();
        } else {
            jQuery('.pwgc-activation-error').text(result.error);
            jQuery('#pwgc-activate-license').prop('disabled', false).val('Activate');
        }
    });
}

function pwgcAdminLoadBalanceSummary() {
    var balanceSummary = jQuery('#pwgc-balance-summary-container');
    var date = jQuery('#pwgc-balance-search-date');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-balance_summary', 'date': date.val(), 'security': pwgc.nonces.balance_summary}, function(result) {
        balanceSummary.html(result);
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            balanceSummary.html(errorThrown);
        } else {
            balanceSummary.html('Unknown Error');
        }
    });
}

function pwgcAdminBalanceSearch() {
    jQuery('#pwgc-balance-search-results,#pwgc-balance-card-activity').text('');
    jQuery('#pwgc-balance-search-results').html('<i class="fas fa-cog fa-spin fa-3x"></i>');

    var submitButton = jQuery('#pwgc-balance-search-button');
    var dateSubmitButton = jQuery('#pwgc-balance-search-date-refresh');
    submitButton.prop('disabled', true);
    dateSubmitButton.prop('disabled', true);

    var searchTerms = jQuery('#pwgc-balance-search');
    var date = jQuery('#pwgc-balance-search-date');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-search', 'search_terms': searchTerms.val(), 'date': date.val(), 'security': pwgc.nonces.search}, function(result) {
        jQuery('#pwgc-balance-search-results').html(result.html);
        searchTerms.trigger('focus');
        submitButton.prop('disabled', false);
        dateSubmitButton.prop('disabled', false);
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown Error');
        }
        searchTerms.trigger('focus');
        submitButton.prop('disabled', false);
        dateSubmitButton.prop('disabled', false);
    });
}

function pwgcAdminGiftCardActivityLoadStart(row) {
    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var activity = buttonCell.find('.pwgc-balance-activity-container');
    if (activity.length == 0) {
        activity = jQuery('<div class="pwgc-balance-activity-container"></div>').appendTo(buttonCell);
    }
    activity.html('<i class="fas fa-cog fa-spin fa-2x"></i>');
}

function pwgcAdminGiftCardActivity(row) {
    pwgcAdminGiftCardActivityLoadStart(row);

    var cardNumber = row.attr('data-gift-card-number');
    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var activity = buttonCell.find('.pwgc-balance-activity-container');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-view_activity', 'card_number': cardNumber, 'security': pwgc.nonces.view_activity}, function(result) {
        activity.html(result.html);
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown Error');
        }
    });
}

function pwgcAdjustBalance(row, amount) {
    var note = prompt( pwgc.i18n.adjustment_note_prompt );
    if (note !== null) {
        pwgcAdminGiftCardActivityLoadStart(row);

        var cardNumber = row.attr('data-gift-card-number');
        var balance = row.find('.pwgc-search-result-balance');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-adjustment', 'card_number': cardNumber, 'amount': amount, 'note': note, 'security': pwgc.nonces.adjustment}, function(result) {
            pwgcAdminGiftCardActivity(row);
            balance.html(result.balance);
        }).fail(function(xhr, textStatus, errorThrown) {
            if (errorThrown) {
                alert(errorThrown);
            } else {
                alert('Unknown ajax error');
            }
        });
    }
}

function pwgcSetExpirationDate(row) {
    var expirationDate = prompt(pwgc.i18n.prompt_for_expiration_date);

    if (expirationDate !== null) {
        var cardNumber = row.attr('data-gift-card-number');
        var expirationDateField = row.find('.pwgc-search-result-expiration-date');
        expirationDateField.html('<i class="fas fa-cog fa-spin fa-2x"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-set_expiration_date', 'card_number': cardNumber, 'expiration_date': expirationDate, 'security': pwgc.nonces.expiration_date}, function(result) {
            expirationDateField.html(result.expiration_date);
        }).fail(function(xhr, textStatus, errorThrown) {
            if (errorThrown) {
                expirationDateField.html(errorThrown);
            } else {
                expirationDateField.html('Unknown ajax error');
            }
        });
    }
}

function pwgcToggleEmailGiftCard(row) {
    // Hide the Activity grid if it is visible.
    row.find('.pwgc-balance-activity-container').remove();

    // Toggle the Email container.
    if (row.find('.pwgc-balance-email-container').length > 0) {
        row.find('.pwgc-balance-email-container').remove();
        return;
    }

    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var emailContainer = buttonCell.find('.pwgc-balance-email-container');
    if (emailContainer.length == 0) {
        emailContainer = jQuery('<div class="pwgc-balance-email-container"></div>').appendTo(buttonCell);
    }

    var cardNumber = row.attr('data-gift-card-number').trim();
    var originalTo = row.attr('data-original-to').trim();
    var originalFrom = row.attr('data-original-from').trim();
    var originalNote = row.attr('data-original-note').trim();

    // Copy the template element from search-results.php
    var emailForm = jQuery('#pwgc-search-results-email-form').clone().removeAttr('id').removeClass('pwgc-hidden');

    // Hook the button events.
    emailForm.on('submit', function(e) {
        pwgcEmailGiftCard(row);

        e.preventDefault();
        return false;
    });

    emailForm.find('.pwgc-search-results-send-email-cancel-button').on('click', function(e) {
        pwgcToggleEmailGiftCard(row);

        e.preventDefault();
        return false;
    });

    // Populate the fields where we can.
    emailForm.find('[name="to"]').val(originalTo);
    emailForm.find('[name="from"]').val(originalFrom);
    emailForm.find('[name="note"]').val(originalNote);

    // The form is all set up, add it to the DOM.
    emailForm.appendTo(emailContainer);
}

function pwgcEmailGiftCardStart(row) {
    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var emailForm = buttonCell.find('.pwgc-balance-email-container');
    emailForm.hide();
    jQuery('<div class="pwgc-email-sending"><i class="fas fa-cog fa-spin fa-2x"></i></div>').appendTo(buttonCell);
}

function pwgcEmailGiftCardStop(row) {
    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var emailForm = buttonCell.find('.pwgc-balance-email-container');
    emailForm.show();
    row.find('.pwgc-email-sending').remove();
}

function pwgcEmailGiftCard(row) {
    pwgcEmailGiftCardStart(row);

    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var emailForm = buttonCell.find('.pwgc-balance-email-container');

    var cardNumber = row.attr('data-gift-card-number');
    var emailAddress = emailForm.find('[name="to"]').val();
    var sender = emailForm.find('[name="from"]').val();
    var note = emailForm.find('[name="note"]').val();
    var designId = emailForm.find('[name="email_design"]').val();

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-email_gift_card', 'card_number': cardNumber, 'email_address': emailAddress, 'from': sender, 'note': note, 'design_id': designId}, function(result) {
        pwgcEmailGiftCardStop(row);
        emailForm.html('<span style="color: #135e96;">' + pwgc.i18n.email_sent + '</span>');
    }).fail(function(xhr, textStatus, errorThrown) {
        pwgcEmailGiftCardStop(row);
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown ajax error');
        }

        pwgcEmailGiftCardStop(row);
    });
}

function pwgcDelete(row) {
    var cardNumber = row.attr('data-gift-card-number');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-delete', 'card_number': cardNumber, 'security': pwgc.nonces.delete}, function(result) {
        if (result.data.deleted) {
            jQuery('#pwgc-balance-search').val('');
            pwgcAdminBalanceSearch();
            alert(pwgc.i18n.gift_card_deleted_message);
        } else {
            row.find('.pwgc-buttons-inactive, .pwgc-inactive-card').removeClass('pwgc-hidden');
            row.find('.pwgc-buttons-active').addClass('pwgc-hidden');
            pwgcAdminLoadBalanceSummary();
        }
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown ajax error');
        }
    });
}

function pwgcRestore(row) {
    var cardNumber = row.attr('data-gift-card-number');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-restore', 'card_number': cardNumber, 'security': pwgc.nonces.restore}, function(result) {
        row.find('.pwgc-buttons-inactive, .pwgc-inactive-card').addClass('pwgc-hidden');
        row.find('.pwgc-buttons-active').removeClass('pwgc-hidden');
        pwgcAdminLoadBalanceSummary();
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown ajax error');
        }
    });
}

function pwgcImportGiftCards(confirm) {
    var importResults = jQuery('#pwgc-import-results');
    var submitButton = jQuery('#pwgc-import-file-submit-button');
    var importFile = jQuery('#pwgc-import-file');
    var sendEmail = jQuery('#pwgc-admin-send-email').is(':checked');
    var overwrite = jQuery('#pwgc-admin-import-overwrite').is(':checked');
    var from = jQuery('#pwgc-admin-import-from').val();
    var designId = jQuery('#pwgc-admin-import-send-email-design').val();

    importResults.html('<i class="pwgc-wait fas fa-cog fa-spin fa-3x"></i>');
    submitButton.prop('disabled', true);
    importFile.prop('disabled', true);

    var files = importFile.prop('files');
    if (files.length > 0) {

        var formData = new FormData();

        formData.append('file', files[0]);
        formData.append('action', 'pw-gift-cards-import_gift_cards');
        if (confirm) {
            formData.append('confirm', true);
        }
        if (overwrite) {
            formData.append('overwrite', true);
        }
        if (sendEmail) {
            formData.append('send_email', true);
            formData.append('from', from);
            formData.append('design_id', designId);
        }

        jQuery.ajax({
            url: ajaxurl,
            type: 'post',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if (response.success) {
                    importResults.html(response.data.html);
                    pwgcAdminLoadBalanceSummary();
                } else if ( response.data && response.data.message ) {
                    importResults.html('<div style="color: red;">Error ' + response.data.message + '</div>');
                } else {
                    importResults.html('<div style="color: red;">Unhandled Error</div>');
                }

                submitButton.prop('disabled', false);
                importFile.prop('disabled', false);
            },
            error: function (xhr, textStatus, errorThrown) {
                importResults.html('<div class="pwgc-import-error-message">Error: ' + errorThrown + '</div>');
                submitButton.prop('disabled', false);
                importFile.prop('disabled', false);
            }

        });
    }
}

function pwgcSelectDesign() {
    jQuery('#pwgc-designer-panel-container').html('<i class="fas fa-cog fa-spin fa-3x"></i>');

    var designId = jQuery('#pwgc-design-selector').val();
    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-select_design', 'design_id': designId, 'security': pwgc.nonces.select_design}, function(result) {
        jQuery('#pwgc-designer-panel-container').html(result.html);
    }).fail(function(xhr, textStatus, errorThrown) {
        if (!errorThrown) {
            errorThrown = 'Unknown Error';
        }
        jQuery('#pwgc-designer-panel-container').text(errorThrown);
    });
}

function pwgcCreateDesign() {
    var designSelector = jQuery("#pwgc-design-selector");
    jQuery('#pwgc-designer-panel-container').html('<i class="fas fa-cog fa-spin fa-3x"></i>');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-create_design', 'design_id': designSelector.val(), 'security': pwgc.nonces.create_design}, function(result) {
        jQuery('#pwgc-design-selector').append('<option value=' + result.design_id + '>' + result.name + '</option>');
        jQuery('#pwgc-design-selector option[value=' + result.design_id + ']').prop('selected', true).trigger('change');
    }).fail(function(xhr, textStatus, errorThrown) {
        if (!errorThrown) {
            errorThrown = 'Unknown Error';
        }
        jQuery('#pwgc-designer-panel-container').text(errorThrown);
    });
}

function pwgcSaveDesign() {
    var designSelector = jQuery("#pwgc-design-selector");
    var designName = jQuery('#pwgc-design-name');
    if (!designName.val()) {
        designName.val(designSelector.text());
    }

    var messageContainer = jQuery('#pwgc-save-design-message');
    var saveButton = jQuery('#pwgc-save-design-button');
    var form = jQuery('#pwgc-designer-form').serialize();

    saveButton.attr('disabled', true);
    messageContainer.clearQueue().html('<i class="fas fa-cog fa-spin fa-3x"></i>').show();

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-save_design', 'form': form, 'security': pwgc.nonces.save_design }, function(result) {
        designSelector.empty();
        designSelector.append(result.designs);

        saveButton.attr('disabled', false);
        pwgcSelectDesign();
        jQuery('#pwgc-designer-panel-message').html(result.html);
    }).fail(function(xhr, textStatus, errorThrown) {
        saveButton.attr('disabled', false);
        if (errorThrown) {
            messageContainer.html(errorThrown);
        } else {
            messageContainer.text('Unknown ajax error');
        }
    });
}

function pwgcDeleteDesign() {
    var designSelector = jQuery("#pwgc-design-selector");
    var designId = jQuery('#pwgc-design-id').val();
    if (confirm(pwgc.i18n.delete_design_prompt)) {

        jQuery('#pwgc-designer-panel-container').html('<i class="fas fa-cog fa-spin fa-3x"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-delete_design', 'design_id': designId, 'security': pwgc.nonces.delete_design}, function(result) {
            designSelector.empty();
            designSelector.append(result.designs);
            designSelector.trigger('change');
        }).fail(function(xhr, textStatus, errorThrown) {
            if (!errorThrown) {
                errorThrown = 'Unknown Error';
            }
            jQuery('#pwgc-designer-panel-container').text(errorThrown);
        });
    }
}

function pwgcSendEmailDesignPreview() {
    var designId = jQuery('#pwgc-design-id').val();
    var emailAddress = prompt(pwgc.i18n.preview_email_notice + '\n\n' + pwgc.i18n.preview_email_prompt, jQuery('#pwgc-preview-email-button').attr('data-email'));
    if (emailAddress) {
        // Save it for later.
        jQuery('#pwgc-preview-email-button').attr('data-email', emailAddress);

        var previewButton = jQuery('#pwgc-preview-email-button');
        var messageContainer = jQuery('#pwgc-preview-email-message');

        previewButton.attr('disabled', true);
        messageContainer.clearQueue().html('<i class="fas fa-cog fa-spin"></i>').show();

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-preview_email', 'design_id': designId, 'email_address': emailAddress, 'security': pwgc.nonces.preview_email}, function(result) {
            messageContainer.html(result.html).delay(2000).fadeOut('slow');
            previewButton.attr('disabled', false);
        }).fail(function(xhr, textStatus, errorThrown) {
            previewButton.attr('disabled', false);
            if (!errorThrown) {
                errorThrown = 'Unknown Error';
            }
            messageContainer.html(errorThrown);
        });
    }
}

function pwgcDesignerUpdateImage() {
    var backgroundImage = jQuery('#pwgc-background-image');
    if (backgroundImage.length) {
        var backgroundImageUrl = "url('" + backgroundImage.val() + "')";
        jQuery('#pwgc-email-gift-card-table').css('background-image', backgroundImageUrl);
    }

    var logoImage = jQuery('#pwgc-logo-image').val();
    var logoImageTemplate = jQuery('#pwgc-email-logo-image');
    if (!logoImageTemplate.length) {
        logoImageTemplate = jQuery('#pwgc-email-logo-image-cell').append('<img id="pwgc-email-logo-image">');
    }
    logoImageTemplate.attr('src', logoImage);
    pwgcDesignerUpdateElementLocations();
}

function pwgcDesignerUpdateElementLocations() {
    var logoImageTable = jQuery('#pwgc-email-logo-image-table');
    var logoImageLocation = jQuery('#pwgc-logo-image-location').val();
    pwgcDesignerUpdateElementLocation(logoImageTable, logoImageLocation);

    var additionalContent = jQuery('#pwgc-email-additional-content');
    var additionalContentLocation = jQuery('#pwgc-additional-content-location').val();
    pwgcDesignerUpdateElementLocation(additionalContent, additionalContentLocation);
}

function pwgcDesignerUpdateElementLocation(el, loc) {
    var target = false;
    switch (loc) {
        case 'top':
            target = '#pwgc-email-top';
        break;

        case 'before_recipient':
            target = '#pwgc-email-before-recipient';
        break;

        case 'before_gift_card':
            target = '#pwgc-email-before-gift-card';
        break;

        case 'inside_gift_card_top':
            target = '#pwgc-email-gift-card-top-cell';
        break;

        case 'inside_gift_card_bottom':
            target = '#pwgc-email-gift-card-bottom-cell';
        break;

        case 'after_gift_card':
            target = '#pwgc-email-after-gift-card';
        break;

        case 'bottom':
            target = '#pwgc-email-bottom';
        break;
    }

    if (target) {
        el.detach().appendTo(target);
    }
}

function pwgcBindMediaPicker( selector, button_selector )  {
    var clicked_button = false;

    jQuery(selector).each(function (i, input) {
        var button = jQuery(input).next(button_selector);
        button.on('click', function (event) {
            event.preventDefault();
            var selected_img;
            clicked_button = jQuery(this);

            var pwgc_media_set_image = function() {
                var selection = wp.media.frames.pwgc_frame.state().get('selection');

                if (!selection) {
                    return;
                }

                selection.each(function(attachment) {
                    var url = attachment.attributes.url;
                    clicked_button.prev(selector).val(url);
                });

                pwgcDesignerUpdateImage();
            };

            if (wp.media.frames.pwgc_frame) {
                wp.media.frames.pwgc_frame.off('close').on('close', pwgc_media_set_image);
                wp.media.frames.pwgc_frame.off('select').on('select', pwgc_media_set_image);
                wp.media.frames.pwgc_frame.open();
                return;
            }

            wp.media.frames.pwgc_frame = wp.media({
                title: pwgc.i18n.select_image,
                multiple: false,
                library: {
                    type: 'image'
                },
                button: {
                    text: pwgc.i18n.use_selected_image
                }
            });

            wp.media.frames.pwgc_frame.on('close', pwgc_media_set_image);
            wp.media.frames.pwgc_frame.on('select', pwgc_media_set_image);
            wp.media.frames.pwgc_frame.open();
        });
   });
}

// source: https://github.com/andymantell/node-wpautop
function pwgc_autop_newline_preservation_helper (matches) {
    return matches[0].replace( "\n", "<WPPreserveNewline />" );
}

function pwgc_wpautop(pee, br) {
    if(typeof(br) === 'undefined') {
        br = true;
    }

    var pre_tags = {};
    if ( pee.trim() === '' ) {
        return '';
    }

    pee = pee + "\n"; // just to make things a little easier, pad the end
    if ( pee.indexOf( '<pre' ) > -1 ) {
        var pee_parts = pee.split( '</pre>' );
        var last_pee = pee_parts.pop();
        pee = '';
        pee_parts.forEach(function(pee_part, index) {
            var start = pee_part.indexOf( '<pre' );

            // Malformed html?
            if ( start === -1 ) {
                pee += pee_part;
                return;
            }

            var name = "<pre wp-pre-tag-" + index + "></pre>";
            pre_tags[name] = pee_part.substr( start ) + '</pre>';
            pee += pee_part.substr( 0, start ) + name;

        });

        pee += last_pee;
    }

    pee = pee.replace(/<br \/>\s*<br \/>/, "\n\n");

    // Space things out a little
    var allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
    pee = pee.replace( new RegExp('(<' + allblocks + '[^>]*>)', 'gmi'), "\n$1");
    pee = pee.replace( new RegExp('(</' + allblocks + '>)', 'gmi'), "$1\n\n");
    pee = pee.replace( /\r\n|\r/, "\n" ); // cross-platform newlines

    if ( pee.indexOf( '<option' ) > -1 ) {
        // no P/BR around option
        pee = pee.replace( /\s*<option'/gmi, '<option');
        pee = pee.replace( /<\/option>\s*/gmi, '</option>');
    }

    if ( pee.indexOf('</object>') > -1 ) {
        // no P/BR around param and embed
        pee = pee.replace( /(<object[^>]*>)\s*/gmi, '$1');
        pee = pee.replace( /\s*<\/object>/gmi, '</object>' );
        pee = pee.replace( /\s*(<\/?(?:param|embed)[^>]*>)\s*/gmi, '$1');
    }

    if ( pee.indexOf('<source') > -1 || pee.indexOf('<track') > -1 ) {
        // no P/BR around source and track
        pee = pee.replace( /([<\[](?:audio|video)[^>\]]*[>\]])\s*/gmi, '$1');
        pee = pee.replace( /\s*([<\[]\/(?:audio|video)[>\]])/gmi, '$1');
        pee = pee.replace( /\s*(<(?:source|track)[^>]*>)\s*/gmi, '$1');
    }

    pee = pee.replace(/\n\n+/gmi, "\n\n"); // take care of duplicates

    // make paragraphs, including one at the end
    var pees = pee.split(/\n\s*\n/);
    pee = '';
    pees.forEach(function(tinkle) {
        pee += '<p>' + tinkle.replace( /^\s+|\s+$/g, '' ) + "</p>\n";
    });

    pee = pee.replace(/<p>\s*<\/p>/gmi, ''); // under certain strange conditions it could create a P of entirely whitespace
    pee = pee.replace(/<p>([^<]+)<\/(div|address|form)>/gmi, "<p>$1</p></$2>");
    pee = pee.replace(new RegExp('<p>\s*(</?' + allblocks + '[^>]*>)\s*</p>', 'gmi'), "$1", pee); // don't pee all over a tag
    pee = pee.replace(/<p>(<li.+?)<\/p>/gmi, "$1"); // problem with nested lists
    pee = pee.replace(/<p><blockquote([^>]*)>/gmi, "<blockquote$1><p>");
    pee = pee.replace(/<\/blockquote><\/p>/gmi, '</p></blockquote>');
    pee = pee.replace(new RegExp('<p>\s*(</?' + allblocks + '[^>]*>)', 'gmi'), "$1");
    pee = pee.replace(new RegExp('(</?' + allblocks + '[^>]*>)\s*</p>', 'gmi'), "$1");

    if ( br ) {
        pee = pee.replace(/<(script|style)(?:.|\n)*?<\/\\1>/gmi, pwgc_autop_newline_preservation_helper); // /s modifier from php PCRE regexp replaced with (?:.|\n)
        pee = pee.replace(/(<br \/>)?\s*\n/gmi, "<br />\n"); // optionally make line breaks
        pee = pee.replace( '<WPPreserveNewline />', "\n" );
    }

    pee = pee.replace(new RegExp('(</?' + allblocks + '[^>]*>)\s*<br />', 'gmi'), "$1");
    pee = pee.replace(/<br \/>(\s*<\/?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)/gmi, '$1');
    pee = pee.replace(/\n<\/p>$/gmi, '</p>');

    if ( Object.keys(pre_tags).length ) {
        pee = pee.replace( new RegExp( Object.keys( pre_tags ).join( '|' ), "gi" ), function (matched) {
            return pre_tags[matched];
        });
    }

    return pee;
}
