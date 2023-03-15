<?php
/**
 * Go_now class.
 *
 * @category   Class
 * @package    GoNowCard
 * @subpackage WordPress
 * @author     Ricky Song
 * @since      1.0.0
 * php version 7.4.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

final class GoNow {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Load the translation.
		add_action( 'init', array( $this, 'i18n' ) );

		// Initialize the plugin.
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'go-now' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

        // Register Shortcode
        if(function_exists('go_now_card')) {
            add_action( 'admin_notices', array( $this, 'admin_notice_conflict_shortcode' ) );
			return;
        } else {
            $this->register_short_code();
        }
		// Once we get here, We have passed all validation checks so we can safely include our widgets.
		require_once 'class-widgets.php';
	}

    public function register_short_code() {
        $go_now_card = function ($links) {
            $links = shortcode_atts( array(
                'default' => '',
                'android' => '',
                'iphone' => '',
                'weixin' => '',
            ), $links );
            $ua = $_SERVER['HTTP_USER_AGENT'];
            // If Mobile
            if(preg_match('/mobile/i', $ua)) {
                // MiniProgram
                if (strpos($ua, 'MicroMessenger')) {
                    return $links['weixin'];
                }
                // Android
                if(preg_match('/android/i', $ua)) {
                    return $links['android'];
                }
                // iPhone
                if(preg_match('/iphone|ipad|ipod/i', $ua)) {
                    return $links['iphone'];
                }
            }
            // Default return pc link
            return $links['default'];
        };
        add_shortcode('go_now_card', $go_now_card);
    }
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		deactivate_plugins( plugin_basename( GONOW ) );

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> to be installed and activated.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'Go Now',
			'Elementor'
		);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		deactivate_plugins( plugin_basename( GONOW ) );

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'Go Now',
			'Elementor',
			self::MINIMUM_ELEMENTOR_VERSION
		);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		deactivate_plugins( plugin_basename( GONOW ) );

		return sprintf(
			wp_kses(
				'<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
				array(
					'div' => array(
						'class'  => array(),
						'p'      => array(),
						'strong' => array(),
					),
				)
			),
			'Go Now',
			'Elementor',
			self::MINIMUM_ELEMENTOR_VERSION
		);
	}

    public function admin_notice_confilt_shortcode() {
        deactivate_plugins( plugin_basename( GONOW ) );

        return sprintf(
            wp_kses(
                '<div class="notice notice-warning is-dismissible"><p><strong>go_now_card</strong> shortcode name already exist, please check the conflict shortcode name.</p></div>',
                array(
                    'div' => array(
                        'class'  => array(),
                        'p'      => array(),
                        'strong' => array(),
                    ),
                )
            ),
            'Go Now',
            'Elementor'
        );
    }
}

// Instantiate Go_Now.
new GoNow();
