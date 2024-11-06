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
        }
        h6, p {
            font-family: 'Poppins', sans-serif;
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
        .table {
    width: 100%; 
    margin: 20px 0;
    border-collapse: collapse; 
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
}

    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <a><img src="assets/Untitled design.png" class="footer-logo"></a>
    <a href="1index.php">Dashboard</a>
    <a href="6inventory.php">Stocks</a>
    <a href="#">Report</a>
    <a href="#">Orders</a>
    <a href="#">Customers</a>
    <a href="#">Settings</a>
</div>

<div class="content" id="content">
    <div class="hamburger" id="hamburger">
        <button class="btn btn-light">☰</button>
    </div>
    <h2 class="text-center">Dashboard</h2>

    <!-- Overview Cards -->
    <div class="row text-center mb-2">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Daily Sales</h6>
                    <p class="card-text">$1,200</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Sales This Month</h6>
                    <p class="card-text">$18,000</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Orders</h6>
                    <p class="card-text">150</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Combined Monthly Sales Box and Chart -->
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Monthly Sales</h6>
                    <p class="card-text">$24,000</p>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combined Order Status Box and Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Order Status</h6>
                    <p class="card-text">Summary of current orders</p>
                    <div class="chart-container">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Recent Orders Table -->
<h6 class="text-center">Recent Orders</h6>
<table class="table table-striped table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1001</td>
            <td>John Doe</td>
            <td><span class="badge badge-success">Shipped</span></td>
            <td>$100</td>
            <td>2024-11-01</td>
        </tr>
        <tr>
            <td>1002</td>
            <td>Jane Smith</td>
            <td><span class="badge badge-warning">Processing</span></td>
            <td>$150</td>
            <td>2024-11-01</td>
        </tr>
    </tbody>
</table>


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

    // Monthly Sales Chart
    const salesChartCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesChartCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Monthly Sales',
                data: [5000, 7000, 8000, 10000, 15000, 20000, 25000],
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1.5,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    

    // Order Status Pie Chart
    const orderStatusChartCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusChartCtx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Processing', 'Shipped', 'Delivered'],
            datasets: [{
                data: [10, 20, 30, 40],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
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
