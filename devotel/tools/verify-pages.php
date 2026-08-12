<?php
/**
 * Fetch a page bypassing WP-Optimize full-page cache when possible.
 *
 * @param string $url Page URL.
 * @return string|false
 */
function devotel_verify_fetch_page_html( $url ) {
	$separator = ( false !== strpos( $url, '?' ) ) ? '&' : '?';
	$fetch_url = $url . $separator . 'devotel_verify=' . rawurlencode( (string) time() );
	$context   = stream_context_create(
		array(
			'http' => array(
				'header'  => "Cache-Control: no-cache\r\nPragma: no-cache\r\n",
				'timeout' => 30,
			),
		)
	);

	return @file_get_contents( $fetch_url, false, $context );
}

/**
 * Whether HTML includes a theme asset by filename or WP enqueue handle.
 *
 * @param string $html        Page HTML.
 * @param string $filename    Basename needle (e.g. blog.css).
 * @param string $handle_base Enqueue handle without suffix (e.g. devotel-page-blog).
 * @return bool
 */
function devotel_verify_html_has_asset( $html, $filename, $handle_base = '' ) {
	$html = (string) $html;
	if ( '' !== $filename && false !== stripos( $html, $filename ) ) {
		return true;
	}

	if ( '' === $handle_base ) {
		return false;
	}

	$needles = array(
		$handle_base . '-css',
		$handle_base . '-js',
		"id='{$handle_base}-css'",
		"id=\"{$handle_base}-css\"",
		"id='{$handle_base}-js'",
		"id=\"{$handle_base}-js\"",
		// WP-Optimize minify bundles drop original filenames/handles.
		'wpo-minify-header-' . $handle_base,
		'wpo-minify-footer-' . $handle_base,
	);

	foreach ( $needles as $needle ) {
		if ( false !== stripos( $html, $needle ) ) {
			return true;
		}
	}

	return false;
}

$asset_handle_map = array(
	'main.css'              => 'devotel-main',
	'products.css'          => 'devotel-page-products',
	'product-subpage.css'   => 'devotel-page-product-subpage-base',
	'communication-apis.css' => 'devotel-page-product-subpage',
	'platforms.css'         => 'devotel-page-product-subpage',
	'telco.css'             => 'devotel-page-product-subpage',
	'sim-based.css'         => 'devotel-page-product-subpage',
	'blog.css'              => 'devotel-page-blog',
	'cta.css'               => 'devotel-site-cta',
	'blog-filters.js'       => 'devotel-blog-filters',
	'blog-pagination.js'    => 'devotel-blog-pagination',
	'blog-single-toc.js'    => 'devotel-blog-single-toc',
	'blog-single-share.js'  => 'devotel-blog-single-share',
	'sim-based-how-it-works.js' => 'devotel-sim-based-how-it-works',
);

$pages = array(
	'home'              => 'http://devotel.local/',
	'products'          => 'http://devotel.local/products/',
	'about'             => 'http://devotel.local/about-us/',
	'contact'           => 'http://devotel.local/contact-us/',
	'comm-sms'          => 'http://devotel.local/products/communication-apis/sms/',
	'comm-rcs'          => 'http://devotel.local/products/communication-apis/rcs/',
	'comm-email'        => 'http://devotel.local/products/communication-apis/email/',
	'comm-whatsapp'     => 'http://devotel.local/products/communication-apis/whatsapp-business/',
	'platform-orbit'    => 'http://devotel.local/products/platforms/orbit/',
	'platform-cmp'      => 'http://devotel.local/products/platforms/cmp/',
	'telco-sms'         => 'http://devotel.local/products/telco/sms-solutions-for-telco/',
	'telco-sms-firewall' => 'http://devotel.local/products/telco/sms-firewall/',
	'telco-sms-monetisation' => 'http://devotel.local/products/telco/sms-monetisation/',
	'telco-voice'       => 'http://devotel.local/products/telco/voice-solutions/',
	'telco-voice-firewall' => 'http://devotel.local/products/telco/voice-firewall/',
	'telco-voice-monetisation' => 'http://devotel.local/products/telco/voice-monetisation/',
	'sim-ota'                  => 'http://devotel.local/products/sim-based/ota/',
	'sim-coverage'             => 'http://devotel.local/products/sim-based/coverage-monitoring-platform/',
	'sim-communication'        => 'http://devotel.local/products/sim-based/communication-platform/',
	'sim-otp'                  => 'http://devotel.local/products/sim-based/otp/',
	'blog'                     => 'http://devotel.local/blog/',
	'blog-single'              => 'http://devotel.local/blog/business-messaging-101-the-benefits-best-practices-and-use-cases/',
);

