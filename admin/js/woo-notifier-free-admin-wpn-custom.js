jQuery(document).ready(function($) {
    "use strict";
    jQuery('#wpn_push_notification').on('click', function(e) {

        // WOO PUSH  NOTIFICATION JQUERY
        e.preventDefault();
        var title = jQuery.trim(jQuery('#wpn_title').val());
        var message = jQuery.trim(jQuery('#wpn_message').val());
        var apikey = jQuery('.notification-api-key').val();
        var projectnumber = jQuery('.notification-project-number').val();
        var url = jQuery('#wpn_url').val();
        var image_url = jQuery('.n_img_block img').attr('src');
        var ext = jQuery('.n_img_block img').attr('src').split(".").pop();

        if (apikey == 'nothing' || projectnumber == 'nothing') {
            jQuery('#error-message').fadeIn(300);
            return false;
        }

        //VALIDATION CHECK JQUERY
        if (title === '') {
            jQuery('#wpn_title').css('border-color', 'red');
        } else {
            jQuery('#wpn_title').css('border-color', '');
        }

        if (message == '') {
            jQuery('#wpn_message').css('border-color', 'red');
        } else {
            jQuery('#wpn_message').css('border-color', '');
        }


        function isUrlValid(url) {
            return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
        }
        if (url != '') {
            if (!isUrlValid(url)) {
                jQuery('#wpn_url').css('border-color', 'red');
                return false;
            } else {
                jQuery('#wpn_url').css('border-color', '');
            }
        }

        function stringEndsWithValidExtension(stringToCheck, acceptableExtensionsArray, required) {
            if (required == false && stringToCheck.length == 0) {
                return true;
            }
            for (var i = 0; i < acceptableExtensionsArray.length; i++) {
                if (stringToCheck.toLowerCase().endsWith(acceptableExtensionsArray[i].toLowerCase())) {
                    return true;
                }
            }
            return false;
        }
        if (!stringEndsWithValidExtension(jQuery('.n_img_block img').attr('src'), [".png", ".jpg", ".ico"], false)) {
            jQuery('.wpn_error_message').html('Photo only allows file types of PNG,JPG and ICO');
            return false;
        }
        //WOO NOTIFICATION AJAX CALL
        if (title != '' && message != '') {

            var postData = {
                action: 'push_notfication',
                suggestion_id: $(this).data('suggestion-id'),
                wpn_title: title,
                wpn_message: message,
                wpn_url: url,
                wpn_image_url: image_url
            };
            $.ajax({
                type: "POST",
                data: postData,
                url: ajaxurl,
                success: function(response) {
                    if (response != '[object Object]') {
                        jQuery('#wpn-send-message').hide();
                        // jQuery('#wpn-send-message').html('<p>Notification Sent Successfully</p>').show();
                        jQuery('#error-message').html('<p><b>Error: ' + response + '</b></p>').show();

                    } else {
                        jQuery('#wpn-send-message').html('<p>Notification Sent Successfully</p>').fadeIn(500);
                        jQuery('#wpn-send-message').html('<p>Notification Sent Successfully</p>').fadeOut(3000);
                        jQuery('#error-message').hide();
                    }
                    jQuery('#wpn_title').val('');
                    jQuery('#wpn_message').val('');
                    jQuery('#wpn_url').val('');
                    jQuery('.n_file_label').text('Browse a File');
                    jQuery('.wpn_error_message').text('');
                    jQuery('.wpn_title_append').text('Notification Title');
                    jQuery('.wpn_message_append').text('Notification Message');
                    jQuery('.wpn_url_append').text('example.com');
                    var default_icon = jQuery('.wpn_default_icon').html();
                    jQuery('.n_img_block img').attr('src', default_icon);
                    console.log('Sent!');
                }
            }).fail(function(data) {
                if (window.console && window.console.log) {
                    console.log(data);

                }
            });
        }
    });



    //KEYUP EVENT FOR NOTIFICATION TYPE
    $(document).on('keyup', '.n_inner_form input', function() {
        var current_field_val = $(this).val();
        var current_field_target = '.n_notification_preview .' + $(this).attr('target');
        $(current_field_target).text(current_field_val);
    });
    $(document).on('keyup', '.n_inner_form textarea', function() {
        var current_field_val = $(this).val();
        var current_field_target = '.n_notification_preview .' + $(this).attr('target');
        $(current_field_target).text(current_field_val);
    });
    // GLOBAL VARIABLE DEFINE
    var file_frame;

    //CLICK EVENT MEDIA BUTTON
    $('.n_file_label').click(function() {
        var that = $(this);
        var img = $(this).siblings('.img');
        var url = $(this).siblings('.image_url');


        //CREATE THE MEDIA FRAME.
        file_frame = wp.media.frames.file_frame = wp.media({title: 'Select Image', button: {text: 'Select Image'}, multiple: false});

        //WHEN AN IMAGE IS SELECTED, RUN A CALLBACK            
        file_frame.on('select', function() {

            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();
            img.html('<img style="width:200px;height:200px" src="' + attachment.url + '" />');
            url.val(attachment.url);

            // Do something with attachment.id and/or attachment.url here                               
            var fullPath = attachment.url;
            $('.n_img_block img').attr('src', fullPath);
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
        });

        // Finally, open the modal
        file_frame.open();
    });

    function readURL(url) {
        if (url) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.n_img_block img').attr('src', e.target.result);
            }
            reader.readAsDataURL(url);
            var fullPath = url;
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $('.n_file_label').text(filename);
        }
    }
    $('.n_inner_form input[type=file]').change(function() {

    });

});

/* Show subscribers page validation click Event */
jQuery(document).ready(function($) {
    $('.subscribers_row_delete').click(function() {
        return confirm("Are you sure you want subscribers to delete?");
    })
//});

    /* Show subscribers page validation click Event */
//jQuery(document).ready(function ($) {
    $('.notification_row_delete').click(function() {
        return confirm("Are you sure you want notification to delete?");
    })
});
