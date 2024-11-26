<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT OrderID, Product, Quantity, Status, Total, Date FROM refund_order WHERE Status = 'Order Refunded'";
$result = $conn->query($sql);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <link rel="stylesheet" href="styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,900');
    
    body {
        font-size: 14px;
        display: flex;
        height: 100vh;
        overflow: hidden;
        background-color: #C1C1C1;
        font-family: 'Poppins', sans-serif;
    }

    h6, p {
        font-size: 14px;
        line-height: 1.7;
        font-weight: 500;
        color: black;
        -webkit-font-smoothing: antialiased;
        -webkit-text-shadow: rgba(0,0,0,.01) 0 0 1px;
        text-shadow: rgba(0,0,0,.01) 0 0 1px;
    }

    .sidebar {
        width: 215px;
        background-color: black;
        color: white;
        padding: 15px;
        position: fixed;
        height: 100%;
        overflow-y: auto;
        transition: transform 0.3s ease;
        z-index: 1000;
    }

    .sidebar h2 {
        color: #fff;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px;
        margin: 5px 0;
        border-radius: 4px;
    }

    .sidebar a:hover {
        background-color: #495057;
    }

    .content {
        margin-left: 220px;
        padding: 20px;
        flex-grow: 1;
        transition: margin-left 0.3s ease;
        overflow-y: auto;
    }

    .hamburger {
        cursor: pointer;
        margin: 15px;
        display: none;
    }

    .footer-logo {
        width: 168px;
        height: auto;
        cursor: default;
    }

    .card {
        border-radius: 20px;
        background-color: white;
        margin-bottom: 15px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            transform: translateX(-100%);
            width: 100%;
            height: 100%;
        }
        .content {
            margin-left: 0;
        }
        .hamburger {
            display: block;
        }
    }

    /* Table Styling */
    .table {
        width: 100%;
        margin: 20px 0;
        border-collapse: collapse;
        font-family: 'Poppins', sans-serif;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
        padding: 10px;
    }

    .table th {
        background-color: #343a40;
        color: white;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 5px;
        background-color: #28a745;
        color: white;
    }

    /* Button Styles */
    .btn {
        padding: 5px 10px;
        font-size: 14px;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }

    .btn-warning {
        background-color: #ffc107;
        color: white;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }
</style>

    
</head>
<body>

<div class="sidebar" id="sidebar">
    <a><img src="assets/Untitled design.png" class="footer-logo"></a>
    <a href="6dashboard.php">Dashboard</a>
    <a href="6inventory.php">Stocks</a>
    <a href="6onprocess.php">On Process</a>
    <a href="6completeorders.php">Complete Orders</a>
    <a href="6cancelorders.php">Cancel Orders</a>
    <a href="6refundorders.php">Refund Orders</a>
</div>

<h2>Completed Orders</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['OrderID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Product']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                    echo "<td><span class='badge badge-success'>" . htmlspecialchars($row['Status']) . "</span></td>";
                    echo "<td>" . htmlspecialchars($row['Total']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No Refund orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
   
    </div>


<!-- JavaScript for Sidebar Toggle -->
<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const hamburger = document.getElementById('hamburger');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        if (sidebar.classList.contains('active')) {
            sidebar.style.transform = 'translateX(0)';
            sidebar.style.zIndex = '1001'; // Ensure it covers content
            content.style.marginLeft = '0'; // No margin
        } else {
            sidebar.style.transform = 'translateX(-100%)'; // Hide off-screen
            content.style.marginLeft = '0'; // Reset margin
            sidebar.style.zIndex = ''; // Reset zIndex
        }
    });

    // Monthly Sales Data from PHP
const monthlySalesData = <?php echo json_encode($monthlySalesData); ?>;
const months = Object.keys(monthlySalesData);
const sales = Object.values(monthlySalesData);

// Render the Monthly Sales Chart as a Line Chart
const salesChartCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesChartCtx, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Monthly Sales',
            data: sales,
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1.5,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Sales (Total)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Month'
                }
            }
        }
    }
});
    

    const orderSummary = <?php echo json_encode($orderSummary); ?>;

    // Order Status Pie Chart
    const orderStatusChartCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusChartCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(orderSummary),
            datasets: [{
                data: Object.values(orderSummary),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)', // Pending
                    'rgba(54, 162, 235, 0.5)', // Processing
                    'rgba(255, 206, 86, 0.5)', // Shipped
                    'rgba(75, 192, 192, 0.5)'  // Delivered
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
<script>
    // JavaScript to make the navbar opaque when scrolling
    window.addEventListener('scroll', function() {
        const mainNav = document.querySelector('.main_nav_container');
        
        if (window.scrollY > 50) { // Adjust the scroll threshold as needed
            mainNav.classList.add('opaque');
        } else {
            mainNav.classList.remove('opaque');
        }
    });
</script>
</body>
</html>
