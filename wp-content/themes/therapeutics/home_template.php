<?php 
/*
Template Name: Home 
*/
get_header();
?>

<section class="banner-wrapper">
        <div class="flexslider">
              <ul class="slides">
                <?php $attachments = new Attachments( 'attachments', get_the_ID());/* pass the instance name */ ?>
                <?php if($attachments->exist()): 
                  $k = 1;
                  while($attachments->get()): ?>
                  <li 
                    class="bg-image slider-item bg-overlay <?php if($k == 1): echo 'active'; endif; ?>" 
                    style="background-image:url('<?php echo $attachments->url(); ?>');">
                
                      <div class="flex-caption">
                        <?php echo $attachments->field( 'caption' ); ?>

                        <?php 
                          $urlStr = ot_get_option('readmore_slider');
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
                          <a href="<?php echo $urlStr;?>" <?php echo $blank;?> class="btn btn-primary">Read More</a>
                      </div>
                  </li>    
                <?php $k++; endwhile; endif; ?>
              </ul>
        </div>
        <a href="javascript:;" id="down-scroll"><div class="mouse-icon"><div class="wheel"></div></div></a>
</section>

<section>
	<div id="scroll-pos" class="section-title">
        <div class="container">
            <div class="row">
               
                    <div class="col-md-5 col-sm-5">
                       <?php  
                       if( !empty( ot_get_option( 'title_first' ) ) ): ?>
                        <h1><?php 
                        echo ot_get_option('title_first');
                        ?>
                        </h1>
                        <?php else:
                       ?>
                        <h1>
                        	Compounding Pharmacy
                        </h1>
                    <?php endif; ?>
                    </div>
                    <div class="col-md-7 col-sm-7">
                            <?php if(!empty(ot_get_option('content_first'))): ?>
                            <?php echo ot_get_option('content_first'); ?>
                        <?php else: ?>
                        <p>
                        At one time nearly all prescriptions were compounded. With the advent of mass drug manufacturing in the 1950s and ‘60s, compounding rapidly declined. The pharmacist’s role as a preparer of medications quickly changed to that of a dispenser of manufactured dosage forms, and most.....
                        </p>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>
                <?php $services= get_posts(array(
                    'post_type'=> 'services',
                    'posts_per_page' => 4,
                    'order'=> 'ASC') ); ?>

        <div class="full-width">
            <div class="container-fluid">
                <div class="row-fluid">

                    <?php if($services):
                    foreach( $services as $key => $service ): ?>
                        <?php if( $key==0 ): ?>
                        <div class="col-md-8 col-sm-12">
                            <div class="row-fluid">
                        <?php endif;?>
                            <?php if( $key==0 || $key==1 ): ?>
                                <div class="col-md-6 col-sm-6">
                                    <div class="box-img">
                                        <a href="<?php echo get_the_permalink( $service->ID );?>" class="">
                                            <div class="img-wrap bg-image" style="background-image:
                                            url(<?php echo wp_get_attachment_url(get_post_thumbnail_id( $service->ID ));?>);">
                                            </div>
                                        </a>
                                        <div class="caption">
                                            <h4><?php echo $service->post_title;?></h4>
                                            <?php echo $service->post_excerpt; ?>
                                            <div class="btn-grp">
                                                <a href="#" class="btn btn-primary">For Professionals</a>
                                                <a href="#" class="btn btn-primary">For Patients</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php if($key == 1): ?>
                        </div>
                        <?php endif;?>
                        <?php if($key == 2): ?>
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <div class="box-img">
                                        <a href="<?php echo get_the_permalink( $service->ID );?>" class="">
                                            <div class="img-wrap bg-image" style="background-image:
                                            url(<?php echo wp_get_attachment_url(get_post_thumbnail_id( $service->ID ));?>);">
                                            </div>
                                        </a>
                                        <div class="caption">
                                            <h4><?php echo $service->post_title;?></h4>
                                            <?php echo $service->post_excerpt; ?>
                                            <div class="btn-grp">
                                                <a href="#" class="btn btn-primary">For Professionals</a>
                                                <a href="#" class="btn btn-primary">For Patients</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                       <?php if($key == 2): ?>
                     </div>
                       <?php endif;?>
                      <?php if ($key == 3): ?>
                        <div class="col-md-4 col-sm-12">
                            <div class="box-img lg">
                                <a href="<?php echo get_the_permalink( $service->ID );?>" class="">
                                    <div class="img-wrap bg-image" style="background-image:
                                    url(<?php echo wp_get_attachment_url(get_post_thumbnail_id( $service->ID ));?>);">
                                    </div>
                                </a>
                                <div class="caption">
                                    <h4><?php echo $service->post_title;?> </h4>
                                    <?php echo $service->post_excerpt; ?>
                                    <div class="btn-grp">
                                        <a href="#" class="btn btn-primary">For Professionals</a>
                                        <a href="#" class="btn btn-primary">For Patients</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; endif;?>
                </div>
            </div>
        </div>
