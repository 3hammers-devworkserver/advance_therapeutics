<?php
    
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $attrs = array();

    $attrs['class'] = 'w-contact-form7';



?>
<div<?php echo wyde_get_attributes( $attrs );?>>
    <?php echo apply_filters( 'vc_contact_form7_shortcode', do_shortcode( '[contact-form-7 id="5" title="Contact 3"]' ) );?>  
</div>