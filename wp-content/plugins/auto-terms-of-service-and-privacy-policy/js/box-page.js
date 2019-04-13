jQuery(document).ready(function ($) {
    $(".wpautoterms-color-selector").wpColorPicker();
    $(".wpautoterms-options-select-combo select").each(function () {
        var t = jQuery(this);
        var id = t.attr("id");
        var custom = t.find(".wpautoterms-custom-value-" + id);
        var tf = jQuery("input[name='custom_" + id + "']");
        t.change(function () {
            if (custom.prop("selected")) {
                tf.show();
            } else {
                tf.hide();
            }
        });
        tf.change(function () {
            custom.val(tf.val());
        });
        t.trigger("change");
        tf.trigger("change");
    });
    $(".wpautoterms-options-select-tag").each(function () {
        var t = jQuery(this);
        var id = t.attr("id");
        var n = jQuery(".wpautoterms-options-new-tag[id='new-tag-" + id + "']");
        t.change(function () {
            if (parseInt(t.val()) === 0) {
                n.show();
            } else {
                n.hide();
            }
        });
    });
    $(".wpautoterms-option-dependent").each(function () {
        var t = jQuery(this);
        var p = t.parent().parent();
        var depType = t.data("type");
        var depVal = t.data("value");
        var s = jQuery("#" + t.data("source"));
        if (depVal === "show") {
            p.hide();
            t.removeClass("wpautoterms-hidden");
        }
        s.change(function () {
            var show = depType === "show";
            if (s.val() !== depVal) {
                show = !show;
            }
            if (show) {
                p.show();
                t.show();
            } else {
                p.hide();
            }
        });
        s.trigger("change");
    });

    function send_to_editor( html ) {
        var editor,
            hasTinymce = typeof tinymce !== 'undefined',
            hasQuicktags = typeof QTags !== 'undefined';

        if ( ! wpActiveEditor ) {
            if ( hasTinymce && tinymce.activeEditor ) {
                editor = tinymce.activeEditor;
                wpActiveEditor = editor.id;
            } else if ( ! hasQuicktags ) {
                return false;
            }
        } else if ( hasTinymce ) {
            editor = tinymce.get( wpActiveEditor );
        }

        if ( editor && ! editor.isHidden() ) {
            editor.execCommand( 'mceInsertContent', false, html );
        } else if ( hasQuicktags ) {
            QTags.insertContent( html );
        } else {
            document.getElementById( wpActiveEditor ).value += html;
        }
    }

    $(".wpautoterms-shortcodes-source a").each(function () {
        var t=jQuery(this);
        var id=t.data("editor");
        var data=t.data("data");
        t.click(function(){
            send_to_editor(data);
            //tinymce.get(id).execCommand('mceInsertContent', false, data);
        });
    });
});
