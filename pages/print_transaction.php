<?php
require '../vendor/autoload.php';
require('../fpdf/fpdf.php');
require '../validate/db.php';

if (!isset($_GET['transaction_id'])) {
    die("Missing required transaction details.");
}

$transactionId = intval($_GET['transaction_id']);

// Retrieve transaction details from the database
$sql = "SELECT email, student_id, name, address, course, author, book_title, DATE(date_borrowed) AS date_borrowed, return_date, barcode FROM transactions WHERE transaction_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $transactionId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Transaction not found.");
}

$transaction = $result->fetch_assoc();

// Generate a unique filename
$pdfFilename = "Transaction_{$transaction['student_id']}_{$transaction['date_borrowed']}.pdf";

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Library Logo
$pdf->Image('../img/LMS_logo.png', 75, 10, 50);
$pdf->Ln(45);

// Title
$pdf->Cell(190, 10, 'AklatURSM Transaction Receipt', 0, 1, 'C');
$pdf->Ln(10);

// Transaction Details
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Transaction Details', 1, 1, 'C', true);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$fields = [
    'Email' => $transaction['email'],
    'Student ID' => $transaction['student_id'],
    'Name' => $transaction['name'],
    'Address' => $transaction['address'],
    'Course' => $transaction['course'],
    'Author' => $transaction['author'],
    'Book Title' => $transaction['book_title'],
    'Date Borrowed' => $transaction['date_borrowed'],
    'Return Date' => $transaction['return_date']
];

foreach ($fields as $label => $value) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, $label . ":", 1, 0, 'L', true);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(130, 10, htmlspecialchars($value), 1, 1, 'L');
}

// Barcode
try {
    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
    $barcodeData = $generatorPNG->getBarcode($transaction['barcode'], Picqer\Barcode\BarcodeGenerator::TYPE_CODE_128);

    // Save barcode image
    $barcodeFilename = tempnam(sys_get_temp_dir(), 'barcode') . '.png';
    file_put_contents($barcodeFilename, $barcodeData);

    // Embed barcode in the PDF
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Book Barcode:', 0, 1, 'C');
    $pdf->Image($barcodeFilename, 70, $pdf->GetY(), 70);

    // Delete the temporary barcode file
    unlink($barcodeFilename);
} catch (Exception $e) {
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Barcode generation failed: ' . $e->getMessage(), 0, 1, 'C');
}

date_default_timezone_set('Asia/Manila'); // Set timezone to Philippine Standard Time

// Footer
$pdf->Ln(30);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(190, 10, 'Generated on ' . date("Y-m-d H:i:s"), 0, 1, 'C'); // Use Philippine time

// Output PDF
$pdf->Output('D', $pdfFilename);
?>
