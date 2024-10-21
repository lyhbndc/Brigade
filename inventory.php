<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management with Search and Update</title>
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

        h2 {
            text-align: center;
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

        .inventory-table {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        #searchInput {
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .update-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            cursor: pointer;
            border-radius: 4px;
        }

        .update-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#">Dashboard</a>
        <a href="#">Orders</a>
        <a href="#">Products</a>
        <a href="#">Inventory</a>
        <a href="#">Delivery</a>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>Inventory Management</h1>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="inventory-table">
            <h2>Product Inventory</h2>
            
            <!-- Search Input -->
            <input type="text" id="searchInput" onkeyup="searchInventory()" placeholder="Search for product names...">

            <table id="inventoryTable">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Stock Quantity</th>
                        <th>Sizes (S)</th>
                        <th>Sizes (M)</th>
                        <th>Sizes (L)</th>
                        <th>Sizes (XL)</th>
                        <th>Sizes (2XL)</th>
                        <th>Product Type</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Brigade T-Shirt</td>
                        <td><input type="number" value="150"></td>
                        <td><input type="number" value="20"></td>
                        <td><input type="number" value="30"></td>
                        <td><input type="number" value="40"></td>
                        <td><input type="number" value="30"></td>
                        <td><input type="number" value="30"></td>
                        <td>T-Shirt</td>
                        <td><button class="update-btn" onclick="updateProduct(this)">Update</button></td>
                    </tr>
                    <tr>
                        <td>Brigade Hoodie</td>
                        <td><input type="number" value="80"></td>
                        <td><input type="number" value="10"></td>
                        <td><input type="number" value="15"></td>
                        <td><input type="number" value="25"></td>
                        <td><input type="number" value="20"></td>
                        <td><input type="number" value="10"></td>
                        <td>Hoodie</td>
                        <td><button class="update-btn" onclick="updateProduct(this)">Update</button></td>
                    </tr>
                    <tr>
                        <td>Brigade Cap</td>
                        <td><input type="number" value="200"></td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>Cap</td>
                        <td><button class="update-btn" onclick="updateProduct(this)">Update</button></td>
                    </tr>
                    <tr>
                        <td>Brigade Jacket</td>
                        <td><input type="number" value="50"></td>
                        <td><input type="number" value="5"></td>
                        <td><input type="number" value="10"></td>
                        <td><input type="number" value="15"></td>
                        <td><input type="number" value="10"></td>
                        <td><input type="number" value="10"></td>
                        <td>Jacket</td>
                        <td><button class="update-btn" onclick="updateProduct(this)">Update</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Function to search products by name
        function searchInventory() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toUpperCase();
            let table = document.getElementById('inventoryTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td')[0];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

        // Function to simulate updating the product (e.g., save changes)
        function updateProduct(button) {
            let row = button.parentNode.parentNode;
            let productName = row.getElementsByTagName('td')[0].innerText;
            alert(productName + " stock updated!");
        }
    </script>

</body>
</html>
