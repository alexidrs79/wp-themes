<?php
/**
 * Extracted from Elementor HTML widget: e06718b
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>#dvthm-prdsec-root{contain:layout style;isolation:isolate}#dvthm-prdsec-root,#dvthm-prdsec-root *{box-sizing:border-box}#dvthm-prdsec-root button,#dvthm-prdsec-root a,#dvthm-prdsec-root [role="tab"]{outline:none!important;outline-width:0!important;outline-style:none!important;outline-color:transparent!important;-webkit-tap-highlight-color:transparent!important;-webkit-tap-highlight-color:#fff0!important}#dvthm-prdsec-root button:focus,#dvthm-prdsec-root button:focus-visible,#dvthm-prdsec-root button:active,#dvthm-prdsec-root a:focus,#dvthm-prdsec-root a:focus-visible,#dvthm-prdsec-root a:active,#dvthm-prdsec-root [role="tab"]:focus,#dvthm-prdsec-root [role="tab"]:focus-visible,#dvthm-prdsec-root [role="tab"]:active{outline:none!important;outline-width:0!important;outline-style:none!important;outline-color:transparent!important;box-shadow:none!important;border-color:inherit!important;-webkit-tap-highlight-color:transparent!important}#dvthm-prdsec-root *:focus,#dvthm-prdsec-root *:focus-visible{outline:none!important;outline-width:0!important;outline-color:transparent!important;box-shadow:none!important}#dvthm-prdsec-root button::-moz-focus-inner,#dvthm-prdsec-root a::-moz-focus-inner{border:0!important;padding:0!important}#dvthm-prdsec-root .dvthm-prdsec-tab:focus,#dvthm-prdsec-root .dvthm-prdsec-tab:focus-visible,#dvthm-prdsec-root .dvthm-prdsec-tab:active,#dvthm-prdsec-root .dvthm-prdsec-link:focus,#dvthm-prdsec-root .dvthm-prdsec-link:focus-visible,#dvthm-prdsec-root .dvthm-prdsec-link:active,#dvthm-prdsec-root .dvthm-prdsec-explore:focus,#dvthm-prdsec-root .dvthm-prdsec-explore:focus-visible,#dvthm-prdsec-root .dvthm-prdsec-explore:active{outline:none!important;outline-width:0!important;outline-color:transparent!important;box-shadow:none!important;border-color:transparent!important}#dvthm-prdsec-root{background:linear-gradient(180deg,rgb(229 240 255) 0%,rgb(235 239 244) 100%,#fff0 100%);border-radius:56px;padding:47px 24px 69px;position:relative;overflow:hidden}#dvthm-prdsec-root .dvthm-prdsec-header{display:flex;flex-direction:column;gap:16px;align-items:center;text-align:center;width:100%;max-width:592px;margin:0 auto 64px}#dvthm-prdsec-root .dvthm-prdsec-header-inner{display:flex;flex-direction:column;gap:8px;align-items:center}#dvthm-prdsec-root .dvthm-prdsec-eyebrow{color:#325fec;font-family:"Inter-SemiBold",sans-serif;font-size:14px;line-height:20px;font-weight:600;text-transform:uppercase}#dvthm-prdsec-root .dvthm-prdsec-title{color:#0f172b;font-family:"Inter-SemiBold",sans-serif;font-size:36px;line-height:44px;letter-spacing:-.02em;font-weight:600;width:100%;max-width:570px}#dvthm-prdsec-root .dvthm-prdsec-desc{color:#45556c;font-family:"Inter-Regular",sans-serif;font-size:18px;line-height:28px;width:100%;max-width:592px}#dvthm-prdsec-root .dvthm-prdsec-card-wrap{max-width:1189px;margin:0 auto}#dvthm-prdsec-root .dvthm-prdsec-card{background:#fff;border-radius:48px;border:1px solid rgb(144 161 185 / .25);width:100%;max-width:1189px;height:608px;min-height:608px;padding:24px 47px 48px 48px;position:relative;overflow:hidden}#dvthm-prdsec-root .dvthm-prdsec-tab-rectangle{background:#fff;border-radius:24px;width:100%;max-width:816px;min-height:64px;margin:0 auto 27px;display:flex;align-items:center;justify-content:center;padding:10px 16px;box-sizing:border-box}#dvthm-prdsec-root .dvthm-prdsec-tabs-wrap{background:#f3f7ff;border-radius:16px;display:flex;flex-direction:row;gap:8px;align-items:center;justify-content:center;padding:0;width:100%;flex-wrap:nowrap;position:relative}#dvthm-prdsec-root .dvthm-prdsec-tab,#dvthm-prdsec-root button.dvthm-prdsec-tab{flex-shrink:0;border-radius:16px;padding:0 20px;height:44px;display:flex;flex-direction:row;align-items:center;justify-content:flex-start;gap:8px;cursor:pointer;border:none;background:transparent!important;background-color:transparent!important;color:#64748b!important;font-family:"Inter-Medium",sans-serif;font-size:14px;line-height:20px;font-weight:500;transition:background 0.25s ease-in-out,color 0.25s ease-in-out,border-radius 0.25s ease-in-out;white-space:nowrap;position:relative;box-shadow:none!important}#dvthm-prdsec-root .dvthm-prdsec-tab:not(.dvthm-prdsec-tab--active),#dvthm-prdsec-root .dvthm-prdsec-tab[aria-selected="false"]{background:transparent!important;background-color:transparent!important;color:#64748b!important;box-shadow:none!important}#dvthm-prdsec-root .dvthm-prdsec-tab.dvthm-prdsec-tab--active{background:#325fec!important;background-color:#325fec!important;color:#ffffff!important;border-radius:33554400px}#dvthm-prdsec-root .dvthm-prdsec-tab:hover:not(.dvthm-prdsec-tab--active),#dvthm-prdsec-root [role="tablist"] .dvthm-prdsec-tab:hover,#dvthm-prdsec-root [role="tablist"] button.dvthm-prdsec-tab:hover{background:#325fec!important;background-color:#325fec!important;color:#ffffff!important;border-radius:33554400px}#dvthm-prdsec-root .dvthm-prdsec-tab-icon{width:20px;height:20px;flex-shrink:0;display:inline-flex;align-items:center;justify-content:center;transition:filter 0.25s ease-in-out}#dvthm-prdsec-root .dvthm-prdsec-tab--active .dvthm-prdsec-tab-icon,#dvthm-prdsec-root .dvthm-prdsec-tab--hover .dvthm-prdsec-tab-icon,#dvthm-prdsec-root .dvthm-prdsec-tab:hover .dvthm-prdsec-tab-icon,#dvthm-prdsec-root [role="tablist"] .dvthm-prdsec-tab:hover .dvthm-prdsec-tab-icon{filter:brightness(0) invert(1)!important}#dvthm-prdsec-root .dvthm-prdsec-tab-icon svg{width:20px;height:20px;display:block}#dvthm-prdsec-root .dvthm-prdsec-tab--sim{display:none!important}#dvthm-prdsec-root [role="tablist"] .dvthm-prdsec-tab:not(.dvthm-prdsec-tab--active),#dvthm-prdsec-root [role="tablist"] button:not(.dvthm-prdsec-tab--active){background:transparent!important;background-color:transparent!important;color:#64748b!important}#dvthm-prdsec-root .dvthm-prdsec-tab:hover,#dvthm-prdsec-root .dvthm-prdsec-tab:focus,#dvthm-prdsec-root .dvthm-prdsec-tab:active,#dvthm-prdsec-root button.dvthm-prdsec-tab:hover,#dvthm-prdsec-root button.dvthm-prdsec-tab:focus,#dvthm-prdsec-root button.dvthm-prdsec-tab:active,#dvthm-prdsec-root [role="tablist"] button:hover,#dvthm-prdsec-root [role="tablist"] button:focus,#dvthm-prdsec-root [role="tablist"] button:active{background:#325fec!important;background-color:#325fec!important;color:#ffffff!important}#dvthm-prdsec-root .dvthm-prdsec-card-body{display:grid;grid-template-columns:455px 1fr;gap:24px;align-items:start;max-width:1094px}#dvthm-prdsec-root .dvthm-prdsec-hero-col{min-width:0}#dvthm-prdsec-root .dvthm-prdsec-hero{line-height:0}#dvthm-prdsec-root .dvthm-prdsec-hero-img{display:block;width:auto;height:auto;max-width:100%}#dvthm-prdsec-root .dvthm-prdsec-links-col{display:flex;flex-direction:column;min-width:0;max-width:615px}#dvthm-prdsec-root .dvthm-prdsec-panel{display:flex;flex-direction:column;align-items:flex-start;width:100%}#dvthm-prdsec-root .dvthm-prdsec-links{display:flex;flex-direction:column;gap:10px;width:100%}#dvthm-prdsec-root .dvthm-prdsec-link{border-radius:24px;border:1px solid #e2e8f0;padding:16px 20px;display:flex;flex-direction:row;gap:8px;align-items:center;text-decoration:none;background:#fff;color:#314158;height:90px;min-height:90px;width:100%;box-sizing:border-box;position:relative;transition:background 0.25s ease-in-out,border-color 0.25s ease-in-out,color 0.25s ease-in-out}#dvthm-prdsec-root .dvthm-prdsec-link:hover{background:#325fec;border-color:#325fec;color:#fff}#dvthm-prdsec-root .dvthm-prdsec-link:hover .dvthm-prdsec-link-desc{color:#c0d7ff}#dvthm-prdsec-root .dvthm-prdsec-link:hover .dvthm-prdsec-link-icon-wrap{background:#fff}#dvthm-prdsec-root .dvthm-prdsec-link--highlight{background:#325fec;border-color:#e2e8f0;border-width:1px;padding:16px 48px 16px 20px;color:#fff}#dvthm-prdsec-root .dvthm-prdsec-link--highlight .dvthm-prdsec-link-desc{color:#c0d7ff}#dvthm-prdsec-root .dvthm-prdsec-link--highlight .dvthm-prdsec-link-icon-wrap{background:#fff}#dvthm-prdsec-root .dvthm-prdsec-link--highlight .dvthm-prdsec-link-arrow{position:absolute;right:22px;top:50%;transform:translateY(-50%);margin:0}#dvthm-prdsec-root .dvthm-prdsec-link-icon-wrap{flex-shrink:0;width:44px;height:44px;border-radius:14px;background:#eff4ff;display:flex;align-items:center;justify-content:center;transition:background 0.25s ease-in-out}#dvthm-prdsec-root .dvthm-prdsec-link-icon-wrap img,#dvthm-prdsec-root .dvthm-prdsec-link-icon-wrap svg{width:24px;height:24px;display:block;flex-shrink:0;max-width:24px;max-height:24px;object-fit:contain}#dvthm-prdsec-root .dvthm-prdsec-link-text{flex:1;min-width:0;display:flex;flex-direction:column;gap:2px}#dvthm-prdsec-root .dvthm-prdsec-link-title{font-family:"Inter-SemiBold",sans-serif;font-size:16px;line-height:24px;font-weight:600}#dvthm-prdsec-root .dvthm-prdsec-link-desc{font-family:"Inter-Regular",sans-serif;font-size:14px;line-height:20px;color:#45556c;transition:color 0.25s ease-in-out}#dvthm-prdsec-root .dvthm-prdsec-link-arrow{flex-shrink:0;width:20px;height:20px;display:flex;align-items:center;justify-content:center;color:inherit;opacity:0;transition:opacity 0.25s ease-in-out}#dvthm-prdsec-root .dvthm-prdsec-link:hover .dvthm-prdsec-link-arrow{opacity:1}#dvthm-prdsec-root .dvthm-prdsec-explore-wrap{margin-top:20px;align-self:flex-end!important;margin-left:auto!important;width:100%;display:flex!important;justify-content:flex-end!important}#dvthm-prdsec-root .dvthm-prdsec-explore{display:inline-flex;flex-direction:row;gap:8px;align-items:center;padding:10px 15px;border-radius:14px;color:#62748e;font-family:"Inter-Medium",sans-serif;font-size:14px;line-height:20px;font-weight:500;text-decoration:none;transition:color 0.25s ease-in-out,background 0.25s ease-in-out}#dvthm-prdsec-root .dvthm-prdsec-explore:hover{color:#325FEC;background:none}#dvthm-prdsec-root .dvthm-prdsec-explore svg{width:15px;height:15px}@media (max-width:768px){#dvthm-prdsec-root{background:#e6effd;border-radius:24px;padding:24px 0 0;min-height:0;overflow:visible}#dvthm-prdsec-root .dvthm-prdsec-header{padding:16px 16px 20px;margin-bottom:64px}#dvthm-prdsec-root .dvthm-prdsec-title{color:var(--Text-text-primary,#0F172B);text-align:center;font-family:var(--Font-family-font-family-display,Inter),sans-serif;font-size:var(--Font-size-display-sm,30px);font-style:normal;font-weight:600;line-height:var(--Line-height-display-sm,38px);letter-spacing:-.6px}#dvthm-prdsec-root .dvthm-prdsec-desc{color:var(--Text-text-tertiary,#45556C);text-align:center;font-family:var(--Font-family-font-family-body,Inter),sans-serif;font-size:var(--Font-size-text-lg,18px);font-style:normal;font-weight:400;line-height:var(--Line-height-text-lg,28px)}#dvthm-prdsec-root .dvthm-prdsec-card-wrap{padding:0 16px;overflow:visible}#dvthm-prdsec-root .dvthm-prdsec-card{border-radius:20px;padding:16px;min-height:0;height:auto;display:flex;flex-direction:column;gap:24px;overflow:visible}#dvthm-prdsec-root .dvthm-prdsec-tab-rectangle{background:#fff0;min-height:0;padding:0;margin:0;max-width:none;flex-shrink:0}#dvthm-prdsec-root .dvthm-prdsec-tabs-wrap{background:#f3f7ff;border-radius:16px;overflow-x:auto;overflow-y:hidden;-webkit-overflow-scrolling:touch;scrollbar-width:none;margin:0;justify-content:flex-start;flex-wrap:nowrap;position:-webkit-sticky;position:sticky;top:72px;z-index:999;flex-shrink:0}#dvthm-prdsec-root .dvthm-prdsec-tabs-wrap::-webkit-scrollbar{display:none}#dvthm-prdsec-root .dvthm-prdsec-card-body{display:none}#dvthm-prdsec-root .dvthm-prdsec-mobile-sections{display:flex;flex-direction:column;gap:32px;flex:1}#dvthm-prdsec-root .dvthm-prdsec-mobile-block{display:flex;flex-direction:column;gap:16px;width:100%}#dvthm-prdsec-root .dvthm-prdsec-hero--mobile{width:100%;border-radius:0;height:auto;min-height:0;display:flex;overflow:visible;padding:12px 0;align-self:stretch}#dvthm-prdsec-root .dvthm-prdsec-hero--mobile .dvthm-prdsec-hero-img{display:block;width:100%;height:auto;max-height:272px;object-fit:contain;object-position:center;align-self:stretch}#dvthm-prdsec-root .dvthm-prdsec-mobile-sections .dvthm-prdsec-links-col{display:flex;flex-direction:column;gap:10px}#dvthm-prdsec-root .dvthm-prdsec-mobile-sections .dvthm-prdsec-explore-wrap{justify-content:center!important;align-self:center!important;margin-left:0!important}#dvthm-prdsec-root .dvthm-prdsec-tabs-wrap.dvthm-prdsec-tab-bar--stuck{box-shadow:0 2px 8px rgb(0 0 0 / .06)}#dvthm-prdsec-root .dvthm-prdsec-tabs-wrap.dvthm-prdsec-tab-bar--fixed{position:fixed!important;top:72px!important;left:16px!important;right:16px!important;width:auto!important;box-sizing:border-box!important;box-shadow:0 2px 8px rgb(0 0 0 / .06);z-index:999}#dvthm-prdsec-root .dvthm-prdsec-section{scroll-margin-top:88px}}@media (min-width:769px){#dvthm-prdsec-root .dvthm-prdsec-mobile-sections{display:none!important}}@media (max-width:768px){#dvthm-prdsec-root .dvthm-prdsec-desktop-only{display:none!important}}</style><div
class="dvthm-prdsec" id="dvthm-prdsec-root"><div
class="dvthm-prdsec-header"><div
class="dvthm-prdsec-header-inner"><div
class="dvthm-prdsec-eyebrow">OUR Products</div><h2 class="dvthm-prdsec-title">What You Need to Succeed in Modern Communications</h2></div><p
class="dvthm-prdsec-desc">Explore our complete suite of solutions that power enterprises and telco's operation at scale.</p></div><div
class="dvthm-prdsec-card-wrap"><div
class="dvthm-prdsec-card"><div
class="dvthm-prdsec-tab-rectangle"><div
class="dvthm-prdsec-tabs-wrap" id="dvthm-prdsec-tab-bar-wrap" role="tablist" aria-label="Product categories" data-dvthm-prdsec-tabs="1">
<button
type="button" class="dvthm-prdsec-tab dvthm-prdsec-tab--active" data-dvthm-tab="applications" role="tab" aria-selected="true">
<img
decoding="async" class="dvthm-prdsec-tab-icon lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-4.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" />
Applications
</button>
<button
type="button" class="dvthm-prdsec-tab" data-dvthm-tab="communication-apis" role="tab" aria-selected="false">
<img
decoding="async" class="dvthm-prdsec-tab-icon lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" />
Communication APIs
</button>
<button
type="button" class="dvthm-prdsec-tab" data-dvthm-tab="telco-solutions" role="tab" aria-selected="false">
<img
decoding="async" class="dvthm-prdsec-tab-icon lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2147228549.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" />
Telco Solutions
</button>
<button
type="button" class="dvthm-prdsec-tab dvthm-prdsec-tab--sim" data-dvthm-tab="sim-based" role="tab" aria-hidden="true">
<img
decoding="async" class="dvthm-prdsec-tab-icon lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-3.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" />
SIM-Based Applications
</button></div></div><div
class="dvthm-prdsec-card-body dvthm-prdsec-desktop-only"><div
class="dvthm-prdsec-hero-col"><div
class="dvthm-prdsec-hero dvthm-prdsec-hero--applications" data-dvthm-hero="applications">
<img
decoding="async" class="dvthm-prdsec-hero-img lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2147228569.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" /></div><div
class="dvthm-prdsec-hero dvthm-prdsec-hero--communication-apis" data-dvthm-hero="communication-apis" style="display:none;">
<img
decoding="async" class="dvthm-prdsec-hero-img lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2147228569-1.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" /></div><div
class="dvthm-prdsec-hero dvthm-prdsec-hero--telco-solutions" data-dvthm-hero="telco-solutions" style="display:none;">
<img
decoding="async" class="dvthm-prdsec-hero-img lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2147228569-2.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" /></div></div><div
class="dvthm-prdsec-links-col"><div
class="dvthm-prdsec-panel dvthm-prdsec-panel--active" data-dvthm-panel="applications"><div
class="dvthm-prdsec-links">
<a
href="https://devotel.com/products/platforms/cmp/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20" fill="none"><path
d="M14.2382 10.8947C7.57497 10.8947 1.87592 3.64912 0 0C6.12301 6.98947 11.8165 7.60868 14.6885 7.05263C21.7145 5.69231 24.1243 7.63158 24.7059 8.89474C20.4288 8.01053 13.6755 13 8.94814 20C9.5672 17.5263 12.5687 12.9474 14.2382 10.8947Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">CMP</span>
<span
class="dvthm-prdsec-link-desc">Connectivity Management Platform</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/platforms/orbit/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
fill-rule="evenodd" clip-rule="evenodd" d="M6.25 12C6.25 8.82436 8.82436 6.25 12 6.25C15.1756 6.25 17.75 8.82436 17.75 12C17.75 15.1756 15.1756 17.75 12 17.75C8.82436 17.75 6.25 15.1756 6.25 12Z" fill="#325FEC"/><path
fill-rule="evenodd" clip-rule="evenodd" d="M12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21C16.9706 21 21 16.9706 21 12C21 11.6955 20.9849 11.3949 20.9555 11.0988C20.901 10.5492 21.3022 10.0595 21.8518 10.0049C22.4014 9.95033 22.8912 10.3516 22.9457 10.9012C22.9816 11.2629 23 11.6295 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C14.5281 1 16.8587 1.85393 18.7164 3.28796C19.1057 3.10346 19.5412 3 20 3C21.6569 3 23 4.34315 23 6C23 7.08908 22.419 8.04153 21.5549 8.56593C21.1007 8.84154 20.5674 9 20 9C18.3431 9 17 7.65685 17 6C17 5.5409 17.1035 5.10556 17.288 4.71643C15.8032 3.63638 13.9768 3 12 3Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">Orbit</span>
<span
class="dvthm-prdsec-link-desc">Customer Engagement Platform</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://hub.devotel.com/#home" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none"><path
d="M18.6319 5.9064C17.8134 2.48377 14.3653 0 10.4348 0H5.92095V3.68608H10.4348C12.4238 3.68608 14.1667 4.9426 14.5808 6.67397C14.9499 8.21779 14.9499 9.78329 14.5808 11.326C14.1667 13.0574 12.4238 14.3139 10.4348 14.3139H5.92095V18H10.4348C14.3653 18 17.8134 15.5162 18.6319 12.0936C19.1227 10.0413 19.1227 7.95977 18.6319 5.9064Z" fill="#325FEC"/><path
d="M4.90362 3.68693H0L3.7855 9.00031L0 14.3148H4.90362L8.6879 9.00031L4.90362 3.68693Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">DevHub</span>
<span
class="dvthm-prdsec-link-desc">Developer API Platform</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://esimora.com/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M0 12C-1.37766e-07 13.5759 0.310389 15.1363 0.913445 16.5922C1.5165 18.0481 2.40042 19.371 3.51472 20.4853C4.62902 21.5996 5.95189 22.4835 7.4078 23.0866C8.86371 23.6896 10.4241 24 12 24L12 18.924C11.0907 18.924 10.1904 18.7449 9.3503 18.3969C8.51024 18.049 7.74694 17.539 7.10399 16.896C6.46104 16.2531 5.95102 15.4898 5.60306 14.6497C5.25509 13.8096 5.076 12.9093 5.076 12H0Z" fill="#325FEC"/><path
d="M24 12C24 10.4241 23.6896 8.86371 23.0866 7.4078C22.4835 5.95189 21.5996 4.62902 20.4853 3.51472C19.371 2.40042 18.0481 1.5165 16.5922 0.913446C15.1363 0.310389 13.5759 -6.88831e-08 12 0C10.4241 6.88831e-08 8.86371 0.310389 7.4078 0.913446C5.95189 1.5165 4.62902 2.40042 3.51472 3.51472C2.40042 4.62902 1.5165 5.95189 0.913445 7.4078C0.310389 8.86371 -1.37766e-07 10.4241 0 12L1.2 12C1.2 10.5817 1.47935 9.17734 2.0221 7.86702C2.56485 6.5567 3.36037 5.36612 4.36325 4.36325C5.36612 3.36037 6.5567 2.56485 7.86702 2.0221C9.17733 1.47935 10.5817 1.2 12 1.2C13.4183 1.2 14.8227 1.47935 16.133 2.0221C17.4433 2.56485 18.6339 3.36037 19.6368 4.36325C20.6396 5.36612 21.4351 6.5567 21.9779 7.86702C22.5206 9.17734 22.8 10.5817 22.8 12H24Z" fill="#325FEC"/><path
d="M19.6875 12C19.6875 10.9905 19.4887 9.99081 19.1023 9.05812C18.716 8.12543 18.1497 7.27797 17.4359 6.56412C16.722 5.85027 15.8746 5.28401 14.9419 4.89768C14.0092 4.51134 13.0095 4.3125 12 4.3125C10.9905 4.3125 9.99081 4.51134 9.05812 4.89768C8.12543 5.28401 7.27797 5.85027 6.56412 6.56412C5.85027 7.27797 5.28401 8.12543 4.89768 9.05812C4.51134 9.99081 4.3125 10.9905 4.3125 12H5.08125C5.08125 11.0914 5.26021 10.1917 5.60791 9.35231C5.95561 8.51289 6.46524 7.75017 7.10771 7.10771C7.75017 6.46524 8.51289 5.95561 9.35231 5.60791C10.1917 5.26021 11.0914 5.08125 12 5.08125C12.9086 5.08125 13.8083 5.26021 14.6477 5.60791C15.4871 5.95561 16.2498 6.46524 16.8923 7.10771C17.5348 7.75017 18.0444 8.51289 18.3921 9.35231C18.7398 10.1917 18.9187 11.0914 18.9187 12H19.6875Z" fill="#325FEC"/><path
d="M21.75 12C21.75 10.7196 21.4978 9.45176 21.0078 8.26884C20.5178 7.08591 19.7997 6.01108 18.8943 5.10571C17.9889 4.20034 16.9141 3.48216 15.7312 2.99217C14.5482 2.50219 13.2804 2.25 12 2.25C10.7196 2.25 9.45176 2.50219 8.26884 2.99217C7.08591 3.48216 6.01108 4.20034 5.10571 5.10571C4.20034 6.01108 3.48216 7.08591 2.99217 8.26884C2.50219 9.45176 2.25 10.7196 2.25 12H3.225C3.225 10.8477 3.45197 9.70659 3.89296 8.64195C4.33394 7.57732 4.9803 6.60997 5.79514 5.79514C6.60997 4.9803 7.57732 4.33394 8.64195 3.89296C9.70658 3.45197 10.8476 3.225 12 3.225C13.1523 3.225 14.2934 3.45197 15.358 3.89296C16.4227 4.33394 17.39 4.9803 18.2049 5.79514C19.0197 6.60997 19.6661 7.57732 20.107 8.64195C20.548 9.70659 20.775 10.8477 20.775 12H21.75Z" fill="#325FEC"/><path
d="M17.3438 12C17.3438 11.2982 17.2055 10.6034 16.937 9.95504C16.6684 9.3067 16.2748 8.71761 15.7786 8.2214C15.2824 7.72519 14.6933 7.33157 14.045 7.06302C13.3966 6.79447 12.7018 6.65625 12 6.65625C11.2982 6.65625 10.6034 6.79447 9.95504 7.06302C9.3067 7.33157 8.71761 7.72519 8.2214 8.2214C7.72518 8.71761 7.33157 9.3067 7.06302 9.95504C6.79447 10.6034 6.65625 11.2982 6.65625 12H9.78018C9.78018 11.7085 9.83759 11.4198 9.94915 11.1505C10.0607 10.8812 10.2242 10.6365 10.4303 10.4303C10.6365 10.2242 10.8812 10.0607 11.1505 9.94915C11.4198 9.83759 11.7085 9.78018 12 9.78018C12.2915 9.78018 12.5802 9.83759 12.8495 9.94915C13.1188 10.0607 13.3635 10.2242 13.5697 10.4303C13.7758 10.6365 13.9393 10.8812 14.0508 11.1505C14.1624 11.4198 14.2198 11.7085 14.2198 12H17.3438Z" fill="#325FEC"/><path
d="M13.5 12.0469C13.5 12.9012 12.8074 13.5938 11.9531 13.5938C11.0988 13.5938 10.4062 12.9012 10.4062 12.0469C10.4062 11.1926 11.0988 10.5 11.9531 10.5C12.8074 10.5 13.5 11.1926 13.5 12.0469Z" fill="#325FEC"/><path
d="M11.7188 12.4688H12.2812V24H11.7188V12.4688Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">eSimora</span>
<span
class="dvthm-prdsec-link-desc">B2C eSIM App</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a></div><div
class="dvthm-prdsec-explore-wrap">
<a
href="https://devotel.com/products/platforms/" class="dvthm-prdsec-explore" target="_blank" rel="noopener">Explore All <svg
viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path
d="M5 12h14M12 5l7 7-7 7"/></svg></a></div></div><div
class="dvthm-prdsec-panel" data-dvthm-panel="communication-apis" style="display:none;"><div
class="dvthm-prdsec-links">
<a
href="https://devotel.com/products/communication-apis/sms/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none"><path
d="M11.095 16.2368C14.6506 16.0026 17.4828 13.1569 17.7158 9.5844C17.7614 8.8853 17.7614 8.16131 17.7158 7.46219C17.4828 3.88969 14.6506 1.04401 11.095 0.80985C9.882 0.72997 8.61553 0.73013 7.40499 0.80985C3.84943 1.04401 1.01725 3.88969 0.7842 7.46219C0.7386 8.16131 0.7386 8.8853 0.7842 9.5844C0.86908 10.8856 1.44992 12.0903 2.13372 13.1076C2.53076 13.8197 2.26873 14.7086 1.85518 15.485C1.557 16.0448 1.40791 16.3247 1.52762 16.5269C1.64732 16.7291 1.91472 16.7356 2.44951 16.7485C3.50712 16.774 4.22028 16.4769 4.78638 16.0634C5.10744 15.8288 5.26798 15.7115 5.37862 15.6981C5.48926 15.6846 5.707 15.7734 6.14241 15.9511C6.53374 16.1108 6.98812 16.2093 7.40499 16.2368C8.61553 16.3165 9.882 16.3166 11.095 16.2368Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">SMS</span>
<span
class="dvthm-prdsec-link-desc">Global SMS Delivery</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/communication-apis/email/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M2 6L8.91302 9.91697C11.4616 11.361 12.5384 11.361 15.087 9.91697L22 6" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/><path
d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">Email</span>
<span
class="dvthm-prdsec-link-desc">Enterprise Email at Scale</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/communication-apis/whatsapp-business/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 13.3789 2.27907 14.6926 2.78382 15.8877C3.06278 16.5481 3.20226 16.8784 3.21953 17.128C3.2368 17.3776 3.16334 17.6521 3.01642 18.2012L2 22L5.79877 20.9836C6.34788 20.8367 6.62244 20.7632 6.87202 20.7805C7.12161 20.7977 7.45185 20.9372 8.11235 21.2162C9.30745 21.7209 10.6211 22 12 22Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/><path
d="M8.58815 12.3773L9.45909 11.2956C9.82616 10.8397 10.2799 10.4153 10.3155 9.80826C10.3244 9.65494 10.2166 8.96657 10.0008 7.58986C9.91601 7.04881 9.41086 7 8.97332 7C8.40314 7 8.11805 7 7.83495 7.12931C7.47714 7.29275 7.10979 7.75231 7.02917 8.13733C6.96539 8.44196 7.01279 8.65187 7.10759 9.07169C7.51023 10.8548 8.45481 12.6158 9.91948 14.0805C11.3842 15.5452 13.1452 16.4898 14.9283 16.8924C15.3481 16.9872 15.558 17.0346 15.8627 16.9708C16.2477 16.8902 16.7072 16.5229 16.8707 16.165C17 15.8819 17 15.5969 17 15.0267C17 14.5891 16.9512 14.084 16.4101 13.9992C15.0334 13.7834 14.3451 13.6756 14.1917 13.6845C13.5847 13.7201 13.1603 14.1738 12.7044 14.5409L11.6227 15.4118" stroke="#325FEC" stroke-width="1.5"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">WhatsApp</span>
<span
class="dvthm-prdsec-link-desc">Interactive Messaging Worldwide</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/communication-apis/rcs/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M14.1706 20.8905C18.3536 20.6125 21.6856 17.2332 21.9598 12.9909C22.0134 12.1607 22.0134 11.3009 21.9598 10.4707C21.6856 6.22838 18.3536 2.84913 14.1706 2.57107C12.7435 2.47621 11.2536 2.47641 9.8294 2.57107C5.64639 2.84913 2.31441 6.22838 2.04024 10.4707C1.98659 11.3009 1.98659 12.1607 2.04024 12.9909C2.1401 14.536 2.82343 15.9666 3.62791 17.1746C4.09501 18.0203 3.78674 19.0758 3.30021 19.9978C2.94941 20.6626 2.77401 20.995 2.91484 21.2351C3.05568 21.4752 3.37026 21.4829 3.99943 21.4982C5.24367 21.5285 6.08268 21.1757 6.74868 20.6846C7.1264 20.4061 7.31527 20.2668 7.44544 20.2508C7.5756 20.2348 7.83177 20.3403 8.34401 20.5513C8.8044 20.7409 9.33896 20.8579 9.8294 20.8905C11.2536 20.9852 12.7435 20.9854 14.1706 20.8905Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/><path
d="M11.9955 12H12.0044M15.991 12H16M8 12H8.00897" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">RCS</span>
<span
class="dvthm-prdsec-link-desc">Rich Messaging Experiences</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a></div><div
class="dvthm-prdsec-explore-wrap">
<a
href="https://devotel.com/products/communication-apis/" class="dvthm-prdsec-explore" target="_blank" rel="noopener">Explore All <svg
viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path
d="M5 12h14M12 5l7 7-7 7"/></svg></a></div></div><div
class="dvthm-prdsec-panel" data-dvthm-panel="telco-solutions" style="display:none;"><div
class="dvthm-prdsec-links">
<a
href="https://devotel.com/products/telco/voice-solutions/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><g
clip-path="url(#dvthm-voice-clip-d)"><path
d="M12 6.33337V18.3334" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M7.5 9.3335V15.3335" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M3 10.8334V13.8334" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M16.5 9.3335V15.3335" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M21 10.8334V13.8334" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath
id="dvthm-voice-clip-d"><rect
width="24" height="24" fill="white"/></clipPath></defs></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">Voice Service</span>
<span
class="dvthm-prdsec-link-desc">High-Quality Voice Connectivity</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/telco/sms-solutions-for-telco/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M7.5 12H13.5M7.5 8H10.5" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M8.5 20C9.55038 20.8697 10.8145 21.4238 12.2635 21.5188C13.4052 21.5937 14.5971 21.5936 15.7365 21.5188C16.1288 21.4931 16.5565 21.4007 16.9248 21.251C17.3345 21.0845 17.5395 21.0012 17.6437 21.0138C17.7478 21.0264 17.8989 21.1364 18.2011 21.3563C18.7339 21.744 19.4051 22.0225 20.4005 21.9986C20.9038 21.9865 21.1555 21.9804 21.2681 21.7909C21.3808 21.6013 21.2405 21.3389 20.9598 20.8141C20.5706 20.0862 20.324 19.2529 20.6977 18.5852C21.3413 17.6315 21.8879 16.5021 21.9678 15.2823C22.0107 14.6269 22.0107 13.9481 21.9678 13.2927C21.9146 12.4799 21.7173 11.7073 21.4012 11" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M12.345 17.4868C15.9006 17.2526 18.7328 14.4069 18.9658 10.8344C19.0114 10.1353 19.0114 9.41131 18.9658 8.71219C18.7328 5.13969 15.9006 2.29401 12.345 2.05985C11.132 1.97997 9.86553 1.98013 8.65499 2.05985C5.09943 2.29401 2.26725 5.13969 2.0342 8.71219C1.9886 9.41131 1.9886 10.1353 2.0342 10.8344C2.11908 12.1356 2.69992 13.3403 3.38372 14.3576C3.78076 15.0697 3.51873 15.9586 3.10518 16.735C2.807 17.2948 2.65791 17.5747 2.77762 17.7769C2.89732 17.9791 3.16472 17.9856 3.69951 17.9985C4.75712 18.024 5.47028 17.7269 6.03638 17.3134C6.35744 17.0788 6.51798 16.9615 6.62862 16.9481C6.73926 16.9346 6.957 17.0234 7.39241 17.2011C7.78374 17.3608 8.23812 17.4593 8.65499 17.4868C9.86553 17.5665 11.132 17.5666 12.345 17.4868Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">SMS Services</span>
<span
class="dvthm-prdsec-link-desc">High-Volume Messaging</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/#telco" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M18.7088 3.49534C16.8165 2.55382 14.5009 2 12 2C9.4991 2 7.1835 2.55382 5.29116 3.49534C4.36318 3.95706 3.89919 4.18792 3.4496 4.91378C3 5.63965 3 6.34248 3 7.74814V11.2371C3 16.9205 7.54236 20.0804 10.173 21.4338C10.9067 21.8113 11.2735 22 12 22C12.7265 22 13.0933 21.8113 13.8269 21.4338C16.4576 20.0804 21 16.9205 21 11.2371V7.74814C21 6.34249 21 5.63966 20.5504 4.91378C20.1008 4.18791 19.6368 3.95706 18.7088 3.49534Z" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M9 11.5C9 11.5 10.4079 11.7519 11 13.5C11 13.5 12.5 10.5 15 9.5" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">SMS and Voice Firewall</span>
<span
class="dvthm-prdsec-link-desc">Network Protection</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/#telco" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M20.9427 16.8398C20.3794 13.4506 17.7138 9.90626 15.8466 7.87773C15.3176 7.30303 14.563 7.00439 13.7819 7.00439H10.2181C9.43699 7.00439 8.68241 7.30303 8.15342 7.87772C6.28619 9.90624 3.62059 13.4506 3.05727 16.8398C2.56893 19.7778 5.27927 22.0044 8.30832 22.0044H15.6917C18.7207 22.0044 21.4311 19.7778 20.9427 16.8398Z" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M12 12C10.8954 12 10 12.6716 10 13.5C10 14.3284 10.8954 15 12 15C13.1046 15 14 15.6716 14 16.5C14 17.3284 13.1046 18 12 18M12 12C12.8708 12 13.6116 12.4174 13.8862 13M12 12V11M12 18C11.1292 18 10.3884 17.5826 10.1138 17M12 18V19" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M9.08607 6.99999L7 3.5L8.98473 3.83079C9.62183 3.93697 10.271 3.72894 10.7277 3.27224L12 2L13.2723 3.27224C13.729 3.72894 14.3782 3.93697 15.0153 3.83079L17 3.5L14.9139 6.99999" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text">
<span
class="dvthm-prdsec-link-title">SMS and Voice Monetisation</span>
<span
class="dvthm-prdsec-link-desc">Monetise SMS and Flash Calls Traffic</span>
</span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a></div><div
class="dvthm-prdsec-explore-wrap">
<a
href="https://devotel.com/products/telco/" class="dvthm-prdsec-explore" target="_blank" rel="noopener">Explore All <svg
viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path
d="M5 12h14M12 5l7 7-7 7"/></svg></a></div></div></div></div><div
class="dvthm-prdsec-mobile-sections"><div
class="dvthm-prdsec-section" id="dvthm-prdsec-section-applications"><div
class="dvthm-prdsec-mobile-block"><div
class="dvthm-prdsec-hero dvthm-prdsec-hero--mobile dvthm-prdsec-hero--applications">
<img
decoding="async" class="dvthm-prdsec-hero-img lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2147228570.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" /></div><div
class="dvthm-prdsec-links-col">
<a
href="https://devotel.com/products/platforms/cmp/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20" fill="none"><path
d="M14.2382 10.8947C7.57497 10.8947 1.87592 3.64912 0 0C6.12301 6.98947 11.8165 7.60868 14.6885 7.05263C21.7145 5.69231 24.1243 7.63158 24.7059 8.89474C20.4288 8.01053 13.6755 13 8.94814 20C9.5672 17.5263 12.5687 12.9474 14.2382 10.8947Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">CMP</span><span
class="dvthm-prdsec-link-desc">Connectivity Management Platform</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/platforms/orbit/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
fill-rule="evenodd" clip-rule="evenodd" d="M6.25 12C6.25 8.82436 8.82436 6.25 12 6.25C15.1756 6.25 17.75 8.82436 17.75 12C17.75 15.1756 15.1756 17.75 12 17.75C8.82436 17.75 6.25 15.1756 6.25 12Z" fill="#325FEC"/><path
fill-rule="evenodd" clip-rule="evenodd" d="M12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21C16.9706 21 21 16.9706 21 12C21 11.6955 20.9849 11.3949 20.9555 11.0988C20.901 10.5492 21.3022 10.0595 21.8518 10.0049C22.4014 9.95033 22.8912 10.3516 22.9457 10.9012C22.9816 11.2629 23 11.6295 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C14.5281 1 16.8587 1.85393 18.7164 3.28796C19.1057 3.10346 19.5412 3 20 3C21.6569 3 23 4.34315 23 6C23 7.08908 22.419 8.04153 21.5549 8.56593C21.1007 8.84154 20.5674 9 20 9C18.3431 9 17 7.65685 17 6C17 5.5409 17.1035 5.10556 17.288 4.71643C15.8032 3.63638 13.9768 3 12 3Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">Orbit</span><span
class="dvthm-prdsec-link-desc">Customer Engagement Platform</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://hub.devotel.com/#home" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none"><path
d="M18.6319 5.9064C17.8134 2.48377 14.3653 0 10.4348 0H5.92095V3.68608H10.4348C12.4238 3.68608 14.1667 4.9426 14.5808 6.67397C14.9499 8.21779 14.9499 9.78329 14.5808 11.326C14.1667 13.0574 12.4238 14.3139 10.4348 14.3139H5.92095V18H10.4348C14.3653 18 17.8134 15.5162 18.6319 12.0936C19.1227 10.0413 19.1227 7.95977 18.6319 5.9064Z" fill="#325FEC"/><path
d="M4.90362 3.68693H0L3.7855 9.00031L0 14.3148H4.90362L8.6879 9.00031L4.90362 3.68693Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">DevHub</span><span
class="dvthm-prdsec-link-desc">Developer API Platform</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://esimora.com/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M0 12C-1.37766e-07 13.5759 0.310389 15.1363 0.913445 16.5922C1.5165 18.0481 2.40042 19.371 3.51472 20.4853C4.62902 21.5996 5.95189 22.4835 7.4078 23.0866C8.86371 23.6896 10.4241 24 12 24L12 18.924C11.0907 18.924 10.1904 18.7449 9.3503 18.3969C8.51024 18.049 7.74694 17.539 7.10399 16.896C6.46104 16.2531 5.95102 15.4898 5.60306 14.6497C5.25509 13.8096 5.076 12.9093 5.076 12H0Z" fill="#325FEC"/><path
d="M24 12C24 10.4241 23.6896 8.86371 23.0866 7.4078C22.4835 5.95189 21.5996 4.62902 20.4853 3.51472C19.371 2.40042 18.0481 1.5165 16.5922 0.913446C15.1363 0.310389 13.5759 -6.88831e-08 12 0C10.4241 6.88831e-08 8.86371 0.310389 7.4078 0.913446C5.95189 1.5165 4.62902 2.40042 3.51472 3.51472C2.40042 4.62902 1.5165 5.95189 0.913445 7.4078C0.310389 8.86371 -1.37766e-07 10.4241 0 12L1.2 12C1.2 10.5817 1.47935 9.17734 2.0221 7.86702C2.56485 6.5567 3.36037 5.36612 4.36325 4.36325C5.36612 3.36037 6.5567 2.56485 7.86702 2.0221C9.17733 1.47935 10.5817 1.2 12 1.2C13.4183 1.2 14.8227 1.47935 16.133 2.0221C17.4433 2.56485 18.6339 3.36037 19.6368 4.36325C20.6396 5.36612 21.4351 6.5567 21.9779 7.86702C22.5206 9.17734 22.8 10.5817 22.8 12H24Z" fill="#325FEC"/><path
d="M19.6875 12C19.6875 10.9905 19.4887 9.99081 19.1023 9.05812C18.716 8.12543 18.1497 7.27797 17.4359 6.56412C16.722 5.85027 15.8746 5.28401 14.9419 4.89768C14.0092 4.51134 13.0095 4.3125 12 4.3125C10.9905 4.3125 9.99081 4.51134 9.05812 4.89768C8.12543 5.28401 7.27797 5.85027 6.56412 6.56412C5.85027 7.27797 5.28401 8.12543 4.89768 9.05812C4.51134 9.99081 4.3125 10.9905 4.3125 12H5.08125C5.08125 11.0914 5.26021 10.1917 5.60791 9.35231C5.95561 8.51289 6.46524 7.75017 7.10771 7.10771C7.75017 6.46524 8.51289 5.95561 9.35231 5.60791C10.1917 5.26021 11.0914 5.08125 12 5.08125C12.9086 5.08125 13.8083 5.26021 14.6477 5.60791C15.4871 5.95561 16.2498 6.46524 16.8923 7.10771C17.5348 7.75017 18.0444 8.51289 18.3921 9.35231C18.7398 10.1917 18.9187 11.0914 18.9187 12H19.6875Z" fill="#325FEC"/><path
d="M21.75 12C21.75 10.7196 21.4978 9.45176 21.0078 8.26884C20.5178 7.08591 19.7997 6.01108 18.8943 5.10571C17.9889 4.20034 16.9141 3.48216 15.7312 2.99217C14.5482 2.50219 13.2804 2.25 12 2.25C10.7196 2.25 9.45176 2.50219 8.26884 2.99217C7.08591 3.48216 6.01108 4.20034 5.10571 5.10571C4.20034 6.01108 3.48216 7.08591 2.99217 8.26884C2.50219 9.45176 2.25 10.7196 2.25 12H3.225C3.225 10.8477 3.45197 9.70659 3.89296 8.64195C4.33394 7.57732 4.9803 6.60997 5.79514 5.79514C6.60997 4.9803 7.57732 4.33394 8.64195 3.89296C9.70658 3.45197 10.8476 3.225 12 3.225C13.1523 3.225 14.2934 3.45197 15.358 3.89296C16.4227 4.33394 17.39 4.9803 18.2049 5.79514C19.0197 6.60997 19.6661 7.57732 20.107 8.64195C20.548 9.70659 20.775 10.8477 20.775 12H21.75Z" fill="#325FEC"/><path
d="M17.3438 12C17.3438 11.2982 17.2055 10.6034 16.937 9.95504C16.6684 9.3067 16.2748 8.71761 15.7786 8.2214C15.2824 7.72519 14.6933 7.33157 14.045 7.06302C13.3966 6.79447 12.7018 6.65625 12 6.65625C11.2982 6.65625 10.6034 6.79447 9.95504 7.06302C9.3067 7.33157 8.71761 7.72519 8.2214 8.2214C7.72518 8.71761 7.33157 9.3067 7.06302 9.95504C6.79447 10.6034 6.65625 11.2982 6.65625 12H9.78018C9.78018 11.7085 9.83759 11.4198 9.94915 11.1505C10.0607 10.8812 10.2242 10.6365 10.4303 10.4303C10.6365 10.2242 10.8812 10.0607 11.1505 9.94915C11.4198 9.83759 11.7085 9.78018 12 9.78018C12.2915 9.78018 12.5802 9.83759 12.8495 9.94915C13.1188 10.0607 13.3635 10.2242 13.5697 10.4303C13.7758 10.6365 13.9393 10.8812 14.0508 11.1505C14.1624 11.4198 14.2198 11.7085 14.2198 12H17.3438Z" fill="#325FEC"/><path
d="M13.5 12.0469C13.5 12.9012 12.8074 13.5938 11.9531 13.5938C11.0988 13.5938 10.4062 12.9012 10.4062 12.0469C10.4062 11.1926 11.0988 10.5 11.9531 10.5C12.8074 10.5 13.5 11.1926 13.5 12.0469Z" fill="#325FEC"/><path
d="M11.7188 12.4688H12.2812V24H11.7188V12.4688Z" fill="#325FEC"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">eSimora</span><span
class="dvthm-prdsec-link-desc">B2C eSIM App</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a></div><div
class="dvthm-prdsec-explore-wrap">
<a
href="https://devotel.com/products/platforms/" class="dvthm-prdsec-explore" target="_blank" rel="noopener">Explore All <svg
viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path
d="M5 12h14M12 5l7 7-7 7"/></svg></a></div></div></div><div
class="dvthm-prdsec-section" id="dvthm-prdsec-section-communication-apis"><div
class="dvthm-prdsec-mobile-block"><div
class="dvthm-prdsec-hero dvthm-prdsec-hero--mobile dvthm-prdsec-hero--communication-apis">
<img
decoding="async" class="dvthm-prdsec-hero-img lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2147228569-4.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" /></div><div
class="dvthm-prdsec-links-col">
<a
href="https://devotel.com/products/communication-apis/sms/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none"><path
d="M11.095 16.2368C14.6506 16.0026 17.4828 13.1569 17.7158 9.5844C17.7614 8.8853 17.7614 8.16131 17.7158 7.46219C17.4828 3.88969 14.6506 1.04401 11.095 0.80985C9.882 0.72997 8.61553 0.73013 7.40499 0.80985C3.84943 1.04401 1.01725 3.88969 0.7842 7.46219C0.7386 8.16131 0.7386 8.8853 0.7842 9.5844C0.86908 10.8856 1.44992 12.0903 2.13372 13.1076C2.53076 13.8197 2.26873 14.7086 1.85518 15.485C1.557 16.0448 1.40791 16.3247 1.52762 16.5269C1.64732 16.7291 1.91472 16.7356 2.44951 16.7485C3.50712 16.774 4.22028 16.4769 4.78638 16.0634C5.10744 15.8288 5.26798 15.7115 5.37862 15.6981C5.48926 15.6846 5.707 15.7734 6.14241 15.9511C6.53374 16.1108 6.98812 16.2093 7.40499 16.2368C8.61553 16.3165 9.882 16.3166 11.095 16.2368Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">SMS</span><span
class="dvthm-prdsec-link-desc">Global SMS Delivery</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/communication-apis/email/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M2 6L8.91302 9.91697C11.4616 11.361 12.5384 11.361 15.087 9.91697L22 6" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/><path
d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">Email</span><span
class="dvthm-prdsec-link-desc">Enterprise Email at Scale</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/communication-apis/whatsapp-business/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 13.3789 2.27907 14.6926 2.78382 15.8877C3.06278 16.5481 3.20226 16.8784 3.21953 17.128C3.2368 17.3776 3.16334 17.6521 3.01642 18.2012L2 22L5.79877 20.9836C6.34788 20.8367 6.62244 20.7632 6.87202 20.7805C7.12161 20.7977 7.45185 20.9372 8.11235 21.2162C9.30745 21.7209 10.6211 22 12 22Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/><path
d="M8.58815 12.3773L9.45909 11.2956C9.82616 10.8397 10.2799 10.4153 10.3155 9.80826C10.3244 9.65494 10.2166 8.96657 10.0008 7.58986C9.91601 7.04881 9.41086 7 8.97332 7C8.40314 7 8.11805 7 7.83495 7.12931C7.47714 7.29275 7.10979 7.75231 7.02917 8.13733C6.96539 8.44196 7.01279 8.65187 7.10759 9.07169C7.51023 10.8548 8.45481 12.6158 9.91948 14.0805C11.3842 15.5452 13.1452 16.4898 14.9283 16.8924C15.3481 16.9872 15.558 17.0346 15.8627 16.9708C16.2477 16.8902 16.7072 16.5229 16.8707 16.165C17 15.8819 17 15.5969 17 15.0267C17 14.5891 16.9512 14.084 16.4101 13.9992C15.0334 13.7834 14.3451 13.6756 14.1917 13.6845C13.5847 13.7201 13.1603 14.1738 12.7044 14.5409L11.6227 15.4118" stroke="#325FEC" stroke-width="1.5"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">WhatsApp</span><span
class="dvthm-prdsec-link-desc">Interactive Messaging Worldwide</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/communication-apis/rcs/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M14.1706 20.8905C18.3536 20.6125 21.6856 17.2332 21.9598 12.9909C22.0134 12.1607 22.0134 11.3009 21.9598 10.4707C21.6856 6.22838 18.3536 2.84913 14.1706 2.57107C12.7435 2.47621 11.2536 2.47641 9.8294 2.57107C5.64639 2.84913 2.31441 6.22838 2.04024 10.4707C1.98659 11.3009 1.98659 12.1607 2.04024 12.9909C2.1401 14.536 2.82343 15.9666 3.62791 17.1746C4.09501 18.0203 3.78674 19.0758 3.30021 19.9978C2.94941 20.6626 2.77401 20.995 2.91484 21.2351C3.05568 21.4752 3.37026 21.4829 3.99943 21.4982C5.24367 21.5285 6.08268 21.1757 6.74868 20.6846C7.1264 20.4061 7.31527 20.2668 7.44544 20.2508C7.5756 20.2348 7.83177 20.3403 8.34401 20.5513C8.8044 20.7409 9.33896 20.8579 9.8294 20.8905C11.2536 20.9852 12.7435 20.9854 14.1706 20.8905Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/><path
d="M11.9955 12H12.0044M15.991 12H16M8 12H8.00897" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">RCS</span><span
class="dvthm-prdsec-link-desc">Rich Messaging Experiences</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a></div><div
class="dvthm-prdsec-explore-wrap">
<a
href="https://devotel.com/products/communication-apis/" class="dvthm-prdsec-explore" target="_blank" rel="noopener">Explore All <svg
viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path
d="M5 12h14M12 5l7 7-7 7"/></svg></a></div></div></div><div
class="dvthm-prdsec-section" id="dvthm-prdsec-section-telco-solutions"><div
class="dvthm-prdsec-mobile-block"><div
class="dvthm-prdsec-hero dvthm-prdsec-hero--mobile dvthm-prdsec-hero--telco-solutions">
<img
decoding="async" class="dvthm-prdsec-hero-img lazyload" data-src="https://devotel.com/wp-content/uploads/2026/03/Frame-2147228570-1.svg" alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjwvc3ZnPg==" /></div><div
class="dvthm-prdsec-links-col">
<a
href="https://devotel.com/products/telco/voice-solutions/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><g
clip-path="url(#dvthm-voice-clip-m)"><path
d="M12 6.33337V18.3334" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M7.5 9.3335V15.3335" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M3 10.8334V13.8334" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M16.5 9.3335V15.3335" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/><path
d="M21 10.8334V13.8334" stroke="#325FEC" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath
id="dvthm-voice-clip-m"><rect
width="24" height="24" fill="white"/></clipPath></defs></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">Voice Service</span><span
class="dvthm-prdsec-link-desc">High-Quality Voice Connectivity</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/telco/sms-solutions-for-telco/" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M7.5 12H13.5M7.5 8H10.5" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M8.5 20C9.55038 20.8697 10.8145 21.4238 12.2635 21.5188C13.4052 21.5937 14.5971 21.5936 15.7365 21.5188C16.1288 21.4931 16.5565 21.4007 16.9248 21.251C17.3345 21.0845 17.5395 21.0012 17.6437 21.0138C17.7478 21.0264 17.8989 21.1364 18.2011 21.3563C18.7339 21.744 19.4051 22.0225 20.4005 21.9986C20.9038 21.9865 21.1555 21.9804 21.2681 21.7909C21.3808 21.6013 21.2405 21.3389 20.9598 20.8141C20.5706 20.0862 20.324 19.2529 20.6977 18.5852C21.3413 17.6315 21.8879 16.5021 21.9678 15.2823C22.0107 14.6269 22.0107 13.9481 21.9678 13.2927C21.9146 12.4799 21.7173 11.7073 21.4012 11" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M12.345 17.4868C15.9006 17.2526 18.7328 14.4069 18.9658 10.8344C19.0114 10.1353 19.0114 9.41131 18.9658 8.71219C18.7328 5.13969 15.9006 2.29401 12.345 2.05985C11.132 1.97997 9.86553 1.98013 8.65499 2.05985C5.09943 2.29401 2.26725 5.13969 2.0342 8.71219C1.9886 9.41131 1.9886 10.1353 2.0342 10.8344C2.11908 12.1356 2.69992 13.3403 3.38372 14.3576C3.78076 15.0697 3.51873 15.9586 3.10518 16.735C2.807 17.2948 2.65791 17.5747 2.77762 17.7769C2.89732 17.9791 3.16472 17.9856 3.69951 17.9985C4.75712 18.024 5.47028 17.7269 6.03638 17.3134C6.35744 17.0788 6.51798 16.9615 6.62862 16.9481C6.73926 16.9346 6.957 17.0234 7.39241 17.2011C7.78374 17.3608 8.23812 17.4593 8.65499 17.4868C9.86553 17.5665 11.132 17.5666 12.345 17.4868Z" stroke="#325FEC" stroke-width="1.5" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">SMS Services</span><span
class="dvthm-prdsec-link-desc">High-Volume Messaging</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/#telco" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M18.7088 3.49534C16.8165 2.55382 14.5009 2 12 2C9.4991 2 7.1835 2.55382 5.29116 3.49534C4.36318 3.95706 3.89919 4.18792 3.4496 4.91378C3 5.63965 3 6.34248 3 7.74814V11.2371C3 16.9205 7.54236 20.0804 10.173 21.4338C10.9067 21.8113 11.2735 22 12 22C12.7265 22 13.0933 21.8113 13.8269 21.4338C16.4576 20.0804 21 16.9205 21 11.2371V7.74814C21 6.34249 21 5.63966 20.5504 4.91378C20.1008 4.18791 19.6368 3.95706 18.7088 3.49534Z" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M9 11.5C9 11.5 10.4079 11.7519 11 13.5C11 13.5 12.5 10.5 15 9.5" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">SMS and Voice Firewall</span><span
class="dvthm-prdsec-link-desc">Network Protection</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a>
<a
href="https://devotel.com/products/#telco" class="dvthm-prdsec-link" target="_blank" rel="noopener">
<span
class="dvthm-prdsec-link-icon-wrap"><svg
xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path
d="M20.9427 16.8398C20.3794 13.4506 17.7138 9.90626 15.8466 7.87773C15.3176 7.30303 14.563 7.00439 13.7819 7.00439H10.2181C9.43699 7.00439 8.68241 7.30303 8.15342 7.87772C6.28619 9.90624 3.62059 13.4506 3.05727 16.8398C2.56893 19.7778 5.27927 22.0044 8.30832 22.0044H15.6917C18.7207 22.0044 21.4311 19.7778 20.9427 16.8398Z" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M12 12C10.8954 12 10 12.6716 10 13.5C10 14.3284 10.8954 15 12 15C13.1046 15 14 15.6716 14 16.5C14 17.3284 13.1046 18 12 18M12 12C12.8708 12 13.6116 12.4174 13.8862 13M12 12V11M12 18C11.1292 18 10.3884 17.5826 10.1138 17M12 18V19" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
d="M9.08607 6.99999L7 3.5L8.98473 3.83079C9.62183 3.93697 10.271 3.72894 10.7277 3.27224L12 2L13.2723 3.27224C13.729 3.72894 14.3782 3.93697 15.0153 3.83079L17 3.5L14.9139 6.99999" stroke="#325FEC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
<span
class="dvthm-prdsec-link-text"><span
class="dvthm-prdsec-link-title">SMS and Voice Monetisation</span><span
class="dvthm-prdsec-link-desc">Monetise SMS and Flash Calls Traffic</span></span>
<span
class="dvthm-prdsec-link-arrow">→</span>
</a></div><div
class="dvthm-prdsec-explore-wrap">
<a
href="https://devotel.com/products/telco/" class="dvthm-prdsec-explore" target="_blank" rel="noopener">Explore All <svg
viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path
d="M5 12h14M12 5l7 7-7 7"/></svg></a></div></div></div></div></div></div></div> <script>(function(){function initDvthmPrdsecWidget(){var root=document.getElementById('dvthm-prdsec-root');if(!root||root.getAttribute('data-dvthm-init')==='1')return;root.setAttribute('data-dvthm-init','1');var tabBarWrap=root.querySelector('#dvthm-prdsec-tab-bar-wrap');function stripFocusRing(el){if(!el||!root.contains(el))return;el.style.setProperty('outline','none','important');el.style.setProperty('outline-width','0','important');el.style.setProperty('outline-color','transparent','important');el.style.setProperty('box-shadow','none','important');el.style.setProperty('-webkit-tap-highlight-color','transparent','important')}
root.addEventListener('focusin',function(e){var el=e.target;stripFocusRing(el);setTimeout(function(){stripFocusRing(el)},0)},!0);var tabs=root.querySelectorAll('.dvthm-prdsec-tab:not(.dvthm-prdsec-tab--sim)');var panels=root.querySelectorAll('.dvthm-prdsec-panel');var heroes=root.querySelectorAll('.dvthm-prdsec-hero-col .dvthm-prdsec-hero');var sections=root.querySelectorAll('.dvthm-prdsec-section');var isMobile=function(){return window.innerWidth<=768};function setActiveTab(key){tabs.forEach(function(t){var isActive=t.getAttribute('data-dvthm-tab')===key;t.classList.toggle('dvthm-prdsec-tab--active',isActive);t.setAttribute('aria-selected',isActive);if(isActive){t.style.setProperty('background','#325fec','important');t.style.setProperty('background-color','#325fec','important');t.style.setProperty('color','#ffffff','important')}else{t.style.setProperty('background','transparent','important');t.style.setProperty('background-color','transparent','important');t.style.setProperty('color','#64748b','important')}});panels.forEach(function(p){if(p.getAttribute('data-dvthm-panel')===key){p.style.display='block'}else{p.style.display='none'}});heroes.forEach(function(h){var name=h.getAttribute('data-dvthm-hero');h.style.display=name===key?'block':'none'})}
function applyTabHoverStyle(tab,isHover){if(!tab||!root.contains(tab))return;var isActive=tab.classList.contains('dvthm-prdsec-tab--active');tab.classList.toggle('dvthm-prdsec-tab--hover',isHover);if(isHover||isActive){tab.style.setProperty('background','#325fec','important');tab.style.setProperty('background-color','#325fec','important');tab.style.setProperty('color','#ffffff','important')}else{tab.style.setProperty('background','transparent','important');tab.style.setProperty('background-color','transparent','important');tab.style.setProperty('color','#64748b','important')}}
tabs.forEach(function(tab){tab.addEventListener('mouseenter',function(){applyTabHoverStyle(this,!0)});tab.addEventListener('mouseleave',function(){applyTabHoverStyle(this,!1)});tab.addEventListener('focus',function(){applyTabHoverStyle(this,!0)});tab.addEventListener('blur',function(){applyTabHoverStyle(this,!1)});tab.addEventListener('click',function(){var key=this.getAttribute('data-dvthm-tab');setActiveTab(key);if(isMobile()){var section=root.querySelector('#dvthm-prdsec-section-'+key);if(section)section.scrollIntoView({behavior:'smooth',block:'start'})}})});var stickyTopOffset=72;var tabRectEl=tabBarWrap?tabBarWrap.parentElement:null;function updateSticky(){if(!isMobile()||!tabBarWrap)return;var rootRect=root.getBoundingClientRect();var tabRect=tabBarWrap.getBoundingClientRect();var sectionScrolledIntoView=rootRect.top<=stickyTopOffset;var sectionStillInView=rootRect.bottom>stickyTopOffset;var barAtStickPosition=tabRect.top<=stickyTopOffset;var isStuck=sectionScrolledIntoView&&sectionStillInView&&barAtStickPosition;tabBarWrap.classList.toggle('dvthm-prdsec-tab-bar--stuck',isStuck);tabBarWrap.classList.toggle('dvthm-prdsec-tab-bar--fixed',isStuck);if(tabRectEl){tabRectEl.style.minHeight=isStuck?tabBarWrap.offsetHeight+'px':''}}
function scrollTabBarToTab(tabEl){if(!tabBarWrap||!tabEl)return;var wrap=tabBarWrap;var tabLeft=tabEl.offsetLeft;var tabWidth=tabEl.offsetWidth;var wrapWidth=wrap.offsetWidth;var scrollLeft=tabLeft-(wrapWidth/2)+(tabWidth/2);wrap.scrollTo({left:Math.max(0,scrollLeft),behavior:'smooth'})}
var observer=null;function initScrollSpy(){if(!isMobile()||sections.length===0)return;if(observer)observer.disconnect();observer=new IntersectionObserver(function(entries){var best=null;var bestRatio=0;entries.forEach(function(entry){if(!entry.isIntersecting)return;var r=entry.intersectionRatio;if(r>bestRatio){bestRatio=r;best=entry.target}});if(best&&best.id){var key=best.id.replace('dvthm-prdsec-section-','');if(key){setActiveTab(key);var activeTab=root.querySelector('.dvthm-prdsec-tab[data-dvthm-tab="'+key+'"]');scrollTabBarToTab(activeTab)}}},{rootMargin:'-25% 0px -45% 0px',threshold:[0,0.1,0.25,0.5]});sections.forEach(function(s){observer.observe(s)})}
function onScroll(){requestAnimationFrame(updateSticky)}
window.addEventListener('scroll',onScroll,{passive:!0});window.addEventListener('resize',function(){updateSticky();initScrollSpy()});updateSticky();setTimeout(updateSticky,150);initScrollSpy();var initialActive=root.querySelector('.dvthm-prdsec-tab--active');if(initialActive){setActiveTab(initialActive.getAttribute('data-dvthm-tab'))}}
try{if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',initDvthmPrdsecWidget)}else{initDvthmPrdsecWidget()}}catch(e){}})()</script> </div></div><div
class="elementor-element elementor-element-698e5c1 e-con-full e-flex e-con e-parent" data-id="698e5c1" data-element_type="container" data-e-type="container"><div