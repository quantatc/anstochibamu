<?php
/**
 * Skin
**/
if ( function_exists( 'get_field' ) ) {
	/**
	 * Dark Version
	 */

	$theme_ui = get_field( 'theme_ui', 'option' );

	if ( $theme_ui ) {
		function myour_light_stylesheets() {
			wp_enqueue_style( 'myour-light', get_template_directory_uri() . '/assets/css/light.css', '1.0' );
		}
		add_action( 'wp_enqueue_scripts', 'myour_light_stylesheets', 10 );

	}
}

function myour_skin() {
	$theme_ui = get_field( 'theme_ui', 'option' );
	$bg_color = get_field( 'theme_bg_color', 'options' );
	$theme_color = get_field( 'theme_color', 'options' );
	$heading_color = get_field( 'heading_color', 'options' );
	$text_color = get_field( 'text_color', 'options' );
	$menu_font_color = get_field( 'menu_font_color', 'options' );
	
	$heading_font_family = get_field( 'heading_font_family', 'options' );
	$text_font_family = get_field( 'text_font_family', 'options' );
	$menu_font_family = get_field( 'menu_font_family', 'options' );

	$heading_font_size = get_field( 'heading_font_size', 'options' );
	$text_font_size = get_field( 'text_font_size', 'options' );
	$menu_font_size = get_field( 'menu_font_size', 'options' );
	
	if ( $theme_ui ) {
		$bg_color = get_field( 'theme_bg_light_color', 'options' );
		$heading_color = get_field( 'heading_light_color', 'options' );
		$text_color = get_field( 'text_light_color', 'options' );
		$menu_font_color = get_field( 'menu_font_light_color', 'options' );
	}
?>

<style>
	
	<?php if ( $bg_color ) : ?>
	/* BG Color */
	body, .section.started .h-title, .wrapper:before, .content-carousel .navs .prev, .content-carousel .navs .next, .skills.circles .progress, .skills.circles .progress:after, .contact-form .group-val .label, .footer .socials a {
		background-color: <?php echo esc_attr( $bg_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $heading_color ) : ?>
	/* Heading Color */
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.section .titles .title,
	.section.started .h-title,
	.content-sidebar .widget-title,
	.title.comment-reply-title, 
	.post-comments .title,
	.resume-item .name,
	.skills .name,
	.service-item .name,
	.box-items .box-item .desc .name,
	.contact-info .name,
	.pricing-item .name,
	.reviews-item .name,
	.blog-items .blog-item .desc .name {
		color: <?php echo esc_attr( $heading_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $heading_font_family ) : ?>
	/* Heading Font Family */
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.section .titles .title,
	.section.started .h-title,
	.content-sidebar .widget-title,
	.title.comment-reply-title, 
	.post-comments .title,
	.resume-item .name,
	.skills .name,
	.service-item .name,
	.box-items .box-item .desc .name,
	.contact-info .name,
	.pricing-item .name,
	.reviews-item .name,
	.blog-items .blog-item .desc .name {
		font-family: '<?php echo esc_attr( $heading_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>

	<?php if ( $heading_font_size ) : ?>
	/* Heading Font Size */
	.section .titles .title {
		font-size: <?php echo esc_attr( $heading_font_size ); ?>px;
	}
	<?php endif; ?>

	<?php if ( $text_color ) : ?>
	/* Text Color */
	body,
	a,
	.section.started .started-content .h-text,
	p,
	.post-latest-col {
		color: <?php echo esc_attr( $text_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $text_font_family ) : ?>
	/* Text Font Family */
	body,
	a,
	.section.started .started-content .h-text,
	p {
		font-family: '<?php echo esc_attr( $text_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>

	<?php if ( $text_font_size ) : ?>
	/* Text Font Size */
	body,
	.section.started .started-content .h-text,
	p {
		font-size: <?php echo esc_attr( $text_font_size ); ?>px;
	}
	<?php endif; ?>

	<?php if ( $menu_font_color ) : ?>
	/* Menu Color */
	.header .top-menu ul li a,
	.header .top-menu-nav .sub-menu li a,
	.header .top-menu-nav .children li a {
		color: <?php echo esc_attr( $menu_font_color ); ?>;
	}
	<?php endif; ?>

	<?php if ( $menu_font_family ) : ?>
	/* Menu Font Family */
	.header .top-menu ul li a,
	.header .top-menu-nav .sub-menu li a,
	.header .top-menu-nav .children li a {
		font-family: '<?php echo esc_attr( $menu_font_family['font_name'] ); ?>';
	}
	<?php endif; ?>

	<?php if ( $menu_font_size ) : ?>
	/* Menu Font Size */
	.header .top-menu ul li a {
		font-size: <?php echo esc_attr( $menu_font_size ); ?>px;
	}
	<?php endif; ?>

	<?php if ( $theme_color ) : ?>
	/* Theme Color */
	.preloader .box-1,
	.preloader .spinner .lines:after,
	.wp-block-button__link,
	a.wp-block-button__link,
	.is-style-outline .wp-block-button__link:hover,
	.content-sidebar td#today,
	.single-post-text table td#today,
	.background-filter,
	.skills .progress .percentage,
	.skills.dotted .progress .da span,
	.box-items .box-item .image .info .centrize,
	.pricing-item .feature-list ul li strong,
	.single-post-text ul>li:before,
	.comment-text ul>li:before,
	.sticky:before {
		background-color: <?php echo esc_attr( $theme_color ); ?>;
	}
	a:hover,
	a.btn:hover .icon,
	.btn:hover .icon,
	.single-post-text input[type="submit"]:hover .icon,
	button:hover .icon,
	.is-style-outline .wp-block-button__link,
	code,
	.header .top-menu ul li.current-menu-item > a,
	.header .top-menu-nav .sub-menu li a:hover,
	.header .top-menu-nav .children li a:hover,
	.header .top-menu-nav .sub-menu li.active a,
	.header .top-menu-nav .children li.active a,
	.section .titles .subtitle,
	.section.started .h-title strong,
	.section.started .started-content .h-subtitle,
	.section.started .started-content .typed-subtitle,
	.section.started .started-content .typed-cursor,
	.info-list ul li strong,
	.resume-item .date,
	.resume-item .icon,
	.skills .progress .percentage .percent,
	.skills.list .name:before,
	.skills.circles .progress span,
	.service-item .icon,
	.section.works .filters label.glitch-effect,
	.box-items .box-item:hover .desc .name,
	.box-items .box-item .desc .category,
	.contact-form .group-val .label strong,
	.contact-info .subname,
	.pricing-item .icons,
	.reviews-item .company,
	.reviews-item .text:before,
	.footer .socials a:hover,
	.blog-items .blog-item .desc .name:hover,
	.started-content .date,
	.single-post-text p a,
	.comment-text p a,
	.post-text-bottom span.cat-links a,
	.post-text-bottom .tags-links a,
	.post-text-bottom .tags-links span,
	.content-sidebar .tagcloud a,
	.error-page__num,
	.popup-box .category,
	.header .download-cv-btn {
		color: <?php echo esc_attr( $theme_color ); ?>;
	}
	a.btn:hover,
	.btn:hover,
	.single-post-text input[type="submit"]:hover,
	button:hover,
	.is-style-outline .wp-block-button__link,
	.skills.circles .progress .bar,
	.skills.circles .progress.p51 .fill,
	.skills.circles .progress.p52 .fill,
	.skills.circles .progress.p53 .fill,
	.skills.circles .progress.p54 .fill,
	.skills.circles .progress.p55 .fill,
	.skills.circles .progress.p56 .fill,
	.skills.circles .progress.p57 .fill,
	.skills.circles .progress.p58 .fill,
	.skills.circles .progress.p59 .fill,
	.skills.circles .progress.p60 .fill,
	.skills.circles .progress.p61 .fill,
	.skills.circles .progress.p62 .fill,
	.skills.circles .progress.p63 .fill,
	.skills.circles .progress.p64 .fill,
	.skills.circles .progress.p65 .fill,
	.skills.circles .progress.p66 .fill,
	.skills.circles .progress.p67 .fill,
	.skills.circles .progress.p68 .fill,
	.skills.circles .progress.p69 .fill,
	.skills.circles .progress.p70 .fill,
	.skills.circles .progress.p71 .fill,
	.skills.circles .progress.p72 .fill,
	.skills.circles .progress.p73 .fill,
	.skills.circles .progress.p74 .fill,
	.skills.circles .progress.p75 .fill,
	.skills.circles .progress.p76 .fill,
	.skills.circles .progress.p77 .fill,
	.skills.circles .progress.p78 .fill,
	.skills.circles .progress.p79 .fill,
	.skills.circles .progress.p80 .fill,
	.skills.circles .progress.p81 .fill,
	.skills.circles .progress.p82 .fill,
	.skills.circles .progress.p83 .fill,
	.skills.circles .progress.p84 .fill,
	.skills.circles .progress.p85 .fill,
	.skills.circles .progress.p86 .fill,
	.skills.circles .progress.p87 .fill,
	.skills.circles .progress.p88 .fill,
	.skills.circles .progress.p89 .fill,
	.skills.circles .progress.p90 .fill,
	.skills.circles .progress.p91 .fill,
	.skills.circles .progress.p92 .fill,
	.skills.circles .progress.p93 .fill,
	.skills.circles .progress.p94 .fill,
	.skills.circles .progress.p95 .fill,
	.skills.circles .progress.p96 .fill,
	.skills.circles .progress.p97 .fill,
	.skills.circles .progress.p98 .fill,
	.skills.circles .progress.p99 .fill,
	.skills.circles .progress.p100 .fill,
	blockquote,
	.started-content .date,
	blockquote,
	.post-text-bottom .tags-links a,
	.post-text-bottom .tags-links span,
	.content-sidebar .tagcloud a,
	.header .download-cv-btn {
		border-color: <?php echo esc_attr( $theme_color ); ?>;
	}
	.animated-button span {
		text-shadow: 0 16px 0 <?php echo esc_attr( $theme_color ); ?>;
	}
	<?php endif; ?>

</style>

<?php
}
add_action( 'wp_head', 'myour_skin', 10 );