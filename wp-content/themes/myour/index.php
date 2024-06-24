<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package myour
 */

get_header();
?>

	<!-- Started -->
	<div class="section started section-title">
		<div class="centrize full-width">
			<div class="vertical-center">
				<div class="started-content">
					<h1 class="h-title"><?php echo esc_html( bloginfo( 'name' ) ); ?></h1>
					<div class="h-subtitles">
						<div class="h-subtitle">
							<p><?php echo esc_html( bloginfo( 'description' ) ); ?></p>
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