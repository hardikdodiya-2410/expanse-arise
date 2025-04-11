<?php
function prx($data){
	echo '<pre>';
	print_r($data);
	die();
}

function get_safe_value($data){
	global $con;
	if($data){
		return mysqli_real_escape_string($con,$data);
	}
}

function redirect($link){
	?>
	<script>
	window.location.href="<?php echo $link?>";
	</script>
	<?php
}

function checkUser(){
	if(isset($_SESSION['UID']) && $_SESSION['UID']!=''){
	
		
	}else{
		redirect('index.php');
	}
}

function getCategory($category_id='', $user_id='', $type='') {
	global $con;
	$query = "SELECT * FROM category WHERE 1";

	// Add condition for type if specified
	if ($type) {
		$query .= " AND type='$type'";
	}

	// Add condition for user ID if specified
	if ($user_id) {
		$query .= " AND user_id='$user_id'";
	}

	$query .= " ORDER BY name ASC";
	$res = mysqli_query($con, $query);

	$html = '<select name="category_id" id="category_id" class="form-control">';
	$html .= '<option value="">Select Category</option>';

	while ($row = mysqli_fetch_assoc($res)) {
		if ($category_id > 0 && $category_id == $row['id']) {
			$html .= '<option value="' . $row['id'] . '" selected>' . $row['name'] . '</option>';
		} else {
			$html .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
		}
	}

	$html .= '</select>';
	return $html;
}

function getDashboardExpense($type){
	global $con;
	$today=date('Y-m-d');
	if($type=='today'){
		$sub_sql=" and expense_date='$today'";
		$from=$today;
		$to=$today;
	}
	elseif($type=='yesterday'){
		$yesterday=date('Y-m-d',strtotime('yesterday'));
		$sub_sql=" and expense_date='$yesterday'";
		$from=$yesterday;
		$to=$yesterday;
	}elseif($type=='week' || $type=='month' || $type=='year'){
		$from=date('Y-m-d',strtotime("-1 $type"));
		$sub_sql=" and expense_date between '$from' and '$today'";
		$to=$today;
	}else{
		$sub_sql=" ";
		$from='';
		$to='';
	}
	if($type=='today'){
		$sub_sql1=" and investment_date='$today'";
		$from=$today;
		$to=$today;
	}
	elseif($type=='yesterday'){
		$yesterday=date('Y-m-d',strtotime('yesterday'));
		$sub_sql1=" and investment_date='$yesterday'";
		$from=$yesterday;
		$to=$yesterday;
	}elseif($type=='week' || $type=='month' || $type=='year'){
		$from=date('Y-m-d',strtotime("-1 $type"));
		$sub_sql1=" and investment_date between '$from' and '$today'";
		$to=$today;
	}else{
		$sub_sql1=" ";
		$from='';
		$to='';
	}
	
	$res=mysqli_query($con,"select sum(price) as price from expense where added_by='".$_SESSION['UID']."' $sub_sql");
	$res1=mysqli_query($con,"select sum(price) as price from investment where added_by='".$_SESSION['UID']."' $sub_sql1");
	$row=mysqli_fetch_assoc($res);
	$row1=mysqli_fetch_assoc($res1);
	$p=0;
	$link="";
	if($row['price']>0 || $row1['price']>0){
		$p=$row['price']+$row1['price'];
		$link="&nbsp;<a href='dashboard_report.php?from=".$from."&to=".$to."' target='_blank' class='detail_link'>Details</a>";
	}
	
	return $p.$link;	
}

function adminArea(){
	if($_SESSION['UROLE']!='Admin'){
		redirect('dashboard.php');
	}
}

function userArea(){
	if($_SESSION['UROLE']!='User'){
		redirect('category.php');
	}
}
?>