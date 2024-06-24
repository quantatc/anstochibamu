<?php
/**
 * Template Name: Blog
 *
 * @package myour
*/

get_header();
?>
	<?php

	$posts_per_page = get_option( 'posts_per_page' );
	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	$posts = wp_count_posts( 'post' );
	$total_posts = $posts->publish;

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
		'post_status' => 'publish',
		'order' => 'desc'
	);
	$the_query = new WP_Query($args);

	//get blog title and subtitle
	$blog_title = get_field( 'title' );
	$blog_subtitle = get_field( 'subtitle' );
	if ( ! $blog_subtitle ) {
		$blog_subtitle = get_field( 'blog_subtitle', 'option' );
	}

	?>

	<!-- Started -->
	<div class="section started section-title">
		<div class="centrize full-width">
			<div class="vertical-center">
				<div class="started-content">
					<h1 class="h-title">
						<?php

						if ( $blog_title && $blog_title != '' ) {
							echo esc_html( $blog_title ); 
						} else { 
							single_post_title(); 
						}

						?>		
					</h1>
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
	<div class="section blog <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>with-sidebar<?php endif; ?>">
		<div class="content">
			
			<?php if ( $the_query->have_posts() ) : ?>

			<!-- blog items -->
			<div class="blog-items cols">
				<?php
				/* Start the Loop */
				while ( $the_query->have_posts() ) :
					$the_query->the_post();

					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile; wp_reset_postdata();
				?>
				<div class="pager">
					<?php
						$big = 999999999; // need an unlikely integer

						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $the_query->max_num_pages,
							'prev_text'		=> esc_html__( 'Prev', 'myour' ),
							'next_text'		=> esc_html__( 'Next', 'myour' ),
						) );
					?>
				</div>
			</div>

			<?php else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
			
			<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<?php get_sidebar(); ?>
			<?php endif; ?>

			<div class="clear"></div>
		</div>
	</div>
<?php
get_footer();