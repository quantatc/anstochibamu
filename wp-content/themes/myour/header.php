<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package myour
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Meta Data -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	
	<!-- Preloader -->
	<div class="preloader">
		<div class="box-1">
			<div class="centrize full-width">
				<div class="vertical-center">
					<div class="spinner">
						<div class="lines"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-2"></div>
	</div>
	
	<!-- Container -->
	<div class="container">
		
		<?php 

		$header_logo_img = get_field( 'header_logo_img', 'options' );
		$header_logo_txt = get_field( 'header_logo_txt', 'options' );

		$header_download_btn = get_field( 'header_download_btn', 'options' );
		$header_download_btn_txt = get_field( 'header_download_btn_txt', 'options' );
		$header_download_btn_url = get_field( 'header_download_btn_url', 'options' );
		$header_download_btn_ico = get_field( 'header_download_btn_ico', 'options' );

		$p_vcard_overwrite = get_field( 'p_vcard_overwrite' );
		
		if ( $p_vcard_overwrite ) {
			$vcard_type = get_field( 'p_vcard_type' );
			$vcard_image = get_field( 'p_vcard_image' );
			$vcard_slides = get_field( 'p_vcard_slides' );
			$vcard_video = get_field( 'p_vcard_video' );
			$header_logo_txt = get_field( 'p_header_logo_txt' );
		} else {
			$vcard_type = get_field( 'vcard_type', 'options' );
			$vcard_image = get_field( 'vcard_image', 'options' );
			$vcard_slides = get_field( 'vcard_slides', 'options' );
			$vcard_video = get_field( 'vcard_video', 'options' );
		}

		?>

		<!-- Header -->
		<header class="header">

			<!-- logo -->
			<div class="logo">
				<a href="<?php echo esc_url( home_url() ); ?>">
					<?php if ( $header_logo_img ) : ?>
					<img class="logo-img" src="<?php echo esc_url( $header_logo_img ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
					<?php endif; ?>

					<span class="logo-lnk">
						<?php
						if ( $header_logo_txt != '' ) {
							echo wp_kses_post( $header_logo_txt );
						} else {
							echo esc_html( get_bloginfo( 'name' ) );
						}
						?>
					</span>
				</a>
			</div>

			<!-- menu button -->
			<a href="#" class="menu-btn"><span></span></a>
			
			<?php if ( $header_download_btn ) : ?>
			<!-- download cv button -->
			<a href="<?php echo esc_url( $header_download_btn_url ); ?>" class="btn download-cv-btn" target="_blank" download>
				<span class="animated-button"><span><?php echo esc_html( $header_download_btn_txt ); ?></span></span>
				<i class="icon <?php echo esc_attr( $header_download_btn_ico ); ?>"></i>
			</a>
			<?php endif; ?>

			<!-- header sidebar -->
			<div class="header-sidebar">

				<!-- top menu -->						
				<div class="top-menu">
					<div class="top-menu-nav">	
						<div class="menu-topmenu-container">
							<?php

							wp_nav_menu( array(
								'theme_location' => 'primary',
								'container' => '',
								'menu_class' => 'menu',
								'walker' => new myour_TopmenuHorizontal_Walker(),
							) );

							?>
						</div>
					</div>
				</div>

			</div>

		</header>
		
		<!-- Wrapper -->
		<div class="wrapper">

			<?php 

			if ( $vcard_type == 1 ) {
				$vcard_class = 'gradient';
			} elseif ( $vcard_type == 2 ) {
				$vcard_class = 'circle';
			} elseif ( $vcard_type == 3 ) {
				$vcard_class = '';
			} elseif ( $vcard_type == 4 ) {
				$vcard_class = '';
			} elseif ( $vcard_type == 5 ) {
				$vcard_class = 'no-filter';
			} else {
				$vcard_class = false;
			}

			?>

			<?php if ( $vcard_type != 4 && is_page_template( 'template-layout-builder.php' ) ) : ?>
			<!-- Background -->
			<div class="background-bg">
				<?php if ( $vcard_type != 3 && $vcard_type != 4 ) : ?>
				<div class="background-filter<?php if ( $vcard_class ) : ?> <?php echo esc_attr( $vcard_class ); ?><?php endif; ?>">
					<div class="background-img" style="background-image: url(<?php echo esc_url( $vcard_image ); ?>);"></div>
				</div>
				<?php endif; ?>

				<?php if ( $vcard_type == 3 && $vcard_slides ) : ?>
				<div class="started-carousel">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?php $i=0; foreach ($vcard_slides as $slide) : $i++; ?>
							<div class="swiper-slide<?php if ( $i == 1 ) : ?> first<?php endif; ?>">
								<div class="background-filter">
									<div class="background-img" style="background-image: url(<?php echo esc_url( $slide['image'] ); ?>);"></div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<?php if ( $vcard_type == 4 && is_page_template( 'template-layout-builder.php' ) ) : ?>
			<!-- Background Video -->
			<div class="background-bg jarallax-video" data-jarallax-video="<?php echo esc_attr( $vcard_video ); ?>"></div>
			<?php endif; ?>

			<?php if ( ! is_page_template( 'template-layout-builder.php' ) ) : ?>
			<div class="background-bg background-bg-inner">
				<div class="background-filter"><div class="background-img"></div></div>
			</div>
			<?php endif; ?>