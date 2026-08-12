<?php
/**
 * Blog archive and single post rendering.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the current request is the posts index (blog archive).
 *
 * @return bool
 */
function devotel_is_blog_archive() {
	return is_home() && ! is_front_page();
}

/**
 * Blog index or post taxonomy/date archives.
 *
 * @return bool
 */
function devotel_is_blog_listing() {
	return devotel_is_blog_archive() || is_category() || is_tag() || is_author() || is_date();
}

/**
 * Elementor single-post template ID.
 *
 * @return int
 */
function devotel_get_blog_single_template_id() {
	return 908;
}

/**
 * Inline arrow icon for blog post titles (Figma).
 *
 * @return string
 */
function devotel_get_blog_title_arrow_icon() {
	return '<svg class="devotel-blog-title-arrow" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">'
		. '<path d="M4.16406 10H15.8307" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>'
		. '<path d="M10 4.167L15.8333 10L10 15.833" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>'
		. '</svg>';
}

/**
 * "See all posts" CTA used in the single-post related band.
 *
 * @param string $blog_url Blog archive URL.
 * @return void
 */
function devotel_render_blog_see_all_posts_button( $blog_url ) {
	$blog_url = is_string( $blog_url ) && '' !== $blog_url ? $blog_url : devotel_get_blog_archive_url();
	?>
	<div class="elementor-element elementor-element-3343994 elementor-align-right elementor-widget elementor-widget-button" data-id="3343994" data-element_type="widget" data-widget_type="button.default">
		<div class="elementor-button-wrapper">
			<a class="elementor-button elementor-button-link elementor-size-sm" href="<?php echo esc_url( $blog_url ); ?>">
				<span class="elementor-button-content-wrapper">
					<span class="elementor-button-text"><?php esc_html_e( 'See all posts', 'devotel' ); ?></span>
				</span>
			</a>
		</div>
	</div>
	<?php
}

/**
 * Posts per page for the blog archive grid (live: 3 columns × 2 rows).
 *
 * @return int
 */
function devotel_get_blog_grid_posts_per_page() {
	return 6;
}

/**
 * Build grid query args for blog listings.
 *
 * @param int                $paged           Current page.
 * @param array<string,mixed> $extra_args      WP_Query overrides (category_name, tag, etc.).
 * @param int                $exclude_post_id Featured post ID to omit on page 1.
 * @return array<string,mixed>
 */
function devotel_build_blog_grid_query_args( $paged, $extra_args = array(), $exclude_post_id = 0 ) {
	$grid_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => devotel_get_blog_grid_posts_per_page(),
		'paged'               => max( 1, (int) $paged ),
		'ignore_sticky_posts' => true,
	);

	if ( is_array( $extra_args ) && ! empty( $extra_args ) ) {
		$grid_args = array_merge( $grid_args, $extra_args );
	}

	if ( $exclude_post_id > 0 && 1 === max( 1, (int) $paged ) ) {
		$grid_args['post__not_in'] = array( (int) $exclude_post_id );
	}

	return $grid_args;
}

/**
 * Build category tax_query args for blog grid filtering.
 *
 * Includes posts assigned to the category even when they have other categories.
 *
 * @param string $category_slug Category slug or empty for all.
 * @return array<string,mixed>
 */
function devotel_build_blog_category_query_args( $category_slug ) {
	$category_slug = sanitize_title( (string) $category_slug );
	if ( '' === $category_slug ) {
		return array();
	}

	$term = get_term_by( 'slug', $category_slug, 'category' );
	if ( ! $term instanceof WP_Term ) {
		return array( 'post__in' => array( 0 ) );
	}

	return array(
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => array( (int) $term->term_id ),
				'operator' => 'IN',
			),
		),
	);
}

/**
 * Enqueue blog archive filter/pagination scripts (always on posts index).
 */
