<?php
/*
Template Name: Refill RX
*/

get_header();

$rxid = $_GET['id'];
global $wpdb;
$sql = "Select * from wp_rxrefill where id = $rxid ";
$result = $wpdb->get_row($sql);
$title = get_the_title( $result->formulation_id );
$users = get_user_by( 'ID', $result->user_id );
$year = get_user_meta( $result->user_id, 'dateyear', true );
$month = get_user_meta( $result->user_id, 'datemonth', true );
$day = get_user_meta( $result->user_id, 'dateday', true );
$phone = get_user_meta( $result->user_id, 'contact', true );

?>

<section class="light-gray step-wrapper edit-refill">
  <div class="step3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
         <h2 class="inner_page_title text-center"><?php echo ucfirst( $title ); ?></h2>
          <div class="step-radio-block">
        <form id="update-advanced-form" method="post" action="javascript:;" class="formsubmit">
        <h3>First step</h3>
        <fieldset>
           <div class="step-radio-block">
    			<div class="form-group">
                    <h5>Refill</h5>
                    <input type="hidden" value="<?php echo site_url();?>" name="siteurl" />
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios1" class="optionval" value="1" required <?php if( $result->refill == 1 ): echo 'checked'; endif;?>>
                          1
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios2" class="optionval" value="2" <?php if( $result->refill == 2 ): echo 'checked'; endif;?>>
                          2
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios3" class="optionval" value="3" <?php if( $result->refill == 3 ): echo 'checked'; endif;?>>
                          3
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios4" value="0" <?php if( $result->refill == 0 ): echo 'checked'; endif;?>>
                         <input type="text" class="form-control" name="lastoption" id="lastoption" value="<?php if( $result->refill == 0 && $result->last_option ): echo $result->last_option; endif;?>">
                        </label>
                    </div>
                   </div>
                   </div>
          </fieldset>
          <h3>Second Step</h3>
          <fieldset>
                      <h2 class="inner_page_title">Please fill in the<span>patients information </span></h2>
                         
                      <div class="patient-form">
                        <div class="form-group">
                          <div class="row">
                          <input type="hidden" name="formulationsection" value="<?php echo $title; ?>" />
                          <input type="hidden" name="refillid" value="<?php echo $rxid; ?>" />
                          <input type="hidden" name="formulationid" value="<?php echo $result->formulation_id; ?>" />

                            <div class="col-md-4 col-sm-4">
                              <label for="">Username <em>*</em></label>
                              <input type="text" class="form-control required" id="username" autocomplete="off" autofocus name="username" value="<?php echo $users->user_login; ?>">
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">First Name <em>*</em></label>
                              <input type="text" class="form-control required valid" id="firstname" name="firstname" value="<?php echo $users->first_name; ?>">
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">Last Name <em>*</em></label>
                              <input type="text" class="form-control required valid" id="lastname" name="lastname" value="<?php echo $users->last_name; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4 col-sm-4">
                              <label for="">Email Address <em>*</em></label>
                              <input type="email" class="form-control required valid" id="emailadd" name="email" value="<?php echo $users->user_email; ?>">
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">DOB <em>*</em></label>
                              <div class="row">
                                <div class="col-md-4"><select name="dyear" id="dyear" class="form-control required">
                                    <option value="">Year</option>
                                    <?php for($i = date('Y'); $i >= 1800; $i-- ) :?>
                                      <option value="<?php echo $i;?>" <?php if($i == $year ){ echo 'selected';}?>><?php echo $i;?></option>
                                   <?php  endfor; ?>
                                  </select> </div>
                                <div class="col-md-4"><select name="dmonth" id="dmonth" class="form-control required">
                                    <option value="">Month</option>
                                    <option value="jan" <?php if('jan' == $month ){ echo 'selected';}?>>Jan</option>
                                    <option value="feb" <?php if('feb' == $month ){ echo 'selected';}?>>Feb</option>
                                    <option value="march" <?php if('march' == $month ){ echo 'selected';}?>>March</option>
                                    <option value="april" <?php if('april' == $month ){ echo 'selected';}?>>April</option>
                                    <option value="may" <?php if('may' == $month ){ echo 'selected';}?>>May</option>
                                    <option value="june" <?php if('june' == $month ){ echo 'selected';}?>>June</option>
                                    <option value="july" <?php if('july' == $month ){ echo 'selected';}?>>July</option>
                                    <option value="aug" <?php if('aug' == $month ){ echo 'selected';}?>>Aug</option>
                                    <option value="sep" <?php if('sep' == $month ){ echo 'selected';}?>>Sep</option>
                                    <option value="oct" <?php if('oct' == $month ){ echo 'selected';}?>>Oct</option>
                                    <option value="nov" <?php if('nov' == $month ){ echo 'selected';}?>>Nov</option>
                                    <option value="dec" <?php if('dec' == $month ){ echo 'selected';}?>>Dec</option>
                                  </select> </div>
                                <div class="col-md-4"><select name="dday" id="dday" class="form-control required">
                                    <option value="">Day</option>
                                    <?php
                                    for($d= 1; $d <= 31; $d++): 
                                      ?>
                                    <option value="<?php echo $d;?>" <?php if($d == $day ){ echo 'selected';}?>><?php echo $d;?></option>
                                  <?php endfor; ?>
                                  </select>  </div>
                              </div>
                              
                                  
                                   
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">Phone Number</label>
                              <input type="tel" class="form-control" id="phonenumber" name="phone" value="<?php echo $phone; ?>">
                            </div>
                            
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-8 col-sm-8">
                              <label for="">Allergies <em>*</em></label>
                              <input type="text" class="form-control required valid" name="allergies" value="<?php echo $result->allergies; ?>">
                            </div>
                      
                            <div class="col-md-4 col-sm-4">
                              <label for=""> Patient Demographics Sheet <em>*</em></label>
                              <span class="btn btn-secondary btn-file">
                                 <i class="fa fa-image"></i> Upload Demographics Sheet <input type="file" hidden name="file" value="<?php echo $result->filename; ?>">
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="optionsRadios1" id="check1" value="option1" <?php if( $result->option1 == 'option1' ): echo 'checked'; endif;?>>
                                        No Known Drug Allergies (NKDA)
                                      </label>
                              </div>
                              <div class="checkbox prescription-profile">
                                  <label>
                                    <input type="checkbox" name="optionsRadios2" id="check2" value="option2" <?php if( $result->option1 == 'option2' ): echo 'checked'; endif;?>>
                                    Save this prescription to your profile
                                  </label>
                                  <input type="text" class="form-control" name="pdfname" style="<?php if( $result->option1 == 'option2' ): echo 'display:block;'; endif;?>">
                              </div>
                              
                            </div>
                          </div>

                        </div>
                      </div> 


          </fieldset>
         </form>
          </div>
        
        </div>
      </div>
  </div>
</div>
</section>
<?php get_footer(); ?>
