<?php 
/* 
Template Name: Password-reset
*/
get_header(); ?>

<section class="light-gray login-page">
    <div class="container">
        <div class="row">
          <div class="col-md-offset-4 col-md-4">
            <div class="form-wrapper">

		<?php if( is_user_logged_in() ): ?>

		<?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post();
			$current_user = wp_get_current_user(); ?>
		<div class="login-wrapper">
                  <div class="login-form">
			<div class="errormsg1"></div>
			<div class="successmsg1"></div>
			<div class="title">
                <h3>Reset Password</h3>
            </div>
		  <form class="form-btm-outline" id="reset-password" action="javascript:;" method="post">
		  	<input type="hidden" value="<?php echo $current_user->ID;?>" name="user_id" id="user_id">
            <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                   <input type="password" class="form-control" id="newpass" name="newpass" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                   <input type="password" class="form-control" id="newconfirmpass" name="newconfirmpass" placeholder="Confirm Password">
                </div>
            </div>
            <div class="btn-grp">
               <input type="hidden" name="pippin_login_nonce" value="<?php echo wp_create_nonce('pippin-login-nonce'); ?>"/>
               <input type="submit" class="btn btn-primary" value="Submit" name="reset-password">
               <img src="<?php echo get_template_directory_uri();?>/assets/images/loader.gif" alt="" class="loaderimg" style="display:none;">
            </div>                      
          </form>
      	 </div>
  		</div>

        <?php endwhile; endif; ?>
        <?php else: ?>
			<div class="errormsg"></div>
			<div class="successmsg"></div>

		      <form id="pippin_forgetpass_form"  class="form-btm-outline" action="javascript:;" method="post">
  					<i>If you have forgotten your password, you can use this form to reset your password. 
  					You will receive an email with instructions.</i>
						<div class="form-group">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user-o"></i></span>
								<input name="pippin_email_address" id="pippin_email_address" class="form-control required" type="email" placeholder="Please enter your email address"/>
		       		</div>
		      	</div>
		      		<div class="btn-grp">
		        		<input type="submit" class="btn btn-primary" value="Submit">
							  <img src="<?php echo get_template_directory_uri();?>/assets/images/loader.gif" alt="" class="loaderimg" style="display:none;">
							  <input type="hidden" name="pippin_login_nonce" value="<?php echo wp_create_nonce('pippin-login-nonce'); ?>"/>
 					    </div>
				  </form>
			<?php endif; ?>
				            
            </div>
          </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