function devotel_enqueue_blog_archive_scripts() {
	if ( is_admin() || ! devotel_is_blog_archive() ) {
		return;
	}

	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	$pagination_js = $theme_dir . '/assets/js/blog-pagination.js';
	if ( file_exists( $pagination_js ) ) {
		wp_enqueue_script(
			'devotel-blog-pagination',
			$theme_uri . '/assets/js/blog-pagination.js',
			array(),
			filemtime( $pagination_js ),
			true
		);
	}

	$filters_js = $theme_dir . '/assets/js/blog-filters.js';
	if ( ! file_exists( $filters_js ) ) {
		return;
	}

	wp_enqueue_script(
		'devotel-blog-filters',
		$theme_uri . '/assets/js/blog-filters.js',
		array(),
		filemtime( $filters_js ),
		true
	);
	wp_localize_script(
		'devotel-blog-filters',
		'devotelBlogFilters',
		array(
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'nonce'          => wp_create_nonce( 'devotel_blog_filters' ),
			'blogUrl'        => devotel_get_blog_archive_url(),
			'featuredPostId' => devotel_get_blog_archive_featured_post_id(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'devotel_enqueue_blog_archive_scripts', 20 );

/**
 * Skip full-page cache for filtered/paginated blog archive URLs.
 */
function devotel_bypass_blog_archive_page_cache() {
	if ( defined( 'DONOTCACHEPAGE' ) ) {
		return;
	}

	if ( ! devotel_is_blog_archive() ) {
		return;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['category_name'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$category_slug = sanitize_title( wp_unslash( (string) $_GET['category_name'] ) );
		if ( '' !== $category_slug ) {
			define( 'DONOTCACHEPAGE', true );
			return;
		}
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['paged'] ) && (int) $_GET['paged'] > 1 ) {
		define( 'DONOTCACHEPAGE', true );
	}
}
add_action( 'init', 'devotel_bypass_blog_archive_page_cache', 0 );

/**
 * Global featured post ID for the blog archive (sticky or latest).
 *
 * @return int
 */
function devotel_get_blog_archive_featured_post_id() {
	$featured = devotel_get_blog_featured_post( array() );

	return $featured instanceof WP_Post ? (int) $featured->ID : 0;
}

/**
 * Post ID to exclude from the grid on page 1.
 *
 * Featured posts stay visible in the hero and also appear in the grid (live parity).
 *
 * @param string $category_slug Active category slug or empty for all.
 * @param int    $paged         Current page.
 * @return int
 */
function devotel_get_blog_grid_exclude_post_id( $category_slug, $paged ) {
	return 0;
}

/**
 * Resolve featured post for blog archive / taxonomy listings.
 *
 * @param array<string,mixed> $extra_args Optional WP_Query constraints.
 * @return WP_Post|null
 */
function devotel_get_blog_featured_post( $extra_args = array() ) {
	$featured_args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 1,
		'ignore_sticky_posts' => false,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	$sticky = get_option( 'sticky_posts' );
	if ( is_array( $sticky ) && ! empty( $sticky ) && empty( $extra_args ) ) {
		$featured_args['post__in'] = array_map( 'intval', $sticky );
		$featured_args['orderby']  = 'post__in';
	}

	if ( is_array( $extra_args ) && ! empty( $extra_args ) ) {
		$featured_args = array_merge( $featured_args, $extra_args );
		$featured_args['ignore_sticky_posts'] = true;
	}

	$featured_query = new WP_Query( $featured_args );
	if ( ! $featured_query->have_posts() ) {
		return null;
	}

	$featured_query->the_post();
	$featured_post = get_post();
	wp_reset_postdata();

	return $featured_post instanceof WP_Post ? $featured_post : null;
}

/**
 * Build a blog archive pagination URL (query-arg based — avoids /blog/page/N/ 404s).
 *
 * @param int    $page          Page number.
 * @param string $category_slug Category slug or empty for all.
 * @return string
 */
function devotel_get_blog_pagination_url( $page, $category_slug = '' ) {
	$page = max( 1, (int) $page );
	$url  = devotel_get_blog_archive_url();
	$args = array();

	if ( $page > 1 ) {
		$args['paged'] = $page;
	}
	if ( '' !== $category_slug ) {
		$args['category_name'] = $category_slug;
	}

	if ( ! empty( $args ) ) {
		$url = add_query_arg( $args, $url );
	}

	return $url;
}

/**
 * Current blog archive page number from query vars / request.
 *
 * @return int
 */
function devotel_get_blog_current_paged() {
	$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['paged'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$paged = max( 1, (int) $_GET['paged'] );
	}

	return $paged;
}

/**
 * Render blog archive pagination (matches live post-872.css).
 *
 * @param WP_Query $query         Post query.
 * @param string   $category_slug Active category slug.
 * @return void
 */
function devotel_render_blog_pagination( $query, $category_slug = '' ) {
	if ( ! $query instanceof WP_Query ) {
		return;
	}

	$total   = (int) $query->max_num_pages;
	$current = max( 1, (int) $query->get( 'paged' ) );
	if ( $total <= 1 ) {
		return;
	}

	$prev_url = $current > 1 ? devotel_get_blog_pagination_url( $current - 1, $category_slug ) : '';
	$next_url = $current < $total ? devotel_get_blog_pagination_url( $current + 1, $category_slug ) : '';
	?>
	<nav class="elementor-pagination" aria-label="<?php esc_attr_e( 'Blog pagination', 'devotel' ); ?>">
		<?php if ( $prev_url ) : ?>
			<a class="page-numbers prev" href="<?php echo esc_url( $prev_url ); ?>" data-page="<?php echo esc_attr( (string) ( $current - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'devotel' ); ?></a>
		<?php else : ?>
			<span class="page-numbers prev disabled"><?php esc_html_e( 'Previous', 'devotel' ); ?></span>
		<?php endif; ?>

		<?php
		$end_size = 1;
		$mid_size = 1;
		for ( $page = 1; $page <= $total; $page++ ) {
			$show = $page <= $end_size
				|| $page > $total - $end_size
				|| abs( $page - $current ) <= $mid_size;

			if ( ! $show ) {
				if ( 2 === $page && $current > 4 ) {
					echo '<span class="page-numbers dots">&hellip;</span>';
				} elseif ( $total - 1 === $page && $current < $total - 3 ) {
					echo '<span class="page-numbers dots">&hellip;</span>';
				}
				continue;
			}

			$page_url = devotel_get_blog_pagination_url( $page, $category_slug );

			if ( $page === $current ) {
				echo '<span class="page-numbers current" aria-current="page">' . esc_html( (string) $page ) . '</span>';
			} else {
				echo '<a class="page-numbers" href="' . esc_url( $page_url ) . '" data-page="' . esc_attr( (string) $page ) . '">' . esc_html( (string) $page ) . '</a>';
			}
		}
		?>

		<?php if ( $next_url ) : ?>
			<a class="page-numbers next" href="<?php echo esc_url( $next_url ); ?>" data-page="<?php echo esc_attr( (string) ( $current + 1 ) ); ?>"><?php esc_html_e( 'Next', 'devotel' ); ?></a>
		<?php else : ?>
			<span class="page-numbers next disabled"><?php esc_html_e( 'Next', 'devotel' ); ?></span>
		<?php endif; ?>
	</nav>
	<?php
}

/**
 * Default blog archive hero copy (matches live).
 *
 * @return array{title: string, description: string}
 */
function devotel_get_blog_archive_hero_copy() {
	return array(
		'title'       => __( 'The Devotel Blog', 'devotel' ),
		'description' => __( 'Your go-to resource for expert tips and insights on all things customer communications and meaningful engagement!', 'devotel' ),
	);
}

/**
 * Canonical blog archive URL.
 *
 * @return string
 */
function devotel_get_blog_archive_url() {
	$page_for_posts = (int) get_option( 'page_for_posts' );
	if ( $page_for_posts > 0 ) {
		$url = get_permalink( $page_for_posts );
		if ( is_string( $url ) && '' !== $url ) {
			return $url;
		}
	}

	$archive = get_post_type_archive_link( 'post' );
	if ( is_string( $archive ) && '' !== $archive ) {
		return $archive;
	}

	return home_url( '/blog/' );
}

/**
 * Use /blog/post-name/ permalinks for published posts.
 *
 * @param string  $permalink Default permalink.
 * @param WP_Post $post      Post object.
 * @return string
 */
function devotel_filter_post_permalink_with_blog_prefix( $permalink, $post ) {
	if ( $post instanceof WP_Post && 'post' === $post->post_type && 'publish' === $post->post_status ) {
		return home_url( '/blog/' . $post->post_name . '/' );
	}

	return $permalink;
}
add_filter( 'post_link', 'devotel_filter_post_permalink_with_blog_prefix', 10, 2 );

/**
 * Rewrite rules so /blog/post-name/ resolves to single posts.
 */
function devotel_register_blog_post_rewrite_rules() {
	add_rewrite_rule(
		'^blog/([^/]+)/?$',
		'index.php?post_type=post&name=$matches[1]',
		'top'
	);

	add_rewrite_rule(
		'^blog/([^/]+)/page/?([0-9]{1,})/?$',
		'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
		'top'
	);
}
add_action( 'init', 'devotel_register_blog_post_rewrite_rules' );

/**
 * Flush permalinks once after this ruleset ships (or on theme switch).
 */
function devotel_maybe_flush_blog_permalink_rules() {
	$version = '1';

	if ( get_option( 'devotel_blog_permalink_rules_version' ) === $version ) {
		return;
	}

	flush_rewrite_rules( false );
	update_option( 'devotel_blog_permalink_rules_version', $version );
}
add_action( 'init', 'devotel_maybe_flush_blog_permalink_rules', 20 );

/**
 * @return void
 */
function devotel_flush_blog_permalink_rules_on_theme_switch() {
	devotel_register_blog_post_rewrite_rules();
	flush_rewrite_rules();
	update_option( 'devotel_blog_permalink_rules_version', '1' );
}
add_action( 'after_switch_theme', 'devotel_flush_blog_permalink_rules_on_theme_switch' );

/**
 * Hero excerpt for single blog posts — ends at "it's time for you to" (live parity).
 *
 * @param WP_Post|int|null $post Post object or ID.
 * @return string
 */
function devotel_get_blog_single_hero_excerpt( $post ) {
	$post = get_post( $post );
	if ( ! $post instanceof WP_Post ) {
		return '';
	}

	$sources = array(
		wp_strip_all_tags( get_the_excerpt( $post ) ),
		wp_strip_all_tags( (string) $post->post_content ),
	);

	foreach ( $sources as $source ) {
		$text = trim( preg_replace( '/\s+/u', ' ', $source ) );
		if ( '' === $text ) {
			continue;
		}

		if ( preg_match( '/it(?:\'|\x{2018}|\x{2019})s time for you to/iu', $text, $matches, PREG_OFFSET_CAPTURE ) ) {
			$end = (int) $matches[0][1] + (int) strlen( $matches[0][0] );

			return trim( substr( $text, 0, $end ) );
		}
	}

	$fallback = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( get_the_excerpt( $post ) ) ) );
	if ( '' !== $fallback ) {
		return wp_trim_words( $fallback, 35, '' );
	}

	return wp_trim_words( wp_strip_all_tags( (string) $post->post_content ), 35, '' );
}

/**
 * Estimate read time in minutes from post content.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function devotel_get_blog_read_time_minutes( $post_id ) {
	$post_id = (int) $post_id;
	$content = (string) get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	$minutes = (int) max( 1, (int) ceil( $words / 200 ) );

	return $minutes;
}

/**
 * Published categories for a post (excludes uncategorized).
 *
 * @param int $post_id Post ID.
 * @return array<int, WP_Term>
 */
function devotel_get_post_display_categories( $post_id ) {
	$post_id    = (int) $post_id;
	$categories = get_the_category( $post_id );
	if ( empty( $categories ) || ! is_array( $categories ) ) {
		return array();
	}

	$display = array();
	foreach ( $categories as $category ) {
		if ( ! $category instanceof WP_Term ) {
			continue;
		}
		if ( 'uncategorized' === $category->slug ) {
			continue;
		}
		$display[] = $category;
	}

	usort(
		$display,
		static function ( $a, $b ) {
			return strcasecmp( (string) $a->name, (string) $b->name );
		}
	);

	return $display;
}

/**
 * Primary category for a post.
 *
 * @param int $post_id Post ID.
 * @return WP_Term|null
 */
function devotel_get_post_primary_category( $post_id ) {
	$categories = devotel_get_post_display_categories( $post_id );

	return ! empty( $categories ) ? $categories[0] : null;
}

/**
 * Echo linked category labels for archive cards and featured rows.
 *
 * @param int    $post_id       Post ID.
 * @param string $wrapper_class Wrapper class list.
 * @return void
 */
function devotel_render_post_category_links( $post_id, $wrapper_class = 'elementor-heading-title elementor-size-default devotel-blog-categories' ) {
	$categories = devotel_get_post_display_categories( $post_id );
	if ( empty( $categories ) ) {
		return;
	}

	echo '<div class="' . esc_attr( $wrapper_class ) . '">';
	foreach ( $categories as $index => $category ) {
		if ( $index > 0 ) {
			echo '<span class="devotel-blog-category-sep" aria-hidden="true">, </span>';
		}
		echo '<a href="' . esc_url( get_category_link( $category ) ) . '" rel="tag">';
		echo esc_html( $category->name );
		echo '</a>';
	}
	echo '</div>';
}

/**
 * Render blog archive with dynamic WordPress posts.
 *
 * @return bool
 */
function devotel_render_blog_archive() {
	if ( ! devotel_is_blog_archive() ) {
		return false;
	}

	$paged = devotel_get_blog_current_paged();

	$category_slug = '';
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['category_name'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$category_slug = sanitize_title( wp_unslash( (string) $_GET['category_name'] ) );
	}

	$category_args = devotel_build_blog_category_query_args( $category_slug );
	$featured_post = devotel_get_blog_featured_post( array() );
	$exclude_id    = devotel_get_blog_grid_exclude_post_id( $category_slug, $paged );
	$grid_query    = new WP_Query( devotel_build_blog_grid_query_args( $paged, $category_args, $exclude_id ) );

	$hero = devotel_get_blog_archive_hero_copy();

	ob_start();
	?>
	<section class="devotel-cached-snapshot devotel-blog-archive" data-source="theme-blog">
		<div data-elementor-type="archive" data-elementor-id="872" class="elementor elementor-872 elementor-location-archive">
			<?php
			get_template_part( 'template-parts/blog/archive', 'hero', array( 'hero' => $hero ) );
			if ( $featured_post instanceof WP_Post ) {
				get_template_part( 'template-parts/blog/featured', 'post', array( 'post' => $featured_post ) );
			}
			$blog_base = devotel_get_blog_archive_url();
			?>
			<div class="elementor-element elementor-element-a743aca e-flex e-con-boxed e-con e-parent" data-id="a743aca" data-element_type="container">
				<div class="e-con-inner">
					<?php
					get_template_part(
						'template-parts/blog/category',
						'filters',
						array(
							'active_slug' => $category_slug,
							'base_url'    => $blog_base,
						)
					);
					get_template_part(
						'template-parts/blog/post',
						'grid',
						array(
							'query'         => $grid_query,
							'category_slug' => $category_slug,
						)
					);
					?>
				</div>
			</div>
			<div class="elementor-element elementor-element-3814e06 e-con-full e-flex e-con e-parent" data-id="3814e06" data-element_type="container">
				<?php get_template_part( 'template-parts/blog/archive', 'cta' ); ?>
			</div>
		</div>
	</section>
	<?php
	$markup = (string) ob_get_clean();
	wp_reset_postdata();

	if ( ! devotel_markup_is_substantial( $markup ) ) {
		return false;
	}

	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	return true;
}

/**
 * Render category/tag/date/author archives with blog layout.
 *
 * @return bool
 */
function devotel_render_blog_tax_listing() {
	if ( ! is_category() && ! is_tag() && ! is_author() && ! is_date() ) {
		return false;
	}

	$paged = devotel_get_blog_current_paged();

	$category_slug = '';
	$grid_extra    = array();

	if ( is_category() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$category_slug = $term->slug;
			$grid_extra    = devotel_build_blog_category_query_args( $category_slug );
		}
	} elseif ( is_tag() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$grid_extra['tag'] = $term->slug;
		}
	} elseif ( is_author() ) {
		$grid_extra['author'] = (int) get_queried_object_id();
	} elseif ( is_date() ) {
		if ( is_year() ) {
			$grid_extra['year'] = (int) get_query_var( 'year' );
		}
		if ( is_month() ) {
			$grid_extra['monthnum'] = (int) get_query_var( 'monthnum' );
		}
		if ( is_day() ) {
			$grid_extra['day'] = (int) get_query_var( 'day' );
		}
	}

	$featured_post = devotel_get_blog_featured_post( array() );
	$exclude_id    = devotel_get_blog_grid_exclude_post_id( $category_slug, $paged );
	$grid_query    = new WP_Query( devotel_build_blog_grid_query_args( $paged, $grid_extra, $exclude_id ) );

	$hero      = devotel_get_blog_archive_hero_copy();
	$blog_base = devotel_get_blog_archive_url();

	ob_start();
	?>
	<section class="devotel-cached-snapshot devotel-blog-archive" data-source="theme-blog">
		<div data-elementor-type="archive" data-elementor-id="872" class="elementor elementor-872 elementor-location-archive">
			<?php
			get_template_part( 'template-parts/blog/archive', 'hero', array( 'hero' => $hero ) );
			if ( $featured_post instanceof WP_Post ) {
				get_template_part( 'template-parts/blog/featured', 'post', array( 'post' => $featured_post ) );
			}
			?>
			<div class="elementor-element elementor-element-a743aca e-flex e-con-boxed e-con e-parent" data-id="a743aca" data-element_type="container">
				<div class="e-con-inner">
					<?php
					get_template_part(
						'template-parts/blog/category',
						'filters',
						array(
							'active_slug' => $category_slug,
							'base_url'    => $blog_base,
						)
					);
					get_template_part(
						'template-parts/blog/post',
						'grid',
						array(
							'query'         => $grid_query,
							'category_slug' => $category_slug,
						)
					);
					?>
				</div>
			</div>
			<div class="elementor-element elementor-element-3814e06 e-con-full e-flex e-con e-parent" data-id="3814e06" data-element_type="container">
				<?php get_template_part( 'template-parts/blog/archive', 'cta' ); ?>
			</div>
		</div>
	</section>
	<?php
	$markup = (string) ob_get_clean();
	wp_reset_postdata();

	if ( ! devotel_markup_is_substantial( $markup ) ) {
		return false;
	}

	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	return true;
}

