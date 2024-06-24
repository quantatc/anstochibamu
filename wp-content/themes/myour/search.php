<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
					<h1 class="h-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search: %s', 'myour' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
						?>
					</h1>
					<div class="h-subtitles">
						<div class="h-subtitle">
							<?php echo esc_html__( 'Search Results', 'myour' ); ?>
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

			<!-- box items -->
			<div class="blog-items">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );
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