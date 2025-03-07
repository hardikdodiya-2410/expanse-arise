<?php
include('header.php');
checkUser();
userArea();
$label="Add";
$msg="";
$item = '';
$price = '';
$details = '';
$investment_date = '';
$category_id = '';

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM investment WHERE id='$id'");
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $item = $row['item'];
        $price = $row['price'];
        $details = $row['details'];
        $investment_date = $row['investment_date'];
        $category_id = $row['category_id'];
    } else {
        header('location:investment.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $item = get_safe_value($_POST['item']);
    $price = get_safe_value($_POST['price']);
    $details = get_safe_value($_POST['details']);
    $investment_date = get_safe_value($_POST['investment_date']);
    $category_id = get_safe_value($_POST['category_id']);
    $added_by = $_SESSION['UID'];

    if (isset($_GET['id']) && $_GET['id'] > 0) {
        mysqli_query($con, "UPDATE investment SET category_id='$category_id', item='$item', price='$price', details='$details', investment_date='$investment_date' WHERE id='$id'");
    } else {
        mysqli_query($con, "INSERT INTO investment(category_id, item, price, details, investment_date, added_by) VALUES('$category_id', '$item', '$price', '$details', '$investment_date', '$added_by')");
    }
    redirect('investment.php');
}


?>

<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <h2><?php echo $label?> Investment</h2>
               <a href="investment.php">Back</a>
               <div class="card">
                  <div class="card-body card-block">
                     <form method="post" class="form-horizontal">
                        <div class="form-group">												<label class="control-label mb-1">Category</label>
                           <?php echo getCategory($category_id, $_SESSION['UID'], 'investment');
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
                        <div class="form-group">												<label class="control-label mb-1">investment_date</label>
                           <input type="date" name="investment_date" required value="<?php echo $investment_date?>" class="form-control" rquired max="<?php echo date('Y-m-d')?>">
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