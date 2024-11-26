<<<<<<< HEAD
<?php
session_start();

// Connect to MySQL
$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch inventory data
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['itemName'])) {
        // Insert new item
        $itemName = $_POST['itemName'];
        $small = $_POST['small'];
        $medium = $_POST['medium'];
        $large = $_POST['large'];
        $extraLarge = $_POST['extraLarge'];
        $twoXL = $_POST['twoXL'];
        $threeXL = $_POST['threeXL'];
        $price = $_POST['price'];

        $totalQuantity = $small + $medium + $large + $extraLarge + $twoXL + $threeXL;

        $stmt = $conn->prepare("INSERT INTO inventory (itemName, quantity, small, medium, large, extraLarge, twoXL, threeXL, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("siiiiiiid", $itemName, $totalQuantity, $small, $medium, $large, $extraLarge, $twoXL, $threeXL, $price);
        if ($stmt->execute()) {
            header("Location: 6inventory.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    if (isset($_POST['itemID'])) {
        // Get form data
        $itemID = $_POST['itemID'];
        $small = $_POST['small'];
        $medium = $_POST['medium'];
        $large = $_POST['large'];
        $extraLarge = $_POST['extraLarge'];
        $twoXL = $_POST['twoXL'];
        $threeXL = $_POST['threeXL'];
        $price = $_POST['price'];
    
        // Fetch current values from the database
        $query = "SELECT small, medium, large, extraLarge, twoXL, threeXL, quantity FROM inventory WHERE itemID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $itemID);
        $stmt->execute();
        $result = $stmt->get_result();
        $current = $result->fetch_assoc();
        
        // Calculate the total difference in quantity
        $currentTotal = $current['quantity'];
        $currentSizesSum = $current['small'] + $current['medium'] + $current['large'] + 
                           $current['extraLarge'] + $current['twoXL'] + $current['threeXL'];
        $newSizesSum = $small + $medium + $large + $extraLarge + $twoXL + $threeXL;
        $quantityDifference = $newSizesSum - $currentSizesSum;
    
        // Update the database
        $updateQuery = "UPDATE inventory 
                        SET small = ?, medium = ?, large = ?, extraLarge = ?, twoXL = ?, threeXL = ?, price = ?, quantity = quantity + ? 
                        WHERE itemID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiiiiidii", $small, $medium, $large, $extraLarge, $twoXL, $threeXL, $price, $quantityDifference, $itemID);
        
        if ($stmt->execute()) {
            header("Location: 6inventory.php");
            exit;
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }    

    if (isset($_POST['deleteitemID'])) {
        // Delete item
        $itemIDToDelete = $_POST['deleteitemID'];

        $stmt = $conn->prepare("DELETE FROM inventory WHERE itemID = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("i", $itemIDToDelete);
        if ($stmt->execute()) {
            header("Location: 6inventory.php");
            exit;
        } else {
            echo "Error deleting record: " . $stmt->error;
        }
    }
}

// Close the connection
$conn->close();
?>


=======
>>>>>>> d477ef1db39c3fa56678ca1f3b52385ec01c932b
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <link rel="stylesheet" href="styles/bootstrap4/bootstrap.min.css">
<<<<<<< HEAD
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
=======
    <link rel="stylesheet" href="styles/dashboard.css">
>>>>>>> d477ef1db39c3fa56678ca1f3b52385ec01c932b
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
<<<<<<< HEAD

        /* Set specific widths for columns */
        th:nth-child(1), td:nth-child(1) { /* Item ID column */ width: 10%;
        }
        th:nth-child(2), td:nth-child(2) { /* Item Name column */ width: 21%;
        }
        th:nth-child(3), td:nth-child(3) { /* Quantity column */ width: 10%;
        }
        th:nth-child(4), td:nth-child(4) { /* Small column */ width: 5%;
        }
        th:nth-child(5), td:nth-child(5) { /* Medium column */ width: 5%;
        }
        th:nth-child(6), td:nth-child(6) { /* Large column */ width: 5%;
        }
        th:nth-child(7), td:nth-child(7) { /* Extra Large column */ width: 5%;
        }
        th:nth-child(8), td:nth-child(8) { /* 2XL column */ width: 5%;
        }
        th:nth-child(9), td:nth-child(9) { /* 3XL column */ width: 5%;
        }
        th:nth-child(10), td:nth-child(10) { /* Price column */ width: 8%;
        }
        th:nth-child(11), td:nth-child(11) { /* Actions column */ width: 26%;
        }

        .custom-btn {
            font-size: 12px; /* Adjust text size */
            padding: 5px 10px; /* Adjust padding */
            border-radius: 4px; /* Optional: Round edges */
        }
        </style>
=======
    </style>
>>>>>>> d477ef1db39c3fa56678ca1f3b52385ec01c932b
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
<<<<<<< HEAD
    
    <!-- Search Bar with Custom Button -->
    <div class="mb-3 d-flex align-items-center">
        <input type="text" id="searchInput" placeholder="Search Items..." class="form-control me-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</button>
    </div>

    <!-- Module for Adding New Item -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add a New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm" action="6inventory.php" method="POST">
                        <div class="mb-3">
                            <label for="itemName" class="form-label">Item Name</label>
                            <input type="text" id="itemName" name="itemName" class="form-control" placeholder="Item Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Quantity" readonly required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="number" id="small" name="small" class="form-control" placeholder="Small">
                            </div>
                            <div class="col">
                                <input type="number" id="medium" name="medium" class="form-control" placeholder="Medium">
                            </div>
                            <div class="col">
                                <input type="number" id="large" name="large" class="form-control" placeholder="Large">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <input type="number" id="extraLarge" name="extraLarge" class="form-control" placeholder="Extra Large">
                            </div>
                            <div class="col">
                                <input type="number" id="twoXL" name="twoXL" class="form-control" placeholder="2XL">
                            </div>
                            <div class="col">
                                <input type="number" id="threeXL" name="threeXL" class="form-control" placeholder="3XL">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="Price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead> <!-- Table Headers -->
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
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo str_pad($row['itemID'], 4, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo $row['itemName']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td><?php echo $row['small']; ?></td>
                        <td><?php echo $row['medium']; ?></td>
                        <td><?php echo $row['large']; ?></td>
                        <td><?php echo $row['extraLarge']; ?></td>
                        <td><?php echo $row['twoXL']; ?></td>
                        <td><?php echo $row['threeXL']; ?></td>
                        <td><?php echo '$' . number_format($row['price'], 2); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm custom-btn" data-bs-toggle="modal" data-bs-target="#editStockModal<?php echo $row['itemID']; ?>">Edit</button>
                            <button class="btn btn-danger btn-sm custom-btn" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['itemID']; ?>">Delete</button>
                        </td>
                    </tr>

                    <!-- Edit Stock Modal for this item -->
                    <div class="modal fade" id="editStockModal<?php echo $row['itemID']; ?>" tabindex="-1" aria-labelledby="editStockModalLabel<?php echo $row['itemID']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStockModalLabel<?php echo $row['itemID']; ?>">Edit Stock for <?php echo $row['itemName']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="6inventory.php" method="POST">
                                        <input type="hidden" name="itemID" value="<?php echo $row['itemID']; ?>">
                                        
                                        <!-- Display sizes and price horizontally -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="small" class="form-label">Small</label>
                                                <input type="number" id="small" name="small" class="form-control" value="<?php echo $row['small']; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="medium" class="form-label">Medium</label>
                                                <input type="number" id="medium" name="medium" class="form-control" value="<?php echo $row['medium']; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="large" class="form-label">Large</label>
                                                <input type="number" id="large" name="large" class="form-control" value="<?php echo $row['large']; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="extraLarge" class="form-label">XL</label>
                                                <input type="number" id="extraLarge" name="extraLarge" class="form-control" value="<?php echo $row['extraLarge']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="twoXL" class="form-label">2XL</label>
                                                <input type="number" id="twoXL" name="twoXL" class="form-control" value="<?php echo $row['twoXL']; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="threeXL" class="form-label">3XL</label>
                                                <input type="number" id="threeXL" name="threeXL" class="form-control" value="<?php echo $row['threeXL']; ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="number" step="0.01" id="price" name="price" class="form-control" value="<?php echo $row['price']; ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal for this item -->
                    <div class="modal fade" id="deleteModal<?php echo $row['itemID']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['itemID']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $row['itemID']; ?>">Delete Stock for <?php echo $row['itemName']; ?>?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the stock for <?php echo $row['itemName']; ?>?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="6inventory.php" method="POST">
                                        <input type="hidden" name="deleteitemID" value="<?php echo $row['itemID']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No inventory at this time. Please add an item.</p>
    <?php endif; ?>
=======

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

>>>>>>> d477ef1db39c3fa56678ca1f3b52385ec01c932b

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
<<<<<<< HEAD

    //Add Item Form: Sum of items available based on quantity entered in sizes
    document.querySelectorAll('#addItemForm input[type="number"]').forEach(input => {
        input.addEventListener('input', updateQuantity);
    });

    function updateQuantity() {
        const small = parseInt(document.getElementById('small').value) || 0;
        const medium = parseInt(document.getElementById('medium').value) || 0;
        const large = parseInt(document.getElementById('large').value) || 0;
        const extraLarge = parseInt(document.getElementById('extraLarge').value) || 0;
        const twoXL = parseInt(document.getElementById('twoXL').value) || 0;
        const threeXL = parseInt(document.getElementById('threeXL').value) || 0;

        const totalQuantity = small + medium + large + extraLarge + twoXL + threeXL;
        document.getElementById('quantity').value = totalQuantity;  // Update the quantity field
    }
</script>

=======
</script>
>>>>>>> d477ef1db39c3fa56678ca1f3b52385ec01c932b
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
<<<<<<< HEAD

<!-- Add Bootstrap JS and its dependencies (Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

=======
>>>>>>> d477ef1db39c3fa56678ca1f3b52385ec01c932b
</body>
</html>
