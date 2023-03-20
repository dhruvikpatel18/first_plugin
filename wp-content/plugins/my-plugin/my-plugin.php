<?php
/**
 * Plugin Name: My Plugin
 * Description: This is test plugin
 * version: 1.0
 * Author: Dhruvik
 */

 //check if anyone access this page from url path then redirect to home
 if(!defined('ABSPATH')){
    header("Location: /first_plugin");
    die();
 }
 
 //activation hook
 function my_plugin_activation(){
    //
 }
 //__FILE__ provides the plugin's path
 register_activation_hook(__FILE__,'my_plugin_activation');
 

 //deactivation hook
 function my_plugin_deactivation(){
    //
 }
 register_deactivation_hook(__FILE__,'my_plugin_deactivation');

 //uninstall hook is in separate file(uninstall.php)

 //shortcode for backend wordpress pages
 function my_sc_fun(){
    return 'Function call';
 }
 add_shortcode('my-sc','my_sc_fun');

?>