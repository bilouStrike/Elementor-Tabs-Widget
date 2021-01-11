<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

defined( 'ABSPATH' ) || die();

class Awesometabs extends Widget_Base {

	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_enqueue_style( 'awesometabs', plugins_url( '/assets/css/style.css', dirname( __FILE__ ) ), array(), '1.0.0' );
		wp_enqueue_style( 'load-fas', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
		wp_register_script( 'awesometabs-js', plugins_url( '/assets/js/tabs-script.js', dirname( __FILE__ ) ), [ 'elementor-frontend' ], '1.0.0', true );
	}


	public function get_script_depends() {
		return [ 'awesometabs-js' ];
	}
	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesometabs';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Awesome Tabs', 'awesome-tabs' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-pencil';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}
	
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Title', 'awesome-tabs' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'awesome-tabs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Tabs Title' , 'awesome-tabs' ),
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Tabs', 'awesome-tabs' ),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Title', 'awesome-tabs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Tab title' , 'awesome-tabs' )
			]
		);

		$repeater->add_control(
			'tab_content', [
				'label' => __( 'Content', 'awesome-tabs' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Tab content' , 'awesome-tabs' ),
			]
		);

		$repeater->add_control(
			'tab_button_text',
			[
				'label' => __( 'CTA button', 'awesome-tabs' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Button Text Here' , 'awesome-tabs' ),
			]
		);

		$repeater->add_control(
			'tab_button_url',
			[
				'label' => __( 'Button URL', 'awesome-tabs' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'Your Link Here', 'awesome-tabs' ),
			]
		);

		$repeater->add_control(
			'tab_image',
			[
				'label' => __( 'Image', 'awesome-tabs' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __( 'Add Your Tabs', 'awesome-tabs' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'TAB Title Here #1', 'awesome-tabs' ),
						'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', 'awesome-tabs' ),
						'tab_button_text' => __( 'Tab Buton Text Here', 'awesome-tabs' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title', 'basic' );

		?>
			<div class="tabs">
				<div class="tabs__list">
					<h2 <?php echo $this->get_render_attribute_string( 'title' ); ?>> <?php echo $settings['title']; ?> </h2>
					<ul class="tabs__items">
						<?php
							foreach ( $settings['tabs'] as $index => $tab ) {
								$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

								$this->add_render_attribute( $tab_title_setting_key, [
									'data-id' => [$tab['_id']],
									'class' => $index === 0 ? 'active' : ''
								] );
								$this->add_inline_editing_attributes( $tab_title_setting_key, 'advanced' );
								?>
									<li <?php echo $this->get_render_attribute_string( $tab_title_setting_key ) ?> >
										<span> <?php echo esc_html( $tab['tab_title'] ) ; ?> </span>
										<i class="fa fa-check-circle"></i>
									</li>
								<?php
							}
						?>
					</ul>
				</div>
				<?php
					foreach ( $settings['tabs'] as $index => $content ) {

						$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );
						$tab_button_text_setting_key = $this->get_repeater_setting_key( 'tab_button_text', 'tabs', $index );

						$this->add_render_attribute( $tab_content_setting_key);
						$this->add_render_attribute( $tab_button_text_setting_key, [
							'class' => ['tabs__CTA'],
							'href' => $content['tab_button_url'] 
						]);

						$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
						$this->add_inline_editing_attributes( $tab_button_text_setting_key, 'advanced' );

						?>
							<div class="tabs__content" data-id=<?php echo esc_attr( $content['_id'] ) ?>>
								<?php
									printf(
									'	<div class="tabs__description">
											<p %1$s> %2$s </p>
											<a %3$s > %4$s </a>
										</div>
										<div class="tabs__image">
											<img src="%5$s" />
										</div>
									',
									$this->get_render_attribute_string( $tab_content_setting_key ),
									esc_html( $content['tab_content'] ),
									$this->get_render_attribute_string( $tab_button_text_setting_key ),
									esc_html( $content['tab_button_text']),
									esc_url( $content['tab_image']['url'] ),
									);
								?>
							</div>
						<?php
					}
				?>
			</div>
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
			<div class="tabs">
				<div class="tabs__list">
					<#
						view.addInlineEditingAttributes( 'title', 'basic' );
					#>
					<h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
					<# if ( settings.tabs.length ) { #>
						<ul class="tabs__items">
							<# _.each( settings.tabs, function( item, index ) { 
								var tabTitletKey = view.getRepeaterSettingKey( 'tab_title', 'tabs', index );

								view.addRenderAttribute( tabTitletKey,  {
									'data-id' : [ item._id ],
									'class' : index === 1 ? 'active' : ''
								} );

								view.addInlineEditingAttributes( tabTitletKey, 'advanced' );
							#>
								<li {{{ view.getRenderAttributeString( tabTitletKey ) }}} >{{{ item.tab_title }}}</li>
							<# }); #>
						</ul>
					<# } #>
				</div>
				<# if ( settings.tabs.length ) { 
					_.each( settings.tabs, function( item, index ) { 
						var tabContentKey = view.getRepeaterSettingKey( 'tab_content', 'tabs', index );
						var tabButtonTextKey = view.getRepeaterSettingKey( 'tab_button_text', 'tabs', index );

						view.addRenderAttribute( tabContentKey );
						view.addRenderAttribute( tabButtonTextKey,  {
							'class' : [ 'tabs__CTA' ],
							'href' : item.tab_button_url ? item.tab_button_url : ''
						} );

						view.addInlineEditingAttributes( tabContentKey, 'advanced' );
						view.addInlineEditingAttributes( tabButtonTextKey, 'advanced' );

						var tabContentImageUrl = item.image ?  item.image : '';
						#>
						<div class="tabs__content" data-id="{{ item._id }}">
							<div class="tabs__description">
								<p {{{ view.getRenderAttributeString( tabContentKey )  }}}> {{{ item.tab_content }}} </p>
								<a {{{ view.getRenderAttributeString( tabButtonTextKey )  }}}> {{{ item.tab_button_text }}} </a>
							</div>
							<div class="tabs__image">
								<img src="{{{ tabContentImageUrl }}}" />
							</div>
						</div>
					<# }); #>
				<# } #>
			</div>
		<?php
	}
}