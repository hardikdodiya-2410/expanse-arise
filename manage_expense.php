<?php
   include('header.php');
   checkUser();
   userArea();
   $msg="";
   $category_id="";
   $item="";
   $price="";
   $details="";
   $expense_date=date('Y-m-d');
   $label="Add";
   if(isset($_GET['id']) && $_GET['id']>0){
   	$label="Edit";
   	$id=get_safe_value($_GET['id']);
   	$res=mysqli_query($con,"select * from expense where id=$id");
   	if(mysqli_num_rows($res)==0){
   		redirect('expense.php');
   		die();
   	}
   	$row=mysqli_fetch_assoc($res);
   	$category_id=$row['category_id'];
   	$item=$row['item'];
   	$price=$row['price'];
   	$details=$row['details'];
   	$expense_date=$row['expense_date'];
   	if($row['added_by']!=$_SESSION['UID']){
   		redirect('expense.php');
   	}
   	
   }
   
 
   if (isset($_POST['submit'])) {
      $item = get_safe_value($_POST['item']);
      $price = get_safe_value($_POST['price']);
      $details = get_safe_value($_POST['details']);
      $expense_date = get_safe_value($_POST['expense_date']);
      $category_id = get_safe_value($_POST['category_id']);
      $added_by = $_SESSION['UID'];
  
      if (isset($_GET['id']) && $_GET['id'] > 0) {
          mysqli_query($con, "UPDATE expense SET category_id='$category_id', item='$item', price='$price', details='$details', expense_date='$expense_date' WHERE id='$id'");
      } else {
          mysqli_query($con, "INSERT INTO expense(category_id, item, price, details, expense_date, added_by) VALUES('$category_id', '$item', '$price', '$details', '$expense_date', '$added_by')");
      }
      redirect('expense.php');
  }
   ?>
<script>
   setTitle("Manage Expense");
   selectLink('expense_link');
</script>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <h2><?php echo $label?> Expense</h2>
               <a href="expense.php">Back</a>
               <div class="card">
                  <div class="card-body card-block">
                     <form method="post" class="form-horizontal">
                     <div class="form-group">												<label class="control-label mb-1">Category</label>
                           <?php echo getCategory($category_id, $_SESSION['UID'], 'expense');
                              ?>                               
                        </div>
                        <div class="form-group">												<label class="control-label mb-1">Item</label>
                           <input type="text" name="item" required value="<?php echo $item?>" class="form-control" rquired>
                        </div>
                        <div class="form-group">												<label class="control-label mb-1">Price</label>
                           <input type="text" name="price" required value="<?php echo $price?>" class="form-control" rquired>
                        </div>
                        <div class="form-group">												<label class="control-label mb-1">Details</label>
                           <input type="text" name="details" required value="<?php echo $details?>" class="form-control" rquired>
                        </div>
                        <div class="form-group">												<label class="control-label mb-1">Expense Date</label>
                           <input type="date" name="expense_date" required value="<?php echo $expense_date?>" class="form-control" rquired max="<?php echo date('Y-m-d')?>">
                        </div>
                        <div class="form-group">												
                           <input type="submit" name="submit" value="Submit"  class="btn btn-lg btn-info btn-block">                          
                        </div>
                        <div id="msg"><?php echo $msg?></div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   include('footer.php');
   ?>