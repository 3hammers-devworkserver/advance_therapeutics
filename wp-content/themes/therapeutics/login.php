<?php 
/* 
Template Name: Login 
*/
get_header(); ?>

<!-- Login form -->
<?php //if(! ( is_user_logged_in() ) ) :?>
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
                        <a href="javascript:;" id="register" class="btn btn-primary">Register</a>
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



  <!-- Registration form -->
  <section class="light-gray register-page hide">
      <div class="container">
        <form id="pippin_registration_form" action="javascript:void(0);" method="POST" >
        <div class="row">
          <div class="col-md-4 col-sm-5">
            <div class="profile-block">
              <div class="top-block profile-image">                
              </div>

              <div class="bottom-block">
                <div class="profile-pic profile-image"></div>
                <label class="btn btn-secondary btn-file">
                   <i class="fa fa-user-o"></i> upload profile picture 
                   <input type="file" name="file" onchange="readfeatured10(this,'profile-image');" hidden>
                </label>
                <p>Please upload a square photo that clearly shows your face.</p>
              </div>

            </div>            
          </div>
          <div class="col-md-8 col-sm-7">
            <h2 class="inner_page_title">Registration <span>form</span></h2>

            <div class="registration-from">

            <div class="errormsg alert alert-danger" style="display:none;"></div>
            <div class="successmsg1 alert alert-success" style="display:none;"></div>            	
              
                <input type="hidden" name="pageid" value="physician"/>
                
                <div class="form-group">
                  <div class="row">

                    <div class="col-md-6">
                      <label>Title <em>*</em></label>                    
                      <input type="text" id="pp_title" name="pp_title" class="form-control" required>                      
                    </div>
                    <div class="col-md-6">
                      <label>Speciality <em>*</em></label>  
                      <input type="text" id="pp_speciality" name="pp_speciality" class="form-control" required>                      
                    </div>                    
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>First Name <em>*</em></label>                    
                      <input type="text" id="pp_firstname" name="pp_firstname" class="form-control" required>
                      
                    </div>
                    <div class="col-md-6">
                      <label>Last Name <em>*</em></label>  
                      <input type="text" id="pp_lastname" name="pp_lastname" class="form-control" required>                      
                    </div>                    
                  </div>
                </div>
              <div class="form-group dob-select">
                <div class="row">
                    <div class="col-md-6">
                      <label>DOB <em>*</em></label> 
                      <select name="dyear" id="" class="form-control">
                        <option value="">Year</option>
                        <?php for($i = date('Y'); $i >= 1800; $i-- ) :?>
                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
                       <?php  endfor; ?>
                      </select> 
                      <select name="dmonth" id="" class="form-control">
                        <option value="">Month</option>
                        <option value="jan">Jan</option>
                        <option value="feb">Feb</option>
                        <option value="march">March</option>
                        <option value="april">April</option>
                        <option value="may">May</option>
                        <option value="june">June</option>
                        <option value="july">July</option>
                        <option value="aug">Aug</option>
                        <option value="sep">Sep</option>
                        <option value="oct">Oct</option>
                        <option value="nov">Nov</option>
                        <option value="dec">Dec</option>
                      </select> 
                      <select name="dday" id="" class="form-control">
                        <option value="">Day</option>
                        <?php
                        for($d= 1; $d <= 31; $d++): 
                          ?>
                        <option value="<?php echo $d;?>"><?php echo $d;?></option>
                      <?php endfor; ?>
                      </select>                 
                      <!-- <input type="text" id="pp_dob" name="pp_dob" data-format="YYYY-MM-DD" 
                      data-template="YYYY MMM D" class="form-control" required> -->                      
                    </div>
                  <div class="col-md-6">
                    <label>Gender <em>*</em></label>  
                    <div class="gender-block">
                      <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="Male" checked>
                            Male
                          </label>
                      </div>
                      <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="Female">
                            Female
                          </label>
                      </div>
                      <div class="radio">
                          <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="Other">
                            Other
                          </label>
                      </div>
                    </div>                      
                  </div>                    
                </div>
              </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Email Address<em>*</em></label>                    
                      <input type="email" id="pp_email" name="pp_email" class="form-control" required>                      
                    </div>
                    <div class="col-md-6">
                      <label>Phone Number <em>*</em></label>  
                      <input type="tel" id="pp_phoneno" name="pp_phoneno" class="form-control" required>                      
                    </div>                     
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>User name<em>*</em></label>                    
                      <input type="text" id="pp_username" name="pp_username" class="form-control" required>                      
                    </div>                    
                    <div class="col-md-6">
                      <label>Password <em>*</em></label>  
                      <input type="password" id="pp_password" name="pp_password" class="form-control" required>                      
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>Address</label>                    
                      <input type="text" id="pp_address" name="pp_address" class="form-control">
                      
                    </div>
                    <div class="col-md-6">
                      <label>City</label>  
                      <input type="text" id="pp_city" name="pp_city" class="form-control">
                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>State</label>                    
                      <input type="text" id="pp_state" name="pp_state" class="form-control">
                      
                    </div>
                    <div class="col-md-6">
                      <label>Postal/Zip Code</label>  
                      <input type="text" id="pp_zipcode" name="pp_zipcode" class="form-control">
                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>LIC #<em>*</em></label>                    
                      <input type="text" id="pp_lic" name="pp_lic" class="form-control" required>
                      
                    </div>
                    <div class="col-md-6">
                      <label>DEA #<em>*</em></label>  
                      <input type="text" id="pp_dea" name="pp_dea" class="form-control" required>
                      
                    </div>
                    
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-6">
                      <label>NPI #<em>*</em></label>                    
                      <input type="text" id="pp_npi" name="pp_npi" class="form-control" required>                      
                    </div>                   
                  </div>
                </div>
      
                <footer>
                  <div class="btn-grp">
                    <span>
                        <i class="fa fa-spinner fa-spin loaderimg" style="display:none;"></i>
                        <input type="submit" class="btn btn-primary" value="Register">
                    </span>
                    <input type="hidden" name="pippin_register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
                    <!-- <input type="hidden" name="pippin_redirect_url" value="<?php echo $_SERVER['REQUEST_URI'];?>"/> -->
                    <p>Already a member ? <a href="javascript:;" id="login">Login</a></p>
                  </div>
                </footer>
              <!-- </form> -->
            </div>
       
          </div>
        </div>
      </form>
      </div>
    </section>

<?php //endif; ?>

<?php get_footer(); ?>
