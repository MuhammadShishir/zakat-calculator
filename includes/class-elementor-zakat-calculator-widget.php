<?php

use Elementor\Controls_Manager;

class Elementor_Zakat_Calculator_Widget extends \Elementor\Widget_Base {

    // Widget constructor
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        // Enqueue scripts and styles
        add_action('elementor/frontend/after_register_scripts', [$this, 'enqueue_zakat_calculator_assets']);
    }

    // Enqueue scripts and styles
    public function enqueue_zakat_calculator_assets() {
        // Enqueue your CSS and JS files here
        wp_enqueue_style('zakat-calculator-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script('zakat-calculator-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', ['jquery'], null, true);
    }

    // Widget name
    public function get_name() {
        return 'zakat_calculator';
    }

    // Widget title
    public function get_title() {
        return __('Zakat Calculator', 'elementor-zakat-calculator');
    }

    // Widget icon
    public function get_icon() {
        return 'eicon-calculator';
    }

    // Widget categories
    public function get_categories() {
        return ['basic'];
    }

    // Register widget controls
    protected function _register_controls() {
        // Content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'elementor-zakat-calculator'),
            ]
        );

        // Label control
        $this->add_control(
            'label',
            [
                'label' => __('Label', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Enter your money amount:', 'elementor-zakat-calculator'),
                'placeholder' => __('Enter your money amount:', 'elementor-zakat-calculator'),
            ]
        );

        $this->end_controls_section();

        // Style section for form
        $this->start_controls_section(
            'form_style_section',
            [
                'label' => __('Form Style', 'elementor-zakat-calculator'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Form label color control
        $this->add_control(
            'form_label_color',
            [
                'label' => __('Label Color', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .zakat-calculator-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Form label font size control
        $this->add_control(
            'form_label_font_size',
            [
                'label' => __('Label Font Size', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .zakat-calculator-label' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Input color control
        $this->add_control(
            'input_color',
            [
                'label' => __('Input Color', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .zakat-calculator-input' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Input background color control
        $this->add_control(
            'input_background_color',
            [
                'label' => __('Input Background Color', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .zakat-calculator-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Submit button color control
        $this->add_control(
            'button_color',
            [
                'label' => __('Button Color', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .zakat-calculator-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Submit button background color control
        $this->add_control(
            'button_background_color',
            [
                'label' => __('Button Background Color', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .zakat-calculator-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style section for overlay
        $this->start_controls_section(
            'overlay_style_section',
            [
                'label' => __('Overlay Style', 'elementor-zakat-calculator'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Overlay color control
        $this->add_control(
            'overlay_color',
            [
                'label' => __('Overlay Color', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .zakat-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Background Image control
        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'elementor-zakat-calculator'),
                'type' => Controls_Manager::MEDIA,
                'selectors' => [
                    '{{WRAPPER}} .zakat-overlay' => 'background-image: url({{URL}});',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // Render widget output on the frontend
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="zakat-calculator-container">
            <div class="zakat-overlay" style="background-color: <?php echo esc_attr($settings['overlay_color']); ?>; background-image: url('<?php echo esc_attr($settings['background_image']['url']); ?>');">
                <form class="zakat-calculator-form">
                    <label class="zakat-calculator-label" style="color: <?php echo esc_attr($settings['form_label_color']); ?>; font-size: <?php echo esc_attr($settings['form_label_font_size']['size'] . $settings['form_label_font_size']['unit']); ?>"><?php echo esc_html($settings['label']); ?></label>
                    <input type="number" class="zakat-calculator-input" step="0.01" required style="color: <?php echo esc_attr($settings['input_color']); ?>; background-color: <?php echo esc_attr($settings['input_background_color']); ?>;">
                    <button type="submit" class="zakat-calculator-submit" style="color: <?php echo esc_attr($settings['button_color']); ?>; background-color: <?php echo esc_attr($settings['button_background_color']); ?>;"><?php _e('Calculate', 'elementor-zakat-calculator'); ?></button>
                </form>
                <div class="zakat-calculator-result" style="display: none;">
                    <h3 class="zakat-calculator-result-title"><?php _e('Zakat Amount:', 'elementor-zakat-calculator'); ?></h3>
                    <span class="zakat-calculator-result-amount"></span>
                    <h6><?php _e('Zakat Amount is 2.5% of Your Money Amount', 'elementor-zakat-calculator'); ?></h6>
                </div>
            </div>
        </div>
        <?php
    }
}

// Register the widget
function register_elementor_zakat_calculator_widget() {
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_Zakat_Calculator_Widget());
}
add_action('elementor/widgets/widgets_registered', 'register_elementor_zakat_calculator_widget');
