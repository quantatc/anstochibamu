<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package myour
 */

get_header();
?>

	<?php
	
	//get blog subtitle
	$blog_subtitle = get_field( 'blog_subtitle', 'option' );
	
	?>

	<!-- Started -->
	<div class="section started section-title">
		<div class="centrize full-width">
			<div class="vertical-center">
				<div class="started-content">
					<h1 class="h-title"><?php echo esc_html( get_the_archive_title() ); ?></h1>
					<div class="h-subtitles">
						<div class="h-subtitle">
							<?php 
					
							if ( $blog_subtitle && $blog_subtitle != '' ) {
								echo esc_html( $blog_subtitle );
							} else {
								echo esc_html__( 'Latest Posts', 'myour' );
							}

							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Blog -->
	<div class="section blog">
		<div class="content">

			<?php if ( have_posts() ) : ?>

			<!-- blog items -->
			<div class="blog-items">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;
				?>
				<div class="pager">
					<?php
						echo paginate_links( array(
							'prev_text'		=> esc_html__( 'Prev', 'myour' ),
							'next_text'		=> esc_html__( 'Next', 'myour' ),
						) );
					?>
				</div>
			</div>

			<!-- sidebar -->
			<?php get_sidebar(); ?>

			<?php else : get_template_part( 'template-parts/content', 'none' ); endif; ?>

			<div class="clear"></div>
		</div>
	</div>
<?php
get_footer();