</section>


<section>
    <div class="section-title">
        <div class="container">
            <div class="row">
                
                    <div class="col-md-5 col-sm-5">
                        <h1>
                        <?php if( !empty( ot_get_option( 'title_second' ) ) ): ?>
                        <?php echo ot_get_option( 'title_second' ); ?>
                        <?php else: ?>
                            Recent From Newsroom
                        <?php endif; ?>

                        </h1>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <?php if(!empty(ot_get_option('content_second'))): ?>
                            <?php echo ot_get_option('content_second'); ?>
                        <?php else: ?>
                        <p>
                           Experience the advantage of excellent service, solutions, partnership, integrity and innovation with leading multi-specialty health care company Advanced Therapeutics.
                           Experience the advantage of excellent service, solutions, partnership, integrity and innovation with leading multi-specialty health care company Advanced Therapeutics.
                        </p>
                        <?php endif; ?>
                        <div class="viewmore-btn">
                         <a href="<?php echo site_url('/newsroom/');?>" class="">
                                    Discover All News
                         </a>
                     </div>
                    </div> 
                    <!--  <div class="row">
                        <div class="container">
                            <div class="col-md-12 text-center">
                               
                            </div>
                        </div>
                    </div> -->
                
            </div>
        </div>
    </div>

    <div class="post-wrapper">
                <div class="container">
                    <div class="post-block">
                        <?php $k = 1; ?>
                        <?php $news = query_posts(array(
                            'post_type' => 'news',
                            'posts_per_page' => 2,
                            'order' => 'ASC' ) ); ?>
                            <?php if( have_posts() ) :            
                            while( have_posts() ) : the_post(); 
                            if ($k % 2 == 1): ?> 
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                            <?php $news_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() )); ?>
                            <a href= "<?php echo get_the_permalink( get_the_ID() );?>" >
                                <div class="post-image bg-image" style="background-image:
                                url('<?php echo $news_image_url;?>');">                                    
                                </div>
                            </a>
                            </div>
                            <div class="col-md-7 col-sm-7">
                                <div class="entry-content p20left">
                                    <div class="post-meta">
                                        <ul class="list-unstyled list-inline">
                                            <li><i class="fa fa-user"></i><em>Posted by</em><a href="#">
                                                <?php the_author();?></a></li>
                                            <?php $cats = get_the_terms( get_the_ID(), 'news_category' );  ?>
                                            <li><i class="fa fa-tag"></i>
                                                
                                                <a href="<?php echo site_url().'/list-by-cat?cat='.$cats[0]->slug; ?>"><?php echo $cats[0]->name; ?></a></li>
                                        
                                        </ul>
                                    </div>
                                    <div class="post-head">
                                        <h1 class="post-title"><a href="<?php echo get_the_permalink( get_the_ID() ); ?>" class=""><?php the_title();?></a></h1>
                                    </div>
                                    <div class="post-content">
                                        <p>
                                            <?php echo wp_trim_words( the_content(), '100', '...' );?>
                                        </p>
                                    </div>
                                    <a href="<?php echo get_the_permalink( get_the_ID() ); ?>" class="">Read More</a>
                                </div>
                            </div>
                        </div>                       
                        
                            <?php else: ?>
                        <div class="row even">                            
                            <div class="col-md-7 col-sm-7">
                                <div class="entry-content p20right">
                                    <div class="post-meta">
                                        <ul class="list-unstyled list-inline">
                                            <li><i class="fa fa-user"></i><em>Posted by</em><a href="#">
                                                <?php the_author();?></a></li>
                                            <?php $cats = get_the_terms( get_the_ID(), 'news_category' );  ?>
                                            <li><i class="fa fa-tag"></i>
                                                
                                                <a href="<?php echo site_url().'/list-by-cat?cat='.$cats[0]->slug; ?>"><?php echo $cats[0]->name; ?></a></li>
                                        
                                        </ul>
                                    </div>
                                    <div class="post-head">
                                        <h1 class="post-title"><a href="<?php echo get_the_permalink( get_the_ID() ); ?>" class=""><?php the_title();?></a></h1>
                                    </div>
                                    <div class="post-content">
                                        <p>
                                            <?php echo wp_trim_words( the_content(), '100', '...' );?>
                                        </p>
                                    </div>
                                    <a href="<?php echo get_the_permalink( get_the_ID() ); ?>" class="">Read More</a>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5">
                                <?php $news_image_url1 = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );?>
                               <a href="<?php echo get_the_permalink( get_the_ID() ); ?>" class=""> <div class="post-image bg-image" style="background-image:
                                url('<?php echo $news_image_url1;?>');">
                                </div></a>
                            </div>
                        </div>                    
                        <?php  endif; $k++; endwhile; endif; ?>                  
                    </div>
                   
                </div>
            </div>
        </section>




<?php get_footer(); ?>