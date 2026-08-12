<?php
/**
 * Extracted from Elementor HTML widget: f69cb00
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>.testimonials-section,.testimonials-section *{box-sizing:border-box}.testimonials-section{background:#fff;padding:140px 100px 140px 100px;display:flex;flex-direction:column;gap:var(--spacing-7xl,64px);align-items:center;justify-content:flex-start;flex-shrink:0;position:relative;overflow:hidden}.testimonials-intro{display:flex;flex-direction:column;gap:32px;align-items:center;justify-content:center;flex-shrink:0;width:550px;position:relative}.testimonials-title-block{display:flex;flex-direction:column;gap:16px;align-items:center;justify-content:center;align-self:stretch;flex-shrink:0;position:relative}.testimonials-eyebrow{color:var(--text-text-brand-primary,#325fec);text-align:center;font-family:var(--text-sm-semibold-eyebrow-font-family,"Inter-SemiBold",sans-serif);font-size:var(--text-sm-semibold-eyebrow-font-size,14px);line-height:var(--text-sm-semibold-eyebrow-line-height,20px);font-weight:var(--text-sm-semibold-eyebrow-font-weight,600);text-transform:uppercase;position:relative;align-self:stretch}.testimonials-heading{color:var(--text-text-primary,#0f172b);text-align:center;font-family:var(--heading-lg-semibold-font-family,"Inter-SemiBold",sans-serif);font-size:var(--heading-lg-semibold-font-size,36px);line-height:var(--heading-lg-semibold-line-height,44px);letter-spacing:var(--heading-lg-semibold-letter-spacing,-.02em);font-weight:var(--heading-lg-semibold-font-weight,600);position:relative}.testimonials-description{color:var(--text-text-tertiary,#45556c);text-align:center;font-family:var(--text-lg-regular-font-family,"Inter-Regular",sans-serif);font-size:var(--text-lg-regular-font-size,18px);line-height:var(--text-lg-regular-line-height,28px);font-weight:var(--text-lg-regular-font-weight,400);position:relative;width:548px}.testimonials-cards-outer{padding:0 40px 0 40px;display:flex;flex-direction:column;gap:var(--spacing-4xl,32px);align-items:flex-start;justify-content:flex-start;align-self:stretch;flex-shrink:0;position:relative}.testimonials-cards-inner{display:flex;flex-direction:column;gap:var(--spacing-5xl,40px);align-items:center;justify-content:flex-start;align-self:stretch;flex-shrink:0;position:relative}.testimonials-bg-blur{opacity:.2;flex-shrink:0;width:1166px;height:375px;position:absolute;left:101.98px;top:99.04px;transform-origin:0 0;transform:rotate(15.781deg) scale(1,1)}.testimonials-bg-ellipse-teal{background:#358c82;border-radius:50%;width:450.15px;height:289.03px;position:absolute;left:93.69px;top:55.33px;transform-origin:0 0;transform:rotate(-3.085deg) scale(.999,1.001);filter:blur(151.69px)}.testimonials-bg-ellipse-blue{background:#518efd;border-radius:50%;width:447.71px;height:287.05px;position:absolute;left:318.4px;top:-10.48px;transform-origin:0 0;transform:rotate(-3.085deg) scale(.999,1.001);filter:blur(173.43px)}.testimonials-bg-ellipse-cyan{background:#32b4ec;border-radius:50%;width:323.98px;height:208.14px;position:absolute;left:650.47px;top:98.56px;transform-origin:0 0;transform:rotate(-3.085deg) scale(.999,1.001);filter:blur(151.69px)}.testimonials-cards{display:flex;flex-direction:row;gap:16px;align-items:flex-start;justify-content:flex-start;align-self:stretch;flex-shrink:0;height:861px;position:relative;overflow:hidden}.testimonials-column{padding:var(--spacing-4xl,32px) 0 0 0;display:flex;flex-direction:column;align-items:flex-start;justify-content:flex-start;flex:1;position:relative;overflow:hidden}.testimonials-column--center{padding:var(--spacing-4xl,32px) 0 0 0}.testimonials-column--right{padding:var(--spacing-5xl,40px) 0 0 0}.testimonials-columns-desktop{display:flex;flex-direction:row;gap:16px;align-items:flex-start;justify-content:flex-start;flex:1;align-self:stretch;position:relative;min-width:0}.testimonials-column-track{display:flex;flex-direction:column;gap:16px;align-items:stretch;justify-content:flex-start;width:100%;flex-shrink:0}.testimonials-column--left .testimonials-column-track{animation:testimonials-scroll-top-down 20s linear infinite}.testimonials-column--center .testimonials-column-track{animation:testimonials-scroll-down-up 20s linear infinite}.testimonials-column--right .testimonials-column-track{animation:testimonials-scroll-top-down 20s linear infinite}.testimonials-column-track{--testimonials-loop-gap:16px;--testimonials-loop-distance:calc(50% + (var(--testimonials-loop-gap) / 2));will-change:transform}@keyframes testimonials-scroll-top-down{0%{transform:translateY(0)}100%{transform:translateY(calc(-1 * var(--testimonials-loop-distance)))}}@keyframes testimonials-scroll-down-up{0%{transform:translateY(calc(-1 * var(--testimonials-loop-distance)))}100%{transform:translateY(0)}}.testimonial-card{background:#fff;border-radius:32px;border:1px solid var(--border-border-secondary,#e2e8f0);padding:var(--spacing-4xl,32px);display:flex;flex-direction:column;gap:40px;align-items:flex-start;justify-content:flex-start;flex-shrink:0;position:relative;width:100%}.testimonial-card-body{display:flex;flex-direction:column;gap:16px;align-items:flex-start;justify-content:flex-start;align-self:stretch;flex-shrink:0;position:relative}.testimonial-card-logo-wrap{flex-shrink:0;min-height:48px;display:flex;align-items:center;justify-content:flex-start;position:relative}.testimonial-card-logo-wrap img{max-width:180px;max-height:48px;width:auto;height:auto;object-fit:contain}.testimonial-card-quote{color:var(--text-text-tertiary,#45556c);text-align:left;font-family:var(--text-md-regular-font-family,"Inter-Regular",sans-serif);font-size:var(--text-md-regular-font-size,16px);line-height:var(--text-md-regular-line-height,24px);font-weight:var(--text-md-regular-font-weight,400);position:relative;align-self:stretch}.testimonial-card-footer{display:flex;flex-direction:row;gap:var(--spacing-lg,12px);align-items:center;justify-content:flex-start;align-self:stretch;flex-shrink:0;position:relative}.testimonial-card-author{display:flex;flex-direction:column;gap:0;align-items:flex-start;justify-content:flex-start;flex:1;position:relative}.testimonial-card-author-name{color:var(--text-text-primary,#0f172b);text-align:left;font-family:var(--text-md-semibold-font-family,"Inter-SemiBold",sans-serif);font-size:var(--text-md-semibold-font-size,16px);line-height:var(--text-md-semibold-line-height,24px);font-weight:var(--text-md-semibold-font-weight,600);position:relative}.testimonial-card-author-role{color:var(--text-text-tertiary,#45556c);text-align:left;font-family:var(--text-sm-regular-font-family,"Inter-Regular",sans-serif);font-size:var(--text-sm-regular-font-size,14px);line-height:var(--text-sm-regular-line-height,20px);font-weight:var(--text-sm-regular-font-weight,400);position:relative;align-self:stretch}.testimonials-fade-top{width:100%;background:linear-gradient(0deg,#fff0 0%,rgb(255 255 255 / .01) 8.07%,rgb(255 255 255 / .02) 15.54%,rgb(255 255 255 / .05) 22.5%,rgb(255 255 255 / .08) 29.04%,rgb(255 255 255 / .13) 35.26%,rgb(255 255 255 / .18) 41.25%,rgb(255 255 255 / .25) 47.1%,rgb(255 255 255 / .32) 52.9%,rgb(255 255 255 / .4) 58.75%,rgb(255 255 255 / .48) 64.74%,rgb(255 255 255 / .58) 70.96%,rgb(255 255 255 / .67) 77.5%,rgb(255 255 255 / .78) 84.46%,rgb(255 255 255 / .89) 91.93%,rgb(255 255 255) 100%);flex-shrink:0;height:200px;position:absolute;left:0;top:0;pointer-events:none}.testimonials-fade-bottom{background:linear-gradient(180deg,#fff0 0%,rgb(255 255 255 / .01) 8.07%,rgb(255 255 255 / .02) 15.54%,rgb(255 255 255 / .05) 22.5%,rgb(255 255 255 / .08) 29.04%,rgb(255 255 255 / .13) 35.26%,rgb(255 255 255 / .18) 41.25%,rgb(255 255 255 / .25) 47.1%,rgb(255 255 255 / .32) 52.9%,rgb(255 255 255 / .4) 58.75%,rgb(255 255 255 / .48) 64.74%,rgb(255 255 255 / .58) 70.96%,rgb(255 255 255 / .67) 77.5%,rgb(255 255 255 / .78) 84.46%,rgb(255 255 255 / .89) 91.93%,rgb(255 255 255) 100%);flex-shrink:0;width:100%;height:200px;position:absolute;left:0;bottom:0;pointer-events:none;z-index:2}.testimonials-fade-top{z-index:2}@media (max-width:768px){.testimonials-section{padding:64px 0 64px 0;gap:32px;background:#F9FAFB}.testimonials-intro{width:100%;max-width:100%;padding:0 16px;gap:16px}.testimonials-description{width:100%;max-width:100%;padding:0 16px}.testimonials-cards-outer{padding:0;width:100%}.testimonials-cards-inner{padding:0 8px;width:100%;box-sizing:border-box;position:relative;overflow:visible}.testimonials-cards{height:1092px;min-height:1092px;flex-direction:column;width:100%;padding:32px 0 0 0;box-sizing:border-box;position:relative;overflow:hidden}.testimonials-columns-desktop{display:none!important}.testimonials-column-mobile{display:flex!important;flex:1;min-width:0;width:100%;padding:0 8px;box-sizing:border-box;z-index:0;position:relative}.testimonials-column-mobile .testimonials-column-track{animation:testimonials-scroll-top-down 35s linear infinite;gap:16px}.testimonials-column-mobile .testimonial-card{width:100%;min-width:0;border-radius:16px;padding:24px}.testimonials-fade-top{position:absolute;top:0;left:0;right:0;width:100%;height:140px;z-index:100;pointer-events:none;background:linear-gradient(to top,transparent 0%,rgb(249 250 251 / .3) 30%,rgb(249 250 251 / .7) 60%,#F9FAFB 100%)}.testimonials-fade-bottom{position:absolute;bottom:0;left:0;right:0;width:100%;height:140px;z-index:100;pointer-events:none;background:linear-gradient(to bottom,transparent 0%,rgb(249 250 251 / .3) 30%,rgb(249 250 251 / .7) 60%,#F9FAFB 100%)}}@media (min-width:769px){.testimonials-cards-outer{align-self:center;width:100%;max-width:1320px}.testimonials-cards-inner{align-self:center;width:100%;max-width:1320px;margin-left:auto;margin-right:auto}.testimonials-cards{align-self:center;width:100%;max-width:1240px;margin-left:auto;margin-right:auto}.testimonials-columns-desktop{flex:none;width:100%;max-width:1240px;margin-left:auto;margin-right:auto}.testimonials-column{flex:1 1 0;min-width:0;max-width:calc((1240px - 32px)/3)}.testimonial-card{width:100%;max-width:100%}.testimonials-column-mobile{display:none!important}}</style><div
class="testimonials-section"><div
class="testimonials-intro"><div
class="testimonials-title-block"><div
class="testimonials-eyebrow">DELIVERING RESULTS WORLDWIDE</div><div
class="testimonials-heading">What Our Customers Say</div></div><div
class="testimonials-description">
See how companies around the globe are achieving their goals with Devotel's solutions and services.</div></div><div
class="testimonials-cards-outer"><div
class="testimonials-cards-inner"><div
class="testimonials-bg-blur"><div
class="testimonials-bg-ellipse-teal"></div><div
class="testimonials-bg-ellipse-blue"></div><div
class="testimonials-bg-ellipse-cyan"></div></div><div
class="testimonials-cards"><div
class="testimonials-columns-desktop"><div
class="testimonials-column testimonials-column--left"><div
class="testimonials-column-track"><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-2.png" alt="TDNT" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 169px; --smush-placeholder-aspect-ratio: 169/68;" /></div><div
class="testimonial-card-quote">My experience with Devotel's products and services has been exceptional and results for our business have been excellent.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Zak Nehme</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-1.png" alt="Carrier Italia" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 239px; --smush-placeholder-aspect-ratio: 239/68;" /></div><div
class="testimonial-card-quote">Devotel is an excellent partner for our business. Their flexibility and tier-1 routes make all the difference.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Pierpaolo Aluise</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-3.png" alt="Baway" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 240px; --smush-placeholder-aspect-ratio: 240/68;" /></div><div
class="testimonial-card-quote">Devotel provides excellence service that keeps our business running smoothly. Their support team is responsive and always resolves issues quickly.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Snizhana Yurchenko</div><div
class="testimonial-card-author-role">Carrier Relations Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-2.png" alt="TDNT" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 169px; --smush-placeholder-aspect-ratio: 169/68;" /></div><div
class="testimonial-card-quote">My experience with Devotel's products and services has been exceptional and results for our business have been excellent.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Zak Nehme</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-1.png" alt="Carrier Italia" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 239px; --smush-placeholder-aspect-ratio: 239/68;" /></div><div
class="testimonial-card-quote">Devotel is an excellent partner for our business. Their flexibility and tier-1 routes make all the difference.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Pierpaolo Aluise</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-3.png" alt="Baway" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 240px; --smush-placeholder-aspect-ratio: 240/68;" /></div><div
class="testimonial-card-quote">Devotel provides excellence service that keeps our business running smoothly. Their support team is responsive and always resolves issues quickly.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Snizhana Yurchenko</div><div
class="testimonial-card-author-role">Carrier Relations Manager</div></div></div></div></div></div><div
class="testimonials-column testimonials-column--center"><div
class="testimonials-column-track"><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame.png" alt="Mediafon" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 204px; --smush-placeholder-aspect-ratio: 204/68;" /></div><div
class="testimonial-card-quote">The Devotel team is highly professional, dedicated, and reliable.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Tarcencova Evghenia</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/chintelecom-logo-1024x280-1.png" alt="China Telecom Global" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 1024px; --smush-placeholder-aspect-ratio: 1024/280;" /></div><div
class="testimonial-card-quote">The team is very responsive, the prices are competitive, and the routes work well.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Polly Xu</div><div
class="testimonial-card-author-role">Business Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/Complete-logo-without-BG.png" alt="Kite Telco LTD" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 587px; --smush-placeholder-aspect-ratio: 587/195;" /></div><div
class="testimonial-card-quote">We've had an excellent experience working together. Both companies have seen growth in revenue and profitability, and I'm confident that together we can achieve 3x growth in 2026.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Muhammad Waqas</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame.png" alt="Mediafon" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 204px; --smush-placeholder-aspect-ratio: 204/68;" /></div><div
class="testimonial-card-quote">The Devotel team is highly professional, dedicated, and reliable.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Tarcencova Evghenia</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/chintelecom-logo-1024x280-1.png" alt="China Telecom Global" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 1024px; --smush-placeholder-aspect-ratio: 1024/280;" /></div><div
class="testimonial-card-quote">The team is very responsive, the prices are competitive, and the routes work well.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Polly Xu</div><div
class="testimonial-card-author-role">Business Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/Complete-logo-without-BG.png" alt="Kite Telco LTD" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 587px; --smush-placeholder-aspect-ratio: 587/195;" /></div><div
class="testimonial-card-quote">We've had an excellent experience working together. Both companies have seen growth in revenue and profitability, and I'm confident that together we can achieve 3x growth in 2026.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Muhammad Waqas</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div></div></div><div
class="testimonials-column testimonials-column--right"><div
class="testimonials-column-track"><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/image-1217.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Devotel has consistently proven to be a trusted and professional partner. Our collaboration has been built on a strong foundation of trust and transparency, which has allowed us to develop a solid and effective working relationship.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Andra-Ioana Podar</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Gemini_Generated_Image_smglahsmglahsmgl-1.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">During the past 6 years, Devotel always showed high level of technical expertise and knowledge of the market and made a significant contribution to evolution of our products.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Dmitry Stafeev</div><div
class="testimonial-card-author-role">CEO</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Group-1321315692.svg" alt="Duo Creative & Software" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Delivery is reliable, integrations are straightforward, and we haven't had any major issues. Support is responsive when needed, which makes things much easier.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Umutcan Olgun</div><div
class="testimonial-card-author-role">CEO</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/image-1217.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Devotel has consistently proven to be a trusted and professional partner. Our collaboration has been built on a strong foundation of trust and transparency, which has allowed us to develop a solid and effective working relationship.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Andra-Ioana Podar</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Gemini_Generated_Image_smglahsmglahsmgl-1.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">During the past 6 years, Devotel always showed high level of technical expertise and knowledge of the market and made a significant contribution to evolution of our products.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Dmitry Stafeev</div><div
class="testimonial-card-author-role">CEO</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap">
<img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Group-1321315692.svg" alt="Duo Creative & Software" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Delivery is reliable, integrations are straightforward, and we haven't had any major issues. Support is responsive when needed, which makes things much easier.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Umutcan Olgun</div><div
class="testimonial-card-author-role">CEO</div></div></div></div></div></div></div><div
class="testimonials-column testimonials-column-mobile"><div
class="testimonials-column-track"><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-2.png" alt="TDNT" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 169px; --smush-placeholder-aspect-ratio: 169/68;" /></div><div
class="testimonial-card-quote">My experience with Devotel's products and services has been exceptional and results for our business have been excellent.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Zak Nehme</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-1.png" alt="Carrier Italia" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 239px; --smush-placeholder-aspect-ratio: 239/68;" /></div><div
class="testimonial-card-quote">Devotel is an excellent partner for our business. Their flexibility and tier-1 routes make all the difference.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Pierpaolo Aluise</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-3.png" alt="Baway" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 240px; --smush-placeholder-aspect-ratio: 240/68;" /></div><div
class="testimonial-card-quote">Devotel provides excellence service that keeps our business running smoothly. Their support team is responsive and always resolves issues quickly.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Snizhana Yurchenko</div><div
class="testimonial-card-author-role">Carrier Relations Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame.png" alt="Mediafon" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 204px; --smush-placeholder-aspect-ratio: 204/68;" /></div><div
class="testimonial-card-quote">The Devotel team is highly professional, dedicated, and reliable.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Tarcencova Evghenia</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/chintelecom-logo-1024x280-1.png" alt="China Telecom Global" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 1024px; --smush-placeholder-aspect-ratio: 1024/280;" /></div><div
class="testimonial-card-quote">The team is very responsive, the prices are competitive, and the routes work well.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Polly Xu</div><div
class="testimonial-card-author-role">Business Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/Complete-logo-without-BG.png" alt="Kite Telco LTD" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 587px; --smush-placeholder-aspect-ratio: 587/195;" /></div><div
class="testimonial-card-quote">We've had an excellent experience working together. Both companies have seen growth in revenue and profitability, and I'm confident that together we can achieve 3x growth in 2026.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Muhammad Waqas</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/image-1217.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Devotel has consistently proven to be a trusted and professional partner. Our collaboration has been built on a strong foundation of trust and transparency.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Andra-Ioana Podar</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Gemini_Generated_Image_smglahsmglahsmgl-1.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">During the past 6 years, Devotel always showed high level of technical expertise and knowledge of the market and made a significant contribution to evolution of our products.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Dmitry Stafeev</div><div
class="testimonial-card-author-role">CEO</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Group-1321315692.svg" alt="Duo Creative & Software" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Delivery is reliable, integrations are straightforward, and we haven't had any major issues. Support is responsive when needed, which makes things much easier.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Umutcan Olgun</div><div
class="testimonial-card-author-role">CEO</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-2.png" alt="TDNT" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 169px; --smush-placeholder-aspect-ratio: 169/68;" /></div><div
class="testimonial-card-quote">My experience with Devotel's products and services has been exceptional and results for our business have been excellent.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Zak Nehme</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-1.png" alt="Carrier Italia" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 239px; --smush-placeholder-aspect-ratio: 239/68;" /></div><div
class="testimonial-card-quote">Devotel is an excellent partner for our business. Their flexibility and tier-1 routes make all the difference.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Pierpaolo Aluise</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame-3.png" alt="Baway" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 240px; --smush-placeholder-aspect-ratio: 240/68;" /></div><div
class="testimonial-card-quote">Devotel provides excellence service that keeps our business running smoothly. Their support team is responsive and always resolves issues quickly.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Snizhana Yurchenko</div><div
class="testimonial-card-author-role">Carrier Relations Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2025/12/Frame.png" alt="Mediafon" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 204px; --smush-placeholder-aspect-ratio: 204/68;" /></div><div
class="testimonial-card-quote">The Devotel team is highly professional, dedicated, and reliable.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Tarcencova Evghenia</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/chintelecom-logo-1024x280-1.png" alt="China Telecom Global" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 1024px; --smush-placeholder-aspect-ratio: 1024/280;" /></div><div
class="testimonial-card-quote">The team is very responsive, the prices are competitive, and the routes work well.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Polly Xu</div><div
class="testimonial-card-author-role">Business Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/01/Complete-logo-without-BG.png" alt="Kite Telco LTD" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" style="--smush-placeholder-width: 587px; --smush-placeholder-aspect-ratio: 587/195;" /></div><div
class="testimonial-card-quote">We've had an excellent experience working together. Both companies have seen growth in revenue and profitability, and I'm confident that together we can achieve 3x growth in 2026.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Muhammad Waqas</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/image-1217.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Devotel has consistently proven to be a trusted and professional partner. Our collaboration has been built on a strong foundation of trust and transparency.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Andra-Ioana Podar</div><div
class="testimonial-card-author-role">Account Manager</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Gemini_Generated_Image_smglahsmglahsmgl-1.svg" alt="Customer" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">During the past 6 years, Devotel always showed high level of technical expertise and knowledge of the market and made a significant contribution to evolution of our products.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Dmitry Stafeev</div><div
class="testimonial-card-author-role">CEO</div></div></div></div><div
class="testimonial-card"><div
class="testimonial-card-body"><div
class="testimonial-card-logo-wrap"><img decoding="async" data-src="https://devotel.com/wp-content/uploads/2026/03/Group-1321315692.svg" alt="Duo Creative & Software" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" class="lazyload" /></div><div
class="testimonial-card-quote">Delivery is reliable, integrations are straightforward, and we haven't had any major issues. Support is responsive when needed, which makes things much easier.</div></div><div
class="testimonial-card-footer"><div
class="testimonial-card-author"><div
class="testimonial-card-author-name">Umutcan Olgun</div><div
class="testimonial-card-author-role">CEO</div></div></div></div></div></div></div><div
class="testimonials-fade-top" aria-hidden="true"></div><div
class="testimonials-fade-bottom" aria-hidden="true"></div></div></div></div></div></div><div
class="elementor-element elementor-element-336ca7d e-con-full e-flex e-con e-parent" data-id="336ca7d" data-element_type="container" data-e-type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}"><div