$comm_checks = array(
	'comm-sms'      => array(
		'Reach billions of devices worldwide',
		'sms-api-frame-2147227729',
		'What Makes our SMS API Better',
		'Got questions about our SMS API',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-communication-apis-page',
		'elementor-page-2002',
		'elementor-2002',
		'post-2002',
		'post-2002.css',
		'communication-apis.css',
		'product-subpage.css',
		'section.bg-gradient-to-r',
		'ts-image-frame',
		'elementor-element-6db40139',
		'id="cm7"',
	),
	'comm-rcs'      => array(
		'Transform Your Messages Into Real Interactive Experiences',
		'sms-api-frame-2147227729',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'elementor-page-2326',
		'elementor-2326',
		'post-2326',
		'post-2326.css',
		'communication-apis.css',
		'section.bg-gradient-to-r',
	),
	'comm-email'    => array(
		'Email API',
		'sms-api-frame-2147227729',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'elementor-page-2276',
		'elementor-2276',
		'post-2276',
		'post-2276.css',
		'communication-apis.css',
		'section.bg-gradient-to-r',
	),
	'comm-whatsapp' => array(
		'WhatsApp Business API',
		'sms-api-frame-2147227729',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'elementor-page-2342',
		'elementor-2342',
		'post-2342',
		'post-2342.css',
		'communication-apis.css',
		'section.bg-gradient-to-r',
	),
);

$platform_checks = array(
	'platform-orbit' => array(
		'Empower Communications Across Every Channel',
		'Maximise Customer Engagement and Revenue at Scale',
		'Ready to Unify Your Customer Communications?',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-platforms-page',
		'elementor-page-2363',
		'elementor-2363',
		'post-2363',
		'post-2363.css',
		'platforms.css',
		'product-subpage.css',
		'ts-image-frame',
		'elementor-element-9a9436b',
		'9a9436b cm7',
		'Book a demo',
		'Everything you need',
	),
	'platform-cmp' => array(
		'Get Your Branded eSIM Business Live in 14 Days with CMP',
		'Turn Global Connectivity into Revenue',
		'Ready to Launch',
		'Your eSIM Business?',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-platforms-page',
		'elementor-page-2051',
		'elementor-2051',
		'post-2051',
		'post-2051.css',
		'platforms.css',
		'product-subpage.css',
		'ts-image-frame',
		'elementor-element-e9de2ce',
		'e9de2ce cm7',
		'Book a Demo',
		'Got Questions on Devotel',
	),
);

