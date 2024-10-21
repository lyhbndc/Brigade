<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Dashboard with Charts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #222;
            padding-top: 30px;
        }

        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin-top: 0;
            font-size: 18px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #333;
            color: white;
        }

        .recent-orders {
            margin-top: 30px;
        }

        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .chart-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#">Dashboard</a>
        <a href="#">Orders</a>
        <a href="#">Products</a>
        <a href="#">Stock</a>
        <a href="#">Delivery</a>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>E-commerce Dashboard</h1>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Dashboard Overview -->
        <div class="dashboard-header">
            <div class="card">
                <h3>Expected Earnings</h3>
                <p>$12,500</p>
            </div>
            <div class="card">
                <h3>Orders This Month</h3>
                <p>150</p>
            </div>
            <div class="card">
                <h3>Average Daily Sales</h3>
                <p>$420</p>
            </div>
            <div class="card">
                <h3>Sales This Month</h3>
                <p>$18,200</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        <div class="table-container recent-orders">
            <h3>Recent Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1001</td>
                        <td>John Doe</td>
                        <td>Oct 20, 2024</td>
                        <td>Delivered</td>
                        <td>$250</td>
                    </tr>
                    <tr>
                        <td>#1002</td>
                        <td>Jane Smith</td>
                        <td>Oct 19, 2024</td>
                        <td>Processing</td>
                        <td>$320</td>
                    </tr>
                    <tr>
                        <td>#1003</td>
                        <td>Michael Brown</td>
                        <td>Oct 18, 2024</td>
                        <td>Shipped</td>
                        <td>$150</td>
                    </tr>
                    <tr>
                        <td>#1004</td>
                        <td>Emily Davis</td>
                        <td>Oct 18, 2024</td>
                        <td>Delivered</td>
                        <td>$400</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Charts Section -->
        <div class="grid-container">
            <div class="card chart-container">
                <h3>Sales Over Time (Line Graph)</h3>
                <canvas id="lineChart"></canvas>
            </div>
            <div class="card chart-container">
                <h3>Product Orders (Pie Chart)</h3>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Line Chart for Sales Over Time
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                datasets: [{
                    label: 'Sales ($)',
                    data: [1000, 2000, 1500, 3000, 2500, 4000, 3500, 4500, 4000, 5000],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart for Product Orders
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Brigade T-Shirts', 'Brigade Hoodies', 'Brigade Caps', 'Brigade Jackets'],
                datasets: [{
                    label: 'Product Orders',
                    data: [120, 80, 200, 50],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>

</body>
</html>
