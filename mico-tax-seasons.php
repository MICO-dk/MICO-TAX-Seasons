<?php
/**
 * MICO TAX Seasons
 *
 * @package 	MICO_TAX_Seasons
 * @author  	Malthe Milthers <malthe@milthers.dk>
 * @license 	GPL
 * @link 		MICO, http://www.mico.dk
 *
 * @wordpress-plugin
 * Plugin Name: 	MICO TAX Seasons
 * Plugin URI:		@TODO
 * Description: 	Registeres a translation ready Custom Taxonomy: "Seasons".
 * Version: 		1.0.0
 * Author: 			Malthe Milthers
 * Author URI: 		http://www.malthemilthers.com
 * Text Domain: 	mico-tax-seasons
 * License: 		GPL
 * GitHub URI:		@TODO
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The plugin class
 */

class MICO_TAX_Seasons {

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file and the name of the main plugin folder. 
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_slug = 'mico-cpt-seasons';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 * @var      object
	 */
	protected static $instance = null;


	/**
	 * This class is only ment to be used once. 
	 * It basically works as a namespace.
	 *
	 * this insures that we can't call an instance of this class.
	 *
	 * @since  1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Event post type: Register post type
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Return the instance of this class.
	 *
	 * @since 		1.0.0 
	 * @return		object		A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( self::$instance == null ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->plugin_slug;

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		$fullpath = dirname( basename( plugins_url() ) ) . '/' . basename(dirname(__FILE__))  . '/languages/';
	
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, $fullpath );		
	
	}

	/**
	 * Register Taxonomy
	 *
	 * @since  1.0.0
	 */
	public function register_post_type() {

		if ( !taxonomy_exists( 'season' ) ) :
			
			$labels = array(
				'name'              => _x( 'Seasons', 'taxonomy general name', $this->plugin_slug ),
				'singular_name'     => _x( 'Season', 'taxonomy singular name', $this->plugin_slug ),
				'search_items'      => __( 'Search Seasons', $this->plugin_slug ),
				'all_items'         => __( 'All Seasons', $this->plugin_slug ),
				'parent_item'       => __( 'Parent Season', $this->plugin_slug ),
				'parent_item_colon' => __( 'Parent Season:', $this->plugin_slug ),
				'edit_item'         => __( 'Edit Season', $this->plugin_slug ),
				'update_item'       => __( 'Update Season', $this->plugin_slug ),
				'add_new_item'      => __( 'Add New Season', $this->plugin_slug ),
				'new_item_name'     => __( 'New Season Name', $this->plugin_slug ),
				'menu_name'         => __( 'Seasons', $this->plugin_slug ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => _x( 'season', 'URL slug', $this->plugin_slug ) ),
			);

			register_taxonomy( 'season', '', $args );

		endif;
	}

} // End of the MICO_CPT Class.

/*
 * Run the one and only instance of the plugins main class.
 */
add_action( 'plugins_loaded', array( 'MICO_TAX_Seasons', 'get_instance' ) );