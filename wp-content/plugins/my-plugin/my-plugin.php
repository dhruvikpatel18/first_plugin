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

//  //shortcode for backend wordpress pages
//  function my_sc_fun(){
//     return 'Function call';
//  }
//  add_shortcode('my-sc','my_sc_fun');

?>