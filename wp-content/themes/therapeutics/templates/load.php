<?php 
/* to create meta box */

function add_therapy_meta_box(){

	add_meta_box( 'therapy-options', 'Alternative therapy table', 'therapy_options', 'formulations', 'normal', 'high' );
/*									'label'												*/
}

add_action( 'add_meta_boxes', 'add_therapy_meta_box' );

function therapy_options($menu)
{
		$values = get_post_custom( $menu->ID );

		?>

        
	<div class="custom-post-options" style="padding-bottom: 10px;">
        <label for="price">D-1</label>
        <div class="input-wrap">
        	<input type="text" name="D-1" value="<?php if(isset($values['D-1'])) echo $values['D-1'][0];?>">
        		
        </div>
        <div class="clear"></div>
    </div>

	<div class="custom-post-options" style="padding-bottom: 10px;">
        <label for="price">L-1</label>
        <div class="input-wrap">
        	<input type="text" class="form-control" value="<?php if(isset($values['L-1'])) echo $values['L-1'][0];?>" name="L-1">
        	
        </div>
        <div class="clear"></div>
    </div>

	<div class="custom-post-options" style="padding-bottom: 10px;">
        <label for="price">CA-1</label>
        <div class="input-wrap">
        	<input type="text" class="form-control" value="<?php if(isset($values['CA-1'])) echo $values['CA-1'][0];?>" name="CA-1">
        
        </div>
        <div class="clear"></div>
    </div> 

    <div class="custom-post-options" style="padding-bottom: 10px;">
        <label for="price">CA-2</label>
        <div class="input-wrap">
        	<input type="text" class="form-control" value="<?php if(isset($values['CA-2'])) echo $values['CA-2'][0];?>" name="CA-2">
        </div>
        <div class="clear"></div>
    </div> 

    <div class="custom-post-options" style="padding-bottom: 10px;">
        <label for="price">S-1</label>
        <div class="input-wrap">
        	<input type="text" class="form-control" value="<?php if(isset($values['S-1'])) echo $values['S-1'][0];?>" name="S-1">
        	
        </div>
        <div class="clear"></div>
    </div> 

    <div class="custom-post-options" style="padding-bottom: 10px;">
        <label for="price">S-2</label>
        <div class="input-wrap">
        	<input type="text" class="form-control" value="<?php if(isset($values['S-2'])) echo $values['S-2'][0];?>" name="S-2">
        	
        </div>
        <div class="clear"></div>
    </div> 

    <div class="custom-post-options" style="padding-bottom: 10px;">
        <label for="price">KB-1</label>
        <div class="input-wrap">
        	<input type="text" class="form-control" value="<?php if(isset($values['KB-1'])) echo $values['KB-1'][0];?>" name="KB-1">
        	
        </div>
        <div class="clear"></div>
    </div>        
<?php
}

add_action( 'save_post', 'save_menus_options' );

function save_menus_options($menu_id){

    if( isset( $_POST['D-1'] ) )
    	update_post_meta( $menu_id, 'D-1', esc_attr( $_POST['D-1'] ) );
   
    if( isset( $_POST['L-1'] ) )
    	update_post_meta( $menu_id, 'L-1', esc_attr( $_POST['L-1'] ) );
   
    if( isset( $_POST['CA-1'] ) )
    	update_post_meta( $menu_id, 'CA-1', esc_attr( $_POST['CA-1'] ) );

    if( isset( $_POST['CA-2'] ) )
    	update_post_meta( $menu_id, 'CA-2', esc_attr( $_POST['CA-2'] ) );

    if( isset( $_POST['S-1'] ) )
    	update_post_meta( $menu_id, 'S-1', esc_attr( $_POST['S-1'] ) );

    if( isset( $_POST['S-2'] ) )
    	update_post_meta( $menu_id, 'S-2', esc_attr( $_POST['S-2'] ) );
    
    if( isset( $_POST['KB-1'] ) )
    	update_post_meta( $menu_id, 'KB-1', esc_attr( $_POST['KB-1'] ) );
   
}


/* to create meta box */

function add_meta_box_breadcrumb(){

    add_meta_box( 'menus-options', 'Breadcrumb', 'breadcrumb_options', 'page', 'side', 'high' );
	add_meta_box( 'menus-options', 'Breadcrumb', 'breadcrumb_options', 'formulations', 'side', 'high' );
/*									'label'												*/
}

add_action( 'add_meta_boxes', 'add_meta_box_breadcrumb' );

function breadcrumb_options($menu)
{
	?>

        <select name="meta-box-dropdown">
                <?php 
                    $option_values = array('Enable', 'Disable');

                    foreach($option_values as $key => $value) 
                    {
                        if($value == get_post_meta($menu->ID, "meta-box-dropdown", true))
                        {
                            ?>
                                <option selected><?php echo $value; ?></option>
                            <?php    
                        }
                        else
                        {
                            ?>
                                <option><?php echo $value; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>			 
<?php
}

add_action( 'save_post', 'save_breadcrumb_options' );

function save_breadcrumb_options($menu_id){

    if( isset( $_POST['meta-box-dropdown'] ) ){
            update_post_meta( $menu_id, 'meta-box-dropdown', $_POST['meta-box-dropdown']);
        }
}



/**/

/* New Description Meta Box for post type*/
add_action( 'add_meta_boxes', 'add_custom_box' );
/* Adds a box to the main column on the Post and Page edit screens */
function add_custom_box() {
  add_meta_box( 'wp_editor_test_2_box', 'Second Row Content', 'wp_meta_box', 'services' );
}

/* Prints the box content */
function wp_meta_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

  $field_value = get_post_meta( $post->ID, '_wp_editor_test_2', false );
  wp_editor( $field_value[0], '_wp_editor_test_2' );
}

/* Do something with the data entered */
add_action( 'save_post', 'save_postdata' );
/* When the post is saved, saves our custom data */
function save_postdata( $post_id ) {

  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if ( ( isset ( $_POST['myplugin_noncename'] ) ) && ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) ) )
      return;

  // Check permissions
  if ( ( isset ( $_POST['post_type'] ) ) && ( 'page' == $_POST['post_type'] )  ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }    
  }
  else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  // OK, we're authenticated: we need to find and save the data
  if ( isset ( $_POST['_wp_editor_test_2'] ) ) {
    update_post_meta( $post_id, '_wp_editor_test_2', $_POST['_wp_editor_test_2'] );
  }

}