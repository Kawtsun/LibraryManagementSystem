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

// Ensure date_borrowed includes both date and time
if (isset($data['date_borrowed']) && strtotime($data['date_borrowed'])) {
    $date_borrowed = date('Y-m-d H:i:s', strtotime($data['date_borrowed'])); // Format to include time
} else {
    $date_borrowed = date('Y-m-d H:i:s'); // Default to current date and time
}

// Update the session data to ensure consistency
$data['date_borrowed'] = $date_borrowed;

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
$pdf_filename = "Transaction_{$student_id}_" . date('Y-m-d', strtotime($date_borrowed)) . ".pdf"; // Filename with date only

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
$pdf->Cell(190, 10, strtoupper('Transaction Details'), 1, 1, 'C', true); // Uppercase the heading
$pdf->Ln(5);

// Set font for table content
$pdf->SetFont('Arial', '', 12);

// Define keys to include in the PDF
$keysToInclude = ['email', 'student_id', 'name', 'contact', 'address', 'course', 'author', 'book_id', 'date_borrowed', 'return_date'];

foreach ($keysToInclude as $key) {
    if (isset($data[$key])) {
        $pdf->SetFont('Arial', 'B', 12);
        $label = ucfirst(str_replace("_", " ", $key));
        if ($key === 'student_id') {
            $label = 'Student ID'; // Change label for student_id
        } elseif ($key === 'book_id') {
            $label = 'Book Title'; // Change label for book_id
        } elseif ($key === 'date_borrowed') {
            $label = 'Date Borrowed'; // Capitalize first letter for date_borrowed
        } elseif ($key === 'return_date') {
            $label = 'Return Date'; // Capitalize first letter for return_date
        }
        $pdf->Cell(60, 10, $label . ":", 1, 0, 'L', true);
        $pdf->SetFont('Arial', '', 12);
        if ($key === 'date_borrowed') {
            $pdf->Cell(130, 10, htmlspecialchars($data['date_borrowed']), 1, 1, 'L'); // Use the updated date_borrowed
        } else {
            $pdf->Cell(130, 10, htmlspecialchars($data[$key]), 1, 1, 'L');
        }
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