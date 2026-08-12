(function () {
	var base = window.devotelHomeHero && devotelHomeHero.uploadsBase;
	if (!base) {
		return;
	}
	var paths = [
		'2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-2.webp',
		'2026/05/Frame-2147227788-2.webp',
		'2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-3.webp',
		'2026/05/Frame-2147227788-8.webp',
		'2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-1.webp',
		'2026/05/Frame-2147227788.png',
		'2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1.png',
	];
	for (var i = 0; i < paths.length; i++) {
		var im = new Image();
		im.decoding = 'async';
		if (im.fetchPriority !== undefined) {
			im.fetchPriority = i < 4 ? 'high' : 'auto';
		}
		im.src = base + paths[i];
	}
})();
