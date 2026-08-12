<?php
/**
 * Generic page template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$post_id = get_the_ID();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'devotel-page' ); ?>>
		<?php
		if ( ! devotel_render_page_content( $post_id ) ) {
			devotel_render_page_native_fallback( $post_id );
		}
		?>
	</article>
	<?php
endwhile;

get_footer();
