<?php

// Initialize the plugin.
add_action( 'plugins_loaded', 'init' );

function init() {

    // Check if Elementor installed and activated.
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'admin_notice_missing_main_plugin' );
		return;
    }
    add_action( 'elementor/widgets/widgets_registered', 'register_widgets' );
}

/**
* Admin notice
*/
function admin_notice_missing_main_plugin() {
    ?>
        <div class="notice notice-warning is-dismissible">
            Awesome-tabs requires Elementor to be installed and activated.</p>
        </div>
    <?php
}

function register_widgets() {
    // include Widgets files.
    require_once 'widget/class-awesometabs.php';

    // Register the plugin widget classes.
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Awesometabs() );
}
