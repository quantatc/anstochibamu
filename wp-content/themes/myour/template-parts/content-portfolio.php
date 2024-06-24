<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package myour
 */

?>

<?php

/* post content */
$current_categories = get_the_terms( get_the_ID(), 'portfolio_categories' );
$categories_string = '';
$categories_slugs_string = '';
if ( $current_categories && ! is_wp_error( $current_categories ) ) {
	$arr_keys = array_keys( $current_categories );
	$last_key = end( $arr_keys );
	foreach ( $current_categories as $key => $value ) {
		if ( $key == $last_key ) {
			$categories_string .= $value->name . ' ';
		} else {
			$categories_string .= $value->name . ', ';
		}
		$categories_slugs_string .= 'category-' . $value->slug . ' ';
	}
}

$image = get_the_post_thumbnail_url( get_the_ID(), 'myour_800x800' );
$title = get_the_title();
$info = get_field( 'short_description' );
$href = get_the_permalink();

?>

<!-- Project Item -->
<figure class="content-grid__item onHover js-scroll-show <?php echo esc_attr( $categories_slugs_string ); ?>">
    <a class="content-grid__link" href="<?php echo esc_url( $href ); ?>">
        <?php if ( $image ) : ?>
        <picture class="content-grid__image-wrap image-wrap-fit js-zooming">
            <img class="cover content-grid__image lazyload" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
	    </picture>
	    <?php endif; ?>
	    <div class="content-grid__caption">
		    <?php if ( $title ) : ?>
		    <h2 class="title title--h5"><?php echo esc_html( $title ); ?></h2>
		    <?php endif; ?>
		    <?php if ( $info ) : ?>
		    <p class="content-grid__description"><?php echo esc_html( $info ); ?></p>
			<?php endif; ?>
	    </div>
    </a>
</figure>
<!-- /Project Item -->