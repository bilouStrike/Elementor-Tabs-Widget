(function() {
	jQuery(document).ready(function() {
		let tabsContent = jQuery('.tabs .tabs__content');

		// Keep only the dirst tab content open
		tabsContent.map(function(index,val) {
			if (index != 0) {
				jQuery(this).hide();
			}
		});

		// listen for click event
		jQuery(".tabs__list li").click(function() {
			let tabsList = jQuery('.tabs__items li');
			let tabIndex = jQuery(this).attr('data-id');
			tabsList.map(function(index,val) {
				jQuery(this).removeClass('active');
				tabsContent.hide();
			});
			jQuery(this).addClass('active');
			displayTabsContent(tabIndex);
		});

		function displayTabsContent(tabIndex) {
			tabsContent.map(function(index,val) {
				if (jQuery(this).attr('data-id') == tabIndex) {
					jQuery(this).show().fadeIn();
					return;
				}
			});
		}
	});
})(jQuery);
