<?php
include('header.php');
checkUser();
userArea();

$from = '';
$to = '';
$sub_sql = "";
$sub_sql1 = "";

if(isset($_GET['from'])){
	$from = get_safe_value($_GET['from']);
}
if(isset($_GET['to'])){
	$to = get_safe_value($_GET['to']);
}

if($from !== '' && $to !== ''){
	$sub_sql .= " AND expense.expense_date BETWEEN '$from' AND '$to'";
	$sub_sql1 .= " AND investment.investment_date BETWEEN '$from' AND '$to'";
}

// Expense Query
$res_expense = mysqli_query($con, "SELECT expense.price, category.name,category.type, expense.details, expense.item, expense.expense_date 
	FROM expense, category 
	WHERE expense.category_id = category.id AND expense.added_by = '".$_SESSION['UID']."' $sub_sql");

// Investment Query
$res_investment = mysqli_query($con, "SELECT investment.price, category.name,category.type,  investment.details, investment.item, investment.investment_date 
	FROM investment,category 
	WHERE investment.category_id = category.id AND investment.added_by = '".$_SESSION['UID']."' $sub_sql1");
?>
<div class="main-content">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div>
						<h2>
							<?php if($from != '' && $to != ''){ ?>
							From <?php echo $from ?> : To <?php echo $to ?>
							<?php } ?>
						</h2>
						<br/>
					</div>

					<!-- EXPENSE TABLE -->
					<?php if(mysqli_num_rows($res_expense) > 0){ ?>
					<h4>Records</h4>
					<div class="table-responsive table--no-card m-b-30">
						<table class="table table-borderless table-striped table-earning">
							<tr>
                        <th>Type</th>
								<th>Category</th>
								<th>Item</th>
								<th>Price</th>
								<th>Details</th>
								<th>Date</th>
							</tr>
							<?php 
							$total_expense = 0;
							while($row = mysqli_fetch_assoc($res_expense)){
								$total_expense += $row['price'];
							?>
							<tr>
                        <td><?php echo $row['type']; ?></td>
								<td><?php echo $row['name']?></td>
								<td><?php echo $row['item']?></td>
								<td><?php echo $row['price']?></td>
								<td><?php echo $row['details']?></td>
								<td><?php echo $row['expense_date']?></td>
							</tr>
							<?php } ?>
							
							<?php 
							$total_investment = 0;
							while($row = mysqli_fetch_assoc($res_investment)){
								$total_investment += $row['price'];
							?>
							<tr>
                        <td><?php echo $row['type']; ?></td>
                     <td><?php echo $row['name']?></td>
								<td><?php echo $row['item']?></td>
								<td><?php echo $row['price']?></td>
								<td><?php echo $row['details']?></td>
								<td><?php echo $row['investment_date']?></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="4"></td>
								<th>Total</th>
								<th><?php echo $total_investment+$total_expense ?></th>
							</tr>
						</table>
					</div>
					<?php } ?>

					<?php if(mysqli_num_rows($res_expense) == 0 && mysqli_num_rows($res_investment) == 0){
						echo "<b>No data found</b>";
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>
