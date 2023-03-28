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

function first_plugin(){
   //database connection
   global $wpdb,$table_prefix;
   $wp_emp = $table_prefix.'emp';
   
   $q = "SELECT * FROM `$wp_emp`;";
   $results = $wpdb->get_results($q);//it provides all database objects

   // echo '<pre>';
   // print_r($results);//for print array
   // echo '<pre>';

   ob_start()
   ?>

   <table>
      <thead>
         <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>status</th>
         </tr>
      </thead>
      <tbody>
         <?php
         foreach($results as $row):
         ?>
         <tr>
            <td><?php echo $row->id;?></td>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->email;?></td>
            <td><?php echo $row->status;?></td>
         </tr>
         <?php
         endforeach;
         ?>
      </tbody>
   </table>
   <?php
   $html = ob_get_clean();
   return $html;
   

}
add_shortcode('first_plugin','first_plugin');

//fetching post using WP_Query
function my_posts(){
   $args = array(
      'post_type' => 'post',
      // 's' => 'hello' //if we want to search a post from specific keyword
      'category_name' => 'cat-2' //if we want to search a post from specific category
   );
   $query = new WP_Query($args);

   ob_start();
   if($query->have_posts()):
   ?>
   <ul>
   <?php
   while($query->have_posts()){
      $query->the_post();
      echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a> ->'.get_the_content().'</li>'; //fetch title and content of the posts
   }
   ?>
   </ul>
   <?php
   endif;
   wp_reset_postdata(); 
   $html = ob_get_clean();
   return $html;
}
add_shortcode('my-posts','my_posts');

function head_fun(){
   if(is_single()){//if load the post
     global $post;
                            //id   ,   key   ,if available
     $views = get_post_meta($post->ID,'views',true); //fetch the meta data
     if($views == ''){//then initiate with 1
         add_post_meta($post->ID,'views',1);
     }else{//update the view by increment 1
      $views++;
      update_post_meta($post->ID,'views',$views);
     }
   //   echo get_post_meta($post->ID,'views',true);
   }
}
add_action('wp_head','head_fun');//call header

function views_count(){
      global $post;
      return 'Total views: ' .get_post_meta($post->ID,'views',true);
}
add_shortcode('views-count','views_count');


function my_plugin_page_func(){
   include 'admin/main-page.php';
}
function my_plugin_subpage_func(){
   echo 'hii from sub page';
}
function my_plugin_menu(){
   add_menu_page('My plugin page','My Plugin Page','manage_options','my-plugin-page','my_plugin_page_func','',6); 
   add_submenu_page('my-plugin-page','All Emp','All Emp','manage_options','my-plugin-page','my_plugin_page_func');
   add_submenu_page('my-plugin-page','My Plugin Sub Page','My Plugin Sub Page','manage_options','my-plugin-subpage','my_plugin_subpage_func');
}
add_action('admin_menu','my_plugin_menu');