$telco_checks = array(
	'telco-sms' => array(
		'SMS SOLUTIONS FOR TELCOS',
		'Connect to 190+ Countries With Carrier-Grade SMS Services',
		'Everything You Need to Deliver, Protect, and Monetise SMS',
		'Why Telcos Choose Devotel',
		'Scale Your SMS Infrastructure Globally',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-telco-page',
		'elementor-page-2427',
		'elementor-2427',
		'post-2427',
		'post-2427.css',
		'telco.css',
		'product-subpage.css',
		'ts-image-frame',
		'elementor-element-ce05b5e',
		'ce05b5e cm7',
		'Talk to an expert',
	),
	'telco-sms-firewall' => array(
		'Protect Revenue While Securing Your Network',
		'Stop Fraud and Secure Your Network',
		'devotel-telco-page',
		'elementor-page-2406',
		'elementor-2406',
		'post-2406.css',
		'telco.css',
		'd5a03e0 cm7',
	),
	'telco-sms-monetisation' => array(
		'Transform A2P SMS Traffic Into a Revenue Stream',
		'Unlock Your Full A2P SMS Revenue Today',
		'devotel-telco-page',
		'elementor-page-2418',
		'elementor-2418',
		'post-2418.css',
		'telco.css',
		'60f0022 cm7',
	),
	'telco-voice' => array(
		'Offer Carrier-Grade Voice Services With Global Reach',
		'Upgrade and Future-Proof Your Voice Infrastructure',
		'devotel-telco-page',
		'elementor-page-2452',
		'elementor-2452',
		'post-2452.css',
		'telco.css',
		'1c9f9a7 cm7',
	),
	'telco-voice-firewall' => array(
		'Block Fraudulent Calls and Protect Your Network',
		'Block Voice Frauds and Protect Your Network Revenue Today',
		'devotel-telco-page',
		'elementor-page-2433',
		'elementor-2433',
		'post-2433.css',
		'telco.css',
		'5796ac9 cm7',
	),
	'telco-voice-monetisation' => array(
		'Capture Revenue From Flash Calls With A2P Voice Monetisation',
		'Transform Flash Calls Into a Sustainable Revenue Stream',
		'devotel-telco-page',
		'elementor-page-2446',
		'elementor-2446',
		'post-2446.css',
		'telco.css',
		'3df2703 cm7',
	),
);

$sim_checks = array(
	'sim-ota' => array(
		'SIM OTA',
		'Have Complete Control of Your SIMs Cards',
		'WHY USE A SIM OTA?',
		'hi-section',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-sim-based-page',
		'elementor-page-7796',
		'elementor-7796',
		'post-7796',
		'post-7796.css',
		'sim-based.css',
		'product-subpage.css',
		'sim-based-how-it-works.js',
		'hi-line-progress',
		'id="hi-step-content"',
		'id="cm7"',
		'id="cm6"',
		'sp-section',
		'sp-eyebrow',
		'sp-logo-grid',
		'sp-grid-separator-h-row',
		'devotel-social-proof-partners',
		'devotel-social-proof-partners-flip',
		'Talk to an expert',
		"Let's streamline and scale your SIM Management",
	),
	'sim-coverage' => array(
		'Coverage Monitoring Platform',
		'Transform how you monitor and optimise your mobile network performance',
		'Four Steps to Complete Network Visibility',
		'hi-section',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-sim-based-page',
		'elementor-page-8835',
		'elementor-8835',
		'post-8835',
		'post-8835.css',
		'sim-based.css',
		'product-subpage.css',
		'sim-based-how-it-works.js',
		'hi-line-progress',
		'id="hi-step-content"',
		'id="cm7"',
		'id="cm6"',
		'sp-section',
		'sp-eyebrow',
		'sp-logo-grid',
		'sp-grid-separator-h-row',
		'devotel-social-proof-partners',
		'devotel-social-proof-partners-flip',
		'Talk to an expert',
		'Improve Your Network Monitoring Today',
	),
	'sim-communication' => array(
		'Communication Platform',
		'Reach Every Subscriber Instantly with Interactive Campaigns',
		'Four Steps to Launch High-Impact Campaigns',
		'hi-section',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-sim-based-page',
		'elementor-page-8717',
		'elementor-8717',
		'post-8717',
		'post-8717.css',
		'sim-based.css',
		'product-subpage.css',
		'sim-based-how-it-works.js',
		'hi-line-progress',
		'id="hi-step-content"',
		'id="cm7"',
		'id="cm6"',
		'sp-section',
		'sp-eyebrow',
		'sp-logo-grid',
		'sp-grid-separator-h-row',
		'devotel-social-proof-partners',
		'devotel-social-proof-partners-flip',
		'Talk to an expert',
		'Send Interactive Messages Your Subscribers Can Instantly See and Act On',
	),
	'sim-otp' => array(
		'SIM OTP',
		'Secure Authentication That Can\'t Be Compromised',
		'Three Steps to Unbreakable Authentication',
		'hi-section',
		'devotel-cached-snapshot',
		'data-source="extracted-widget"',
		'devotel-product-subpage',
		'devotel-sim-based-page',
		'elementor-page-8645',
		'elementor-8645',
		'post-8645',
		'post-8645.css',
		'sim-based.css',
		'product-subpage.css',
		'sim-based-how-it-works.js',
		'hi-line-progress',
		'id="hi-step-content"',
		'id="cm7"',
		'id="cm6"',
		'sp-section',
		'sp-eyebrow',
		'sp-logo-grid',
		'sp-grid-separator-h-row',
		'devotel-social-proof-partners',
		'devotel-social-proof-partners-flip',
		'Talk to an expert',
		'Make Your Authentication Process Stronger with SIM-Based OTP',
	),
);

