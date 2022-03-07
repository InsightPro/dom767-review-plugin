<?php

class Dom767_review_Option_Page{
  public function __construct(){

    add_action('admin_menu',array($this,'dom767_review_create_admin_manu'));///review menu
    add_action('admin_menu',array($this,'dom767_review_create_admin_submenu'));//review sub menu

    add_action('admin_post_dom767ReviewAdminSettingPage',array($this,'dom767_review_setting_form_save'));///admin_post_(action name)

  }

  /////////////////////////////// menue functions ///////////////////////////
  public function dom767_review_create_admin_manu(){
    $page_title = __('Review Settings', 'dom767_review');
    $menu_title = __('Review Settings', 'dom767_review');
    $capability = 'manage_options';
    $slug       = 'dom767_review_setting_page';
    $callback   = array($this, 'dom767_review_menu_page_content');
    add_menu_page($page_title, $menu_title, $capability, $slug, $callback);
  }
  public function dom767_review_menu_page_content(){
    require_once plugin_dir_path(__FILE__)."../../templates/admin/form.php";
  }
  ///////////////////////////////////////////////////////////////////////////

  ////////////////////////////// sub menu //////////////////////////////////
  public function dom767_review_create_admin_submenu(){
    $page_title = __('View All Reviews', 'dom767_review');
    $menu_title = __('View All Reviews', 'dom767_review');
    $capability = 'manage_options';
    $menu_slug  = 'dom767_review_setting_page';
    $sub_slug   = 'dom767_review_setting_page_view_all';
    $callback   = array($this, 'dom767_review_submenu_page_content');
    add_submenu_page($menu_slug, $menu_title, $page_title, $capability, $sub_slug, $callback);
  }
  public function dom767_review_submenu_page_content(){
    require_once plugin_dir_path( __FILE__ ) . '../../templates/admin/post_total_review_count_query.php';
  }
  //////////////////////////////////////////////////////////////////////////



  public function dom767_review_setting_form_save(){
    //print_r($_POST);
    //die();
    check_admin_referer("dom767_review");

    $settingTypes = array('review-media','comment-media', 'review-edit', 'comment-edit', 'review-filter-oldest', 'review-filter-high-rating', 'review-filter-low-rating', 'review-aprove-when-submit', 'comment-aprove-when-submit');
    foreach ($settingTypes as $settingType) {
      if (isset($_POST['dom767_review_seting_option_'.$settingType])) {
        update_option('dom767_review_seting_option_'.$settingType, sanitize_text_field($_POST['dom767_review_seting_option_'.$settingType]));
      }
    }
    wp_redirect('admin.php?page=dom767_review_setting_page');
  }

}///end class
new Dom767_review_Option_Page;