/**
 * Render any blog listing route (index or taxonomy).
 *
 * @return bool
 */
function devotel_render_blog_listing() {
	if ( devotel_is_blog_archive() ) {
		return devotel_render_blog_archive();
	}
	return devotel_render_blog_tax_listing();
}

/**
 * Build table of contents from H2 headings in post content (#blogsss).
 *
 * @param string $content Post content HTML (after the_content filters).
 * @return array<int, array{id: string, text: string, level: int}>
 */
function devotel_build_blog_toc_items( $content ) {
	$items = array();
	if ( ! preg_match_all( '/<h2([^>]*)>(.*?)<\/h2>/is', $content, $matches, PREG_SET_ORDER ) ) {
		return $items;
	}

	$index = 0;
	foreach ( $matches as $match ) {
		$text = trim( wp_strip_all_tags( $match[2] ) );
		if ( '' === $text ) {
			continue;
		}
		++$index;
		$items[] = array(
			'id'    => 'devotel-toc-' . $index,
			'text'  => $text,
			'level' => 2,
		);
	}

	return $items;
}

/**
 * Inject IDs into H2 headings for TOC anchors.
 *
 * @param string $content Post content HTML.
 * @param array  $items   TOC items from devotel_build_blog_toc_items().
 * @return string
 */
