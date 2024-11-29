<?php
session_start();

// Connect to MySQL
$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch products data
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'])) { // ADD ITEM MODULE
        // Process the form
        $name = $_POST['name'];
    
        // Use null coalescing to default to 0 if not set, and check if the value is numeric
        $small_stock = isset($_POST['small_stock']) && is_numeric($_POST['small_stock']) ? (int)$_POST['small_stock'] : 0;
        $medium_stock = isset($_POST['medium_stock']) && is_numeric($_POST['medium_stock']) ? (int)$_POST['medium_stock'] : 0;
        $large_stock = isset($_POST['large_stock']) && is_numeric($_POST['large_stock']) ? (int)$_POST['large_stock'] : 0;
        $xl_stock = isset($_POST['xl_stock']) && is_numeric($_POST['xl_stock']) ? (int)$_POST['xl_stock'] : 0;
        $xxl_stock = isset($_POST['xxl_stock']) && is_numeric($_POST['xxl_stock']) ? (int)$_POST['xxl_stock'] : 0;
        $xxxl_stock = isset($_POST['xxxl_stock']) && is_numeric($_POST['xxxl_stock']) ? (int)$_POST['xxxl_stock'] : 0;
        $price = isset($_POST['price']) && is_numeric($_POST['price']) ? (float)$_POST['price'] : 0;
    
        // Calculate total quantity
        $totalQuantity = $small_stock + $medium_stock + $large_stock + $xl_stock + $xxl_stock + $xxxl_stock;
    
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
        $stmt = $conn->prepare("INSERT INTO products (name, quantity, small_stock, medium_stock, large_stock, xl_stock, xxl_stock, xxxl_stock, price, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("siiiiiiids", $name, $totalQuantity, $small_stock, $medium_stock, $large_stock, $xl_stock, $xxl_stock, $xxxl_stock, $price, $image);
        if ($stmt->execute()) {
            header("Location: 6inventory.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }    

    if (isset($_POST['id'])) {//EDIT STOCK MODULE
        // Get form data
        $id = $_POST['id'];
        $small_stock = $_POST['small_stock'];
        $medium_stock = $_POST['medium_stock'];
        $large_stock = $_POST['large_stock'];
        $xl_stock = $_POST['xl_stock'];
        $xxl_stock = $_POST['xxl_stock'];
        $xxxl_stock = $_POST['xxxl_stock'];
        $price = $_POST['price'];
    
        // Fetch current values from the database
        $query = "SELECT small_stock, medium_stock, large_stock, xl_stock, xxl_stock, xxxl_stock, quantity FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $current = $result->fetch_assoc();
        
        // Calculate the total difference in quantity
        $currentTotal = $current['quantity'];
        $currentSizesSum = $current['small_stock'] + $current['medium_stock'] + $current['large_stock'] + 
                           $current['xl_stock'] + $current['xxl_stock'] + $current['xxxl_stock'];
        $newSizesSum = $small_stock + $medium_stock + $large_stock + $xl_stock + $xxl_stock + $xxxl_stock;
        $quantityDifference = $newSizesSum - $currentSizesSum;
    
        // Update the database
        $updateQuery = "UPDATE products 
                        SET small_stock = ?, medium_stock = ?, large_stock = ?, xl_stock = ?, xxl_stock = ?, xxxl_stock = ?, price = ?, quantity = quantity + ? 
                        WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiiiiidii", $small_stock, $medium_stock, $large_stock, $xl_stock, $xxl_stock, $xxxl_stock, $price, $quantityDifference, $id);
        
        if ($stmt->execute()) {
            header("Location: 6inventory.php");
            exit;
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }    

    if (isset($_POST['deleteitemID'])) {//DELETE STOCK MODULE
        // Delete item
        $idToDelete = $_POST['deleteitemID'];
    
        // Step 1: Retrieve the image filename from the database
        $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
    
        $stmt->bind_param("i", $idToDelete);
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
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }
    
            $stmt->bind_param("i", $idToDelete);
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
    <div class="sidebar">
        <a href="6dashboard.php">Dashboard</a>
        <a href="6inventory.php">Stocks</a>
        <a href="6onprocess.php">On Process</a>
        <a href="6completeorders.php">Complete Orders</a>
        <a href="6cancelorders.php">Cancel Orders</a>
        <a href="6refundorders.php">Refund Orders</a>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="6employees.php">Employees</a>
        <?php endif; ?>

        <a href="logout.php" class="logout-button">Logout</a>
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
                                <label for="name" class="form-label">Item Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Item Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Quantity" readonly required>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="number" id="small_stock" name="small_stock" class="form-control" placeholder="Small">
                                </div>
                                <div class="col">
                                    <input type="number" id="medium_stock" name="medium_stock" class="form-control" placeholder="Medium">
                                </div>
                                <div class="col">
                                    <input type="number" id="large_stock" name="large_stock" class="form-control" placeholder="Large">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <input type="number" id="xl_stock" name="xl_stock" class="form-control" placeholder="Extra Large">
                                </div>
                                <div class="col">
                                    <input type="number" id="xxl_stock" name="xxl_stock" class="form-control" placeholder="2XL">
                                </div>
                                <div class="col">
                                    <input type="number" id="xxxl_stock" name="xxxl_stock" class="form-control" placeholder="3XL">
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
                            <td style="width: 8%"><?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td style="width: 10%">
                                <?php if (!empty($row['image'])): ?>
                                    <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    No image
                                <?php endif; ?>
                            </td>
                            <td style="width: 8%"><?php echo $row['name']; ?></td>
                            <td style="width: 8%"><?php echo $row['quantity']; ?></td>
                            <td style="width: 5%"><?php echo $row['small_stock']; ?></td>
                            <td style="width: 5%"><?php echo $row['medium_stock']; ?></td>
                            <td style="width: 5%"><?php echo $row['large_stock']; ?></td>
                            <td style="width: 5%"><?php echo $row['xl_stock']; ?></td>
                            <td style="width: 5%"><?php echo $row['xxl_stock']; ?></td>
                            <td style="width: 5%"><?php echo $row['xxxl_stock']; ?></td>
                            <td style="width: 10%"><?php echo '$' . number_format($row['price'], 2); ?></td>
                            <td style="width: 10%">
                                <button class="btn btn-warning btn-sm custom-btn" data-bs-toggle="modal" data-bs-target="#editStockModal<?php echo $row['id']; ?>">Edit</button>
                                <button class="btn btn-danger btn-sm custom-btn" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">Delete</button>
                            </td>
                        </tr>

                        <!-- Edit Stock Modal for this item -->
                        <div class="modal fade" id="editStockModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editStockModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStockModalLabel<?php echo $row['id']; ?>">Edit Stock for <?php echo $row['name']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="6inventory.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            
                                            <!-- Display sizes and price horizontally -->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="small_stock" class="form-label">Small</label>
                                                    <input type="number" id="small_stock" name="small_stock" class="form-control" value="<?php echo $row['small_stock']; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="medium_stock" class="form-label">Medium</label>
                                                    <input type="number" id="medium_stock" name="medium_stock" class="form-control" value="<?php echo $row['medium_stock']; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="large_stock" class="form-label">Large</label>
                                                    <input type="number" id="large_stock" name="large_stock" class="form-control" value="<?php echo $row['large_stock']; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="xl_stock" class="form-label">XL</label>
                                                    <input type="number" id="xl_stock" name="xl_stock" class="form-control" value="<?php echo $row['xl_stock']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="xxl_stock" class="form-label">2XL</label>
                                                    <input type="number" id="xxl_stock" name="xxl_stock" class="form-control" value="<?php echo $row['xxl_stock']; ?>" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="xxxl_stock" class="form-label">3XL</label>
                                                    <input type="number" id="xxxl_stock" name="xxxl_stock" class="form-control" value="<?php echo $row['xxxl_stock']; ?>" required>
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
                        <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Delete Stock for <?php echo $row['name']; ?>?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete the stock for <?php echo $row['name']; ?>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="6inventory.php" method="POST">
                                            <input type="hidden" name="deleteitemID" value="<?php echo $row['id']; ?>">
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
            const small_stock = parseInt(document.getElementById('small_stock').value) || 0;
            const medium_stock = parseInt(document.getElementById('medium_stock').value) || 0;
            const large_stock = parseInt(document.getElementById('large_stock').value) || 0;
            const xl_stock = parseInt(document.getElementById('xl_stock').value) || 0;
            const xxl_stock = parseInt(document.getElementById('xxl_stock').value) || 0;
            const xxxl_stock = parseInt(document.getElementById('xxxl_stock').value) || 0;

            const totalQuantity = small_stock + medium_stock + large_stock + xl_stock + xxl_stock + xxxl_stock;
            document.getElementById('quantity').value = totalQuantity;  // Update the quantity field
        }
    </script>

    <!-- Add Bootstrap JS and its dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
