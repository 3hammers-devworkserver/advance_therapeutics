<?php 
/* Template Name: steps */
get_header(); ?>

<section class="light-gray step-wrapper">
    <div class="step3">
        <div class="container">
          <div class="row">
          	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
          	<div id="wpmem_reg" >
			  <form id="demoForm" method="post" action="" class="bbq">
				<div class="step" id="first">

				<fieldset>
				  <div class="col-md-12">
                   <h2 class="prescription-title">
              	   Ketoprofen 10% Gabapentin 6% Lidocaine 5% Amitriptyline 2% Baclofen 2% Cyclobenzaprine 2%<span>Qty: 240g  Sig: Apply 2 grams to the affected area 3-4 times daily.</span></h2>
                   <div class="step-radio-block">

                   <div class="form-group">
                    <h5>Refill</h5>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                          1
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                          2
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
                          3
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios4" value="option4">
                         <input type="text" class="form-control">
                        </label>
                    </div>
                   </div>
                   </div>
	              <div class="well">
	                <p>
	                  ^If for any reason patient cannot receive the above prescribed therapy, I order that the pharmacy shall dispense an alternative therapy from the Alternative Therapy Table included at the bottom of this prescription sheet with the stated quantity and application instructions. One alternative therapy shall be dispensed in the order set forth in the following schedule: <span class="primary-highlight">D-1 + L-1 CA-1 CA-2KB-1</span>
	                </p>
	              </div>
            	 </div>

		            <div class="col-md-12">
		              <div class="alternative-table">
		                <div class="table-head primary-block">alternative therapy table*</div>
		                <div class="table-content light-block">
		                  <p>D-1 – Diclofenac 1.5% Solution | <span class="primary-highlight">Qty: 300mL; Sig: Apply 2.5 mL (approx. 40 drops) to the affected area 3-4 times daily</span></p>
		                  <p>
		                    L-1 – Lidocaine 5% Ointment  <span class="primary-highlight">Qty: 250g; Sig: Apply 2.5 grams to the affected area 3-4 times daily</span>
		                  </p>
		                  <p>
		                    CA-1 – Gabapentin 2% Celecoxib 3% Acetaminophen 6.5% Butalbital 0.5% Lidocaine 2% Prilocaine 2% Cream <span class="primary-highlight">Qty: 240g; Sig: Apply 2 grams to the affected area 3-4 times daily</span>
		                  </p>
		                  <p>
		                    CA-2 – Ketoprofen 5% Lidocaine 2% Cyclobenzaprine 2% Amitriptyline 2% Cream | <span class="primary-highlight">Qty: 240g; Sig: Apply 2 grams to the affected area 3-4 times daily</span>
		                  </p>
		                  <p>
		                    S-1 – Fluocinonide 0.1% Cream | <span class="primary-highlight">Qty: 120g; Sig:Apply 2 grams to the affected area 1-2 times daily</span>
		                  </p>
		                  <p>
		                    S-2 – Tamoxifen 0.1% Tranilast 1% Caffeine 0.1% Lipoic Acid 0.5% Cream | <span class="primary-highlight">Qty: 120g; Sig: Apply 2 grams to the affected area 1-2 times daily</span>
		                  </p>
		                  <p>
		                    KB-1 – Ketoprofen 10% Baclofen 2% Cyclobenzaprine 2% Lidocaine 5% | <span class="primary-highlight">Qty: 120g; Sig: Apply 2 grams to the affected area 1-2 times daily</span>
		                  </p>

		                </div>
		              </div>
		            </div>

		            <!-- <div class="col-md-12">
		              <div class="pagination-btn">
		                <a href="step2.html" class="btn btn-primary"><i class="fa fa-angle-left"></i>Back</a>
		                <a href="step4.html" class="btn btn-primary">Next <i class="fa fa-angle-right"></i></a>		                
		              </div>
		            </div> -->

				</fieldset>
			    </div>



			    <div id="second" class="step">
					<fieldset>
				        <div class="container">
				          <div class="row">
				            <div class="col-md-12">
				              <h2 class="inner_page_title">Please fill in the<span>patient's information </span></h2>
				                 
				              <div class="patient-form">
				                <div class="form-group">
				                  <div class="row">
				                    <div class="col-md-4 col-sm-4">
				                      <label for="">First Name <em>*</em></label>
				                      <input type="text" class="form-control" required>
				                    </div>
				                    <div class="col-md-4 col-sm-4">
				                      <label for="">Middle Name</label>
				                      <input type="text" class="form-control">
				                    </div>
				                    <div class="col-md-4 col-sm-4">
				                      <label for="">Last Name <em>*</em></label>
				                      <input type="text" class="form-control" required>
				                    </div>
				                  </div>
				                </div>
				                <div class="form-group">
				                  <div class="row">
				                    <div class="col-md-4 col-sm-4">
				                      <label for="">DOB <em>*</em></label>
				                      <input type="text" class="form-control" required>
				                    </div>
				                    <div class="col-md-4 col-sm-4">
				                      <label for="">Phone Number</label>
				                      <input type="text" class="form-control">
				                    </div>
				                    <div class="col-md-4 col-sm-4">
				                      <label for="">Email Address</label>
				                      <input type="email" class="form-control">
				                    </div>
				                  </div>
				                </div>
				                <div class="form-group">
				                  <div class="row">
				                    <div class="col-md-8 col-sm-8">
				                      <label for="">Allergies <em>*</em></label>
				                      <input type="text" class="form-control" required>
				                    </div>
				              
				                    <div class="col-md-4 col-sm-4">
				                      <label for=""> Patient Demographics Sheet <em>*</em></label>
				                      <span class="btn btn-secondary btn-file">
				                         <i class="fa fa-image"></i> Upload Demographics Sheet <input type="file" hidden>
				                      </span>
				                    </div>
				                  </div>
				                </div>
				                <div class="form-group">
				                  <div class="row">
				                    <div class="col-md-4">
				                      <div class="checkbox">
				                              <label>
				                                <input type="checkbox" name="optionsRadios" id="check1" value="option1">
				                                No Known Drug Allergies (NKDA)
				                              </label>
				                      </div>
				                      <div class="checkbox prescription-profile">
				                          <label>
				                            <input type="checkbox" name="optionsRadios" id="check2" value="option1">
				                            Save this prescription to your profile
				                          </label>
				                          <input type="text" class="form-control">
				                      </div>
				                      
				                    </div>
				                  </div>

				                </div>
				              </div>             

				              
				            </div>

				            
				            <!-- <div class="col-md-12">
				              <div class="pagination-btn">
				                <a href="step3.html" class="btn btn-primary"><i class="fa fa-angle-left"></i>Back</a>
				                <input type="submit" class="btn btn-secondary" value="Submit">
				              </div>
				            </div> -->
				            
				          </div>
				        </div>

					</fieldset>
			    </div>
				<div class="col-md-12">
					<div id="demoNavigation pagination-btn"> 							
	                   <input class="navigation_button btn btn-primary" id="back" value="Back" type="reset" />
	                   <i class="fa fa-angle-left"></i>
	                   <input class="navigation_button btn btn-primary" id="next" value="Next" type="submit" />
	                   <i class="fa fa-angle-right"></i>
	                </div>
                </div>
			  </form>
			</div>

			<?php endwhile; endif; ?>
          </div>
      	</div>
  	</div>
</section>


<?php get_footer(); ?>