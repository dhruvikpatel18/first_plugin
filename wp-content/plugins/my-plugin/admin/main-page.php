
<?php
//database connection
global $wpdb,$table_prefix;
$wp_emp = $table_prefix.'emp';

if(isset($_POST['search_term'])){
   $q = "SELECT * FROM `$wp_emp` WHERE `name` LIKE '%".$_POST['search_term']."%';";
}else{
   $q = "SELECT * FROM `$wp_emp`;";
}


$results = $wpdb->get_results($q);//it provides all database objects

// echo '<pre>';
// print_r($results);//for print array
// echo '<pre>';

ob_start()
?>
<div class="wrap">  
    <h2>My Plugin Page</h2>
<div class="my-form">
    <form action="<?php echo admin_url('admin.php');?>" id="my-search-form">
        <input type="hidden" name="page" value="my-plugin-page">
        <input type="text" name="my_search_term" id="my-search-term">
        <input type="submit" value="search" name="search">
    </form>
</div>
<table class="wp-list-table widefat fixed striped table-view-list posts">
   <thead>
      <tr>
         <th>Id</th>
         <th>Name</th>
         <th>Email</th>
         <th>status</th>
      </tr>
   </thead>
   <tbody id="my-table-result">
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
    </div>
<?php
$html = ob_get_clean();
echo $html;