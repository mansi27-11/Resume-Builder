<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Enable remote CSS/images if needed
$options = new Options();
$options->set('isRemoteEnabled', true);

// Create Dompdf instance
$dompdf = new Dompdf($options);

// Load your resume HTML (inline, or from file)
ob_start();
include 'view_resume.php';  // Your resume HTML file
$html = ob_get_clean();

// Load and render the HTML
$dompdf->loadHtml($html);
$dompdf->setPaper([0, 0, 595, 842]); // or landscape
$dompdf->render();

// Download the PDF
$dompdf->stream("resume.pdf", ["Attachment" => 1]); // 1 = download, 0 = preview
?>
