<?php
   include('header.php');
   checkUser();
   userArea();
   
   if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0){
   	$id=get_safe_value($_GET['id']);
   	mysqli_query($con,"delete from expense where id=$id");
   	echo "<br/>Data deleted<br/>";
   }
   
   $res_expense = mysqli_query($con,"select expense.*,category.name from expense,category where expense.category_id=category.id and expense.added_by='".$_SESSION['UID']."' order by expense.expense_date asc");

   $res_investment = mysqli_query($con,"select investment.*,category.name from investment,category where investment.category_id=category.id and investment.added_by='".$_SESSION['UID']."' order by investment.investment_date asc");
?>

<script>
   setTitle("Expense and Investment");
   selectLink('expense_link');
</script>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <h2>Expense</h2>
               <a href="manage_expense.php">Add Expense</a>
               <br/><br/>
               <?php if(mysqli_num_rows($res_expense) > 0) { ?>
               <div class="table-responsive table--no-card m-b-30">
                  <table class="table table-borderless table-striped table-earning">
                     <thead>
                        <tr>
                           <th>Category</th>
                           <th>Item</th>
                           <th>Price</th>
                           <th>Details</th>
                           <th>Expense Date</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php while($row = mysqli_fetch_assoc($res_expense)) { ?>
                        <tr>
                           <td><?php echo $row['name'] ?></td>
                           <td><?php echo $row['item'] ?></td>
                           <td><?php echo $row['price'] ?></td>
                           <td><?php echo $row['details'] ?></td>
                           <td><?php echo $row['expense_date'] ?></td>
                           <td>
                              <a href="manage_expense.php?id=<?php echo $row['id']; ?>">Edit</a>&nbsp;
                              <a href="javascript:void(0)" onclick="delete_confir('<?php echo $row['id']; ?>','expense.php')">Delete</a>
                           </td>
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