function devotel_inject_blog_toc_heading_ids( $content, $items ) {
	if ( empty( $items ) ) {
		return $content;
	}

	$index = 0;
	return preg_replace_callback(
		'/<h2([^>]*)>(.*?)<\/h2>/is',
		static function ( $match ) use ( $items, &$index ) {
			$text = trim( wp_strip_all_tags( $match[2] ) );
			if ( '' === $text || ! isset( $items[ $index ] ) ) {
				return $match[0];
			}
			$id = esc_attr( $items[ $index ]['id'] );
			++$index;
			if ( preg_match( '/\sid=(["\']).*?\1/i', $match[1] ) ) {
				return $match[0];
			}
			return '<h2' . $match[1] . ' id="' . $id . '">' . $match[2] . '</h2>';
		},
		$content
	);
}

/**
 * Social share URLs for a blog post.
 *
 * @param string $url   Permalink.
 * @param string $title Post title.
 * @return array<string, array{label: string, url: string}>
 */
function devotel_get_blog_share_links( $url, $title = '' ) {
	$url   = esc_url_raw( $url );
	$title = rawurlencode( wp_strip_all_tags( (string) $title ) );

	return array(
		'twitter'  => array(
			'label' => __( 'Share on X', 'devotel' ),
			'url'   => 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&text=' . $title,
		),
		'facebook' => array(
			'label' => __( 'Share on Facebook', 'devotel' ),
			'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ),
		),
		'linkedin' => array(
			'label' => __( 'Share on LinkedIn', 'devotel' ),
			'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ),
		),
	);
}

