<?php
   include('header.php');
   checkUser();
   userArea();
   
   $startDate = $_POST['start_date'] ?? '';
   $endDate = $_POST['end_date'] ?? '';
   
  
   if ($con->connect_error) {
       die("Connection failed: " . $con->connect_error);
   }
   
   $query = "SELECT 'Investment' AS type,details, item, price, investment_date AS date FROM investment WHERE investment_date BETWEEN '$startDate' AND '$endDate'
             UNION ALL
             SELECT 'Expense' AS type,details, item, price, expense_date AS date FROM expense WHERE expense_date BETWEEN '$startDate' AND '$endDate'";
   
   $result = $con->query($query);

  
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
<script>
   setTitle("Reports");
   selectLink('reports_link');

   async function downloadPDF() {
       const { jsPDF } = window.jspdf;
       const doc = new jsPDF();

       // Company name
       const companyName = "Expense Arise";

       // Get date range from the form inputs
    

      

       // Add some line space
       const lineSpacing = 5;

     

       // Get the table element
       const table = document.querySelector('.table');
       console.log(table); // Log the table to verify its content

       // Add the table to the PDF using autoTable with custom styles
       doc.autoTable({
           html: table,
           startY: 10 + lineSpacing,
           styles: {
               fontSize: 12, // Set the font size for the table content
               font: 'helvetica', // Set the font type
               fillColor: [255, 255, 255], // White background
               textColor: [0, 0, 0], // Black text color
               fontStyle: 'normal', // Normal font style
               lineColor: [0, 0, 0], // Black border color
               lineWidth: 0.1 // Border width
           },
           headStyles: {
               fillColor: [200, 200, 200], // Light gray background for header
               textColor: [0, 0, 0], // Black text color for header
               fontStyle: 'bold' // Bold font style for header
           }
       });

       // Save the PDF
       doc.save('report.pdf');
   }
</script>
<div class="main-content">
   <div class="section__content section__content--p30">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-12">
               <div class="filter_form">
                  <form method="POST">
                      <label class="form-label">From</label>
                      <input type="date" id="start_date" name="start_date" class="form-control w250" required>
                      <label class="form-label">To</label>
                      <input type="date" id="end_date" name="end_date" class="form-control w250" required>
                      <button type="submit" class="btn btn-primary" style="margin-top: 0px;">Submit</button>
                      <a href="reports.php" class="btn btn-danger" style="margin-top: 0px;">Reset</a>
                     </form>
               </div>
               <br/><br/>
               <div class="table-responsive table--no-card m-b-30">
                  <table class="table table-borderless table-striped table-earning">
                       
                  <thead>
                     <tr>
                        <th colspan="3">Expense Report</th>
                        <th colspan="2">From: <?= $startDate ?> To: <?= $endDate ?></th>
                     </tr>
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
                  $con->close();
                  ?>
                 
                  </tbody>
                  
                  </table>
                
               </div>
               <button type="button" onclick="downloadPDF()" class="btn btn-success" style="margin-top: 0px;">Download PDF</button>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   include('footer.php');
?>