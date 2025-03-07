<?php
   include('header.php');
   checkUser();
   $msg="";
   $category="";
   $type="expense";
   $label="Add";
$uid= $_SESSION['UID'];
   if(isset($_GET['id']) && $_GET['id']>0){
   	$label="Edit";
   	$id=get_safe_value($_GET['id']);
   	$res=mysqli_query($con,"select * from category where id=$id");
   	if(mysqli_num_rows($res)==0){
   		redirect('category.php');
   		die();
   	}
   	$row=mysqli_fetch_assoc($res);
   	$category=$row['name'];
   	$type=$row['type'];
   }
   
   if(isset($_POST['submit'])){
   	$name=get_safe_value($_POST['name']);
   	$type=get_safe_value($_POST['type']);
   	
   	$sub_sql="";
   	if(isset($_GET['id']) && $_GET['id']>0){
   		$sub_sql="and id!=$id";
   	}
   	
   	$res=mysqli_query($con,"select * from category where name='$name' $sub_sql");
   	if(mysqli_num_rows($res)>0){
   		$msg="Category already exists";
   	}else{
   		$sql="insert into category(name, type,user_id) values('$name', '$type','$uid')";
   		if(isset($_GET['id']) && $_GET['id']>0){
   			$sql="update category set name='$name', type='$type' where id=$id";
   		}
   		mysqli_query($con,$sql);
   		redirect('category.php');
   	}
   }
   ?>
<script>
   setTitle("Manage Category");
   selectLink('category_link');
</script>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <h2><?php echo $label?> Category</h2>
               <a href="category.php">Back</a>
               <div class="card">
                  <div class="card-body card-block">
                     <form method="post" class="form-horizontal">
                        <div class="form-group">												
                           <label class="control-label mb-1">Category</label>
                           <input type="text" name="name" required value="<?php echo $category?>" class="form-control" rquired>
                        </div>
                        <div class="form-group">												
                           <label class="control-label mb-1">Type</label>
                           <select style="display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15sease-in-out, box-shadow .15sease-in-out;" name="type" required>
                              <option value="expense" <?php if ($type == 'expense') echo 'selected'; ?>>Expense</option>
                              <option value="investment" <?php if ($type == 'investment') echo 'selected'; ?>>Investment</option>
                           </select>
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