<?php
/**
 * Footer markup — structure matches footer.html reference for nth-child CSS.
 *
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$devotel_footer_uploads = trailingslashit( home_url( '/wp-content/uploads' ) );
$devotel_home           = home_url( '/' );
$devotel_privacy_url    = 'https://devotel.com/privacy-policy/';
$devotel_brand_kit_url  = 'https://devotel.com/brand-kit/';
$devotel_linkedin_url   = 'https://www.linkedin.com/company/devotel';
?>
<div id="devotel-footer-wrapper" class="devotel-footer">
	<div class="devotel-footer-top">
		<div class="devotel-footer-top-inner">
			<div class="devotel-footer-top-stack">
				<div class="devotel-footer-brand-row">
					<div class="devotel-footer-brand">
						<div class="devotel-footer-brand-text">
							<img src="<?php echo esc_url( $devotel_footer_uploads . '2025/11/white-logo.svg' ); ?>" alt="devotel" class="devotel-footer-logo" width="126" height="34">
							<div class="devotel-footer-description">Innovating in the telecommunications sector since 2018, Devotel specialises in delivering comprehensive communication and connectivity solutions globally.</div>
						</div>
						<div class="devotel-footer-certs">
							<div class="devotel-cert-badge">
								<div class="devotel-cert-badge-container">
									<div class="devotel-cert-badge-icon">
										<img src="<?php echo esc_url( $devotel_footer_uploads . '2026/01/ISO.svg' ); ?>" alt="CCPA" class="devotel-cert-badge-img" width="46" height="46">
									</div>
									<div class="devotel-cert-badge-label">
										<div class="devotel-cert-badge-label-text">
											<span class="label-line-first">CCPA</span>
											<span class="label-line-second">COMPLIANT</span>
										</div>
									</div>
								</div>
							</div>
							<div class="devotel-cert-badge">
								<div class="devotel-cert-badge-container">
									<div class="devotel-cert-badge-icon">
										<img src="<?php echo esc_url( $devotel_footer_uploads . '2026/01/Vector.svg' ); ?>" alt="GDPR" class="devotel-cert-badge-img" width="46" height="46">
									</div>
									<div class="devotel-cert-badge-label">
										<div class="devotel-cert-badge-label-text">
											<span class="label-line-first">GDPR</span>
											<span class="label-line-second">COMPLIANT</span>
										</div>
									</div>
								</div>
							</div>
							<div class="devotel-cert-badge">
								<div class="devotel-cert-badge-container">
									<div class="devotel-cert-badge-icon">
										<img src="<?php echo esc_url( $devotel_footer_uploads . '2026/01/Cyber-Essentials.png' ); ?>" alt="AICPA SOC" class="devotel-cert-badge-img" width="46" height="46">
									</div>
									<div class="devotel-cert-badge-label">
										<div class="devotel-cert-badge-label-text">
											<span class="label-line-first">SOC 2</span>
											<span class="label-line-second">TYPE II</span>
										</div>
									</div>
								</div>
							</div>
							<div class="devotel-cert-badge">
								<div class="devotel-cert-badge-container">
									<div class="devotel-cert-badge-icon">
										<img src="<?php echo esc_url( $devotel_footer_uploads . '2026/01/ISO.svg' ); ?>" alt="EU DATA HOSTING" class="devotel-cert-badge-img" width="46" height="46">
									</div>
									<div class="devotel-cert-badge-label">
										<div class="devotel-cert-badge-label-text">
											<span class="label-line-first">EU</span>
											<span class="label-line-second">DATA HOSTING</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="devotel-footer-newsletter">
						<div class="devotel-footer-newsletter-header">
							<div class="devotel-footer-newsletter-title">Devotel Newsletter</div>
							<div class="devotel-footer-newsletter-subtitle">The latest experience tips and trends. No spam!</div>
						</div>
						<div class="wpcf7-newsletter-wrapper">
							<div class="wpcf7 no-js" id="wpcf7-f9119-o3" lang="en-US" dir="ltr" data-wpcf7-id="9119">
								<div class="screen-reader-response"><p role="status" aria-live="polite" aria-atomic="true"></p><ul></ul></div>
								<form action="/#wpcf7-f9119-o3" method="post" class="wpcf7-form init" aria-label="Contact form" novalidate="novalidate" data-status="init">
									<fieldset class="hidden-fields-container">
										<input type="hidden" name="_wpcf7" value="9119">
										<input type="hidden" name="_wpcf7_version" value="6.1.6">
										<input type="hidden" name="_wpcf7_locale" value="en_US">
										<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f9119-o3">
										<input type="hidden" name="_wpcf7_container_post" value="0">
										<input type="hidden" name="_wpcf7_posted_data_hash" value="">
										<input type="hidden" name="_wpcf7_recaptcha_response" value="">
									</fieldset>
									<div class="devotel-newsletter-field">
										<span class="wpcf7-form-control-wrap" data-name="newsletter-email">
											<input size="40" maxlength="400" class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email devotel-newsletter-input" id="devotel-newsletter-email" aria-required="true" aria-invalid="false" placeholder="Enter your email" value="" type="email" name="newsletter-email">
										</span>
									</div>
									<p class="devotel-newsletter-submit">
										<input class="wpcf7-form-control wpcf7-submit has-spinner devotel-subscribe-btn" id="devotel-subscribe-btn" type="submit" value="Subscribe">
									</p>
									<div class="wpcf7-response-output" aria-hidden="true"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="devotel-footer-nav">
					<div class="devotel-footer-nav-col">
						<div class="devotel-footer-nav-title">Communication APIs</div>
						<div class="devotel-footer-nav-links">
							<a href="<?php echo esc_url( $devotel_home . 'products/communication-apis/whatsapp-business/' ); ?>">WhatsApp Business API</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/communication-apis/sms/' ); ?>">SMS</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/communication-apis/rcs/' ); ?>">RCS</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/communication-apis/email/' ); ?>">Email</a>
						</div>
					</div>
					<div class="devotel-footer-nav-col">
						<div class="devotel-footer-nav-title">Platforms</div>
						<div class="devotel-footer-nav-links">
							<a href="<?php echo esc_url( $devotel_home . 'products/platforms/cmp/' ); ?>">CMP</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/platforms/orbit/' ); ?>">Orbit</a>
							<a href="https://esimora.com/">Esimora</a>
							<a href="https://hub.devotel.com/#home">Devhub</a>
						</div>
					</div>
					<div class="devotel-footer-nav-col">
						<div class="devotel-footer-nav-title">Telco</div>
						<div class="devotel-footer-nav-links">
							<a href="<?php echo esc_url( $devotel_home . 'products/telco/sms-solutions-for-telco/' ); ?>">Messaging</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/telco/voice-solutions/' ); ?>">Voice</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/telco/sms-firewall/' ); ?>">SMS Firewall</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/telco/voice-firewall/' ); ?>">Voice Firewall</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/telco/sms-monetisation/' ); ?>">SMS Monetisation</a>
							<a href="<?php echo esc_url( $devotel_home . 'products/telco/voice-monetisation/' ); ?>">Voice Monetisation</a>
						</div>
					</div>
					<div class="devotel-footer-nav-col">
						<div class="devotel-footer-nav-title">Resources</div>
						<div class="devotel-footer-nav-links">
							<a href="<?php echo esc_url( $devotel_home . 'blog/' ); ?>">Blog</a>
						</div>
					</div>
					<div class="devotel-footer-nav-col">
						<div class="devotel-footer-nav-title">Company</div>
						<div class="devotel-footer-nav-links">
							<a href="<?php echo esc_url( $devotel_home . 'about-us/' ); ?>">About Devotel</a>
							<a href="<?php echo esc_url( $devotel_home . 'contact-us/' ); ?>">Contact Us</a>
							<a href="<?php echo esc_url( $devotel_privacy_url ); ?>">Privacy Policy</a>
							<a href="<?php echo esc_url( $devotel_brand_kit_url ); ?>">Brand Kit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="devotel-footer-bottom">
		<div class="devotel-footer-bottom-inner">
			<div class="devotel-footer-bottom-row">
				<div class="devotel-footer-legal">
					<div class="devotel-footer-legal-links">
						<div class="devotel-footer-copyright">&copy; 2026 Devotel LTD. All rights reserved.</div>
						<a href="<?php echo esc_url( $devotel_privacy_url ); ?>">Privacy Policy</a>
						<a href="<?php echo esc_url( $devotel_brand_kit_url ); ?>">Brand Kit</a>
					</div>
				</div>
				<div class="devotel-footer-social">
					<a href="<?php echo esc_url( $devotel_linkedin_url ); ?>" target="_blank" rel="noopener noreferrer" class="devotel-footer-social-link" aria-label="LinkedIn">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M16.6676 0H1.32891C0.594141 0 0 0.580078 0 1.29727V16.6992C0 17.4164 0.594141 18 1.32891 18H16.6676C17.4023 18 18 17.4164 18 16.7027V1.29727C18 0.580078 17.4023 0 16.6676 0ZM5.34023 15.3387H2.66836V6.74648H5.34023V15.3387ZM4.0043 5.57578C3.14648 5.57578 2.45391 4.8832 2.45391 4.02891C2.45391 3.17461 3.14648 2.48203 4.0043 2.48203C4.85859 2.48203 5.55117 3.17461 5.55117 4.02891C5.55117 4.87969 4.85859 5.57578 4.0043 5.57578ZM15.3387 15.3387H12.6703V11.1621C12.6703 10.1672 12.6527 8.88398 11.2816 8.88398C9.89297 8.88398 9.68203 9.97031 9.68203 11.0918V15.3387H7.01719V6.74648H9.57656V7.9207H9.61172C9.9668 7.2457 10.8387 6.53203 12.1359 6.53203C14.8395 6.53203 15.3387 8.31094 15.3387 10.6242V15.3387Z" fill="#62748e"/>
</svg>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
