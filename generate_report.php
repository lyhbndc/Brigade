<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

// Start output buffering
ob_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Database connection failed.");
}

// Fetch monthly sales
$currentMonth = date('Y-m');
$sqlMonthlySales = "SELECT SUM(Total) as monthly_total FROM `order` WHERE DATE_FORMAT(Date, '%Y-%m') = '$currentMonth' AND Status = 'Order Completed'";
$resultMonthlySales = $conn->query($sqlMonthlySales);
$monthlySales = $resultMonthlySales->fetch_assoc()['monthly_total'] ?? 0;

// Fetch total number of orders
$sqlTotalOrders = "SELECT COUNT(*) as total_orders FROM `order`";
$resultTotalOrders = $conn->query($sqlTotalOrders);
$totalOrders = $resultTotalOrders->fetch_assoc()['total_orders'] ?? 0;

// Fetch all orders
$sqlAllOrders = "SELECT * FROM `order` ORDER BY Date DESC";
$resultAllOrders = $conn->query($sqlAllOrders);

// Prepare HTML content
$html = "<h1 style='text-align: center;'>Monthly Report</h1>";
$html .= "<h2>Monthly Sales: ₱" . number_format($monthlySales, 2) . "</h2>";
$html .= "<h3>Total Number of Orders: " . $totalOrders . "</h3>";  // Display the total number of orders

$html .= "<h3>All Orders</h3>";
$html .= "<table border='1' style='width: 100%; border-collapse: collapse; text-align: left;'>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>";

if ($resultAllOrders->num_rows > 0) {
    while ($row = $resultAllOrders->fetch_assoc()) {
        $html .= "<tr>
                    <td>{$row['OrderID']}</td>
                    <td>{$row['Customer']}</td>
                    <td>{$row['Date']}</td>
                    <td>{$row['Status']}</td>
                    <td>" . number_format($row['Total'], 2) . "</td>
                  </tr>";
    }
} else {
    $html .= "<tr><td colspan='5' style='text-align: center;'>No orders found</td></tr>";
}

$html .= "</tbody></table>";

// Close database connection
$conn->close();

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

// Debug rendering
try {
    $dompdf->render();
} catch (Exception $e) {
    die("Error rendering PDF: " . $e->getMessage());
}

// Stream the PDF file to download
ob_end_clean(); // Clear any output buffer before sending headers
$dompdf->stream("Monthly_Report_" . date('F_Y') . ".pdf", ["Attachment" => true]);
?>
