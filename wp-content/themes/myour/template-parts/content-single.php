<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package myour
 */

?>

<?php
	$blog_featured_img = get_field( 'blog_featured_img', 'option' );
	$blog_related = get_field( 'blog_related', 'option' );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="content-box">
		<div class="single-post-text">
			<?php 
				if ( has_post_thumbnail() && ! $blog_featured_img ) : 
					the_post_thumbnail( 'full', array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						)),
					) );
				endif;

				the_content(); 

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'myour' ),
					'after'  => '</div>',
				) );
			?>
		</div>
		<div class="post-text-bottom">	
			<?php myour_entry_footer(); ?>
		</div>
		<?php if ( !$blog_related ) : ?>
		<div class="post-latest">
			<div class="title post-latest-title">
				<div class="title_inner">
					<?php echo esc_html__( 'Related Posts', 'myour' ) ?>
				</div>
			</div>
			<div class="post-latest-items">
				<?php
					$orig_post = $post;
					global $post;
					$tags = wp_get_post_tags($post->ID);

					if ($tags) {
						$tag_ids = array();
						foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
						$args=array(
							'tag__in' => $tag_ids,
							'post__not_in' => array($post->ID),
							'posts_per_page'=>3
						);

						$my_query = new WP_Query( $args );

						while( $my_query->have_posts() ) { $my_query->the_post();
				?>
					<div class="post-latest-col">
						<div class="post-latest-item">
							<div class="image">
								<?php myour_post_thumbnail( 'blog' ); ?>
							</div>
							<div class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
							<div class="desc"><?php the_excerpt(__( '(more…)', 'myour' ) ); ?></div>
						</div>
					</div>
				<? }} $post = $orig_post; wp_reset_query(); ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div><!-- #post-<?php the_ID(); ?> -->