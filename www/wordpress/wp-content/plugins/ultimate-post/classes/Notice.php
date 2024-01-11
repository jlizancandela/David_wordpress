<?php
/**
 * Notice Action.
 * 
 * @package ULTP\Notice
 * @since v.1.0.0
 */
namespace ULTP;

defined('ABSPATH') || exit;

/**
 * Notice class.
 */
class Notice {
    /**
	 * Setup class.
	 *
	 * @since v.1.0.0
	 */
    private $notice_version = 'v13';    
    private $valid_notices = array();
    public function __construct(){
        $default_notice = ultimate_post()->get_notice_data('banner', $this->notice_version);

        $this->valid_notices = array();
        if (is_array($default_notice ) && count($default_notice) > 0) {
            foreach ($default_notice as $key => $notice) {
                $current_time = date('U');

                if ($current_time > strtotime($notice['start']) && $current_time < strtotime($notice['end']) && $notice['visibility']) {
                    $this->valid_notices[] = $notice;
                }
            }
        }

        if (count($this->valid_notices) > 0) {
            add_action('admin_notices',array($this,'ultp_installation_notice_callback'));
        }
		add_action('admin_init', array($this, 'set_dismiss_notice_callback'));
	}

    /**
	 * Promotional Dismiss Notice Option Data
     * 
     * @since v.2.0.1
	 * @param NULL
	 * @return NULL
	 */
	public function set_dismiss_notice_callback() {
        if(count($this->valid_notices)>0) {
            foreach ($this->valid_notices as $notice) {
                $notice_key = isset($notice['key'])?$notice['key']:$this->notice_version;                
                if (isset($_GET['disable_postx_notice_' .$notice_key ])) {
                    if (sanitize_key($_GET['disable_postx_notice_' . $notice_key]) == 'yes') {
                        // set_transient( 'ultp_get_pro_notice_' . $this->notice_version, 'off', 2592000 ); // 30 days notice
                        if(isset($notice['repeat_interval']) && ''!=$notice['repeat_interval']) {
                            $interval = (int) $notice['repeat_interval'];
                            $this->set_notice('ultp_get_pro_notice_' . $notice_key, 'off',  $interval ); // 30 (2592000) days notice
                        } else {
                            
                            $this->set_notice('ultp_get_pro_notice_' . $notice_key, 'off' ); // 30 (2592000) days notice
                        }
                    }
                }
                
                
            }
        }
	}

    /**
	 * Dismiss Notice HTML Data
     * 
     * @since v.1.0.0
	 * @param NULL
	 * @return STRING
	 */
	public function ultp_installation_notice_callback() {    
        // ultimate_post()->get_tran('ultp_get_pro_notice_' . $this->notice_version) != 'off'        
        if(count($this->valid_notices)>0) {
            foreach ($this->valid_notices as $notice) {                
                $notice_key = isset($notice['key'])?$notice['key']:$this->notice_version;
                if ($this->get_notice('ultp_get_pro_notice_' . $notice_key) != 'off') {
                    // if (!ultimate_post()->is_lc_active() && ($this->force || get_transient('wpxpo_installation_date') != 'yes')) {
                    if ( ($notice['force'] || get_transient('wpxpo_installation_date') != 'yes') ) {                        
                        if (!isset($_GET['disable_postx_notice_' . $notice_key])) {
                            $this->ultp_notice_css();
                            
                            ?>
                            
                            
                                <?php
                                    switch ($notice['type']) {
                                        case 'banner': 
                                        ?>
                                        <div class="wc-install ultp-free-notice">
                                            <div class="wc-install-body ultp-image-banner">
                                                <a class="wc-dismiss-notice" href="<?php echo esc_url( add_query_arg( 'disable_postx_notice_' . $notice_key, 'yes' ) ); ?>">
                                                    Dismiss
                                                </a>
                                                <a class="ultp-btn-image" target="_blank" href="<?php echo esc_url($notice['url']); ?>">
                                                    <img loading="lazy" src="<?php echo esc_url($notice['content']); ?>" alt="Discount Banner"/>
                                                </a>
                                            </div>
                                            </div>
                                        <?php
                                         break;
                                        case 'content':
                                            echo $notice['content'];
                                        ?>
                                        <?php break;
                                    }
                                ?>
                            
                            <?php
                        }
                    }
                }
            }
        }
		
	}

