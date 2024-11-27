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
    if (isset($_POST['itemName'])) { //ADD ITEM MODULE
        // Process the form
        $itemName = $_POST['itemName'];

        // Use null coalescing to default to 0 if not set, and check if the value is numeric
        $small = isset($_POST['small']) && is_numeric($_POST['small']) ? (int)$_POST['small'] : 0;
        $medium = isset($_POST['medium']) && is_numeric($_POST['medium']) ? (int)$_POST['medium'] : 0;
        $large = isset($_POST['large']) && is_numeric($_POST['large']) ? (int)$_POST['large'] : 0;
        $extraLarge = isset($_POST['extraLarge']) && is_numeric($_POST['extraLarge']) ? (int)$_POST['extraLarge'] : 0;
        $twoXL = isset($_POST['twoXL']) && is_numeric($_POST['twoXL']) ? (int)$_POST['twoXL'] : 0;
        $threeXL = isset($_POST['threeXL']) && is_numeric($_POST['threeXL']) ? (int)$_POST['threeXL'] : 0;
        $price = isset($_POST['price']) && is_numeric($_POST['price']) ? (float)$_POST['price'] : 0;

        // Calculate total quantity
        $totalQuantity = $small + $medium + $large + $extraLarge + $twoXL + $threeXL;

        // Handle image upload (if any)
        $image = null; // Default if no image is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "uploads/"; // Directory to store images
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }
            $image = basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $image;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                die("Error uploading image.");
            }
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO inventory (itemName, quantity, small, medium, large, extraLarge, twoXL, threeXL, price, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("siiiiiiids", $itemName, $totalQuantity, $small, $medium, $large, $extraLarge, $twoXL, $threeXL, $price, $image);
        if ($stmt->execute()) {
            header("Location: 6inventory.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    if (isset($_POST['itemID'])) {//EDIT STOCK MODULE
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

    if (isset($_POST['deleteitemID'])) {//DELETE STOCK MODULE
        // Delete item
        $itemIDToDelete = $_POST['deleteitemID'];
    
        // Step 1: Retrieve the image filename from the database
        $stmt = $conn->prepare("SELECT image FROM inventory WHERE itemID = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $itemIDToDelete);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image = $row['image'];
    
            // Step 2: Delete the image file from the directory
            if (!empty($image)) {
                $imagePath = "uploads/" . $image; // Adjust path if needed
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file
                }
            }
    
            // Step 3: Delete the database record
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
        } else {
            echo "Item not found.";
        }
    }
    
}

// Close the connection
$conn->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <link rel="stylesheet" href="styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="styles/stocks.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <a href="6employees.php">Employees</a>
</div>

<div class="content" id="content">
    <h2 class="text-center">Inventory</h2>
    
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
                    <form id="addItemForm" action="6inventory.php" method="POST" enctype="multipart/form-data">
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
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
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
                    <th style="width: 8%;">Item ID</th>
                    <th style="width: 10%;">Image</th>
                    <th style="width: 8%;">Item Name</th>
                    <th style="width: 8%;">Quantity</th>
                    <th style="width: 5%;">S</th>
                    <th style="width: 5%;">M</th>
                    <th style="width: 5%;">L</th>
                    <th style="width: 5%;">XL</th>
                    <th style="width: 5%;">2XL</th>
                    <th style="width: 5%;">3XL</th>
                    <th style="width: 10%;">Price</th>
                    <th style="width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody id="inventoryTableBody">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td style="width: 8%"><?php echo str_pad($row['itemID'], 4, '0', STR_PAD_LEFT); ?></td>
                        <td style="width: 10%">
                            <?php if (!empty($row['image'])): ?>
                                <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['itemName']; ?>" style="width: 100px; height: 100px; object-fit: cover;">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td style="width: 8%"><?php echo $row['itemName']; ?></td>
                        <td style="width: 8%"><?php echo $row['quantity']; ?></td>
                        <td style="width: 5%"><?php echo $row['small']; ?></td>
                        <td style="width: 5%"><?php echo $row['medium']; ?></td>
                        <td style="width: 5%"><?php echo $row['large']; ?></td>
                        <td style="width: 5%"><?php echo $row['extraLarge']; ?></td>
                        <td style="width: 5%"><?php echo $row['twoXL']; ?></td>
                        <td style="width: 5%"><?php echo $row['threeXL']; ?></td>
                        <td style="width: 10%"><?php echo '$' . number_format($row['price'], 2); ?></td>
                        <td style="width: 10%">
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

<!-- Add Bootstrap JS and its dependencies (Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
