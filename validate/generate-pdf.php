<?php
require '../vendor/autoload.php';
require('../fpdf/fpdf.php');
require '../validate/db.php'; // Include your database connection

session_start();

if (!isset($_SESSION["transaction_data"])) {
    die("No transaction data found.");
}
date_default_timezone_set('Asia/Manila'); // Set timezone to Philippine Standard Time

$data = $_SESSION["transaction_data"];
$student_id = $data['student_id'] ?? 'Unknown';
$date_borrowed = $data['date_borrowed'] ?? date('Y-m-d');
$book_title = $data['book_id'] ?? 'Unknown Book'; // Assuming book_id is the title

// Retrieve barcode from the session
$barcode = $data['barcode'] ?? null; // Retrieve barcode from session

if (!$barcode) {
    // If barcode not in session, try to retrieve from the database.
    $barcode = getBarcodeFromDatabase($conn, $student_id, $book_title, $date_borrowed);
    if (!$barcode) {
        $barcode = "Barcode Not Found"; // Default if barcode is not found
    }
}

// Generate a unique filename
$pdf_filename = "Transaction_{$student_id}_{$date_borrowed}.pdf";

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Library Logo (Centered and Spaced Correctly)
$pdf->Image('../img/LMS_logo.png', 75, 10, 50); // Adjust X, Y, and width
$pdf->Ln(45); // Increased space below logo

// Title (Library Transaction Receipt)
$pdf->Cell(190, 10, 'AklatURSM Transaction Receipt', 0, 1, 'C');
$pdf->Ln(10); // Extra space to prevent overlap

// Transaction Details Heading (Fixed Position)
$pdf->SetFillColor(200, 220, 255);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Transaction Details', 1, 1, 'C', true);
$pdf->Ln(5);

// Set font for table content
$pdf->SetFont('Arial', '', 12);

// Define keys to include in the PDF
$keysToInclude = ['email', 'student_id', 'name', 'contact', 'address', 'course', 'author', 'book_id', 'date_borrowed', 'return_date'];

foreach ($keysToInclude as $key) {
    if (isset($data[$key])) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(60, 10, ucfirst(str_replace("_", " ", $key)) . ":", 1, 0, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(130, 10, $data[$key], 1, 1, 'L');
    }
}

// Barcode Generation
try {
    $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
    $barcodeData = $generatorPNG->getBarcode($barcode, Picqer\Barcode\BarcodeGenerator::TYPE_CODE_128); //Use the retrieved barcode.

    // Save barcode image
    $barcodeFilename = tempnam(sys_get_temp_dir(), 'barcode') . '.png';
    file_put_contents($barcodeFilename, $barcodeData);

    // Embed barcode in the PDF
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Book Barcode:', 0, 1, 'C');
    $pdf->Image($barcodeFilename, 70, $pdf->GetY(), 70); // Adjust position as needed

    // Delete the temporary barcode file
    unlink($barcodeFilename);
} catch (Exception $e) {
    // Handle barcode generation error
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Barcode generation failed: ' . $e->getMessage(), 0, 1, 'C');
}

// Footer (Generated Date)
$pdf->Ln(30); // Adjust spacing after barcode/error message
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(190, 10, 'Generated on ' . date("Y-m-d H:i:s"), 0, 1, 'C'); // Use Philippine time

// Save and Output PDF
$pdf->Output('D', $pdf_filename);

// Function to retrieve barcode from the database
function getBarcodeFromDatabase($conn, $student_id, $book_title, $date_borrowed) {
    $sql = "SELECT barcode FROM transactions WHERE student_id = ? AND book_title = ? AND date_borrowed = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_id, $book_title, $date_borrowed);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['barcode'];
    } else {
        return false;
    }
}
?>