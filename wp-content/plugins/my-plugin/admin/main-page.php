<h1>Hello!</h1>

<?php
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
<div class="wrap">  
<table class="wp-list-table widefat fixed striped table-view-list posts">
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
    </div>
<?php
$html = ob_get_clean();
echo $html;