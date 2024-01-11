<?php
/**
 * Plugin Name: Social Feeds for Elementor
 * Description: Facebook likebox display widget for elementor.
 * Plugin URI:  https://www.junktheme.com
 * Version:     1.0.1
 * Author:      Junk Theme
 * Text Domain: social-feeds-for-em
*/

if( ! defined( 'ABSPATH' ) ) exit();

 /**
 * Elementor Extension main CLass
 * @since 1.0.0
 */
final class SFF_Elementor_Widget {

    // Plugin version
    const VERSION = '1.0.0';

    // Minimum Elementor Version
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    // Minimum PHP Version
    const MINIMUM_PHP_VERSION = '7.0';

    // Instance
    private static $_instance = null;

    /**
    * SIngletone Instance Method
    * @since 1.0.0
    */
    public static function instance() {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * Construct Method
    * @since 1.0.0
    */
    public function __construct() {
        // Call Constants Method
        $this->define_constants();
        // add_action( 'wp_enqueue_scripts', [ $this, 'scripts_styles' ] );
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    /**
    * Define Plugin Constants
    * @since 1.0.0
    */
    public function define_constants() {
        define( 'SFF_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
        define( 'SFF_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
    }

    /**
    * Load Text Domain
    * @since 1.0.0
    */
    public function i18n() {
       load_plugin_textdomain( 'sff-elementor-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
    * Initialize the plugin
    * @since 1.0.0
    */
    public function init() {
        // Check if the ELementor installed and activated
        if( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        if( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        if( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        add_action( 'elementor/init', [ $this, 'init_category' ] );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }

    /**
    * Init Widgets
    * @since 1.0.1
    */
    public function init_widgets() {
        require_once SFF_PLUGIN_PATH . '/widgets/social-f.php';
        require_once SFF_PLUGIN_PATH . '/widgets/social-t.php';
    }

    /**
    * Init Category Section
    * @since 1.0.0
    */
    public function init_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'sff-for-elementor',
            [
                'title' => 'Social Profile Display by JunkTheme.COM'
            ],
            1
        );
    }

    /**
    * Admin Notice
    * Warning when the site doesn't have Elementor installed or activated
    * @since 1.0.0
    */
    public function admin_notice_missing_main_plugin() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated', 'sff-elementor-widget' ),
            '<strong>'.esc_html__( 'Social Feeds for Elementor', 'sff-elementor-widget' ).'</strong>',
            '<strong>'.esc_html__( 'Elementor', 'my-elementor-widget' ).'</strong>'
        );

        printf( '<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin Notice
    * Warning when the site doesn't have a minimum required Elementor version.
    * @since 1.0.0
    */
    public function admin_notice_minimum_elementor_version() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater', 'sff-elementor-widget' ),
            '<strong>'.esc_html__( 'Social Feeds for Elementor', 'sff-elementor-widget' ).'</strong>',
            '<strong>'.esc_html__( 'Elementor', 'sff-elementor-widget' ).'</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin Notice
    * Warning when the site doesn't have a minimum required PHP version.
    * @since 1.0.0
    */
    public function admin_notice_minimum_php_version() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater', 'sff-elementor-widget' ),
            '<strong>'.esc_html__( 'Social Feeds for Elementor', 'sff-elementor-widget' ).'</strong>',
            '<strong>'.esc_html__( 'PHP', 'sff-elementor-widget' ).'</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message );
    }

}

SFF_Elementor_Widget::instance();