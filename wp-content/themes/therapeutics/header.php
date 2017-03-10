<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="<?php if(isset($description)){ echo $description;} ?>">
    <meta name="author" content="">

    <?php $favicon = ot_get_option('pp_favicon_upload'); ?>
    <?php if(!empty($favicon)){ ?>
    <link rel="icon" href="<?php echo $favicon ;?>" type="image/x-icon">
    <?php } else{ ?>
    <link rel="icon" href="../../favicon.ico">
    <?php } ?>
    
    <title>
      <?php
        /*
        Print the <title> tag based on what is being viewed.
        */
        global $page, $paged;
        // Add the blog name.
        bloginfo( 'name' );
        wp_title( '|', false, 'left' );
        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ){
        echo " | $site_description";
      }
        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 ){
        echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );
      }
      ?>
    </title>

    <!-- fonts -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet"> -->
    <!-- Bootstrap core CSS -->
    <link href="<?php echo get_template_directory_uri();?>/assets/css/bootstrap.css" rel="stylesheet">
    <!-- main style -->
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/jquery.auto-complete.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/datatables/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/flexslider.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/navmenu-reveal.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/custom.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/assets/css/responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php wp_head();?>
<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
    function readURL(input) {
        if (input.files && input.files[0]) {
          $('#blah').html(input.files[0]['name'])
        }
    }
    function readeditURL(input) {
        if (input.files && input.files[0]) {
          $('.filename-list').html(input.files[0]['name'])
          $('a.blah').hide()
        }
    }
    function readedit(input,classname) {
        if (input.files && input.files[0]) {
          $('.'+classname).html(input.files[0]['name'])
          $('a.blah').hide()
        }    }
</script>

</head>

<body <?php body_class( $post->post_name ); ?> >
    <div class="navmenu navmenu-default navmenu-fixed-right">
        	<?php wp_nav_menu( array( 
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '<ul class="menu list-unstyled">%3$s</ul>',
                'link_after' => '<i class=""></i>' 
                ) ); ?>
      
          <?php wp_nav_menu( array( 
                    'theme_location' => 'secondary',
                    'container' => false,
                    'items_wrap' => '<ul class="menu list-unstyled">%3$s</ul>',                    
                     ) ); ?>

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

    <div class="canvas">
            <?php $class = "";
            if ( is_user_logged_in() ) {
                $class = "auth-space";
            } ?>
        <div class="navbar navbar-default navbar-fixed-top <?php echo $class; ?> ">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo site_url();?>">
                	<?php if(!empty(ot_get_option('pp_logo_upload'))): ?>
                		<img src="<?php echo ot_get_option('pp_logo_upload');?>" alt="Advance Therapeutics">
                	<?php else: ?>                	
                  		<img src="<?php echo get_template_directory_uri();?>/assets/images/logo.png" alt="Advance Therapeutics">
           			<?php endif; ?>
            	</a>

          <?php if ( is_user_logged_in() ): ?>
              <div class="auth">
                  <div class="auth-img">
                    <i class="fa fa-user-o"></i>
                  </div>
                  <ul class="list-unstyled">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <?php $current_user = wp_get_current_user(); ?>
                          <?php $title = get_user_meta( $current_user->ID, 'title', false ); ?>
                          <?php echo $title[0]; ?> 
                          <?php echo $current_user->user_firstname." ".$current_user->user_lastname; ?>
                          <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu navmenu-nav">
                          <?php if(!current_user_can('administrator')): ?>
                            <li><a href="<?php echo site_url();?>/my-profile/"><i class="fa fa-cog"></i>Manage Account</a></li>
                          <?php endif; ?>
                            <li><a href="<?php echo site_url();?>/dashboard/"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
                            <li><a href="<?php echo wp_logout_url(site_url());?>"><i class="fa fa-sign-out"></i>log out</a></li>
                        </ul>
                    </li>
                  </ul>              
              </div> 
          <?php endif; ?>

                <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </div>




<?php $breadbrumb = get_post_meta($post->ID, 'meta-box-dropdown', true);?>
<?php if($breadbrumb != 'Disable'): ?> 
<?php if(! is_front_page() ): ?>
  <?php if( have_posts() ):
  while( have_posts() ) : the_post(); ?>
        <?php $headerimg = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() )); ?>
        <?php if( !empty( $headerimg ) ) : ?>
        <section class="inner-banner bg-image bg-overlay" style="background-image:url('<?php echo $headerimg;?>')">
        <?php else: ?>
        <section class="inner-banner bg-image bg-overlay" style="background-image:url('<?php echo get_template_directory_uri();?>/assets/images/banner2.png')">
      <?php endif; ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner-header">
                            <?php echo show_breadcrumb(); ?>                                                    
                        </div>                        
                    </div>
                </div>
            </div>            
        </section>
<?php endwhile; endif; ?>
<?php endif; endif; ?>