    /**
	 * Admin Notice CSS File
     * 
     * @since v.1.0.0
	 * @param NULL
	 * @return STRING
	 */
	public function ultp_notice_css() {
		?>
		<style type="text/css">
            .ultp-free-notice.wc-install {
                display: flex;
                align-items: center;
                background: #fff;
                margin-top: 40px;
                width: calc(100% - 50px);
                border: 1px solid #ccd0d4;
                padding: 4px;
                border-radius: 4px;
                border-left: 3px solid #007fe1;
                line-height: 0;
            }   
            .ultp-free-notice.wc-install img {
                margin-right: 0; 
                max-width: 100%;
            }
            .ultp-free-notice .wc-install-body {
                -ms-flex: 1;
                flex: 1;
                position: relative;
                padding: 10px;
            }
            .ultp-free-notice .wc-install-body.ultp-image-banner{
                padding: 0px;
            }
            .ultp-free-notice .wc-install-body h3 {
                margin-top: 0;
                font-size: 24px;
                margin-bottom: 15px;
            }
            .ultp-install-btn {
                margin-top: 15px;
                display: inline-block;
            }
			.ultp-free-notice .wc-install .dashicons{
				display: none;
				animation: dashicons-spin 1s infinite;
				animation-timing-function: linear;
			}
			.ultp-free-notice.wc-install.loading .dashicons {
				display: inline-block;
				margin-top: 12px;
				margin-right: 5px;
			}
            .ultp-free-notice .wc-install-body h3 {
                font-size: 20px;
                margin-bottom: 5px;
            }
            .ultp-free-notice .wc-install-body > div {
                max-width: 100%;
                margin-bottom: 10px;
            }
            .ultp-free-notice .button-hero {
                padding: 8px 14px !important;
                min-height: inherit !important;
                line-height: 1 !important;
                box-shadow: none;
                border: none;
                transition: 400ms;
            }
            .ultp-free-notice .ultp-btn-notice-pro {
                background: #2271b1;
                color: #fff;
            }
            .ultp-free-notice .ultp-btn-notice-pro:hover,
            .ultp-free-notice .ultp-btn-notice-pro:focus {
                background: #185a8f;
            }
            .ultp-free-notice .button-hero:hover,
            .ultp-free-notice .button-hero:focus {
                border: none;
                box-shadow: none;
            }
			@keyframes dashicons-spin {
				0% {
					transform: rotate( 0deg );
				}
				100% {
					transform: rotate( 360deg );
				}
			}
			.ultp-free-notice .wc-dismiss-notice {
                color: #fff;
                background-color: #000000;
                padding-top: 0px;
                position: absolute;
                right: 0;
                top: 0px;
                padding: 10px 10px 14px;
                border-radius: 0 0 0 4px;
                display: inline-block;
                transition: 400ms;
            }
            .ultp-free-notice .wc-dismiss-notice:hover {
                color:red;
            }
			.ultp-free-notice .wc-dismiss-notice .dashicons{
                display: inline-block;
                text-decoration: none;
                animation: none;
                font-size: 16px;
			}
            /* ===== Eid Banner Css ===== */
            .ultp-free-notice .wc-install-body {
                background: linear-gradient(90deg,rgb(0,110,188) 0%,rgb(2,17,196) 100%);
            }
            .ultp-free-notice p{
                color: #fff;
                margin: 5px 0px;
                font-size: 16px;
                font-weight: 300;
                letter-spacing: 1px;
            }
            .ultp-free-notice p.ultp-enjoy-offer {
                display: inline;
                font-weight: bold;
                
            }
            .ultp-free-notice .ultp-get-now {
                font-size: 14px;
                color: #fff;
                background: #14a8ff;
                padding: 8px 12px;
                border-radius: 4px;
                text-decoration: none;
                margin-left: 10px;
                position: relative;
                top: -4px;
                transition: 400ms;
            }
            .ultp-free-notice .ultp-get-now:hover{
                background: #068fe0;
            }
            .ultp-free-notice .ultp-dismiss {
                color: #fff;
                background-color: #000964;
                padding-top: 0px;
                position: absolute;
                right: 0;
                top: 0px;
                padding: 10px 8px 12px;
                border-radius: 0 0 0 4px;
                display: inline-block;
                transition: 400ms;
            }
            .ultp-free-notice .ultp-dismiss:hover {
                color: #d2d2d2;
            }
            /* ===== Old Banner Css End ===== */
			/* ===== Updated Banner Css Start ===== */
            .ultp-notice {
                background: #fff;
                border: 1px solid #c3c4c7;
                border-left-color: #037FFF !important;
                border-left-width: 4px;
                border-radius: 4px 0px 0px 4px;
                box-shadow: 0 1px 1px rgba(0,0,0,.04);
                padding: 0px !important;
                margin: 20px 20px 0 2px !important;
                clear: both;
            }
            .ultp-notice .ultp-notice-container {
                display: flex;
                width: 100%;
            }

            .ultp-notice .ultp-notice-container a{
                text-decoration: none;
            }

            .ultp-notice .ultp-notice-container a:visited{
                color: white;
            }
            .ultp-notice .ultp-notice-container img {
                height: 100%; 
                width: 100%;
                max-width: 30px !important;
                padding: 12px;
            }

            .ultp-notice .ultp-notice-image {
                display: flex;
                align-items: center;
                flex-direction: column;
                justify-content: center;
                background-color: #f4f4ff;
            }
            .ultp-notice .ultp-notice-image img{
                max-width: 100%;
                /* height: 300px; */
            }

            .ultp-notice .ultp-notice-content {
                width: 100%;
                margin: 5px !important;
                padding: 8px !important;
                display: flex;
                flex-direction: column;
                gap: 0px;
            }

            .ultp-notice .ultp-notice-ultp-button {
                max-width: fit-content;
                text-decoration: none;
                padding: 7px 12px;
                font-size: 12px;
                color: white;
                border: none;
                border-radius: 2px;
                cursor: pointer;
                margin-top: 6px;
                background-color: #037FFF;
            }

            .ultp-notice-heading {
                font-size: 18px;
                font-weight: 500;
                color: #1b2023;
            }

            .ultp-notice-content-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .ultp-notice-close .dashicons-no-alt {
                font-size: 25px;
                height: 26px;
                width: 25px;
                cursor: pointer;
                color: #585858;
            }

            .ultp-notice-close .dashicons-no-alt:hover {
                color: red;
            }

            .ultp-notice-content-body {
                font-size: 12px;
                color: #343b40;
            }
            .ultp-bold {
                font-weight: bold;
            }
            a.ultp-pro-dismiss:focus {
                outline: none;
                box-shadow: unset;
            }
            .ultp-free-notice .loading, .ultp-notice .loading {
                width: 16px;
                height: 16px;
                border: 3px solid #FFF;
                border-bottom-color: transparent;
                border-radius: 50%;
                display: inline-block;
                box-sizing: border-box;
                animation: rotation 1s linear infinite;
                margin-left: 10px;
            }
            a.ultp-notice-ultp-button:hover {
                color: #fff !important;
            }
            .ultp-notice .ultp-link-wrap  {
                margin-top: 10px;
            }
            .ultp-notice .ultp-link-wrap a {
                margin-right: 4px;
            }
            .ultp-notice .ultp-link-wrap a:hover {
                background-color: #004fd0;
            }
            body .ultp-notice .ultp-link-wrap > a.ultp-notice-skip {
                background: none !important;
                border: 1px solid #037FFF;
                color: #037FFF;
                padding: 6px 15px !important;
            }
            body .ultp-notice .ultp-link-wrap > a.ultp-notice-skip:hover {
                background: #037FFF !important;
            }
            @keyframes rotation {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
		    /* ===== Updated Banner Css End ===== */
		</style>
		<?php
    }

    public function set_notice($key='',$value='',$expiration='') {
        if($key) {
            $option_name = 'ultp_notice';
            $notice_data = ultimate_post()->get_option_without_cache($option_name,array());
            if(!isset($notice_data) || !is_array($notice_data)) {
                $notice_data = array();
            } 
    
            $notice_data[$key] = $value;
    
            if($expiration) {
                $expire_notice_key = 'timeout_'.$key;
                $notice_data[$expire_notice_key] = time() + $expiration;
            }
            update_option( $option_name, $notice_data );
        }
    }

    public function get_notice($key='') {
        if($key) {
            $option_name = 'ultp_notice';
            $notice_data = ultimate_post()->get_option_without_cache($option_name,array());
            if(!isset($notice_data) || !is_array($notice_data)) {
                return false;
            }

            if(isset($notice_data[$key])) {
                $expire_notice_key = 'timeout_'.$key;
                if(isset($notice_data[$expire_notice_key]) && $notice_data[$expire_notice_key]< time()  ) {
                    unset($notice_data[$key]);
                    unset($notice_data[$expire_notice_key]);
                    update_option( $option_name, $notice_data);
                    return false;
                }
                return $notice_data[$key];
            }
        }
        return false;
    }
    
}