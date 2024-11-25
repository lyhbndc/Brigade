<?php
session_start();


$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


if (isset($_POST['addEmployee'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "INSERT INTO employee (name, username, password) VALUES ('$name', '$username', '$password')";
    if (mysqli_query($conn, $sql)) {
        header("Location: 6employees.php?success=Employee added");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


$sql = "SELECT id, name, username, password FROM employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
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
        <h2 class="text-center">Employees</h2>
        
        <!-- Search Bar and Add Employee Button -->
        <div class="mb-3 d-flex align-items-center">
            <input type="text" id="searchInput" placeholder="Search Name..." class="form-control me-2">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
        </div>

        <!-- Add Employee Modal -->
        <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEmployeeModalLabel">Add a New Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="addEmployee" class="btn btn-primary">Add Employee</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Table -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No employees found. Add a new employee.</p>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
