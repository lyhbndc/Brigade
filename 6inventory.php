<!DOCTYPE html>
<html lang="en">
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
