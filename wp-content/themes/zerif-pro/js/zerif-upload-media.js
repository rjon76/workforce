jQuery(document).ready(function($) {
    jQuery(document).on("click", ".upload_image_button", function() {

        jQuery.data(document.body, 'prevElement', jQuery(this).prev());

        window.send_to_editor = function(html) {
            //var imgurl = jQuery('img',html).attr('src');
			var dom_nodes = jQuery(jQuery.parseHTML(html));
			var img = dom_nodes[0];
			var imgurl = img.src;
            var inputText = jQuery.data(document.body, 'prevElement');

            if(inputText != undefined && inputText != '')
            {
                inputText.val(imgurl);
            }

            tb_remove();
        };

        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });
});