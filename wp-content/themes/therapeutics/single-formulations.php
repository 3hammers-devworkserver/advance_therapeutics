<?php get_header();?>
<?php
// Start the loop.
if( have_posts() ):  while ( have_posts() ) : the_post();
?>
<section class="light-gray step-wrapper">
  <div class="step3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
         
        <form id="example-advanced-form" method="post" action="javascript:;" class="formsubmit">
        <h3>First step</h3>
        <fieldset>
                   <h2 class="prescription-title">

                    <?php the_excerpt(); ?> 
                    </h2>
                   <div class="step-radio-block">

                   <div class="form-group">
                    <h5>Refill</h5>
                    <div class="radio">
                        <label>
                          <input type="radio" class="optionval" name="optionsRadios" id="optionsRadios1" value="1" required>
                          1
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" class="optionval" name="optionsRadios" id="optionsRadios2" value="2">
                          2
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" class="optionval" name="optionsRadios" id="optionsRadios3" value="3">
                          3
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios4" value="0" >
                         <input type="text" class="form-control" name="lastoption" value="" id="lastoption">
                        </label>
                    </div>
                   </div>
                   </div>
                <div class="well">
                  <p>
                    <?php the_content(); ?>
                  </p>
                </div>
               

                  <div class="alternative-table">
                    <div class="table-head primary-block">alternative therapy table*</div>
                    <div class="table-content light-block">
                      <?php
                      $d1 = get_post_meta(get_the_ID(), 'D-1', true);
                      $l1 = get_post_meta(get_the_ID(), 'L-1', true);
                      $ca1 = get_post_meta(get_the_ID(), 'CA-1', true);
                      $ca2 = get_post_meta(get_the_ID(), 'CA-2', true);
                      $s1 = get_post_meta(get_the_ID(), 'S-1', true);
                      $s2 = get_post_meta(get_the_ID(), 'S-2', true);
                      $kb1 = get_post_meta(get_the_ID(), 'KB-1', true);
                       ?>
                      
                      <p> D-1 – <?php echo $d1; ?></p>
                      <p> L-1 – <?php echo $l1; ?> </p>
                      <p> CA-1 – <?php echo $ca1; ?> </p>
                      <p> CA-2 –  <?php echo $ca2; ?> </p>
                      <p> S-1 – <?php echo $s1; ?></p>
                      <p> S-2 – <?php echo $s2; ?></p>
                      <p> KB-1 – <?php echo $kb1; ?> </p>

                    </div>
                  </div>
        </fieldset>
          <h3>Second Step</h3>
          <fieldset>
                      <h2 class="inner_page_title">Please fill in the<span>patients information </span></h2>
                         
                      <div class="patient-form">
                        <div class="form-group">
                          <div class="row">
                          <input type="hidden" name="formulationsection" value="<?php echo $post->post_title; ?>" />
                          <input type="hidden" name="formulationid" value="<?php echo $post->ID; ?>" />
                            <div class="col-md-4 col-sm-4">
                              <label for="">Username <em>*</em></label>
                              <input type="text" class="form-control required" id="username" autocomplete="off" autofocus name="username" value="">
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">First Name <em>*</em></label>
                              <input type="text" class="form-control required valid" id="firstname" name="firstname" value="">
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">Last Name <em>*</em></label>
                              <input type="text" class="form-control required valid" id="lastname" name="lastname" value="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4 col-sm-4">
                              <label for="">Email Address <em>*</em></label>
                              <input type="email" class="form-control required valid" id="emailadd" name="email" value="">
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">DOB <em>*</em></label>
                              <div class="dob-select">
                                  <select name="dyear" id="dyear" class="form-control required">
                                    <option value="">Year</option>
                                    <?php for($i = date('Y'); $i >= 1800; $i-- ) :?>
                                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                   <?php  endfor; ?>
                                  </select> 
                                <select name="dmonth" id="dmonth" class="form-control required">
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
                                  <select name="dday" id="dday" class="form-control required">
                                    <option value="">Day</option>
                                    <?php
                                    for($d= 1; $d <= 31; $d++): 
                                      ?>
                                    <option value="<?php echo $d;?>"><?php echo $d;?></option>
                                  <?php endfor; ?>
                                  </select>
                              </div>
                              
                                  
                                   
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <label for="">Phone Number</label>
                              <input type="tel" class="form-control" id="phonenumber" name="phone" value="">
                            </div>
                            
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-8 col-sm-6">
                              <label for="">Allergies <em>*</em></label>
                              <input type="text" class="form-control required valid" name="allergies" value="">
                            </div>
                      
                            <div class="col-md-4 col-sm-6">
                              <label for=""> Patient Demographics Sheet <em>*</em></label>
                              <span class="btn btn-secondary btn-file">
                                 <i class="fa fa-image"></i> Upload Demographics Sheet <input type="file" hidden name="file">
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4">
                              <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="optionsRadios1" id="check1" value="option1">
                                        No Known Drug Allergies (NKDA)
                                      </label>
                              </div>
                              <div class="checkbox prescription-profile">
                                  <label>
                                    <input type="checkbox" name="optionsRadios2" id="check2" value="option2">
                                    Save this prescription to your profile
                                  </label>
                                  <input type="text" class="form-control" name="pdfname">
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
</section>

<?php endwhile; endif; ?>
<?php get_footer();?>