function init() {
	selectize = $("#userid").selectize({
		create: true
	});
}

window.addEventListener('load', init);