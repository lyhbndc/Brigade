<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <link rel="stylesheet" href="styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <style>
        body {
            font-size: 14px;
            display: flex;
            height: 100vh;
            overflow: hidden;
            background-color: white;
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
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <a><img src="assets/Untitled design.png" class="footer-logo"></a>
    <a href="1index.php">Dashboard</a>
    <a href="6inventory.php">Inventory</a> 
    <a href="#">Report</a>
    <a href="#">Orders</a>
    <a href="#">Customers</a>
    <a href="#">Settings</a>
</div>

<div class="content" id="content">
    <div class="hamburger" id="hamburger">
        <button class="btn btn-light">☰</button>
    </div>
    <h2 class="text-center">Inventory</h2>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" placeholder="Search Items..." class="form-control">
    </div>

    <!-- Inventory Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>S</th>
                <th>M</th>
                <th>L</th>
                <th>XL</th>
                <th>2XL</th>
                <th>3XL</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="inventoryTableBody">
            <tr>
                <td>101</td>
                <td>T-Shirt</td>
                <td>50</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>$15.00</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
            <tr>
                <td>102</td>
                <td>Jeans</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>30</td>
                <td>$40.00</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>


<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const hamburger = document.getElementById('hamburger');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        if (sidebar.classList.contains('active')) {
            sidebar.style.transform = 'translateX(0)';
            sidebar.style.zIndex = '1001'; 
            content.style.marginLeft = '0'; 
        } else {
            sidebar.style.transform = 'translateX(-100%)'; 
            content.style.marginLeft = '0'; 
            sidebar.style.zIndex = ''; 
        }
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#inventoryTableBody tr');

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            let match = false;

            for (let i = 1; i < cells.length; i++) { 
                if (cells[i].textContent.toLowerCase().includes(filter)) {
                    match = true;
                    break;
                }
            }

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
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
