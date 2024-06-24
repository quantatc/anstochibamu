<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package myour
 */

?>

<?php

$social_links = get_field( 'social_links', 'options' );
$footer_text = get_field( 'footer_text', 'options' );

if ( ! $footer_text ) {
	$footer_text = esc_html__( '&copy; 2020. All rights reserved', 'myour' );
}

?>

	</div>
		
	<!-- Footer -->
	<footer class="footer">
		<div class="footer-inner">
			<?php if ( $footer_text ) : ?>
			<div class="text">
				<?php echo esc_html( $footer_text ); ?>
			</div>
			<?php endif; ?>
			<?php if ( $social_links ) : ?>
			<div class="socials">
				<?php foreach ( $social_links as $link ) : ?>
				<a target="_blank" href="<?php echo esc_url( $link['url'] ); ?>">
					<i class="icon <?php echo esc_attr( $link['icon'] ); ?>"></i>
				</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
	</footer>
	
</div>
	
<?php wp_footer(); ?>

</body>
</html>