(function () {
	var CASE_IMG_SIZES = '(max-width: 768px) min(100vw - 32px, 292px), 292px';

	function retryLoad(img) {
		var raw = img.getAttribute('src');
		if (!raw || img.dataset.ducImgRetry) {
			return;
		}
		img.dataset.ducImgRetry = '1';
		try {
			var u = new URL(raw, window.location.href);
			u.searchParams.set('duc-retry', String(Date.now()));
			img.src = u.toString();
		} catch (e) {
			img.src =
				raw + (raw.indexOf('?') >= 0 ? '&' : '?') + 'duc-retry=' + Date.now();
		}
	}

	function arm(img) {
		if (!img || img.dataset.ducImgArm) {
			return;
		}
		img.dataset.ducImgArm = '1';
		img.addEventListener('error', function () {
			retryLoad(img);
		});
	}

	function applyRetinaSrcset(img) {
		function apply() {
			var nw = img.naturalWidth;
			if (nw < 1) {
				return;
			}
			var src = img.getAttribute('src');
			if (!src) {
				return;
			}
			img.sizes = CASE_IMG_SIZES;
			img.srcset = src + ' ' + nw + 'w';
		}
		if (img.complete && img.naturalWidth > 0) {
			apply();
		} else {
			img.addEventListener('load', apply, { once: true });
		}
	}

	function prefetchCaseImages(imgs) {
		for (var i = 1; i < imgs.length; i++) {
			(function (url) {
				if (!url) {
					return;
				}
				var warm = new Image();
				warm.decoding = 'async';
				if (warm.fetchPriority !== undefined) {
					warm.fetchPriority = 'high';
				}
				warm.src = url;
			})(imgs[i].getAttribute('src'));
		}
	}

	var root = document.getElementById('devotel-product-use-cases');
	if (!root) {
		return;
	}

	var imgs = root.querySelectorAll('.duc-case-card__img');
	imgs.forEach(function (img) {
		arm(img);
		applyRetinaSrcset(img);
	});
	prefetchCaseImages(imgs);
})();
