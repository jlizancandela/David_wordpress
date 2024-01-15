<?php

namespace Elementor;

class SFF_Facebook_Widget extends Widget_Base {
    public function get_name()
    {
        return 'sff-facebook-widget-id';
    }

    public function get_title() {
        return esc_html('Social Facebook Feeds', 'sff-elementor-widget');
    }

    public function get_icon() {
        return 'eicon-facebook-like-box';
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
			'fb_page_url',
			[
				'label' => __( 'Facebook Page URL', 'social-feeds-for-em' ),
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
			'timeline',
			[
				'label' => __( 'Timeline', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'timeline', 'social-feeds-for-em' ),
				'placeholder' => __( 'eg: timeline,events,messages', 'social-feeds-for-em' ),
			]
		);

        $this->add_control(
			'width',
			[
				'label' => __( 'Width', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 180,
				'max' => 500,
				'step' => 5,
				'default' => 340,
			]
		);

        $this->add_control(
			'height',
			[
				'label' => __( 'Height', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 70,
				'step' => 5,
				'default' => 500,
			]
		);

        $this->add_control(
			'show_facepile',
			[
				'label' => __( 'Show Friend Photos', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'social-feeds-for-em' ),
				'label_off' => __( 'Hide', 'social-feeds-for-em' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'hide_cover',
			[
				'label' => __( 'Hide Cover', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'social-feeds-for-em' ),
				'label_off' => __( 'Hide', 'social-feeds-for-em' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'hide_cta',
			[
				'label' => __( 'Hide Call To Action Button', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'social-feeds-for-em' ),
				'label_off' => __( 'Hide', 'social-feeds-for-em' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'small_header',
			[
				'label' => __( 'Small Header', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'social-feeds-for-em' ),
				'label_off' => __( 'Hide', 'social-feeds-for-em' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $this->add_control(
			'adapt_container_width',
			[
				'label' => __( 'Adapt Container Width', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'social-feeds-for-em' ),
				'label_off' => __( 'Hide', 'social-feeds-for-em' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->add_control(
			'lazy',
			[
				'label' => __( 'Lazy Loading', 'social-feeds-for-em' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'social-feeds-for-em' ),
				'label_off' => __( 'Hide', 'social-feeds-for-em' ),
				'return_value' => 'yes',
				'default' => 'no',
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

        // $fb_page_url = wp_oembed_get($sff_values['fb_page_url']['url']);

        if ( 'yes' === $settings['show_facepile'] ) {
            $facepile = 'true';
        } else {
            $facepile = 'false';
        }
        // echo $facepile;

        if ( 'yes' === $settings['hide_cover'] ) {
            $hide_cover = 'true';
        } else {
            $hide_cover = 'false';
        }
        // echo $hide_cover;

        if ( 'yes' === $settings['hide_cta'] ) {
            $hide_cta = 'true';
        } else {
            $hide_cta = 'false';
        }

        if ( 'yes' === $settings['small_header'] ) {
            $small_header = 'true';
        } else {
            $small_header = 'false';
        }

        if ( 'yes' === $settings['adapt_container_width'] ) {
            $adapt_container_width = 'true';
        } else {
            $adapt_container_width = 'false';
        }

        if ( 'yes' === $settings['lazy'] ) {
            $lazy = 'true';
        } else {
            $lazy = 'false';
        }

        ?>
		<?php if (!empty($settings['fb_page_url']['url'])) : ?>

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v12.0" nonce="3mhOXtbx"></script>

        <div class="fb-page" data-href="<?php echo esc_url($settings['fb_page_url']['url']) ?>" data-tabs="<?php echo esc_attr($settings['timeline']) ?>" data-width="<?php echo esc_attr($settings['width']) ?>" data-height="<?php echo esc_attr($settings['height']) ?>" data-small-header="<?php echo esc_attr($small_header) ?>" data-adapt-container-width="<?php echo esc_attr($adapt_container_width) ?>" data-hide-cover="<?php echo esc_attr($hide_cover) ?>" data-show-facepile="<?php echo esc_attr($facepile) ?>" data-hide-cta="<?php echo esc_attr($hide_cta) ?>" data-lazy="<?php echo esc_attr($lazy) ?>"><blockquote cite="<?php echo esc_url($settings['fb_page_url']['url']) ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo esc_url($settings['fb_page_url']['url']) ?>"><?php echo esc_url($settings['fb_page_url']['url']) ?></a></blockquote></div>
		
		<?php else : ?>

			<p>Please, Input your social profile url.</p>

		<?php endif; ?>

<?php
    }

    protected function content_template()
    {
        
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new SFF_Facebook_widget() );