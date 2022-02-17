<?php
/*
Plugin Name:    DOM767 Review Plugin
Plugin URI:     https://www.dom767.com/
Description:    This plugin is for review posts and custom posts
Version:        1.1.0
Author:         Ibrahim Abdullah
Author URI:     https://www.dom767.com/
License:        GPLv2 or later
Text Domain:    dom767_review
Domain Path:    /languages/
*/

define( "DOM767_RIV_ASSETS_DIR", plugin_dir_url( __FILE__ ) . "assets/" );
define( "DOM767_RIV_ASSETS_PUBLIC_DIR", plugin_dir_url( __FILE__ ) . "assets/public" );
define( "DOM767_RIV_ASSETS_ADMIN_DIR", plugin_dir_url( __FILE__ ) . "assets/admin" );
define( 'DOM767_RIV_VERSION', time() );

class DOM767_Review {

    private $version;

    public function __construct() {

        $this->version = time();

        add_action('init',array($this,'dom767_init'));

        add_action( 'plugins_loaded', array( $this, 'dom767_review_load_textdomain' ) );
        //add_action('admin_menu',array($this,'dom_review_create_setting'));
        //add_action( 'admin_init', array( $this, 'review_options_sutup_sections' ) );
        //add_action( 'admin_init', array( $this, 'review_options_sutup_fields' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'dom767_load_review_front_assets' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_dom767_review_admin_assets' ) );



    }




    //////////// register and deregister assates //////////////
    function dom767_init(){
        /*wp_deregister_style('fontawesome-css');
        wp_register_style('fontawesome-css','//use.fontawesome.com/releases/v5.2.0/css/all.css');*/

        //wp_deregister_script('tinyslider-js');
        //wp_register_script('tinyslider-js','//cdn.jsdelivr.net/npm/tiny-slider@2.8.5/dist/tiny-slider.min.js',null,'1.0',true);
    }

    function dom767_review_load_textdomain(){
        load_plugin_textdomain('dom767_review', false, dirname(__FILE__)."/languages");
    }


    ////////// load assate for admin panel //////////
    function load_dom767_review_admin_assets( $screen ) {
        if ( isset($_GET['page']) && $_GET['page'] == 'dom767_review_setting_page' ) {

            wp_enqueue_script( 'dom_review_admin_main-js', DOM767_RIV_ASSETS_ADMIN_DIR . "/js/dom_review_admin_main.js", array( 'jquery' ), $this->version, true );

            wp_localize_script('dom_review_admin_main-js', 'dom_admin_review_list', array('ajax_url'=> admin_url('admin-ajax.php'), 'security'=> wp_create_nonce('ajax_nonce')));

            wp_enqueue_style( 'dom767-review-admin-main-css', DOM767_RIV_ASSETS_ADMIN_DIR . "/css/review-admin-main.css", null, $this->version );
        }

    }

    ////////// load assate for front end //////////
    function dom767_load_review_front_assets() {
        global $current_user;
        $cur_user_id = get_current_user_id();

        wp_enqueue_style( 'dom767-review-main-css', DOM767_RIV_ASSETS_PUBLIC_DIR . "/css/dom_review_main.css", null, $this->version );


        wp_enqueue_script('js-cookie-1', DOM767_RIV_ASSETS_PUBLIC_DIR . '/js/js.cookie.min.js', array('jquery'), '1.0.0', true);

        wp_enqueue_script( 'dom767-review-main-assets', DOM767_RIV_ASSETS_PUBLIC_DIR . "/js/review_main_scripts_new.js", array( 'jquery' ), $this->version, true );

        wp_localize_script('dom767-review-main-assets', 'dom_review_list', array(
            'ajax_url'=> admin_url('admin-ajax.php'), 
            'security'=> wp_create_nonce('ajax_nonce'),
            'current_user_id'=> $cur_user_id )
        );

    }




}////DOM767_Review class end
new DOM767_Review();


require plugin_dir_path( __FILE__ ) . 'revieworite_functions.php';
require plugin_dir_path( __FILE__ ) . 'classes/admin/option_page_class.php';
require plugin_dir_path( __FILE__ ) . 'classes/admin/page_templater.php';




function dom_review_filter_hug($value)
{
    echo $value;
    return;
}
add_filter("test_dom_review_filter_hug", "dom_review_filter_hug");

//apply_filter('test_dom_review_filter_hug', $value);




/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dom767-review-activator.php
 */
function activate_dom767_review() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-dom767-review-activator.php';
    Dom767_Review_Activator::activate();
    Dom767_Review_Activator::create_folder_on_uploads();
    
}
register_activation_hook( __FILE__, 'activate_dom767_review' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dom767-review-deactivator.php
 */
function deactivate_dom767_review() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-dom767-review-deactivator.php';
    Dom767_Review_Deactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_dom767_review' );