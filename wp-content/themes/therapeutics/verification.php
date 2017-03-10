<?php 
/*
Template Name: Verification
*/
get_header(); ?>

<?php 
global $wpdb;
$userid = $_GET['id'];
$user = get_user_by( 'id', $userid );
$pass = get_user_meta($userid,'upassword',true);
$contact = get_user_meta($userid,'contact',true);
$rows_affected = $wpdb->query(
                    $wpdb->prepare(
                    "UPDATE wp_users SET user_activation_key = %s where ID= %d",
                     0, $userid
                    ) // $wpdb->prepare
                    ); // $wpdb->query
add_filter( 'wp_mail_content_type', 'set_html_content_type' );

$verify = '<html lang="en" style="background:#fbfbfb;">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <div style="margin:0 auto; padding:50px 0; width: 100%;">
        <center>
            <table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
                <tr class="logo">
                    <td style="padding:0 20px; border-bottom:1px dashed #500847; margin:0;">
                        <a href="'.site_url().'" style="display:block;">
                            <img class="w320" height="120" src="'.get_template_directory_uri().'/assets/images/logo.png" alt="company logo">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:14px; padding:10px 20px 0; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0; color: #52595f;">
                        Welcome to Advanced Therapeutics.
                      </p>
                    </td>
                </tr>
                <tr class="highlight" style="padding:0; margin:0;">
                    <td style="font-size:14px; padding:10px 20px; margin:0; font-family:Arial;" class="w320 mobile-spacing">
                        <p style="color: #52595f; padding:0; margin:0">Use the following values when prompted to log in:</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0; font-size:14px; font-family:Arial; ">
                        <table style="padding:5px 20px; margin:0; background:#fafafa; width:100%;">
                         <tr>
                          <td style="width:20%; text-align: left;">
                           <b style="margin:0 20px 0 0; padding:0;">Username:</b>
                          </td>
                          <td align="left" style="text-align: left; width: 80%;">'.$user->user_email.'
                          </td>
                         </tr>
                        </table>
                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                        <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                         <tr>
                          <td align="left" style="width:20%;"><b style="margin:0 20px 0 0; padding:0;">Password:</b></td>
                          <td align="left" style="width: 80%; text-align: left;">
                           '.$pass.'
                          </td>
                         </tr>
                        </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                        <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                         <tr>
                          <td align="left" style="width:20%;"><b style="margin:0 20px 0 0; padding:0;">Contact No:</b></td>
                          <td align="left" style="width: 80%; text-align: left;">
                           '.$contact.'
                          </td>
                         </tr>
                        </table>                       
                    </td>
                </tr>
                    <tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:14px;line-height:normal; 
                            margin:0; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">Thank You,</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">'.ot_get_option("pp_title").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_address").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;"><a href="mailto:'.ot_get_option("pp_email_address").'">'.ot_get_option("pp_email_address").'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style=" font-family:Arial; padding:0 20px 20px">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_phone_number").'</p>
                        </td>
                    </tr>
            </table>
        </center>
    </div>
</body>
</html>';


$headers = 'From: Advanced Therapeutics <info@advancedtherapeutics.com>' . "\r\n";
$email_subject = "Email Verified";
if( wp_mail( $user->user_email, $email_subject, $verify, $headers ) ){
 ?>
 <section class="verify-wrapper text-center">
 <div class="container">
<div class="successmsg text-center">
    <h2>
        Your email has been verified successfully. Please login with your info.
    </h2>

</div>         
</div>
 </section>
 <section class="light-gray login-page">
      <div class="container">
        <div class="row">
          <div class="col-md-offset-4 col-sm-offset-3 col-md-4 col-sm-6">
            <div class="form-wrapper">
              
              <div class="login-wrapper">
                <div class="light-block">
                  <div class="title">
                    <h3>Login</h3>
                  </div>
                  <div class="login-form">
                    <div class="errormsg1 alert alert-danger" style="display:none;"></div>
                    <div class="successmsg alert alert-success" style="display:none;"></div> 
                    <form class="form-btm-outline" id="pippin_login_form" action="javascript:;" method="post">
                      <input type="hidden" name="pippin_redirect_url" value="<?php echo site_url(); ?>"/>
                      <div class="form-group">
                        <div class="input-grp">
                          <span class="input-grp-addon" id="basic-addon1"><i class="fa fa-user-o"></i></span>
                           <input type="text" class="form-control" id="pp_user_login" name="pp_user_login" placeholder="Email" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-grp">
                          <span class="input-grp-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                          <input type="password" class="form-control" id="pp_user_pass" name="pp_user_pass" placeholder="Password" required>
                        </div>
                      </div>
                      <div class="btn-grp">
                          <span>
                            <i class="fa fa-spinner fa-spin loaderimg" style="display:none;"></i>
                            <input type="submit" class="btn btn-primary" value="Login">
                          </span>
                        <input type="hidden" name="pippin_login_nonce" value="<?php echo wp_create_nonce('pippin-login-nonce'); ?>"/>
                        <!-- <a href="javascript:;" id="register" class="btn btn-primary">Register</a> -->
                      </div>
                      
                    </form>
                    
                  </div>
                  <div class="login-footer">
                    <p>forgot your password? <a href="<?php echo site_url('/password-reset/');?>" >click here</a></p>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
 <?php
}else{ ?>
<section class="verify-wrapper text-center">
   <div class="container">
    <div class="errormsg text-center">
      <h2>
        Your email has not been verified. Please check your email again and click link to verify.
      </h2>
    </div>
   </div>
</section>
<?php }

remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

?>

<?php get_footer(); ?>