<?php
/**
 * REST API Action.
 * 
 * @package ULTP\REST_API
 * @since v.1.0.0
 */
namespace ULTP;

defined('ABSPATH') || exit;

/**
 * Styles class.
 */
class REST_API{
    
    /**
	 * Setup class.
	 *
	 * @since v.1.0.0
	 */
    public function __construct() {
        add_action( 'rest_api_init', array($this, 'ultp_register_route') );
    }


    /**
	 * REST API Action
     * 
     * @since v.1.0.0
	 * @return NULL
	 */
    public function ultp_register_route() {
        register_rest_route( 'ultp', 'posts', array(
                'args' => array(),
                'callback' => array($this,'ultp_route_post_data'),
                'permission_callback' => '__return_true'
            )
        );
        register_rest_route( 'ultp', 'common', array(
                'methods' => \WP_REST_Server::READABLE,
                'args' => array('wpnonce' => []),
                'callback' => array($this,'ultp_route_common_data'),
                'permission_callback' => '__return_true'
            )
        );
        register_rest_route( 'ultp', 'specific_taxonomy', array(
                'methods' => \WP_REST_Server::READABLE,
                'args' => array('taxType' => [], 'taxSlug' => [], 'taxValue' => [], 'queryNumber' => [], 'wpnonce' => [], 'archiveBuilder' => []),
                'callback' => array($this,'ultp_route_taxonomy_info_data'),
                'permission_callback' => '__return_true'
            )
        );
        register_rest_route(
			'ultp/v1',
			'/search/',
			array(
				array(
					'methods'  => 'POST',
					'callback' => array($this, 'search_settings_action'),
					'permission_callback' => function () {
						return current_user_can('edit_posts');
					},
					'args' => array()
				)
			)
		);
        register_rest_route(
			'ultp/v2',
			'/template_page_insert/',
			array(
				array(
					'methods'  => 'POST',
					'callback' => array($this, 'template_page_insert'),
					'permission_callback' => function () {
						return current_user_can('publish_posts');
					},
					'args' => array()
				)
			)
		);
        register_rest_route(
			'ultp/v2',
			'/addon_block_action/',
			array(
				array(
					'methods'  => 'POST',
					'callback' => array($this, 'addon_block_action'),
					'permission_callback' => function () {
						return current_user_can('manage_options');
					},
					'args' => array()
				)
			)
		);
        register_rest_route(
			'ultp/v2',
			'/premade_wishlist_save/',
			array(
				array(
					'methods'  => 'POST',
					'callback' => array($this, 'premade_wishlist_save'),
					'permission_callback' => function () {
						return current_user_can('edit_posts');
					},
					'args' => array()
				)
			)
		);
        register_rest_route(
			'ultp/v2',
			'/save_plugin_settings/',
			array(
				array(
					'methods'  => 'POST',
					'callback' => array($this, 'save_plugin_settings'),
					'permission_callback' => function () {
						return current_user_can('manage_options');
					},
					'args' => array()
                )
            )
        );
        register_rest_route(
			'ultp',
			'/ultp_search_data/',
			array(
				array(
					'methods'  => 'POST',
					'callback' => array($this, 'ultp_search_result'),
                    'permission_callback' => '__return_true'
				)
			)
		);
        register_rest_route(
			'ultp/v2',
			'/get_all_settings/',
			array(
				array(
					'methods'  => 'POST',
					'callback' => array($this, 'get_all_settings'),
					'permission_callback' => function () {
						return current_user_can('edit_posts');
					},
					'args' => array()
				)
			)
		);
        register_rest_route(
			'ultp/v2', 
			'/dashborad/',
			array(
				array(
					'methods'  => 'POST', 
					'callback' => array( $this, 'get_dashboard_callback'),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
					'args' => array()
				)
			)
        );
        register_rest_route(
			'ultp/v2', 
			'/wizard_site_status/',
			array(
				array(
					'methods'  => 'POST', 
					'callback' => array( $this, 'wizard_site_status_callback'),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
					'args' => array()
				)
			)
        );
        register_rest_route(
			'ultp/v2', 
			'/send_initial_plugin_data/',
			array(
				array(
					'methods'  => 'POST', 
					'callback' => array( $this, 'send_initial_plugin_data_callback'),
					'permission_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
					'args' => array()
				)
			)
        );
        register_rest_route(
			'ultp/v2', 
			'/initial_setup_complete/',
			array(
				array(
					'methods'  => 'POST', 
					'callback' => array( $this, 'initial_setup_complete_callback'),
					'permission_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
					'args' => array()
				)
			)
        );
    }

