<?php 
/* 
Template Name: Edit-Profile
*/
get_header(); ?>


<section class="light-gray register-page profile">
      <div class="container">
        <form id="pippin_edit_form" action="javascript:void(0);" method="POST" novalidate>
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <div class="profile-block">
              <?php   $current_user = wp_get_current_user(); ?>            
              <input type="hidden" class="" name="userid" value="<?php echo $current_user->ID;?> ">
              <?php 
              $image = get_user_meta($current_user->ID,'ppicture',true); 
              $final = site_url() ."/wp-content/uploads/". $image;
              ?>
              <div class="top-block profile-image" style="background-image:url('<?php echo $final; ?>');">
                
              </div>
              <div class="bottom-block">
                <div class="profile-pic profile-image" style="background-image:url(<?php echo $final; ?>);">
                 
                </div>
                <div class="profile-content text-center">
                  <h4 class="">
                    <?php $title = get_user_meta( $current_user->ID, 'title', false ); ?>
                    <?php echo $title[0]; ?> 
                    <?php echo $current_user->user_firstname." ".$current_user->user_lastname; ?>
                  </h4>
                  <h5><?php if( get_user_meta( $current_user->ID,'contact',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'contact', true ); endif;?></h5>
              <!--     <ul class="list-unstyled social-links list-inline">
                    <li ><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                    <li ><a href="#" class="google"><i class="fa fa-google"></i></a></li>
                    <li ><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                  </ul> -->
                </div>
                <label class="btn btn-secondary btn-file">
                   <i class="fa fa-user-o"></i> Change profile picture 
                    <input type="file" name="file" onchange="readfeatured10(this,'profile-image');" hidden>

                </label>
                <p>Please upload a square photo that clearly shows your face.</p>
              </div>
            </div>
            
          </div>
          <div class="col-md-8 col-sm-8">
            <div class="errormsg alert alert-danger" style="display:none;"></div>
            <div class="successmsg alert alert-success" style="display:none;"></div> 
            <h2 class="inner_page_title">My <span>Profile</span></h2>
            <div class="registration-from">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Title <em>*</em></label>                    
                      <input type="text" class="form-control" name="pp_title"
                      value="<?php if( get_user_meta( $current_user->ID,'title',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'title', true ); endif;?>">                      
                    </div>
                    <div class="col-md-6">
                      <label>Speciality <em>*</em></label>  
                      <input type="text" class="form-control" name="pp_speciality"
                      value="<?php if( get_user_meta( $current_user->ID,'speciality',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'speciality', true ); endif;?>">                      
                    </div>                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>First Name <em>*</em></label>                    
                      <input type="text" class="form-control" name="pp_firstname"
                      value="<?php if($current_user->user_firstname) : 
                      echo $current_user->user_firstname; endif; ?>" >                      
                    </div>
                    <div class="col-md-6">
                      <label>Last Name <em>*</em></label>  
                      <input type="text" class="form-control" name="pp_lastname"
                      value="<?php if($current_user->user_lastname) : 
                      echo $current_user->user_lastname; endif; ?>">                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group dob-select">
                  <div class="row">
                    <div class="col-md-6">
                      <label>DOB <em>*</em></label>
                      <select name="dyear" id="" class="form-control required">
                        <option value="">Year</option>
                        <?php $year = get_user_meta($current_user->ID,'dateyear',true); ?>
                        <?php for($i = date('Y'); $i >= 1800; $i-- ) :?>
                          <option value="<?php echo $i;?>" <?php if( $i == $year ){ echo 'selected';}?>><?php echo $i;?></option>
                       <?php  endfor; ?>
                      </select> 
                      <select name="dmonth" id="" class="form-control required">
                        <option value="">Month</option>
                        <option value="jan" <?php if('jan' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>Jan</option>
                        <option value="feb" <?php if('feb' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>Feb</option>
                        <option value="march" <?php if('march' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>March</option>
                        <option value="april" <?php if('april' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>April</option>
                        <option value="may" <?php if('may' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>May</option>
                        <option value="june" <?php if('june' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>June</option>
                        <option value="july" <?php if('july' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>July</option>
                        <option value="aug" <?php if('aug' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>Aug</option>
                        <option value="sep" <?php if('sep' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>Sep</option>
                        <option value="oct" <?php if('oct' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>Oct</option>
                        <option value="nov" <?php if('nov' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>Nov</option>
                        <option value="dec" <?php if('dec' == get_user_meta($current_user->ID,'datemonth',true) ){ echo 'selected';}?>>Dec</option>
                      </select> 
                      <select name="dday" id="" class="form-control required">
                        <option value="">Day</option>
                        <?php
                         $day = get_user_meta($current_user->ID,'dateday',true);
                        for($d= 1; $d <= 31; $d++): 
                          ?>
                        <option value="<?php echo $d;?>" <?php if($d == $day ){ echo 'selected';}?>><?php echo $d;?></option>
                      <?php endfor; ?>
                      </select>                     
                    </div>
                    <div class="col-md-6">
                      <label>Gender <em>*</em></label>  
                      <div class="gender-block">
                        <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" 
                            value="Male" 
                            <?php if( get_user_meta( $current_user->ID,'gender',true) == 'Male') : 
                            echo 'Checked'; endif; ?>> Male
                          </label>
                      </div>
                      <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" 
                            value="Female" 
                            <?php if( get_user_meta($current_user->ID,'gender',true) == 'Female') : 
                            echo 'Checked'; endif; ?>> Female
                         </label>
                      </div>
                      <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios3" 
                            value="Others"
                            <?php if( get_user_meta($current_user->ID,'gender',true) == 'Other') : 
                            echo 'Checked'; endif; ?>> Other
                          </label>
                      </div>
                    </div>
                      
                    </div>
                    
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>User name<em>*</em></label>                    
                      <input type="text" class="form-control" name="pp_username"
                      value="<?php if($current_user->user_login) : 
                      echo $current_user->user_login; endif; ?>" disable readonly>
                      
                    </div>
                    <div class="col-md-6">
                      <label>password<em>*</em></label>  
                      <?php $password = get_user_meta($current_user->ID,'upassword',true); ?>                  
                      <input type="password" class="form-control" name="pp_password"
                      value="<?php if($password) : 
                      echo $password; endif; ?>" disable readonly>
                      
                    </div>
                    
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Email Address<em>*</em></label>                    
                      <input type="email" class="form-control" name="pp_email"
                      value="<?php if($current_user->user_email) : 
                      echo $current_user->user_email; endif; ?>">
                      
                    </div>
                    <div class="col-md-6">
                      <label>Phone Number <em>*</em></label>  
                      <input type="text" class="form-control" name="pp_phoneno"
                      value="<?php if( get_user_meta( $current_user->ID,'contact',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'contact', true ); endif;?>">
                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Address</label>                    
                      <input type="text" class="form-control" name="pp_address"
                      value="<?php if( get_user_meta( $current_user->ID,'address',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'address', true ); endif;?>">
                      
                    </div>
                    <div class="col-md-6">
                      <label>City</label>  
                      <input type="text" class="form-control" name="pp_city"
                      value="<?php if( get_user_meta( $current_user->ID,'city',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'city', true ); endif;?>">
                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>State</label>                    
                      <input type="text" class="form-control" name="pp_state"
                      value="<?php if( get_user_meta( $current_user->ID,'state',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'state', true ); endif;?>">
                      
                    </div>
                    <div class="col-md-6">
                      <label>Postal/Zip Code</label>  
                      <input type="text" class="form-control" name="pp_zipcode"
                      value="<?php if( get_user_meta( $current_user->ID,'zipcode',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'zipcode', true ); endif;?>">
                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>LIC #<em>*</em></label>                    
                      <input type="text" class="form-control" name="pp_lic"
                      value="<?php if( get_user_meta( $current_user->ID,'lic',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'lic', true ); endif;?>">
                      
                    </div>
                    <div class="col-md-6">
                      <label>DEA #<em>*</em></label>  
                      <input type="text" class="form-control" name="pp_dea"
                      value="<?php if( get_user_meta( $current_user->ID,'dea',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'dea', true ); endif;?>">
                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>NPI #<em>*</em></label>                    
                      <input type="text" class="form-control" name="pp_npi"
                      value="<?php if( get_user_meta( $current_user->ID,'npi',true ) ) : 
                      echo get_user_meta( $current_user->ID, 'npi', true ); endif;?>">
                      
                    </div>
                    
                    
                  </div>
                </div>
      
                <footer>
                  <div class="btn-grp">
                    <input type="hidden" name="pippin_register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
                    <span>
                      <i class="fa fa-spinner fa-spin loaderimg" style="display:none;"></i>
                      <input type="submit" class="btn btn-secondary" value="Update Profile">
                    </span>
                  </div>
                </footer>
              <!-- </form> -->
            </div>
       
          </div>
        </div>
      </form>
      </div>
    </section>

<?php get_footer(); ?>