/**
 * Render Elementor-style share buttons for blog singles.
 *
 * @param string $url   Permalink.
 * @param string $title Post title.
 * @return void
 */
function devotel_render_blog_share_buttons( $url, $title = '' ) {
	$links = devotel_get_blog_share_links( $url, $title );
	$icons = array(
		'facebook' => '<svg class="e-font-icon-svg e-fab-facebook" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor"><path fill="currentColor" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"></path></svg>',
		'twitter'  => '<svg class="e-font-icon-svg e-fab-twitter" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor"><path fill="currentColor" d="M389.2 48h70.6L305.6 224.2 487 464H345.9L238.4 318.6 106.5 464H35.8l164.9-188.5L26.8 48h144.4l97.7 132.9L389.2 48zm-24.8 373.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>',
		'linkedin' => '<svg class="e-font-icon-svg e-fab-linkedin" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor"><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 63-34.5 67.5 0 79.9 44.5 79.9 102.2V416z"></path></svg>',
	);
	?>
	<div class="elementor-share-buttons elementor-grid" role="list">
		<?php foreach ( $links as $network => $link ) : ?>
			<div class="elementor-grid-item" role="listitem">
				<div
					class="elementor-share-btn elementor-share-btn_<?php echo esc_attr( $network ); ?>"
					role="button"
					tabindex="0"
					aria-label="<?php echo esc_attr( $link['label'] ); ?>"
					data-share-url="<?php echo esc_url( $link['url'] ); ?>"
				>
					<span class="elementor-share-btn__icon">
						<?php echo $icons[ $network ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Enqueue blog single TOC script.
 */
function devotel_enqueue_blog_single_scripts() {
	if ( is_admin() || ! is_singular( 'post' ) ) {
		return;
	}

	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();
	$toc_js    = $theme_dir . '/assets/js/blog-single-toc.js';
	$share_js  = $theme_dir . '/assets/js/blog-single-share.js';
	$deps      = array();

	if ( file_exists( $share_js ) ) {
		wp_enqueue_script(
			'devotel-blog-single-share',
			$theme_uri . '/assets/js/blog-single-share.js',
			array(),
			filemtime( $share_js ),
			true
		);
		$deps[] = 'devotel-blog-single-share';
	}

	if ( ! file_exists( $toc_js ) ) {
		return;
	}

	wp_enqueue_script(
		'devotel-blog-single-toc',
		$theme_uri . '/assets/js/blog-single-toc.js',
		$deps,
		filemtime( $toc_js ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'devotel_enqueue_blog_single_scripts', 20 );

/**
 * Render a single blog post layout.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function devotel_render_blog_single( $post_id ) {
	$post_id = (int) $post_id;
	$post    = get_post( $post_id );
	if ( ! $post instanceof WP_Post || 'post' !== $post->post_type ) {
		return false;
	}

	setup_postdata( $post );

	$content = apply_filters( 'the_content', $post->post_content );
	$toc     = devotel_build_blog_toc_items( $content );
	if ( ! empty( $toc ) ) {
		$content = devotel_inject_blog_toc_heading_ids( $content, $toc );
	}

	ob_start();
	?>
	<section class="devotel-cached-snapshot devotel-blog-single" data-source="theme-blog">
		<article id="post-<?php echo esc_attr( (string) $post_id ); ?>" <?php post_class( 'devotel-blog-single-article' ); ?>>
			<?php
			get_template_part(
				'template-parts/blog/single',
				'layout',
				array(
					'post'    => $post,
					'content' => $content,
					'toc'     => $toc,
				)
			);
			?>
		</article>
		<?php get_template_part( 'template-parts/shared/site', 'cta' ); ?>
	</section>
	<?php
	$markup = (string) ob_get_clean();
	wp_reset_postdata();

	if ( ! devotel_markup_is_substantial( $markup ) ) {
		return false;
	}

	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	return true;
}

/**
 * Render blog grid partial for AJAX filter responses.
 *
 * @param string $category_slug Active category slug (empty = all).
 * @param int    $paged         Current page.
 * @return array{html: string, max_pages: int}
 */
function devotel_get_blog_grid_response( $category_slug = '', $paged = 1 ) {
	$category_slug = sanitize_title( (string) $category_slug );
	$category_args = devotel_build_blog_category_query_args( $category_slug );
	$exclude_id    = devotel_get_blog_grid_exclude_post_id( $category_slug, $paged );
	$grid_query    = new WP_Query( devotel_build_blog_grid_query_args( $paged, $category_args, $exclude_id ) );

	ob_start();
	get_template_part(
		'template-parts/blog/post',
		'grid',
		array(
			'query'         => $grid_query,
			'category_slug' => $category_slug,
		)
	);
	$html = (string) ob_get_clean();
	// Harden AJAX HTML payload: allow only post-content-safe markup before returning to JS.
	$html = (string) wp_kses_post( $html );
	wp_reset_postdata();

	$response = array(
		'html'      => $html,
		'max_pages' => (int) $grid_query->max_num_pages,
	);

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		$term                 = get_term_by( 'slug', $category_slug, 'category' );
		$response['debug']    = array(
			'category_slug' => $category_slug,
			'term_id'       => $term instanceof WP_Term ? (int) $term->term_id : 0,
			'found_posts'   => (int) $grid_query->found_posts,
			'post_ids'      => wp_list_pluck( $grid_query->posts, 'ID' ),
			'exclude_id'    => $exclude_id,
		);
	}

	return $response;
}

/**
 * AJAX: return filtered blog grid HTML.
 */
function devotel_ajax_blog_grid() {
	check_ajax_referer( 'devotel_blog_filters', 'nonce' );

	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$category_slug = isset( $_POST['category_slug'] ) ? sanitize_title( wp_unslash( (string) $_POST['category_slug'] ) ) : '';
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	$paged = isset( $_POST['paged'] ) ? max( 1, (int) $_POST['paged'] ) : 1;

	wp_send_json_success( devotel_get_blog_grid_response( $category_slug, $paged ) );
}
add_action( 'wp_ajax_devotel_blog_grid', 'devotel_ajax_blog_grid' );
add_action( 'wp_ajax_nopriv_devotel_blog_grid', 'devotel_ajax_blog_grid' );

/**
 * Redirect broken /blog/page/N/ permalinks to ?paged=N query form.
 */
function devotel_redirect_blog_paged_permalink() {
	if ( ! is_404() ) {
		return;
	}

	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	if ( ! preg_match( '#/blog/page/(\d+)/?(\?.*)?$#i', $uri, $matches ) ) {
		return;
	}

	$page = max( 1, (int) $matches[1] );
	$args = array( 'paged' => $page );

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( isset( $_GET['category_name'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$args['category_name'] = sanitize_title( wp_unslash( (string) $_GET['category_name'] ) );
	}

	wp_safe_redirect( add_query_arg( $args, devotel_get_blog_archive_url() ), 301 );
	exit;
}
add_action( 'template_redirect', 'devotel_redirect_blog_paged_permalink', 1 );
