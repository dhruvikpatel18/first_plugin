<?php
/**
 * Plugin Name: My Plugin
 * Description: This is test plugin
 * version: 1.0
 * Author: Dhruvik
 */

 //(secure)check if anyone access this page from url path then redirect to home
 if(!defined('ABSPATH')){
    header("Location: /first_plugin");
    die();
 }
 
 //activation hook
 function my_plugin_activation(){
   //$wpdb is a global variable which used to connect databse in wordpress
   //$table_prifix fetch the tables from databse with prifix (wp_) bydefault. 
    global $wpdb, $table_prefix;
    $wp_emp =  $table_prefix.'emp';//create table 'emp' in database

    //SQL QUERY for table creation
    $q = "CREATE TABLE IF NOT EXISTS `$wp_emp` (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL , `email` VARCHAR(100) NOT NULL , `status` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;"; 
    //execute the query
    $wpdb->query($q);

   //  //SQL QUERY FOR DATA INSERT IN TABLE
   //  $q = "INSERT INTO `$wp_emp` (`name`,`email`,`status`) VALUES ('dhruvik','dhruvikmalaviya18@gmail.com',1);";
   //  $wpdb->query($q);

   //execute sql query using wordpress function 'insert'
   $data = array(
      'name' => 'Dhruvik',
      'email' => 'dhruvikmalaviya18@gmail.com',
      'status' => 1
   );
   $wpdb->insert($wp_emp, $data);
 }
 //__FILE__ provides the plugin's path till this file
 register_activation_hook(__FILE__,'my_plugin_activation');
 

 //deactivation hook
 function my_plugin_deactivation(){
    global $wpdb, $table_prefix;
    $wp_emp = $table_prefix.'emp';

    //SQL QUERY FOR DELETE TABLE
    $q = "TRUNCATE `$wp_emp`";
    $wpdb->query($q);
 }
 register_deactivation_hook(__FILE__,'my_plugin_deactivation');

 //uninstall hook is in separate file(uninstall.php)

// //  //shortcode for backend wordpress pages
//  function my_shortcode(){
//    return 'Hello my_plugin';
// }
// add_shortcode('first-plugin','my_shortcode');

//include script

function my_custom_files(){
   $path_js = plugins_url('js/main.js', __FILE__);//for url path for script
   $path_style = plugins_url('css/style.css', __FILE__);//for url path for style
   $dep = array('jquery');
   $ver_js =filemtime(plugin_dir_path(__FILE__).'js/main.js'); //for server path
   $ver_style =filemtime(plugin_dir_path(__FILE__).'css/style.css'); //for server path
   wp_enqueue_script('my-custom-js',$path_js,$dep,$ver_js,true); //true is for infooter it means now wordpress knows that our script is end.
   wp_enqueue_style('my-custom-style',$path_style,'',$ver_style);
}
add_action('wp_enqueue_scripts','my_custom_files');

?>