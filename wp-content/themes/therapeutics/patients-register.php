<?php 
/*
Template Name: Patients register
*/
get_header(); ?>

<section class="inner-wrapper">
            <div class="inner-content light-gray patient-register">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                       <h2 class="inner_page_title">Please fill the <span>form below</span></h2>
                    </div>
                  </div>
                    <div class="patient-register-form">
						
                      <form action="javascript:;" id="pippin_patient_form" method="post" name="patient_form" novalidate>
                        <div class="row">                        
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>User Name <em>*</em></label>
                                <input type="text" id="pippin_user_name" name="pippin_user_name" class="form-control" required>
                              </div>                              
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>First Name <em>*</em></label>
                                <input type="text" id="pippin_first_name" name="pippin_first_name" class="form-control" required>
                              </div>                              
                            </div>

                            <!-- <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" id="pippin_middle_name" name="pippin_middle_name" class="form-control">
                              </div>
                              
                            </div> -->
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>Last Name <em>*</em></label>
                                <input type="text" id="pippin_last_name" name="pippin_last_name" class="form-control" required>
                              </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group dob-select">
                                <label>DOB<em>*</em></label>
                                <select name="dyear" id="" class="form-control" required>
                                  <option value="">Year</option>
                                  <?php for($i = date('Y'); $i >= 1800; $i-- ) :?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                 <?php  endfor; ?>
                                </select> 
                                <select name="dmonth" id="" class="form-control" required>
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
                                <select name="dday" id="" class="form-control last" required>
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
                              <div class="form-group">
                                <label>Phone Number <em>*</em></label>
                                <input type="tel" id="pippin_number" name="pippin_number" class="form-control" required>
                              </div>
                              
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>Email Address <em>*</em></label>
                                <input type="email" id="pippin_email" name="pippin_email" class="form-control" required>
                              </div>
                              
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>Insurance Carrier <span class="secondary-highlight">(if known)</span> </label>
                                <input type="text" id="insurance_carrier" name="insurance_carrier" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>How long have you had pain?</label>
                                <input type="text" id="pain_duration" name="pain_duration" class="form-control">
                              </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                              <div class="form-group">
                                <label>Where is your pain located?</label>
                                <input type="text" id="pain_location" name="pain_location" class="form-control">
                              </div>
                            </div>
                        </div>
                        

                        <div class="check-wrap">
                          <p>
                            Which of the following best describes how the pain begin <span class="secondary-highlight">(check all that apply)</span>
                          </p>
                          <div class="row">
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox1" name="checkBox[]" value="Accident at home">
                                        Accident at home
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox2" name="checkBox[]" value="Work Related">
                                        Work Related
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox3" name="checkBox[]" value="Motor Vehicle Accident">
                                        Motor Vehicle Accident
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox4" name="checkBox[]" value="Just Began">
                                        Just Began
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox5" name="checkBox[]" value="Motor Vehicle Accident">
                                        Motor Vehicle Accident
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox6" name="checkBox[]" value="After Surgery">
                                        After Surgery
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox7" name="checkBox[]" value="Came on Gradually">
                                        Came on Gradually
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox8" name="checkBox[]" value="Accident at work">
                                        Accident at work
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox9" name="checkBox[]" value="After Illness">
                                        After Illness
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="checkBox10" name="checkBox[]" value="others">
                                        others
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                            </div>
                        </div>

                        <div class="check-wrap">
                          <p>
                            How do you best describe your pain?
                          </p>
                          <div class="row">
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="Checkbox1" name="Checkbox[]" value="Dull Ache">
                                        Dull Ache
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="Checkbox2" name="Checkbox[]" value="Burning">
                                        Burning
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="Checkbox3" name="Checkbox[]" value="Throbbing">
                                        Throbbing
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="Checkbox4" name="Checkbox[]" value="Shooting">
                                        Shooting
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="Checkbox5" name="Checkbox[]" value="Sharp">
                                        Sharp
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="Checkbox6" name="Checkbox[]" value="Others">
                                        Others
                                      </label>
                                  </div>
                                </div>                               
                             </div>                            
                                                          
                          </div>
                        </div>

                        <div class="radio-wrap">
                          <p>
                            How do you best describe your pain?
                          </p>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="radio">
                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="Tingling/numbness in the hands/feet">
                                    Yes
                                  </label>

                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="no">
                                    No
                                  </label>
                                  <span class="help-block" id="option1" name="option1">Tingling/numbness in the hands/feet</span>
                                </div>
                                
                              </div>
                              <div class="form-group">
                                <div class="radio">
                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="Weakness in the hands/feet">
                                    Yes
                                  </label>

                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="no">
                                    No
                                  </label>
                                  <span class="help-block" id="option2" name="option2">Weakness in the hands/feet</span>
                                </div>
                                
                              </div>
                              <div class="form-group">
                                <div class="radio">
                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="Pain radiating/traveling to arm/forearm/hands">
                                    Yes
                                  </label>

                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="no">
                                    No
                                  </label>
                                  <span class="help-block" id="option3" name="option3">Pain radiating/traveling to arm/forearm/hands</span>
                                </div>
                                
                              </div>
                              <div class="form-group">
                                <div class="radio">
                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="Pain radiating/traveling to thigh/buttocks/legs/feet">
                                    Yes
                                  </label>

                                  <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="no">
                                    No
                                  </label>
                                  <span class="help-block" id="option4" name="option4">Pain radiating/traveling to thigh/buttocks/legs/feet</span>
                                </div>                                
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="check-wrap">
                          <p>
                           Which affect your pain?<span class="secondary-highlight">(check all that apply)</span>
                          </p>
                          <div class="row">
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox1" name="CheckBox[]" value="Massaging or rubbing">
                                        Massaging or rubbing
                                      </label>
                                  </div>
                                </div>                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox2" name="CheckBox[]" value="Getting out of bed">
                                        Getting out of bed
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox3" name="CheckBox[]" value="Bright light">
                                        Bright light
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox4" name="CheckBox[]" value="Sudden movements">
                                        Sudden movements
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox5" name="CheckBox[]" value="Sitting">
                                        Sitting
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox6" name="CheckBox[]" value="Bending">
                                        Bending
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox7" name="CheckBox[]" value="Noise">
                                        Noise
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox8" name="CheckBox[]" value="Walking">
                                        Walking
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox9" name="CheckBox[]" value="Straining">
                                        Straining
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox10" name="CheckBox[]" value="Cold weather">
                                        Cold weather
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox11" name="CheckBox[]" value="Standing">
                                        Standing
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox12" name="CheckBox[]" value="Lifting">
                                        Lifting
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox13" name="CheckBox[]" value="Strong emotions">
                                        Strong emotions
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                             <div class="col-md-3 col-sm-3">
                                <div class="form-group">
                                  <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="CheckBox14" name="CheckBox[]" value="Running">
                                        Running
                                      </label>
                                  </div>
                                </div>
                               
                             </div>
                            </div>
                        </div>
  
                      <div class="row">
                        <div class="col-md-12">
                          <div class="btn-grp">
                          <span>
                            <i class="fa fa-spinner fa-spin loaderimg" style="display:none;"></i>
                            <input type="submit" value="Register" class="btn btn-primary">
                          </span>
                        </div>
                            <div class="successMessage alert alert-success" style="display:none;"></div>
                            <div class="errorMessage alert alert-danger" style="display:none;"></div>
                        </div>
                      </div>
                      </form>
                      
                    </div>
                    
                </div>
                
            </div>

            

            

    
        </section>

<?php get_footer(); ?>