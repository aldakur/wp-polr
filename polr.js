
jQuery(document).ready(function($) {
    jQuery("#button_polr_get_url").click(function(){

    var url = MyAjax.ajax_path;
    jQuery.ajax({
            type: 'POST',
            url: url,
            dataType: 'text',

            data: {
                postID: MyAjax.post_id, // From PHP
                action: MyAjax.action // From PHP-tik
            },
            success: function(data, textStatus, XMLHttpRequest){
                $('#polr_shortened_url').val(data);
            },
            error: function(MLHttpRequest, textStatus, errorThrown){
                alert(errorThrown);
            }
        });
    });
});