    /**
     * Initial Plugin Setup Complete
     *
     * * @since v.2.8.1
     * @return STRING
     */
    public static function initial_setup_complete_callback($server) {
        $post = $server->get_params();
        if ( ! (isset($post['wpnonce']) && wp_verify_nonce( sanitize_key(wp_unslash($post['wpnonce'])), 'ultp-nonce' )) ) {
            die();
		}
        ultimate_post()->set_setting('init_setup', 'yes');
        return rest_ensure_response([
            'success' => true, 
            'redirect' => admin_url('admin.php?page=ultp-settings'),
        ]);
    }

    /**
     * Send Plugin Data When Initial Setup
     *
     * * @since v.2.8.1
     * @return STRING
     */
    public function send_initial_plugin_data_callback($server) {
        $post = $server->get_params();
        if ( ! (isset($post['wpnonce']) && wp_verify_nonce( sanitize_key(wp_unslash($post['wpnonce'])), 'ultp-nonce' )) ) {
            die();
		}
        

        $site = isset($post['site']) ? sanitize_text_field( $post['site'] ) : '';

        require_once ULTP_PATH.'classes/Deactive.php';
        $obj = new \ULTP\Deactive();
        $obj->send_plugin_data('postx_wizard', $site);
    }

    /**
     * wizard_site_status_callback
     *
     * * @since v.3.0.0
     * @return STRING
     */
    public static function wizard_site_status_callback() {
        if ( ! (isset($_POST['wpnonce']) && wp_verify_nonce( sanitize_key(wp_unslash($_POST['wpnonce'])), 'ultp-nonce' )) ) {
			die();
		}
        if ( isset( $_FILES['siteIcon'],$_FILES['siteIcon']['name'] )  ) {
            $file_extension     = strtolower( pathinfo( $_FILES['siteIcon']['name'], PATHINFO_EXTENSION ) ); //phpcs:ignore
			$allowed_extenstion = array( 'jpg', 'jpeg', 'png', 'gif', 'webp', 'ico' );
			if ( in_array( $file_extension, $allowed_extenstion ) ) {
                require_once ABSPATH . 'wp-admin/includes/image.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';
				$file_id = media_handle_upload( 'siteIcon', 0 );
				if ( $file_id ) {
                    update_option( 'site_icon', $file_id );
				}
			}
		}
		if ( isset( $_POST['siteName'] ) ) {
            $site_name = sanitize_text_field( $_POST['siteName'] );
			update_option( 'blogname', $site_name );
		}
		if ( isset( $_POST['siteType'] ) ) {
            $site_type = sanitize_text_field( $_POST['siteType'] );
			update_option( '__ultp_site_type', $site_type );
		}
        return rest_ensure_response( ['success' => true ]);
    }

