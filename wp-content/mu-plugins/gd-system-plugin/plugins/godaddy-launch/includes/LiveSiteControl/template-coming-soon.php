<?php
/**
 * Page template for a restricted site.
 *
 * @package GoDaddy
 */

?>
<!doctype html>
<html>

<head <?php get_language_attributes(); ?>>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
	<style>
		body {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			padding: 20px;
			margin: 0;
			height: calc( 100vh - 40px );
			background:
				linear-gradient(
					101.44deg,
					rgba(252, 204, 203, 0.2) 16.81%,
					rgba(239, 230, 212, 0.2) 53.67%,
					rgba(211, 220, 243, 0.2) 67.17%,
					rgba(217, 245, 253, 0.2) 76.66%,
					rgba(255, 255, 255, 0.2) 86.88%
				),
				linear-gradient(0deg, #FFFFFF, #FFFFFF);
		}

		h1, p {
			max-width: 820px;
			margin: 0;
		}

		h1 {
			font-family: Baskerville, Georgia, Cambria, "Times New Roman", Times, serif;
			font-weight: normal;
			font-size: clamp( 36px, 10.5vw, 96px );
			line-height: 1.15em;
			text-align: center;
			color: #000000;
		}

		p {
			font-family: Avenir, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
			font-weight: 500;
			font-size: clamp( 16px, 4.4vw, 36px );
			line-height: 1.5em;
			text-align: center;
			color: #2B2B2B;
			margin-top: 2em;
		}
	</style>
</head>

<body>
	<h1><?php _e( 'Great things are coming soon<', 'godaddy-launch' ); ?>/h1>
	<p><?php _e( 'Stay tuned', 'godaddy-launch' ); ?></p>
</body>

</html>
