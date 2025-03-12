<?php
include('header.php');
$msg = "";

if(isset($_SESSION['UID']) && $_SESSION['UID'] != ''){
    $id = $_SESSION['UID'];
    $res = mysqli_query($con, "SELECT username FROM users WHERE id='$id'");
    if($row = mysqli_fetch_assoc($res)) {
        $username = $row['username'];
    }
} else {
    redirect('index.php');
}
userArea();

if(isset($_POST['submit'])){
    $password = get_safe_value($_POST['password']);
    $confirm_password = get_safe_value($_POST['confirm_password']);

    if($password !== $confirm_password){
        $msg = "Passwords do not match!";
    } else {
        $res = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
        if(mysqli_num_rows($res) > 0){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password='$password' WHERE id=$id";
            mysqli_query($con, $sql);
            $msg = "Password is changed successfully!";
        } else {
            $msg = "User not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
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
                            <form action="" method="post">
                            <div class="form-group">
    <label>Username</label>
    <input class="au-input au-input--full" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
</div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" required placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="au-input au-input--full" type="password" name="confirm_password" required placeholder="Confirm Password">
                                </div>
                                <div id="msg"><?php echo $msg; ?></div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" name="submit">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php'); ?>