    /**
	 * Save Settings of Option Panel
     * 
     * @since v.3.0.0
	 * @return NULL
	 */
    public function get_all_settings($server) {
        return rest_ensure_response(['success' => true, 'settings' => ultimate_post()->get_setting()]);
    }
    /**
	 * Save Settings of Option Panel
     * 
     * @since v.3.0.0
	 * @return NULL
	 */
    public function save_plugin_settings($server) {
        $post = $server->get_params();
        $data = ultimate_post()->recursive_sanitize_text_field($post['settings']);
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                ultimate_post()->set_setting($key, $val);
            }
            do_action('ultimate_post_after_setting_save');
        }
        return rest_ensure_response([
            'success' => true, 
            'message' => __('You have successfully saved the settings data.', 'ultimate-post') , 
            'wishListArr' => json_encode($data)]);
    }

    /**
	 * Save and get premade_wishlist_save
     * 
     * @since v.3.0.0
     * @param STRING
	 * @return ARRAY | Inserted Post Url 
	 */
    public function premade_wishlist_save($server) {
        $post = $server->get_params();
        $id = sanitize_text_field($post['id']);
        $action = sanitize_text_field($post['action']);
        $wishListArr = get_option('ultp_premade_wishlist', []);

        if ($id && sanitize_text_field($post['type']) != 'fetchData') {
            if($action == 'remove') {
                $index = array_search($id, $wishListArr);
                if ($index !== false) {
                    unset($wishListArr[$index]);
                }
            } else {
                if (!in_array($id, $wishListArr)) {
                    array_push($wishListArr,  $id );
                }
            }
            update_option('ultp_premade_wishlist', $wishListArr);
        }
        return rest_ensure_response([
            'success' => true, 
            'message' => $action == 'remove' ? __('Item has been removed from wishlist.', 'ultimate-post') : __('Item added to wishlist.', 'ultimate-post'),
            'wishListArr' => json_encode($wishListArr)]
        );
    }
    /**
	 * Save addon / blocks on/off data 
     * 
     * @since v.3.0.0
     * @param STRING
	 * @return ARRAY | Inserted Post Url 
	 */
    public function addon_block_action($server) {
        $post = $server->get_params();
        $addon_name = sanitize_text_field($post['key']);
        $addon_value = sanitize_text_field($post['value']);
        if ($addon_name) {
            $addon_data = ultimate_post()->get_setting();
            $addon_data[$addon_name] = $addon_value;
            $GLOBALS['ultp_settings'][$addon_name] = $addon_value;
            update_option('ultp_options', $addon_data);
        }
        return array( 
            'success' => true, 
            'message' => ($addon_value == 'true' || $addon_value == 'false') ? ($addon_value == 'true' ? __('The addon has been enabled.', 'ultimate-post') : __('The addon has been disabled.', 'ultimate-post') ) : ($addon_value == 'yes' ? __('The block has been enabled.', 'ultimate-post') : __('The block has been disabled.', 'ultimate-post')) 
        );
    }
    /**
	 * Saved Template & Custom Font Actions 
     * 
     * @since v.3.0.0
     * @param STRING
	 * @return ARRAY | Inserted Post Url 
	 */
    public function get_dashboard_callback($server) {
        $post = $server->get_params();
        if (isset($post['type'])) {

            switch ($post['type']) {

                case 'saved_templates':
                    $post_per_page = 10;
                    $data = [];
                    $args = array(
                        'post_type' => $post['pType'],
                        'post_status' => array('publish', 'draft'),
                        'posts_per_page' => $post_per_page,
                        'paged' => $post['pages']
                    );

                    if (isset($post['search'])) {
                        $args['paged'] = 1;
                        $args['s'] = $post['search'];
                    }

                    $the_query = new \WP_Query( $args );
                    if ( $the_query->have_posts() ) {
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $final = [
                                'id' => get_the_ID(),
                                'title' => get_the_title(),
                                'date' => get_the_modified_date('Y/m/d h:i a'),
                                'status' => get_post_status(),
                                'edit' => get_edit_post_link()
                            ];
        
                            if ($post['pType'] == 'ultp_custom_font') {
                                $final = array_merge($final ,['woff' => false,'woff2' => false,'ttf' => false,'svg' => false,'eot' => false]);
                                $settings = get_post_meta( get_the_ID(), '__font_settings', true );
                                foreach ($settings as $key => $value) {
                                    if ($value['ttf']) { $final['ttf'] = true; }
                                    if ($value['svg']) { $final['svg'] = true; }
                                    if ($value['eot']) { $final['eot'] = true; }
                                    if ($value['woff']) { $final['woff'] = true; }
                                    if ($value['woff2']) { $final['woff2'] = true; }
                                }
                                $final['font_settings'] = $settings;
                            }
                            $data[] = $final;
                        }
                    }
                    wp_reset_postdata();
                    return array(
                        'success' => true, 
                        'data' => $data,
                        'new' => ($post['pType'] == 'ultp_custom_font' ? admin_url('post-new.php?post_type=ultp_custom_font') : admin_url('post-new.php?post_type=ultp_templates')),
                        'found' => $the_query->found_posts,
                        'pages' => $the_query->max_num_pages
                    );
                break;

                
                case 'action_draft':
                case 'action_publish':
                    if (isset($post['ids']) && is_array($post['ids'])) {
                        foreach ($post['ids'] as $id) {
                            wp_update_post(array(
                                'ID' => $id,
                                'post_status' => str_replace('action_', '',$post['type'])
                            ));
                        }
                        return array(
                            'success' => true, 
                            'message' => __('Status changed for selected items.', 'ultimate-post')
                        );
                    }
                break;

                case 'license_action':
                    $message = '';
                    
                    if ( isset($post['edd_ultp_license_key']) && function_exists('ultimate_post_pro') ) {
                        $is_success = false;
                        $license = trim( sanitize_text_field( $post['edd_ultp_license_key'] ) );

                        if ($license && $license != '******************') {
                            update_option( 'edd_ultp_license_key', $license);
                            $api_params = array(
                                'edd_action' => 'activate_license',
                                'license'    => $license,
                                'item_id'    => 181,
                                'url'        => home_url()
                            );
                            
                            $response = wp_remote_post( 
                                'https://www.wpxpo.com', 
                                array( 
                                    'timeout' => 15, 
                                    'sslverify' => false, 
                                    'body' => $api_params 
                                )
                            );
            
                            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                                $message =  ( is_wp_error( $response ) && ! empty( $response->get_error_message() ) ) ? $response->get_error_message() : __('An error occurred, please try again.', 'ultimate-post-pro');
                            } else {
                                $license_data = json_decode( wp_remote_retrieve_body( $response ) );
                                if ( false === $license_data->success ) {
                                    update_option( 'edd_ultp_license_key', '');
                                    switch( $license_data->error ) {
                                        case 'expired' :
                                            $message = sprintf(
                                                __('Your license key expired on %s.', 'ultimate-post'),
                                                date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
                                            );
                                            break;
                                        case 'revoked' :
                                            $message = __('Your license key has been disabled.', 'ultimate-post');
                                            break;
                                        case 'missing' :
                                            $message = __('Invalid license.', 'ultimate-post');
                                            break;
                                        case 'invalid' :
                                        case 'site_inactive':
                                            $message = __( 'Your license is not active for this URL.', 'ultimate-post' );
                                            break;
                                        case 'item_name_mismatch':
                                            $message = __( 'This appears to be an invalid license key.', 'ultimate-post' );
                                            break;
                                        case 'no_activations_left':
                                            $message = __( 'Your license key has reached its activation limit.', 'ultimate-post' );
                                            break;
                                        default :
                                            $message = __( 'An error occurred, please try again.', 'ultimate-post' );
                                            break;
                                    }
                                } else {
                                    $message = __('Your license key has been updated.', 'ultimate-post');
                                    $is_success = true;
                                }
                                update_option( 'edd_ultp_license_status', $license_data->license );
                                update_option( 'edd_ultp_license_expire', $license_data->expires );
                                update_option( 'edd_ultp_activations_left', $license_data->activations_left );

                            }
                        } else {
                            $message = __( 'Invalid license.', 'ultimate-post' );
                        }
                    } else {
                        $message = __( 'Invalid license.', 'ultimate-post' );
                        if (!function_exists('ultimate_post_pro')) {
                            $message = __( 'Install & Acivate PostX Pro plugin.', 'ultimate-post' );
                        }
                    }
                    return array('success' => $is_success, 'message' => $message);
                break;

                case 'action_delete':
                    if (isset($post['ids']) && is_array($post['ids'])) {
                        foreach ($post['ids'] as $id) {
                            wp_delete_post( $id, true); 
                        }
                    }
                    return array(
                        'success' => true, 
                        'message' => __('The selected item is deleted.', 'ultimate-post')
                    );
                break;

                // case 'header':
                //     $menu_list = array(
                //         'menu' => array(
                //             array(
                //                 'link' => '#home',
                //                 'label' => __('Getting Started', 'ultimate-post'),
                //                 'showin' => 'both',
                //             ),
                //             array(
                //                 'link' => '#builder',
                //                 'label' => __('Site Builder', 'ultimate-post'),
                //                 'showin' => ultimate_post()->get_setting('ultp_builder') != 'false' ? 'both' : 'none',
                //                 'showhide' => true
                //             ),
                //             array(
                //                 'link' => '#templatekit',
                //                 'label' => __('Template kits', 'ultimate-post'),
                //                 'showin' => 'both',
                //             ),
                //             array(
                //                 'link' => '#saved-templates',
                //                 'label' => __('Saved Templates', 'ultimate-post'),
                //                 'showin' => ultimate_post()->get_setting('ultp_templates') != 'false' ? 'both' : 'none',
                //                 'showhide' => true
                //             ),
                //             array(
                //                 'link' => '#custom-font',
                //                 'label' => __('Custom Font', 'ultimate-post'),
                //                 'showin' => ultimate_post()->get_setting('ultp_custom_font') != 'false' ? 'both' : 'none',
                //                 'showhide' => true
                //             ),
                //             array(
                //                 'link' => '#addons',
                //                 'label' => __('Addons', 'ultimate-post'),
                //                 'showin' => 'both',
                //             ),
                //             array(
                //                 'link' => '#blocks',
                //                 'label' => __('Blocks', 'ultimate-post'),
                //                 'showin' => 'both',
                //             ),
                //             array(
                //                 'link' => '#settings',
                //                 'label' => __('Settings', 'ultimate-post'),
                //                 'showin' => 'both',
                //             ),
                //             array(
                //                 'link' => '#tutorials',
                //                 'label' => __('Tutorials', 'ultimate-post'),
                //                 'showin' => 'sidebar',
                //             ),
                //             array(
                //                 'link' => '#license',
                //                 'label' => __('License', 'ultimate-post'),
                //                 'showin' => 'sidebar',
                //             )
                //         ),
                //         'common' => array(
                //             'version' => ULTP_VER
                //         ),
                //         'help_menu' => array(
                //             array(
                //                 'label' => __('Get Support', 'ultimate-post'),
                //                 'icon' => 'dashicons-phone',
                //                 'link' => ultimate_post()->get_premium_link('https://www.wpxpo.com/contact/', 'plugin_dir_pro')
                //             ),
                //             array(
                //                 'label' => __('Welcome Guide', 'ultimate-post'),
                //                 'icon' => 'dashicons-megaphone',
                //                 'link' => admin_url('admin.php?page=ultp-initial-setup-wizard')
                //             ),
                //             array(
                //                 'label' => __('Join Community', 'ultimate-post'),
                //                 'icon' => 'dashicons-facebook-alt',
                //                 'link' => 'https://www.facebook.com/groups/gutenbergpostx'
                //             ),
                //             array(
                //                 'label' => __('Feature Request', 'ultimate-post'),
                //                 'icon' => 'dashicons-email-alt',
                //                 'link' => ultimate_post()->get_premium_link('https://www.wpxpo.com/postx/roadmap/', 'plugin_dir_pro')
                //             ),
                //             array(
                //                 'label' => __('Youtube Tutorials', 'ultimate-post'),
                //                 'icon' => 'dashicons-youtube',
                //                 'link' => 'https://www.youtube.com/@wpxpo'
                //             ),
                //             array(
                //                 'label' => __('Documentation', 'ultimate-post'),
                //                 'icon' => 'dashicons-book',
                //                 'link' => 'https://docs.wpxpo.com/docs/postx/'
                //             ),
                //             array(
                //                 'label' => __('What’s New', 'ultimate-post'),
                //                 'icon' => 'dashicons-edit',
                //                 'link' => ultimate_post()->get_premium_link('https://www.wpxpo.com/category/postx/', 'plugin_dir_pro')
                //             ),
                //         )
                //     );

                //     return array(
                //         'success' => true, 
                //         'data' => apply_filters( 'postx_menu_system', $menu_list ),
                //         'helloBar' => get_transient('ultp_helloBar'),
                //         'status' => get_option( 'edd_ultp_license_status' ),
                //         'expire' => get_option( 'edd_ultp_license_expire' )
                //     );
                // break;
                case 'helloBarAction':
                    set_transient( 'ultp_helloBar', 'hide', 1296000);
                    return array(
                        'success' => true, 
                        'message' => __('Notice is removed.', 'ultimate-post')
                    );
                break;

                default:
                    # code...
                    break;
            }
        }
    }

    /**
	 * Insert Post For Imported Template
     * 
     * @since v.2.6.7
     * @param STRING
	 * @return ARRAY | Inserted Post Url 
	 */
    public function template_page_insert($server) {
        $post = $server->get_params();
        $new_page = array(
            'post_title' => $post['title'],
            'post_type' => 'page',
            'post_content' => $post['blockCode'],	
            'post_status' => 'draft',
        );
        $post_id = wp_insert_post( $new_page );
        return array( 'success' => true, 'link' => get_edit_post_link($post_id));
    }


    public function search_settings_action($server) {
		global $wpdb;
        $post = $server->get_params();

        switch ($post['type']) {
            case 'posts':
            case 'allpost':
            case 'postExclude':
                $post_type = array('post');
                if ($post['type'] == 'allpost') {
                    $post_type = array_keys(ultimate_post()->get_post_type());
                } else if ($post['type'] == 'postExclude') {
                    $post_type = array($post['condition']);
                }
                $args = array(
                    'post_type'         => $post_type,
                    'post_status'       => 'publish',
                    'posts_per_page'    => 10,
                );
                if (is_numeric($post['term'])) {
                    $args['p'] = $post['term'];
                } else {
                    $args['s'] = $post['term'];
                }

                $post_results = new \WP_Query($args);
                $data = [];
                if (!empty($post_results)) {
                    while ( $post_results->have_posts() ) {
                        $post_results->the_post();
                        $id = get_the_ID();
                        $title = html_entity_decode(get_the_title());
                        $data[] = array('value'=>$id, 'title'=>($title?'[ID: '.$id.'] '.$title:('[ID: '.$id.']')));
                    }
                    wp_reset_postdata();
                }
                return ['success' => true, 'data' => $data];
                break;

            case 'author':
                $term = '%'. $wpdb->esc_like( $post['term'] ) .'%';
                $post_results = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT ID, display_name 
                        FROM $wpdb->users 
                        WHERE user_login LIKE '%s' OR ID LIKE '%s' OR user_nicename LIKE '%s' OR user_email LIKE '%s' OR display_name LIKE '%s' LIMIT 10", $term, $term, $term, $term, $term 
                    )
                );
                $data = [];
                if (!empty($post_results)) {
                    foreach ($post_results as $key => $val) {
                        $data[] = array('value'=>$val->ID, 'title'=>'[ID: '.$val->ID.'] '.$val->display_name);
                    }
                }
                return ['success' => true, 'data' => $data];
                break;

            case 'taxvalue':
                $split = explode('###', $post['condition']);
                $condition = $split[1] != 'multiTaxonomy' ? array($split[1]) : get_object_taxonomies($split[0]);
                $args = array(
                    'taxonomy'  => $condition,
                    'fields'    => 'all',
                    'orderby'   => 'id', 
                    'order'     => 'ASC',
                    'name__like'=> $post['term']
                );
                if (is_numeric($post['term'])) {
                    unset($args['name__like']);
                    $args['include'] = array($post['term']);
                }

                $post_results = get_terms( $args );
                $data = [];
                if (!empty($post_results)) {
                    foreach ($post_results as $key => $val) {
                        if ($split[1] == 'multiTaxonomy') {
                            $data[] = array('value'=>$val->taxonomy.'###'.$val->slug, 'title'=> '[ID: '.$val->term_id.'] '.$val->taxonomy.': '.$val->name);
                        } else {
                            $data[] = array('value'=>urldecode($val->slug), 'title'=>'[ID: '.$val->term_id.'] '.$val->name);
                        }
                    }
                }
                return ['success' => true, 'data' => $data];
                break;

            case 'taxExclude':
                $condition = get_object_taxonomies($post['condition']);
                $args = array(
                    'taxonomy'  => $condition,
                    'fields'    => 'all',
                    'orderby'   => 'id', 
                    'order'     => 'ASC',
                    'name__like'=> $post['term']
                ); 
                if (is_numeric($post['term'])) {
                    unset($args['name__like']);
                    $args['include'] = array($post['term']);
                }
                $post_results = get_terms( $args );
                $data = [];
                if (!empty($post_results)) {
                    foreach ($post_results as $key => $val) {
                        $data[] = array('value'=>$val->taxonomy.'###'.$val->slug, 'title'=> '[ID: '.$val->term_id.'] '.$val->taxonomy.': '.$val->name);
                    }
                }
                return ['success' => true, 'data' => $data];
                break;
                // allPostType
            case 'allPostType': 
                $all_types = array_values(get_post_types( array( 'public' => true ), 'names' ));
                $postType = array();
                foreach($all_types as $type){
                    $postType[] = array(
                        'title' => $type,
                        'value' => $type,
                    );
                };

                return ['success' => true, 'data' => $postType ];
            default:
                return ['success' => true, 'data' => [['value'=>'', 'title'=>'- Select -']]];
                break;
        }
	}

    /**
	 * Post Data Response of REST API
     * 
     * @since v.1.0.0
     * @param MIXED | Pram (ARRAY), Local (BOOLEAN)
	 * @return ARRAY | Response Image Size as Array
	 */
    public function ultp_route_post_data($prams) {
        if ( ! (isset($_REQUEST['wpnonce']) && wp_verify_nonce( sanitize_key(wp_unslash($_REQUEST['wpnonce'])), 'ultp-nonce' )) ) {
			die();
		}
        $prams = $prams->get_params();
        $data = [];
        $loop = new \WP_Query( ultimate_post()->get_query($prams) );
        $max_tax = isset($prams['maxTaxonomy']) && $prams['maxTaxonomy'] ? ( $prams['maxTaxonomy'] == '0' ? 0 : $prams['maxTaxonomy'] ) : 30 ;
        

        if ($loop->have_posts()) {
            while($loop->have_posts()) {
                $loop->the_post(); 
                $var                = array();
                $post_id            = get_the_ID();
                $user_id            = get_the_author_meta('ID');
                $content_data       = get_the_content();
                $var['ID']          = $post_id;
                $var['title']       = get_the_title();
                $var['permalink']   = get_permalink();
                $var['seo_meta']    = ultimate_post()->get_excerpt($post_id, 1);
                $var['excerpt']     = strip_tags($content_data);
                $var['excerpt_full']= strip_tags(get_the_excerpt());
                $var['time']        = (int)get_the_date('U')*1000;
                $var['timeModified']= (int)get_the_modified_date('U')*1000;
                $var['post_time']   = human_time_diff(get_the_time('U'),current_time('U'));
                $var['view']        = get_post_meta(get_the_ID(),'__post_views_count', true);
                $var['comments']    = get_comments_number();
                $var['author_link'] = get_author_posts_url($user_id);
                $var['avatar_url']  = get_avatar_url($user_id);
                $var['display_name']= get_the_author_meta('display_name');
                $var['reading_time']= ceil(strlen($content_data)/1200);
                $post_video = get_post_meta($post_id, '__builder_feature_video', true);
                // Video 
                if ($post_video) {
                    $var['has_video'] = ultimate_post()->get_youtube_id($post_video);
                }
                // image
                $image_sizes = ultimate_post()->get_image_size();
                $image_src = array();
                if (has_post_thumbnail()) {
                    $thumb_id = get_post_thumbnail_id($post_id);
                    foreach ($image_sizes as $key => $value) {
                        $image_src[$key] = wp_get_attachment_image_src($thumb_id, $key, false)[0];
                    }
                    $var['image'] = $image_src;
                } elseif(isset($prams['fallbackImg']['id'])) {
                    foreach ($image_sizes as $key => $value) {
                        $image_src[$key] = wp_get_attachment_image_src($prams['fallbackImg']['id'], $key, false)[0];
                    }
                    $var['image'] = $image_src;
                    $var['is_fallback'] = true;
                }

                // tag
                $tag = get_the_terms($post_id, (isset($prams['tag'])?esc_attr($prams['tag']):'post_tag'));
                if (!empty($tag)) {
                    $v = array();
                    foreach ($tag as $k => $val) {
                        if ($k >= $max_tax) { break; }
                        $v[] = array('slug' => $val->slug, 'name' => $val->name, 'url' => get_term_link($val->term_id));
                    }
                    $var['tag'] = $v;
                }

                // Taxonomy
                $cat = get_the_terms($post_id, (isset($prams['taxonomy'])?esc_attr($prams['taxonomy']):'category'));

                if(!empty($cat)){
                    $v = array();
                    foreach ($cat as $k => $val) {
                        if ($k >= $max_tax) { break; }
                        $v[] = array('slug' => $val->slug, 'name' => $val->name, 'url' => get_term_link($val->term_id), 'color' => get_term_meta($val->term_id, 'ultp_category_color', true));
                    }
                    $var['category'] = $v;
                }
                $data[] = $var;
            }
            wp_reset_postdata();
        }
        return rest_ensure_response( $data);
    }


    /**
	 * Taxonomy Data Response of REST API
     * 
     * @since v.1.0.0
     * @param ARRAY | Parameter (ARRAY)
	 * @return ARRAY | Response Taxonomy List as Array
	 */
    public function ultp_route_common_data($prams) {
        if ( ! (isset($_REQUEST['wpnonce']) && wp_verify_nonce( sanitize_key(wp_unslash($_REQUEST['wpnonce'])), 'ultp-nonce' )) ) {
            return rest_ensure_response([]);
		}
        
        $all_post_type = ultimate_post()->get_post_type();
        $data = array();
        foreach ($all_post_type as $post_type_slug => $post_type ) {
            $data_term = array();
            $taxonomies = get_object_taxonomies($post_type_slug);
            foreach ($taxonomies as $key => $taxonomy_slug) {
                $taxonomy_value = get_terms(array(
                    'taxonomy' => $taxonomy_slug,
                    'hide_empty' => false
                ));
                if (!is_wp_error($taxonomy_value)) {
                    $data_tax = array();
                    foreach ($taxonomy_value as $k => $taxonomy) {
                        $data_tax[urldecode_deep($taxonomy->slug)] = $taxonomy->name;
                    }
                    if (count($data_tax) > 0) {
                        $data_term[$taxonomy_slug] = $data_tax;
                    }
                }
            }
            $data[$post_type_slug] = $data_term;
        }
        // Global Customizer
        $global = get_option('postx_global', []);
        // Image Size
        $image_sizes = ultimate_post()->get_image_size();

        return rest_ensure_response(['taxonomy' => $data, 'global' => $global, 'image' => json_encode($image_sizes), 'posttype' => json_encode($all_post_type)]);
    }

    /**
	 * Specific Taxonomy Data Response of REST API
     * 
     * @since v.1.0.0
     * @param ARRAY | Parameter (ARRAY)
	 * @return ARRAY | Response Taxonomy List as Array
	 */
    public function ultp_route_taxonomy_info_data($prams) {
        if ( ! (isset($_REQUEST['wpnonce']) && wp_verify_nonce( sanitize_key(wp_unslash($_REQUEST['wpnonce'])), 'ultp-nonce' )) ) {
            return rest_ensure_response([]);
		}

        return rest_ensure_response( ultimate_post()->get_category_data(json_decode($prams['taxValue']), $prams['queryNumber'], $prams['taxType'], $prams['taxSlug'], $prams['archiveBuilder']) );
    }

    /**
	 * Search Block Data Showing
     * 
     * @since v.2.9.9
     * @param STRING
	 * @return ARRAY | Inserted Post Url 
	 */
    public function ultp_search_result($server) {
        $post = $server->get_params();
        
        $query_args = array(
            's' => sanitize_text_field($post['searchText']),
            'paged' =>  sanitize_text_field($post['paged']), 
            'compare' => 'LIKE',
            'orderby' => 'relevance',
            'posts_per_page' => sanitize_text_field($post['postPerPage']),
        );
        if(isset($post['exclude']) && is_array($post['exclude']) && count($post['exclude']) > 0) {
            $post_exclude = array();
            foreach( $post['exclude'] as $data ){
                $post_exclude[$data['title']] = $data['title'];
            }
            $all_types = get_post_types( array( 'public' => true ), 'names' );
            $post_type = array_diff_key($all_types, $post_exclude);
            $query_args['post_type'] = $post_type;
        }
        $output = '';
        $query_result = new \WP_Query($query_args);

        if ($query_result->have_posts()) {
            while ($query_result->have_posts()) {
                $query_result->the_post(); 
                $post_id = get_the_ID();
                $title = get_the_title();
                
                $output .= '<div class="ultp-search-result__item">';
                    if ($post['image'] == 1 && has_post_thumbnail()) {
                        $thumb_id = get_post_thumbnail_id($post_id);
                        $output .= '<img class="ultp-searchresult-image" src='.wp_get_attachment_image_src($thumb_id, 'thumbnail', false)[0].' alt="'.$title.'"/>';
                    }
                    $output .= '<div class="ultp-searchresult-content">';
                        $output .= '<div class="ultp-rescontent-meta">';
                            // Category
                            $post_cat = get_the_terms($post_id, 'category');
                            if ($post['category'] == 1 && $post_cat && count($post_cat)) {
                                $output .= '<div class="ultp-searchresult-category">';
                                    foreach($post_cat as $cat){
                                        $output .= '<a href="'.get_term_link($cat->term_id).'">'.$cat->name.'</a>';
                                    }
                                $output .= '</div>';
                            }
                            // Author
                            if ($post['author'] == 1) {
                                $user_id = get_the_author_meta('ID');
                                $output .= '<a href="'.get_author_posts_url($user_id).'" class="ultp-searchresult-author">'.get_the_author_meta('display_name').'</a>';
                            }
                            // Date
                            if ($post['date'] == 1) {
                                $output .= '<div class="ultp-searchresult-publishdate">'.get_the_date('F j, Y').'</div>';
                            }
                        $output .= '</div>';
                        $output .= '<a href="'.get_permalink().'" class="ultp-searchresult-title">'.$title.'</a>';
                        if ($post['excerpt'] == 1) {
                            $output .= '<div class="ultp-searchresult-excerpt">'.wp_trim_words(get_the_excerpt(), $post['excerptLimit']).'</div>';
                        }
                    $output .= '</div>';
                $output .= '</div>';
            }
        }
        
        return array('post_data' => $output, 'post_count' => $query_result->found_posts);
    }
}