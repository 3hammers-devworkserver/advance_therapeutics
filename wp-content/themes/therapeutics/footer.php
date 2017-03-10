<footer class="footer-wrapper">
           <div class="primary-footer">
               <div class="container">
                   <div class="row">
                       <div class="col-md-4 col-sm-4">
                          <ul class="footer-menu list-unstyled list-inline">
                              <li>
                                  <a href="<?php echo site_url();?>/home/">Home</a>
                              </li>
                              <li>
                                  <a href="<?php echo site_url();?>/about-us/">About Us</a>
                              </li>
                              <li>
                                  <a href="<?php echo site_url();?>/contact-us/">Contact Us</a>
                              </li>
                              <li>
                                  <a href="<?php echo site_url();?>/newsroom/">Newsroom</a>
                              </li>
                          </ul>
                       </div>
                       <div class="col-md-4 col-sm-4">
                           <div class="footer-logo">
                               <a href="<?php echo site_url();?>">
                                   <img src="<?php echo ot_get_option('pp_logo_upload'); ?>" alt="Advance Therapeutics">
                               </a>
                           </div>
                       </div>
                      <div class="col-md-4 col-sm-4">
                        <ul class="social-links list-inline list-unstyled">
                            <li>
                              <?php 
                                $urlStr = ot_get_option('pp_facebook_link');
                                $parsed = parse_url($urlStr);
                                if(empty($urlStr)):
                                  $urlStr='javascript:;';
                                  $blank='';
                                  elseif (empty($parsed['scheme'])) : 
                                      $urlStr = 'https://' . ltrim($urlStr, '/'); 
                                      $blank='target="_blank"';
                                    else : ?>
                                    <?php $urlStr = $urlStr; ?>
                              <?php endif;?>
                                <a href="<?php echo $urlStr;?>" <?php echo $blank;?> >
                                <i class="fa fa-facebook"></i></a>              
                          </li>
                          <li>
                            <?php 
                                $urlStr = ot_get_option('pp_twitter_link');
                                $parsed = parse_url($urlStr);
                                if(empty($urlStr)):
                                  $urlStr='javascript:;';
                                  $blank='';
                                  elseif (empty($parsed['scheme'])) : 
                                      $urlStr = 'https://' . ltrim($urlStr, '/'); 
                                      $blank='target="_blank"';
                                    else : ?>
                                    <?php $urlStr = $urlStr; ?>
                            <?php endif;?>
                              <a href="<?php echo $urlStr;?>" <?php echo $blank;?> >
                              <i class="fa fa-twitter"></i></a>
                          </li>
                          <li>
                            <?php 
                                $urlStr = ot_get_option('pp_instagram_link');
                                $parsed = parse_url($urlStr);
                                if(empty($urlStr)):
                                  $urlStr='javascript:;';
                                  $blank='';
                                  elseif (empty($parsed['scheme'])) : 
                                      $urlStr = 'https://' . ltrim($urlStr, '/'); 
                                      $blank='target="_blank"';
                                    else : ?>
                                    <?php $urlStr = $urlStr; ?>
                            <?php endif;?>
                              <a href="<?php echo $urlStr;?>" <?php echo $blank;?> >
                              <i class="fa fa-instagram"></i></a>
                          </li>
                          <li>
                            <?php 
                                $urlStr = ot_get_option('pp_linkedin_link');
                                $parsed = parse_url($urlStr);
                                if(empty($urlStr)):
                                  $urlStr='javascript:;';
                                  $blank='';
                                  elseif (empty($parsed['scheme'])) : 
                                      $urlStr = 'https://' . ltrim($urlStr, '/'); 
                                      $blank='target="_blank"';
                                    else : ?>
                                    <?php $urlStr = $urlStr; ?>
                            <?php endif;?>
                              <a href="<?php echo $urlStr;?>" <?php echo $blank;?> >
                              <i class="fa fa-linkedin"></i></a>
                          </li>
                          <li>
                            <?php 
                                $urlStr = ot_get_option('pp_youtube_link');
                                $parsed = parse_url($urlStr);
                                if(empty($urlStr)):
                                  $urlStr='javascript:;';
                                  $blank='';
                                  elseif (empty($parsed['scheme'])) : 
                                      $urlStr = 'https://' . ltrim($urlStr, '/'); 
                                      $blank='target="_blank"';
                                    else : ?>
                                    <?php $urlStr = $urlStr; ?>
                            <?php endif;?>
                              <a href="<?php echo $urlStr;?>" <?php echo $blank;?> >
                              <i class="fa fa-youtube"></i></a>
                          </li>
                        </ul>
                           
                       </div>
                   </div>
               </div>
           </div>
           <div class="secondary-footer">
               <div class="container">
                   <div class="row">
                       <div class="col-md-6 text-left">
                           <p>
                            <?php if(ot_get_option('pp_copyrights') != ''): 
                            echo ot_get_option('pp_copyrights'); else: 
                            echo '&copy;Advance Therapeutics. All Rights Reserved'; endif;?>
                           </p>
                          <p>
                          </div>
                          <div class="col-md-6 text-right">
                           <a href="http://3hammers.com" target="_blank">
              Digital Agency &nbsp;
              <img src="<?php echo get_template_directory_uri(). '/assets/images/3hammers_footer.png'; ?>" width="30">
            </a></p>
                       </div>
                   </div>
               </div>
           </div>
        </footer>

    </div>


<?php wp_footer(); ?>
   <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/jasny-bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.flexslider.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/scripts.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/moment.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/combodate.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.validate.min.js"></script>
    <!-- <script type="text/javascript" src="<?php //echo get_template_directory_uri();?>/assets/js/formwizard/jquery-1.4.2.min.js"></script> 
    <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/assets/js/formwizard/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/assets/js/formwizard/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/assets/js/formwizard/bbq.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/assets/js/formwizard/jquery-ui-1.8.5.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/assets/js/formwizard/jquery.form.wizard.js"></script> -->
    <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.auto-complete.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/jquery.steps.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/datatables/jquery.dataTables.min.js"></script>
    

    <script src="<?php echo get_template_directory_uri();?>/assets/js/function.js"></script>
     <?php if( is_user_logged_in() ): ?>
      <script type="text/javascript">
      $(document).ready(function(){
        $('.navmenu #menu-item-45').hide();
      })
      </script>
     <?php endif;    ?>


</body>
</html>