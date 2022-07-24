<?php
/**
 *
 * JGJ Citation Plugin
 *
 * This file is responsible for starting the plugin using the main plugin class file.
 *
 * @since 0.0.1
 * @package JGJ_Citation
 *
 * @wordpress-plugin
 * Plugin Name:     JGJ Citation
 * Description:     Add citations to your wordpress articles. Use the shortcode ['jgj_citation post_id="" '].
 * Version:         0.0.1
 * Author:          Juan Giovanni John
 * Author URI:      https://juangiovannijohn.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     jgj-citation
 * Domain Path:     /lang
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access not permitted.' );
}

if ( ! class_exists( 'jgj_citation' ) ) {

	/*
	 * main jgj_citation class
	 *
	 * @class plugin_name
	 * @since 0.0.1
	 */
	class jgj_citation {

		/*
		 * jgj_citation plugin version
		 *
		 * @var string
		 */
		public $version = '0.0.1';

		/**
		 * The single instance of the class.
		 *
		 * @var jgj_citation
		 * @since 0.0.1
		 */
		protected static $instance = null;

		/**
		 * Main jgj_citation instance.
		 *
		 * @since 0.0.1
		 * @static
		 * @return jgj_citation - main instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * jgj_citation class constructor.
		 */
		public function __construct() {
			$this->load_plugin_textdomain();
			$this->define_constants();
			$this->includes();
			$this->define_actions();
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'jgj-citation', false, basename( dirname( __FILE__ ) ) . '/lang/' );
		}

		/**
		 * Include required core files
		 */
		public function includes() {
			// Load custom functions and hooks
			require_once __DIR__ . '/includes/includes.php';
			
			//CSS and JS
			require_once __DIR__ . '/assets/includes_scripts_styles.php';
			
			
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}


		/**
		 * Define jgj_citation constants
		 */
		private function define_constants() {
			define( 'JGJ_CITATION_PLUGIN_FILE', __FILE__ );
			define( 'JGJ_CITATION_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			define( 'JGJ_CITATION_VERSION', $this->version );
			define( 'JGJ_CITATION_PATH', $this->plugin_path() );
		}

		/**
		 * Define jgj_citation actions
		 */
		public function define_actions() {
			//
		}

		/**
		 * Define jgj_citation menus
		 */
		public function define_menus() {
            //
		}
	}
}
	$jgj_citation = new jgj_citation();


