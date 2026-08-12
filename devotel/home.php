<?php
/**
 * Blog posts index template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( devotel_render_blog_listing() ) {
	get_footer();
	return;
}
?>
<div class="devotel-container">
	<p><?php esc_html_e( 'No content found.', 'devotel' ); ?></p>
</div>
<?php
get_footer();