$comm_smush_bad = '<img decoding="async" width="560" height="582" src="http://devotel.local/wp-content/uploads/2026/01/hero-SMS.png"';

foreach ( $pages as $name => $url ) {
	$html = devotel_verify_fetch_page_html( $url );
	if ( ! $html ) {
		echo "$name: fetch failed\n";
		continue;
	}
	echo "=== $name (" . strlen( $html ) . " bytes) ===\n";

	if ( 'products' === $name ) {
		$checks = array(
			'Try it for free',
			'Unleash the full power of our products',
			'id="applications-section"',
			'id="communication-apis-section"',
			'id="connectivity-section"',
			'cta-main-dark',
			'Learn more',
			'orbit-product-icon-img',
			'sectionHashMap',
			'devotel-cached-snapshot',
			'data-source="extracted-widget"',
			'elementor-page-495',
			'post-495',
			'products.css',
			'Ready to Transform Your Customer Communications',
		);
	} elseif ( 'home' === $name ) {
		$checks = array(
			'devotel-solutions',
			'devotel-solutions-root',
			'Reach Every Customer. Power Every Network.',
			'devotel-home-solutions-hero',
			'devotel-home-solutions-hero-preload',
			'sp-section',
			'sp-eyebrow',
			'sp-logo-grid',
			'sp-grid-separator-h-row',
			'Trusted by 500+ leading brands across industries',
			'devotel-social-proof-partners',
			'devotel-social-proof-partners-flip',
			'duc-use-cases',
			'devotel-product-use-cases',
			'Notification &amp; Campaigns',
			'eSIM Connectivity',
			'devotel-home-product-use-cases',
			'devotel-home-product-use-cases-preload',
			'What Our Customers Say',
			'Insights from the Telecom Industry',
			'elementor-1027',
			'post-1027',
		);
		$checks[] = 'absent: elementor-element-09ee701';
		$checks[] = 'absent: Connect with Every Customer';
		$checks[] = 'absent: Try it for free';
		$checks[] = 'absent: dvthm-prdsec';
		$checks[] = 'absent: What You Need to Succeed';
		$checks[] = 'absent: </section>>';
	} elseif ( isset( $comm_checks[ $name ] ) ) {
		$checks = $comm_checks[ $name ];
		$checks[] = 'sp-section';
		$checks[] = 'sp-eyebrow';
		$checks[] = 'sp-logo-grid';
		$checks[] = 'sp-grid-separator-h-row';
		$checks[] = 'devotel-social-proof-partners';
		$checks[] = 'devotel-social-proof-partners-flip';
		$checks[] = 'main.css';
		if ( 'comm-sms' === $name ) {
			$checks[] = 'elementor-element-30937a10';
			$checks[] = $comm_smush_bad;
		}
		$checks[] = '<!DOCTYPE html><br';
		$checks[] = 'localhost/conversion';
	} elseif ( isset( $platform_checks[ $name ] ) ) {
		$checks = $platform_checks[ $name ];
		$checks[] = 'sp-section';
		$checks[] = 'sp-eyebrow';
		$checks[] = 'sp-logo-grid';
		$checks[] = 'sp-grid-separator-h-row';
		$checks[] = 'devotel-social-proof-partners';
		$checks[] = 'devotel-social-proof-partners-flip';
		$checks[] = 'main.css';
		$checks[] = '<!DOCTYPE html><br';
		$checks[] = 'localhost/conversion';
		$checks[] = 'entry-title';
	} elseif ( isset( $telco_checks[ $name ] ) ) {
		$checks = $telco_checks[ $name ];
		$checks[] = 'sp-section';
		$checks[] = 'sp-eyebrow';
		$checks[] = 'sp-logo-grid';
		$checks[] = 'sp-grid-separator-h-row';
		$checks[] = 'devotel-social-proof-partners';
		$checks[] = 'devotel-social-proof-partners-flip';
		$checks[] = 'devotel-cached-snapshot';
		$checks[] = 'data-source="extracted-widget"';
		$checks[] = 'devotel-product-subpage';
		$checks[] = 'product-subpage.css';
		$checks[] = 'main.css';
		$checks[] = '<!DOCTYPE html><br';
		$checks[] = 'localhost/conversion';
		$checks[] = 'entry-title';
	} elseif ( isset( $sim_checks[ $name ] ) ) {
		$checks = $sim_checks[ $name ];
		$checks[] = 'main.css';
		$checks[] = '<!DOCTYPE html><br';
		$checks[] = 'localhost/conversion';
		$checks[] = 'entry-title';
	} elseif ( 'blog' === $name ) {
		$checks = array(
			'The Devotel Blog',
			'Your go-to resource for expert tips and insights',
			'devotel-blog-page',
			'elementor-page-872',
			'elementor-872',
			'elementor-element-504959e',
			'elementor-element-b617508',
			'elementor-element-3814e06',
			'data-source="theme-blog"',
			'devotel-blog-archive',
			'devotel-site-cta',
			'cta-section-container',
			'devotel-blog-title-arrow',
			'Talk to an expert',
			'class="elementor-pagination"',
			'blog-pagination.js',
			'blog-filters.js',
			'cta.css',
			'post-872',
			'blog.css',
			'post-880',
			'entry-title',
			'devotel-blog-show-more',
			'Start your project',
			'Talk to Sales',
			'Try it for free',
		);
	} elseif ( 'blog-single' === $name ) {
		$checks = array(
			'Business Messaging 101',
			'devotel-blog-single-page',
			'elementor-page-908',
			'elementor-908',
			'devotel-blog-single',
			'data-source="theme-blog"',
			'id="blogsss"',
			'entry-content',
			'post-908',
			'post-880.css',
			'blog.css',
			'cta.css',
			'blog-single-toc.js',
			'Table of contents',
			'devotel-blog-toc-sticky',
			'devotel-site-cta',
			'cta-section-container',
			'Ready to Transform Your Customer Communications',
			'Talk to an expert',
			'Our blog',
			'Latest blog posts',
			'See all posts',
			'elementor-element-fad9316',
			'elementor-element-3343994',
			'elementor-element-72570d9',
			'elementor-author-box',
			'November 30, 2025',
			'devotel-blog-related-card',
			'blog-single-share.js',
			'elementor-share-btn',
			'elementor-element-f47042b',
			'entry-title',
		);
	} elseif ( 'about' === $name ) {
		$checks = array(
			'Try it for free',
			'7ee2817',
			'cb4f458',
			'2c18098',
			'910680a',
			'6d9a1aa',
			'59be7c5',
			'79d494a',
			'480d110',
			'a8b7b70',
			'1dd90da',
			'Empowering Global',
			'Instantly Everywhere',
			'devotel-about-page',
			'post-12',
		);
	} else {
		$checks = array(
			'9e6c16f',
			'id="blueback"',
			'e3241fe',
			'f7c355e',
			'88b8c88',
			'Get in touch',
			'Our locations',
			'AMERICAS',
			'devotel-contact-page',
			'post-21',
		);
	}

	$blog_absent       = array( 'entry-title', 'devotel-blog-show-more', 'Try it for free', 'Start your project', 'Talk to Sales' );
	$site_cta_absent   = array( 'Try it for free' );
	$site_cta_routes   = array( 'home', 'products', 'about', 'blog' );

	foreach ( $checks as $needle ) {
		if ( str_starts_with( $needle, 'absent: ' ) ) {
			$absent_needle = substr( $needle, 8 );
			$ok            = false === stripos( $html, $absent_needle );
			echo ( $ok ? '  OK ' : ' BAD' ) . " absent: $absent_needle\n";
			continue;
		}
		if ( in_array( $name, $site_cta_routes, true ) && in_array( $needle, $site_cta_absent, true ) ) {
			$ok = false === stripos( $html, $needle );
			echo ( $ok ? '  OK ' : ' BAD' ) . " absent: $needle\n";
			continue;
		}
		if ( 'blog' === $name && in_array( $needle, $blog_absent, true ) ) {
			if ( 'entry-title' === $needle ) {
				$ok = false === stripos( $html, 'class="entry-title"' );
			} else {
				$ok = false === stripos( $html, $needle );
			}
			echo ( $ok ? '  OK ' : ' BAD' ) . " absent: $needle\n";
			continue;
		}
		if ( 'blog-single' === $name && 'entry-title' === $needle ) {
			$ok = false === stripos( $html, 'class="entry-title"' );
			echo ( $ok ? '  OK ' : ' BAD' ) . " absent: $needle\n";
			continue;
		}
		if ( 'blog-single' === $name && 'min read' === $needle ) {
			$ok = false === stripos( $html, 'min read' );
			echo ( $ok ? '  OK ' : ' BAD' ) . " absent: $needle\n";
			continue;
		}
		if ( ( isset( $comm_checks[ $name ] ) || isset( $platform_checks[ $name ] ) || isset( $telco_checks[ $name ] ) || isset( $sim_checks[ $name ] ) ) && in_array( $needle, array( '<!DOCTYPE html><br', 'localhost/conversion', 'entry-title' ), true ) ) {
			$ok = false === stripos( $html, $needle );
			echo ( $ok ? '  OK ' : ' BAD' ) . " absent: $needle\n";
			continue;
		}
		if ( 'comm-sms' === $name && $comm_smush_bad === $needle ) {
			$ok = false === stripos( $html, $needle );
			echo ( $ok ? '  OK ' : ' BAD' ) . " absent: $needle\n";
			continue;
		}
		if ( isset( $asset_handle_map[ $needle ] ) ) {
			$ok = devotel_verify_html_has_asset( $html, $needle, $asset_handle_map[ $needle ] );
		} elseif ( preg_match( '/^post-(\d+)\.css$/', $needle, $legacy_match ) ) {
			$legacy_id      = (int) $legacy_match[1];
			$legacy_handles = array(
				'devotel-route-legacy-post-' . $legacy_id,
				'devotel-legacy-post-' . $legacy_id,
			);
			$ok             = false;
			foreach ( $legacy_handles as $legacy_handle ) {
				if ( devotel_verify_html_has_asset( $html, $needle, $legacy_handle ) ) {
					$ok = true;
					break;
				}
			}
		} else {
			$ok = false !== stripos( $html, $needle );
		}
		echo ( $ok ? '  OK ' : ' MISS' ) . " $needle\n";
	}

	if ( 'contact' === $name ) {
		$pos = array();
		foreach ( array( 'Get in touch', 'Our locations', 'AMERICAS' ) as $t ) {
			$p = stripos( $html, $t );
			if ( false !== $p ) {
				$pos[ $t ] = $p;
			}
		}
		asort( $pos );
		echo '  order: ' . implode( ' < ', array_keys( $pos ) ) . "\n";
		echo '  wpcf7: ' . preg_match_all( '/class=["\']wpcf7[\s"\']/i', $html ) . "\n";
	}
	echo "\n";
}
