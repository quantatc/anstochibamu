<?php
/**
 * Template part for displaying single start section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package myour
 */

?>

<!-- Section Started -->
<div class="section started">
	<div class="centrize full-width">
		<div class="vertical-center">
			<div class="started-content">
				<h1 class="h-title"><?php the_title(); ?></h1>
				<?php if ( get_post_type() == 'post' ) : ?>
				<div class="h-subtitles">
					<div class="h-subtitle">
						<?php echo esc_html( get_the_date() ); ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>