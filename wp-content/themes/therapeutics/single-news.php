<?php

get_header(); 

?>
    <?php if(have_posts()) :

while(have_posts()): the_post(); 
?>
    <section class="inner-wrapper">
        <div class="inner-content">
            <div class="container">
                <div class="news-list">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <header class="post-entry-header clearfix">
                                <div class="share">
                                    <div class="post-meta">
                                        <ul class="list-unstyled list-inline">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-share-alt"></i>
                                        Share</a>
                                                  <ul class="dropdown-menu">
                                                <li>
                                                    <a id="backforunical19" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink($new->ID);?>" onclick="javascript:void window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink($new->ID); ?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -0px -120px ">
                                                    <i class="fa fa-facebook"></i>facebook</a></li>
                                                <li>
                                                    <a id="backforunical19" href="https://twitter.com/share?status=<?php echo get_the_permalink($new->ID); ?>&amp;text=<?php echo $new->post_title; ?>" onclick="javascript:void window.open('https://twitter.com/share?status=<?php echo get_the_permalink($new->ID); ?>&amp;text=<?php echo $new->post_title; ?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -20px -80px "><i class="fa fa-twitter"></i>twitter</a></li>
                                            <li><a id="backforunical19" href="https://www.linkedin.com/shareArticle?title=<?php echo $new->post_title; ?>&amp;mini=true&amp;url=<?php echo get_the_permalink($new->ID); ?>" onclick="javascript:void window.open('https://www.linkedin.com/shareArticle?title=<?php echo $new->post_title; ?>&amp;mini=true&amp;url=<?php echo get_the_permalink($new->ID); ?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -80px -80px "><i class="fa fa-linkedin"></i>linkedin</a></li>
                                          </ul>
                                            </li>
                                            <li><i class="fa fa-user"></i><em>Posted by</em><span>
                                                <?php the_author();?></span></li>
                                            <?php $cats = get_the_terms( $new->ID, 'news_category' );  ?>
                                            <li><i class="fa fa-tag"></i>
                                                <a href="#"><?php echo $cats[0]->name; ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                    </header>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="featured-image">
                            <?php $news_image_url1 = wp_get_attachment_url(get_post_thumbnail_id( get_the_ID()));?>
                            <div class="post-image bg-image" style="background-image:
                                url('<?php echo $news_image_url1;?>');">
                            </div>
                        </div>
                        <div class="content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endwhile; 
endif;
?>
    <?php get_footer(); ?>
