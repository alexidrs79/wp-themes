<?php
/**
 * Blog archive category filter tabs.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$active_slug = isset( $args['active_slug'] ) ? (string) $args['active_slug'] : '';
$base_url    = isset( $args['base_url'] ) ? (string) $args['base_url'] : home_url( '/blog/' );
$categories  = get_categories(
	array(
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);
?>
<div class="elementor-element elementor-element-e5db5b6 filters elementor-widget elementor-widget-taxonomy-filter" data-id="e5db5b6" data-element_type="widget" data-widget_type="taxonomy-filter.default">
	<nav class="e-filter" id="filters" role="navigation" aria-label="<?php esc_attr_e( 'Blog categories', 'devotel' ); ?>">
		<a class="e-filter-item" href="<?php echo esc_url( $base_url ); ?>" data-filter="__all" aria-pressed="<?php echo '' === $active_slug ? 'true' : 'false'; ?>">
			<?php esc_html_e( 'All', 'devotel' ); ?>
		</a>
		<?php foreach ( $categories as $category ) : ?>
			<?php if ( 'uncategorized' === $category->slug ) : ?>
				<?php continue; ?>
			<?php endif; ?>
			<?php
			$is_active  = $active_slug === $category->slug;
			$filter_url = add_query_arg( 'category_name', $category->slug, $base_url );
			?>
			<a class="e-filter-item" href="<?php echo esc_url( $filter_url ); ?>" data-filter="<?php echo esc_attr( $category->slug ); ?>" aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>">
				<?php echo esc_html( $category->name ); ?>
			</a>
		<?php endforeach; ?>
	</nav>
</div>
