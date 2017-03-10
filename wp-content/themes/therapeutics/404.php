<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">

				<div class="page-content">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<!-- <header class="page-header">
									<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentyfifteen' ); ?></h1>
								</header> --><!-- .page-header -->
								<!-- <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentyfifteen' ); ?></p>
								<?php get_search_form(); ?> -->
								
								<div class="page404">
									<img src="<?php echo get_template_directory_uri()."/assets/images/404-img.png" ?>" alt="">
									<div class="content404">
									<h1 class="error-title">404</h1>
									<h2>Look's like you're lost</h2>
									<p>
										the page you are looking for not availible !!
									</p>
										<a href="#" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>Back To Home</a>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
