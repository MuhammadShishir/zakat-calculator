<?php
/*
Plugin Name: Zakat Calculator Elementor 
Description: A simple Elementor widget to calculate Zakat.
Version: 1.0
Author: MKS Entertainment & Technologies
Author URI: https://mkshishir.pages.dev/
Text Domain: zakat-calculator-elementor
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class Elementor_Zakat_Calculator {

    function __construct() {
        // Enqueue scripts and styles
        add_action('elementor/frontend/after_register_scripts', array($this, 'enqueue_zakat_calculator_assets'));

        // Register the Elementor widget
        add_action('elementor/widgets/widgets_registered', array($this, 'register_zakat_calculator_widget'));
    }

    // Enqueue scripts and styles
    function enqueue_zakat_calculator_assets() {
        // Enqueue your CSS and JS files here
        wp_enqueue_style('zakat-calculator-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script('zakat-calculator-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
    }

    // Register the Elementor widget
    function register_zakat_calculator_widget() {
        // Include your widget class file and register the widget
        require_once(plugin_dir_path(__FILE__) . 'includes/class-elementor-zakat-calculator-widget.php');

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Zakat_Calculator_Widget());
    }
}

// Instantiate the plugin class
new Elementor_Zakat_Calculator();
