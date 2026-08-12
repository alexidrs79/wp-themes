<?php
/**
 * Blog archive hero band.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero = isset( $args['hero'] ) && is_array( $args['hero'] ) ? $args['hero'] : devotel_get_blog_archive_hero_copy();
?>
<div class="elementor-element elementor-element-b617508 e-flex e-con-boxed e-con e-parent" data-id="b617508" data-element_type="container">
	<div class="e-con-inner">
		<div class="elementor-element elementor-element-14de6dd elementor-widget elementor-widget-heading" data-id="14de6dd" data-element_type="widget" data-widget_type="heading.default">
			<h2 class="elementor-heading-title elementor-size-default"><?php echo esc_html( $hero['title'] ); ?></h2>
		</div>
		<div class="elementor-element elementor-element-01ca74e elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="01ca74e" data-element_type="widget" data-widget_type="text-editor.default">
			<p><?php echo esc_html( $hero['description'] ); ?></p>
		</div>
	</div>
</div>
