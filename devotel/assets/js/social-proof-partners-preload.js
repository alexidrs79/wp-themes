(function () {
	var cfg = window.devotelPartnerLogos || {};
	var base = cfg.uploadsBase;
	if (!base) {
		return;
	}
	var numbers = cfg.logoNumbers;
	if (!numbers || !numbers.length) {
		numbers = [];
		var n;
		for (n = 1; n <= 13; n++) {
			numbers.push(n);
		}
		for (n = 15; n <= 27; n++) {
			numbers.push(n);
		}
	}
	var urls = [];
	for (var i = 0; i < numbers.length; i++) {
		urls.push(base + '2026/05/partner-logo-' + numbers[i] + '.png');
	}
	for (var j = 0; j < urls.length; j++) {
		var im = new Image();
		im.decoding = 'async';
		if (im.fetchPriority !== undefined) {
			im.fetchPriority = j < 14 ? 'high' : 'low';
		}
		im.src = urls[j];
	}
})();
