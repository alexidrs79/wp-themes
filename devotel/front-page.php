<?php
/**
 * Front page template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php if ( devotel_render_cached_snapshot_for_request() ) : ?>
	<?php // Homepage snapshot is the primary renderer without Elementor runtime. ?>
<?php elseif ( devotel_render_home_section_fallback() ) : ?>
	<?php // Composed extracted widgets when snapshot is unavailable. ?>
<?php elseif ( function_exists( 'get_field' ) && get_field( 'devotel_enable_dynamic_builder' ) && devotel_render_dynamic_sections() ) : ?>
	<?php // ACF dynamic builder only when explicitly enabled and snapshot/fallback fail. ?>
<?php endif; ?>

<?php
get_footer();

