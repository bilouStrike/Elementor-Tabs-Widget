jQuery( window ).on(
	'elementor/frontend/init',
	() => {
		const TabsHandler = () => {

			jQuery('.tabs').map(function(index, val) {
				jQuery(val).children().slice(2).hide();
			});

			// listen for click event
			jQuery(".tabs__list li").click(function() {
				const $this = jQuery( this );
				const tabIndex = jQuery(this).attr('data-id');
				const tabsContent = $this.closest('.tabs').children().slice(1);
				const tabsList = $this.parent().children();
				tabsList.map(function() {
					jQuery(this).removeClass('active');
					tabsContent.hide();
				});
				jQuery(this).addClass('active');
				displayTabsContent(tabIndex, tabsContent);
			});

			// display tab content
			function displayTabsContent(tabIndex, tabsContent) {
				tabsContent.map(function() {
					if (jQuery(this).attr('data-id') == tabIndex) {
						jQuery(this).show().fadeIn();
						return;
					}
				});
			}

		};

		elementorFrontend.hooks.addAction(
			'frontend/element_ready/awesometabs.default',
			TabsHandler
		);
});
