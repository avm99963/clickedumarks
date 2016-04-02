function init() {
	selectize = $("#query").selectize({
		create: true
	});
}

window.addEventListener('load', init);