<?php
include('config.php');
include('functions.php');
$msg="";
$username="";
$password="";
$Email="";
$Mobile="";
$label="Add";
/*if(isset($_GET['id']) && $_GET['id']>0){
	$label="Edit";
	$id=get_safe_value($_GET['id']);
	$res=mysqli_query($con,"select * from users where id=$id");
	if(mysqli_num_rows($res)==0){
		redirect('users.php');
		die();
	}
	$row=mysqli_fetch_assoc($res);
	$username=$row['username'];
	$password=$row['password'];
}*/

if(isset($_POST['submit'])){
	$username=get_safe_value($_POST['username']);
    $password = get_safe_value($_POST['password']);
    $Email = get_safe_value($_POST['email']);
    $Mobile = get_safe_value($_POST['mobile']);

	$type="add";
	$sub_sql="";
	if(isset($_GET['id']) && $_GET['id']>0){
		$type="edit";
		$sub_sql="and id!=$id";
	}
	
	$res=mysqli_query($con,"select * from users where username='$username' $sub_sql");
	if(mysqli_num_rows($res)>0){
		$msg="Username already exists";
	}
	else
	{
		
		$password=password_hash($password,PASSWORD_DEFAULT);
		
		$sql="insert into users(username,password,email,mobile,role) values('$username','$password','$Email','$Mobile','User')";
		if(isset($_GET['id']) && $_GET['id']>0){
			$sql="update users set username='$username',password='$password' where id=$id";
		}
		mysqli_query($con,$sql);
		redirect('index.php');
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Register</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>
<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="images/icon/logo.PNG" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
						<br/>
<form action="" method="post">
	<div class="form-group">
    	<label>Username</label>
        <input class="au-input au-input--full" type="text" name="username" required value="<?php echo $username?>" placeholder="Username">
	</div>
	<div class="form-group">
        <label>Email</label>
        <input class="au-input au-input--full" type="Email" name="email" required value="<?php echo $Email?>" placeholder="email">
    </div>
    <div class="form-group">
        <label>Mobile</label>
        <input class="au-input au-input--full" type="numver" name="mobile" maxlength="10" required value="<?php echo $Mobile?>" placeholder="mobile">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input class="au-input au-input--full" type="password" name="password" required value="<?php echo $password?>" placeholder="Password">
    </div>
	<div id="msg"><?php echo $msg?></div>
	<button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="submit">register</button>
	<div class="register-link">
        <p>
			Already have account?<a href="index.php">&nbsp;Sign In</a>
    	</p>
    </div>
</form>


<?php
include('footer.php');
?>