<?php

namespace Elementor;

class SFF_Twitter_Widget extends Widget_Base {
    public function get_name()
    {
        return 'sff-twitter-widget-id';
    }

    public function get_title() {
        return esc_html('Social Twitter Feeds', 'sff-elementor-widget');
    }

    public function get_icon() {
        return 'eicon-twitter-feed';
    }

    public function get_categories() {
        return [ 'sff-for-elementor' ];
    }

    public function _register_controls() {

        // Controls - Content Settings

        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content Settings', 'social-feeds-for-em' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        // control fields
        $this->add_control(
			'tw_page_url',
			[
				'label' => __( 'Twitter Profile URL', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( '', 'social-feeds-for-em' ),
				'show_external' => false,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => true,
				],
			]
		);

        $this->add_control(
			'width',
			[
				'label' => __( 'Width', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 240,
				'step' => 5,
				'default' => '',
			]
		);

        $this->add_control(
			'height',
			[
				'label' => __( 'Height', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 180,
				'step' => 5,
				'default' => '',
			]
		);

        $this->add_control(
			'language',
			[
				'label' => __( 'Language Code', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '', 'social-feeds-for-em' ),
				'placeholder' => __( 'eg: en - keep blank for auto selection', 'social-feeds-for-em' ),
			]
		);

        $this->add_control(
			'theme',
			[
				'label' => __( 'Theme', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Light', 'social-feeds-for-em' ),
				'label_off' => __( 'Dark', 'social-feeds-for-em' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->end_controls_section();

        // Style Tab
        $this->style_tab();

    }

    private function style_tab() {

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if ( 'yes' === $settings['theme'] ) {
            $theme = '';
        } else {
            $theme = 'dark';
        }

        ?>
		<?php if (!empty($settings['tw_page_url']['url'])) : ?>

            <a class="twitter-timeline" data-width="<?php echo esc_attr($settings['width']) ?>" data-height="<?php echo esc_attr($settings['height']) ?>" data-theme="<?php echo esc_attr($theme) ?>" href="<?php echo esc_url($settings['tw_page_url']['url']) ?>">Tweets</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		
		<?php else : ?>

			<p>Please, Input your twitter profile url.</p>

		<?php endif; ?>

<?php
    }

    protected function content_template()
    {
        
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new SFF_Twitter_widget() );