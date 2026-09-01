<?php
/**
 * Default template for standard WordPress Pages with no page-templates/
 * file assigned. Simple single-column content — none of the landing
 * page's section apparatus.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main class="container" style="padding-block: 64px;">
	<?php
	while ( have_posts() ) :
		the_post();
		the_title( '<h1>', '</h1>' );
		the_content();
	endwhile;
	?>
</main>
<?php
get_footer();
