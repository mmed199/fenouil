jQuery(document).ready(function () {
    function onClick() {
        var b = jQuery(this);
        b.attr("disabled", "disabled");
        jQuery.post(ajaxurl, {
            action: this.dataset.action,
            nonce: wpautotermsLicenseSettings.nonce,
            apiKey: jQuery("#" + wpautotermsLicenseSettings.keyId).val()
        }).done(function (response) {
            if (typeof response !== "object") {
                alert(response);
            } else {
                var text = response.status;
                if (response.errorMessage) {
                    text += " (" + response.errorMessage + ")";
                }
                jQuery("#wpautoterms_license_status").text(text);
                updateLastCheck(response.timestamp);
            }
        }).fail(function (error) {
            console.log(error);
            alert(error.statusText);
        }).always(function () {
            b.removeAttr("disabled");
        });
    }

    function updateLastCheck(stamp) {
        var txt = stamp === 0 ? wpautotermsLicenseSettings.never : (new Date(stamp * 1000)).toLocaleString();
        jQuery("#wpautoterms_license_last_check").text(txt);
    }

    updateLastCheck(wpautotermsLicenseSettings.lastCheck);

    jQuery("#wpautoterms_recheck").click(onClick);
});
