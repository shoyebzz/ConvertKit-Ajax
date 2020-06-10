<?php

//call jquery
function ckform_scripts() {

	wp_enqueue_script('jquery');
}
add_action( 'wp_enqueue_scripts', 'ckform_scripts');



//[ckform form='1438993' apipage='http://kanelsnurr.com/dev/wp/api-req' tag='1571557']
function ckFormShortcode( $atts ) {
	$att = shortcode_atts( array(
		'form' => '1438994',
		'tag' => '1571557',
		'apipage' => 'http://kanelsnurr.com/dev/wp/api-req',
    ), $atts );
    
    ob_start();
    ?>

        <form action="<?php echo $att['apipage']; ?>" id="ckit_formx" method="post">
            <input type="text" name="usr_name" placeholder="Your Name" require>
            <input type="email" name="usr_email" placeholder="Your email" require>
            <input type="checkbox" name="tosagree" require>
            <input type="hidden" name="form_id" value="<?php echo $att['form']; ?>">
            <input type="hidden" name="form_tag" value="<?php echo $att['tag']; ?>">
            <button type="submit">Subscrib</button>
        </form>

        <div id="form-response"></div>

        <script>
        jQuery(document).ready(function(){

            jQuery("#ckit_formx").submit(function(e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.
                

                var form = jQuery(this);
                var url = form.attr('action');

                //console.log(form.serialize());

                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data)
                    {   
                        jQuery("#form-response").html(data);
                        form.find("input[type=text], input[type=email], input[type=checkbox]").val("").prop('checked', false);
                    },
                    error: function (data) {

                        jQuery("#form-response").html(data);

                    }

                });
            });


        });
        </script>

    <?php
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'ckform', 'ckFormShortcode' );

?>