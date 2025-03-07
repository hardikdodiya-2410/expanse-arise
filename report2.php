<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

input[type="date"], select {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

button {
    background-color: #17a2b8;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 4px;
}

button:hover {
    background-color: #17a2b8;
}

table {
    width: 90%;
    margin-left: 5%;
    border-radius: 4px;
}

th, td {
  
    padding: 10px;
    text-align: left;
}

th {
    background-color: #17a2b8;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

.total-row {
    font-weight: bold;
    background-color: #e0f2f1;
}

</style>
<?php


$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';

$conn = new mysqli('localhost', 'root', '', 'expense');

if ($conn->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$query = "SELECT 'Investment' AS type,details, item, price, investment_date AS date FROM investment WHERE investment_date BETWEEN '$startDate' AND '$endDate'
          UNION ALL
          SELECT 'Expense' AS type,details, item, price, expense_date AS date FROM expense WHERE expense_date BETWEEN '$startDate' AND '$endDate'";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment and Expense Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body><div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="filter_form">
                  
    <form method="POST">
       
        <input type="date" id="start_date" name="start_date" required>

        <input type="date" id="end_date" name="end_date" required>
        <button type="submit">Submit</button>
    </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Details</th>
                <th>Item</th>
                <th>Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalPrice = 0; // Initialize total price
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    
                    echo "<tr>
                            <td>{$row['type']}</td>
                            <td>{$row['details']}</td>
                            <td>{$row['item']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['date']}</td>
                          </tr>";
                      $totalPrice += $row['price']; // Add price to total
                  
                }
                
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }

            echo "<tr class='total-row'><td colspan='3'>Total Price</td> <td colspan='2'>{$totalPrice}</td></tr>";

            $conn->close();
            ?>
        </tbody>
    </table>

    <!-- Display total price -->
    <p></p>
</body>
</html>
