<?php 
/*
Template Name: Contact-us 
*/
get_header();
?>

<section class="inner-wrapper">
            <div class="inner-content light-gray contact">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="map-area">
                      	<?php if(!empty(ot_get_option('pp_map_location'))): 
                      	echo ot_get_option('pp_map_location'); ?>
                      	<?php else: ?>
                      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14128.65416853426!2d85.3187813!3d27.7122364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1486977870873" 
                      width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                 		<?php endif; ?>
                     </div>
                    </div>
                  </div>

                    <div class="row">

                        <div class="col-md-5 col-sm-5">
                            <h2 class="inner_page_title">contact <span>info</span></h2>
                            <div class="content">                   
                              <div class="icon-box-wrap">
                                <div class="icon-box">
                                  <i class="fa fa-paper-plane-o"></i>
                                </div>
                                <div class="icon-text">
                                  <h4>Address</h4>
                                  <p>
									<?php if(!empty(ot_get_option('pp_address_detail'))): 
									echo ot_get_option('pp_address_detail'); ?>         
								  </p>
								<?php else: ?>
                                  <p>
                                    Box 565, Pinney's Beach, Nevis, West Indies, Caribbean
                                  </p>
                              		<?php endif; ?>
                                </div>
                              </div>
                              <div class="icon-box-wrap">
                                <div class="icon-box">
                                  <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="icon-text">
                                  <h4>Hours of Operation</h4>
                                  <p>
                                    <?php if(!empty(ot_get_option('pp_hours_operation'))): 
                                    echo ot_get_option('pp_hours_operation'); ?>  
                                  </p>
                              	<?php else: ?>
                                  <p>
                                    Monday – Friday: 9:00am – 5:00pm <br>
                                    Pacific Standard Time
                                  </p>
                              	<?php endif; ?>
                                </div>
                              </div>
                              <div class="icon-box-wrap">
                                <div class="icon-box">
                                  <i class="fa fa-phone"></i>
                                </div>
                                <div class="icon-text">
                                  <h4>Helpline</h4>
                                  <p>
                                    <?php if(!empty(ot_get_option('pp_helpline'))): 
                                    echo ot_get_option('pp_helpline'); ?>
                                  </p>
								<?php else: ?>
                                  <p>
                                    Toll Free: (888) 603-8181<br>
                                    Local: (714) 667-3832<br>
                                    Fax: (888) 978-5154
                                  </p>
                              	<?php endif; ?>
                                </div>
                              </div>
                              <div class="icon-box-wrap">
                                <div class="icon-box">
                                  <i class="fa fa-envelope-o"></i>
                                </div>
                                <div class="icon-text">
                                  <h4>General Enquiries</h4>
                                  <p>
                                  	<?php if(!empty(ot_get_option('pp_email_detail'))): ?>
                                    <a href="<?php echo ot_get_option('pp_email_detail'); ?>">
                                    <?php echo ot_get_option('pp_email_detail'); ?></a>
                                  </p>
								<?php else: ?>
                                  <p>
                                    <a href="mailto:more@advthx.com">more@advthx.com</a>
                                  </p>
                              	<?php endif; ?>
                                </div>
                              </div>

                            
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <h2 class="inner_page_title">keep<span> in touch</span></h2>
                            <div class="content">                   
                              <p class="lead">Don’t be a stranger. We would like to hear from you as much as possible.</p>
                              <div class="contact-form">
                                <form action="#">
                                  <?php echo do_shortcode('[contact-form-7 id="146" title="Contact form 1"]'); ?>                                  
                                </form>
                              </div>                    
                            </div>
                        </div>
                    </div>
                </div>                
            </div>   
        </section>

<?php get_footer(); ?>