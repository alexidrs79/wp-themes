<?php
/**
 * Homepage section: resources
 *
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$resources_title = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_resources_title' ) : '';
$resources_text  = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_resources_text' ) : '';

$resources_title = $resources_title ? $resources_title : 'Resources';
$resources_text  = $resources_text ? $resources_text : 'Latest insights and updates from the Devotel team.';

$resources_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
?>
<section class="devotel-section devotel-section--resources devotel-native-resources" aria-label="resources">
	<div class="devotel-container">
		<header class="devotel-native-resources__header">
			<p class="devotel-native-resources__kicker"><?php esc_html_e( 'Resources', 'devotel' ); ?></p>
			<h2><?php echo esc_html( $resources_title ); ?></h2>
			<p><?php echo esc_html( $resources_text ); ?></p>
		</header>

		<?php if ( $resources_posts->have_posts() ) : ?>
			<div class="devotel-native-resources__grid">
				<?php
				while ( $resources_posts->have_posts() ) :
					$resources_posts->the_post();
					?>
					<article class="devotel-native-resources__card">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="devotel-native-resources__thumb">
								<?php the_post_thumbnail( 'medium_large' ); ?>
							</a>
						<?php endif; ?>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
					</article>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<div class="devotel-native-resources__actions">
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="devotel-btn devotel-btn--secondary">
				<?php esc_html_e( 'View all posts', 'devotel' ); ?>
			</a>
		</div>
	</div>
</section>
