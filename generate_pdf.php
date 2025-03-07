<?php
require_once('tcpdf/tcpdf.php'); // or 'fpdf/fpdf.php' if using FPDF

$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';

// Create new PDF document
$pdf = new TCPDF();
$pdf->AddPage();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Report');

// Add a title
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(0, 10, 'Report', 0, 1, 'C');

// Add a subtitle with date range
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, "From: $startDate To: $endDate", 0, 1, 'C');

// Add table headers
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(30, 10, 'Type', 1);
$pdf->Cell(50, 10, 'Details', 1);
$pdf->Cell(30, 10, 'Item', 1);
$pdf->Cell(30, 10, 'Price', 1);
$pdf->Cell(30, 10, 'Date', 1);
$pdf->Ln();

// Fetch data from the database
$conn = new mysqli('localhost', 'root', '', 'expense');
$query = "SELECT 'Investment' AS type, details, item, price, investment_date AS date FROM investment WHERE investment_date BETWEEN '$startDate' AND '$endDate'
          UNION ALL
          SELECT 'Expense' AS type, details, item, price, expense_date AS date FROM expense WHERE expense_date BETWEEN '$startDate' AND '$endDate'";
$result = $conn->query($query);

$totalPrice = 0;
if ($result->num_rows > 0) {
    $pdf->SetFont('helvetica', '', 12);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['type'], 1);
        $pdf->Cell(50, 10, $row['details'], 1);
        $pdf->Cell(30, 10, $row['item'], 1);
        $pdf->Cell(30, 10, $row['price'], 1);
        $pdf->Cell(30, 10, $row['date'], 1);
        $pdf->Ln();
        $totalPrice += $row['price'];
    }
}

// Add total price
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(110, 10, 'Total Price', 1);
$pdf->Cell(30, 10, $totalPrice, 1);
$pdf->Ln();

// Close and output PDF document
$pdf->Output('report.pdf', 'I');

$conn->close();
?> 