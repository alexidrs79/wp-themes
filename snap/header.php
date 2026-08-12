<?php
/**
 * The header for our theme.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">
<?php wp_body_open(); ?>
<?php
/*
 * Figma node 15150:1496 ("Frame 33") — the grid backdrop behind the header
 * + hero. It's full-bleed page width and sits behind everything that
 * follows, so it's an absolutely-positioned, negative-z-index layer here
 * rather than something scoped inside the header or hero markup.
 */
if ( SNAP_PAGE_BACKGROUND_GRID_ID ) {
	echo wp_get_attachment_image(
		SNAP_PAGE_BACKGROUND_GRID_ID,
		'full',
		false,
		array(
			'class' => 'site-background-grid',
			'alt'   => '',
		)
	);
}
?>
<?php get_template_part( 'template-parts/header' ); ?>
