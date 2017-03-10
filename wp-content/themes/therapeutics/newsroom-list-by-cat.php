<?php
/*
Template Name: List by categories
*/

get_header(); 

$catname = $_GET['cat'];
?>

<section class="inner-wrapper">
			<div class="inner-content">
	    		  <div class="news-list-page">
	<div class="container">
	                        <?php 

$categories = get_categories( array( 'post_type' => 'news', 'taxonomy' => 'news_category', 'hide_empty' => 0 ));

if( $categories ):

foreach( $categories as $key => $cat ): ?>

<?php if($cat->slug == $catname ) : 

 $news = query_posts( array(
							'post_type' => __('news','therapeutics'),
							'tax_query' => array(
									array(
											'taxonomy' => __('news_category','therapeutics'),
											'field' => 'id',
											'terms' => $cat->term_id,
									)
							),
							'posts_per_page' => -1,
							'orderby' => 'title',
							'order' => 'ASC'
						));
$count = count($news); 
 if( have_posts() ): 

 	while( have_posts() ) : the_post();
?>
<div class="news-list">
	                        	<header class="post-entry-header clearfix">
					<div class="row">
						<div class="col-md-8 col-sm-8">
							<div class="share">
								<div class="post-meta">
                                        <ul class="list-unstyled list-inline">
                                        <li class="dropdown">
								          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-share-alt"></i>
										Share</a>
								          <ul class="dropdown-menu">
								            	<li>
                                                 <a id="backforunical19" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink( get_the_ID() );?>&title=<?php the_title();?>" onclick="javascript:void window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink( get_the_ID() ); ?>&title=<?php the_title();?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -0px -120px ">
								            		<i class="fa fa-facebook"></i>facebook</a></li>
												<li>
													<a id="backforunical19" href="https://twitter.com/share?status=<?php echo get_the_permalink( get_the_ID() ); ?>&amp;text=<?php the_title(); ?>" onclick="javascript:void window.open('https://twitter.com/share?status=<?php echo get_the_permalink( get_the_ID() ); ?>&amp;text=<?php echo $new->post_title; ?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -20px -80px "><i class="fa fa-twitter"></i>twitter</a></li>
											<li><a id="backforunical19" href="https://www.linkedin.com/shareArticle?title=<?php the_title(); ?>&amp;mini=true&amp;url=<?php echo get_the_permalink( get_the_ID() ); ?>" onclick="javascript:void window.open('https://www.linkedin.com/shareArticle?title=<?php the_title(); ?>&amp;mini=true&amp;url=<?php echo get_the_permalink( get_the_ID() ); ?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -80px -80px "><i class="fa fa-linkedin"></i>linkedin</a></li>
								          </ul>
								        </li>
                                            <li><i class="fa fa-user"></i><em>Posted by</em><span>
                                                <?php the_author();?></span></li>
                                        </ul>
                                    </div>
                            </div>
						</div>
						<div class="col-md-4 col-sm-4">
							<span class="view-post">
								<a href="<?php echo get_the_permalink( get_the_ID() ); ?>">
									View post
									<i class="fa fa-long-arrow-right"></i>
								</a>
							</span>
							
						</div>
					</div>
				</header>
	                        		
								<div class="row">
									<div class="col-md-4 col-sm-4">
										<h1>
											<a href="<?php echo get_the_permalink( get_the_ID() ); ?>" class=""><?php echo wp_trim_words( the_title(), '7', '...' );?></a>
										</h1>
										<span><?php echo $date = get_the_date( 'F j, Y', get_the_ID() ); ?></span>
									</div>
									<div class="col-md-8 col-sm-8">
										<?php $news_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() )); ?>
										<div class="list-content">
										<p>
											<?php echo wp_trim_words( the_content(), '100', '...' );?>
										</p>
										<div class="post-image bg-image" style="background-image:
		                                url('<?php echo $news_image_url;?>');">                                    
		                                </div>
		                            	</div>
									</div>
									
								</div>
										
							</div> 

<?php endwhile;
?>
<?php if( $count > 2) : ?>  	            
<p class="text-center"><a href="javascript:;" class="loadmorebtn btn btn-primary">load more</a></p>
<?php endif; ?>
<?php 

 endif; ?>

	<?php endif; ?>

<?php 	endforeach;
endif;
?>
	                                          
 
	</div>
</div>
</div>
        </section>
	
<?php get_footer(); ?>