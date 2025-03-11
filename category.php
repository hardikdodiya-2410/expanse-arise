
<?php
   include('header.php');
   checkUser();

   if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
       $id = get_safe_value($_GET['id']);
       $result = mysqli_query($con, "DELETE FROM category WHERE id=$id");
       
       if ($result) {
           echo "<br/>Data deleted<br/>";
         
       } else {
           echo "<br/>Error deleting data: " . mysqli_error($con) . "<br/>";
       }
   }
   
   if($_SESSION['UROLE']=='User'){
      $uid = $_SESSION['UID'];
      $res = mysqli_query($con, "SELECT * FROM category WHERE user_id=$uid ORDER BY id DESC");
   } else {
      $res = mysqli_query($con, "SELECT * FROM category ORDER BY id DESC");
   }
 
?>

<script>
   setTitle("Category");
   selectLink('category_link');

   function delete_confir(id, page) {
       if (confirm("Are you sure you want to delete this item?")) {
           window.location.href = page + "?type=delete&id=" + id;
       }
   }
</script>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
         <div class="col-lg-5.5">
               <h2>Category</h2>
               <a href="manage_category.php">Add category</a>
               <br/><br/>
               <?php if(mysqli_num_rows($res) > 0) { ?>
                  <div class="table-responsive table--no-card m-b-30">
                  <table class="table table-borderless table-striped table-earning">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>Type</th>
                           <th></th>
                           <?php
                              if($_SESSION['UROLE']=='Admin')
                              { ?>
                                   <th>User</th>
                                 
                              <?php } ?>
                        </tr>
                     <tbody>
                        <?php while($row = mysqli_fetch_assoc($res)){ ?>
                        <tr>
                           <td><?php echo $row['name']?></td>
                           <td><?php echo $row['type']?></td>
                           <td>
                                    <a href="manage_category.php?id=<?php echo $row['id'];?>">Edit</a>&nbsp;
                                    <a href="javascript:void(0)" onclick="delete_confir('<?php echo $row['id'];?>','category.php')">Delete</a>
                                 </td>
<?php
                           if($_SESSION['UROLE']=='Admin')
                           { ?>
                              <td><?php echo $row['user_id']?></td>
                              <?php } ?>
                                
                             
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
               <?php } else { echo "No expense data found"; } ?>

                           
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   include('footer.php');
   ?>