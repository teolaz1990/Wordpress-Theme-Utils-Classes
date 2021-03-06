<?php 
/**
 * Stores the code for the parent theme setting initialization and management
 */


/**
 * Initializes and manages the parent theme config and constants
 * @author etessore
 * @version 1.0.0
 * @package classes
 */
class ThemeUtils{
	/**
	 * Stores the unique instance
	 * @var ThemeUtils
	 */
	private static $instance = null;
	
	/**
	 * Stores the dir name of PHP classes
	 * @var string
	 */
	const WORDPRESS_THEME_UTILS_CLASS_DIR = 'classes';

	/**
	 * Initializes default settings
	 * Singleton private constructor
	 */
	private function __construct(){
		self::default_constants();
		//self::enable_autoload_system();
		//self::disable_debug();
		//self::register_main_menu();
		//self::register_bottom_menu();
		self::register_text_domain();
		self::$instance = $this;
	}
	
	/**
	 * Register the wtu-framework text domain to WordPress
	 */
	public static function register_text_domain(){
		load_theme_textdomain('wtu_framework', WORDPRESS_THEME_UTILS_PATH.'/languages');
	}

	/**
	 * Gets the instance with the current options set
	 * @return ThemeUtils current instance
	 */
	public static function get_instance(){
		if(is_null(self::$instance)){
			self::$instance = new self();
		}

		return self::$instance;
	}

    public static function include_once_file_if_exists($file){
        if(file_exists($file))
            include_once $file;
    }

	/**
	 * Initializes the autoloader subsystem
	 */
	public static function enable_autoload_system(){
		if(!class_exists('ClassAutoloader')) {
            self::include_once_file_if_exists(WORDPRESS_THEME_UTILS_PATH . WORDPRESS_THEME_UTILS_AUTOLOADER_RELATIVE_PATH);
        }

        if(class_exists('ClassAutoloader')) {
			ClassAutoloader::get_instance()
				// First search in the child theme dir
				->add_loading_template(
					get_stylesheet_directory().'/'
					.WORDPRESS_THEME_UTILS_DIRNAME
					.'/%classname%.class.php'
				)
				// then search into the parent theme dir
				->add_loading_template(
					get_template_directory().'/'
					.WORDPRESS_THEME_UTILS_DIRNAME
					.'/%classname%.class.php'
				);
		}

	}

	/**
	 * Registers the Primary Menu to WordPress
	 * @param string $label the label for the menu
	 */
	public static function register_main_menu($label=''){
		register_nav_menu('primary', (empty($label)) ? __('Primary Menu', 'theme') : $label);
	}

	/**
	 * Register the Secondary Menu to WordPress
	 * @param string $label the label for the menu
	 */
	public static function register_bottom_menu($label=''){
		register_nav_menu('secondary', (empty($label)) ? __('Secondary Menu', 'theme'): $label);
	}

	/**
	 * Enables vd()\vc()\v() functions output,
	 * This is generically good for development environments.
	 */
	public static function enable_debug(){
		$debug = DebugUtils::get_instance();
		$debug->status = true;
	}


	/**
	 * Disable vd()\vc()\v() functions output,
	 * This is default status, generically good for production environments.
	 */
	public static function disable_debug(){
		$debug = DebugUtils::get_instance();
		$debug->status = false;
	}
	
	/**
	 * Enable the Lorem Ipsum body text on empty pages
	 */
	public static function dummy_content(){
		$dummy_content = new LipsumGenerator();
		$dummy_content->init()->save()->hook();
	} 

	/**
	 * Register some constants
	 */
	public static function default_constants(){
		// initialize constants only once
		if(defined('WORDPRESS_THEME_UTILS_PATH')) return;

		/**
		 * The absolute base path for Wordpress Theme Utils
		 */
		if(!defined('WORDPRESS_THEME_UTILS_PATH'))
			define('WORDPRESS_THEME_UTILS_PATH', dirname(dirname(__FILE__)));

		/**
		 * The main directory name for Wordpress Theme Utils
		 */
		if(!defined('WORDPRESS_THEME_UTILS_DIRNAME'))
			define('WORDPRESS_THEME_UTILS_DIRNAME', trim(str_replace(WORDPRESS_THEME_UTILS_PATH,'', dirname(__FILE__)),'/\\'));

		/**
		 * Set to false to disable registration of Top Menu
		 */
		if(!defined('WORDPRESS_THEME_UTILS_REGISTER_TOP_MENU'))
			define('WORDPRESS_THEME_UTILS_REGISTER_TOP_MENU', true);

		/**
		 * Set to false to disable registration of Bottom Menu
		 */
		if(!defined('WORDPRESS_THEME_UTILS_REGISTER_BOTTOM_MENU'))
			define('WORDPRESS_THEME_UTILS_REGISTER_BOTTOM_MENU', true);

		/**
		 * Relative path for template parts
		 */
		if(!defined('WORDPRESS_THEME_UTILS_PARTIALS_RELATIVE_PATH'))
			define('WORDPRESS_THEME_UTILS_PARTIALS_RELATIVE_PATH', 'partials/');

		/**
		 * Path for libraries
		 */
		if(!defined('WORDPRESS_THEME_UTILS_LIBRARIES_RELATIVE_PATH'))
			define('WORDPRESS_THEME_UTILS_LIBRARIES_RELATIVE_PATH', 'libraries/');
		
		if(!defined('WORDPRESS_THEME_UTILS_LIBRARIES_ABSOLUTE_PATH'))
			define('WORDPRESS_THEME_UTILS_LIBRARIES_ABSOLUTE_PATH', WORDPRESS_THEME_UTILS_PATH.'/libraries/');

		/**
		 * Relative path for autoloader class
		 */
		if(!defined('WORDPRESS_THEME_UTILS_AUTOLOADER_RELATIVE_PATH'))
			define('WORDPRESS_THEME_UTILS_AUTOLOADER_RELATIVE_PATH', '/'.WORDPRESS_THEME_UTILS_DIRNAME.'/ClassAutoloader.class.php');
	}
	
	/**
	 * Enables the Custom Links feature
	 */
	public static function enable_links_manager(){
		LinksManager::getInstance();
	}
	
	/**
	 * Disables the loading of javascripts and csses from a template part
	 */
	public static function disable_automatic_assets_manager(){
		global $assets;
		$assets->disable_automatic_manager();
	}
}


/**
 * Initializes the WordPress Theme Utils.
 * Use this in your child theme functions.php
 */
function wtu_init(){
	ThemeUtils::get_instance();

	/**
	 * Register some standard assets
	 *
	 * overload the global $assets variable in your child theme functions.php if you need customization on this.
	 * @see DefaultAssets for adding or remove assets
	*/
	/*global $assets;
	if(empty($assets)){
		$assets = new DefaultAssetsCDN();
	}*/

	/**
	 * Register runtime infos, useful for javascript
	 *
	 * Overload the global $runtime_infos in your child theme functions.php if you need customization on this.
	 * @see RuntimeInfos for more details
	 */
	/*global $runtime_infos;
	if(empty($runtime_infos)){
		$runtime_infos = new RuntimeInfos();
		$runtime_infos->hook();
	}*/
}