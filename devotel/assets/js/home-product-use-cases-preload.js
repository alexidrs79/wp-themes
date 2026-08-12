(function () {
	var base = window.devotelHomeProductUseCases && devotelHomeProductUseCases.uploadsBase;
	if (!base) {
		return;
	}

	var files = [
		'2026/05/Notification-Campaigns.png',
		'2026/05/Authentication-Security.png',
		'2026/05/Customer-Care.png',
		'2026/05/eSIM-Connectivity.png',
	];

	for (var i = 0; i < files.length; i++) {
		var im = new Image();
		im.decoding = 'async';
		im.src = base + files[i];
	}
})();
