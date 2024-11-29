<?php
session_start();

// Role validation to check if ADMIN before allowing view and access on the page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect non-admin users to another page (e.g., dashboard)
    header("Location: 6dashboard.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle adding new employee
if (isset($_POST['addEmployee'])) {
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Create the username by concatenating first and last names (removing spaces and converting to lowercase)
    $username = strtolower(str_replace(' ', '', $firstName)) . '.' . strtolower(str_replace(' ', '', $lastName));
    
    // Create the email based on the username (adding @brigade.com)
    $email = $username . '@brigade.com';

    // Insert the new employee into the database
    $sql = "INSERT INTO employees (first_name, last_name, username, email, password, role) 
            VALUES ('$firstName', '$lastName', '$username', '$email', '$password', '$role')"; 
    
    if (mysqli_query($conn, $sql)) {
        header("Location: 6employees.php?success=Employee added");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handle updating employee information
if (isset($_POST['updateEmployee'])) {
    $employeeId = $_POST['employeeId'];
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $username = strtolower(str_replace(' ', '', $firstName)) . '.' . strtolower(str_replace(' ', '', $lastName));
    $email = $username . '@brigade.com';
    $role = $_POST['role'];

    // Update the employee in the database (exclude password if not updated)
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $updateSql = "UPDATE employees SET first_name='$firstName', last_name='$lastName', username='$username', email='$email', password='$password', role='$role' WHERE id=$employeeId";
    } else {
        $updateSql = "UPDATE employees SET first_name='$firstName', last_name='$lastName', username='$username', email='$email', role='$role' WHERE id=$employeeId";
    }

    if (mysqli_query($conn, $updateSql)) {
        header("Location: 6employees.php?success=Employee updated");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handle deleting employee
if (isset($_POST['deleteEmployee'])) {
    $employeeId = $_POST['employeeId'];
    $deleteSql = "DELETE FROM employees WHERE ID = $employeeId";
    if (mysqli_query($conn, $deleteSql)) {
        header("Location: 6employees.php?success=Employee deleted");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch employee data
$sql = "SELECT id, first_name, last_name, username, email, role FROM employees";
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
                        <form method="POST" action="6employees.php">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" id="firstName" name="firstName" class="form-control" oninput="updateUserEmail()" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" id="lastName" name="lastName" class="form-control" oninput="updateUserEmail()" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div style="position: relative;">
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <i id="togglePassword" class="fa fa-eye toggle-password" style="position: absolute; right: 10px; top: 10px; cursor: pointer;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
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
                        <th style="width: 10%;">Employee ID</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 20%;">Username</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 10%;">Role</th>
                        <th style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editEmployeeModal<?php echo $row['id']; ?>">Edit</button>
                                
                                <!-- Delete Button -->
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="employeeId" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="deleteEmployee" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete <?php echo $row['username']; ?>?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Employee Modal -->
                            <div class="modal fade" id="editEmployeeModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="6employees.php">
                                                <input type="hidden" name="employeeId" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="firstName" class="form-label">First Name</label>
                                                    <input type="text" id="firstName<?php echo $row['id']; ?>" name="firstName" class="form-control" value="<?php echo $row['first_name']; ?>" required oninput="updateUsernameEmail(<?php echo $row['id']; ?>)">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="lastName" class="form-label">Last Name</label>
                                                    <input type="text" id="lastName<?php echo $row['id']; ?>" name="lastName" class="form-control" value="<?php echo $row['last_name']; ?>" required oninput="updateUsernameEmail(<?php echo $row['id']; ?>)">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" id="username<?php echo $row['id']; ?>" name="username" class="form-control" value="<?php echo $row['username']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" id="email<?php echo $row['id']; ?>" name="email" class="form-control" value="<?php echo $row['email']; ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select name="role" class="form-control">
                                                        <option value="admin" <?php echo $row['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                        <option value="user" <?php echo $row['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                                                    </select>
                                                </div>

                                                <!-- Update Password Section -->
                                                <div class="mb-3">
                                                    <button type="button" class="btn btn-primary" id="togglePasswordForm<?php echo $row['id']; ?>" onclick="togglePasswordForm(<?php echo $row['id']; ?>)">Update Password</button>
                                                    <button type="button" class="btn btn-secondary d-none" id="cancelPasswordUpdate<?php echo $row['id']; ?>" onclick="togglePasswordForm(<?php echo $row['id']; ?>)">Cancel Update</button>
                                                </div>
                                                <div id="passwordForm<?php echo $row['id']; ?>" style="display:none;">
                                                    <div class="mb-3">
                                                        <label for="newPassword" class="form-label">Enter New Password</label>
                                                        <input type="password" id="newPassword<?php echo $row['id']; ?>" name="newPassword" class="form-control" oninput="validatePassword(<?php echo $row['id']; ?>)">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="reenterNewPassword" class="form-label">Re-enter New Password</label>
                                                        <input type="password" id="reenterNewPassword<?php echo $row['id']; ?>" name="reenterNewPassword" class="form-control" oninput="validatePassword(<?php echo $row['id']; ?>)">
                                                    </div>
                                                    <div id="passwordConditions<?php echo $row['id']; ?>" class="mb-3">
                                                        <ul>
                                                            <li id="lengthCondition<?php echo $row['id']; ?>" style="color: red;">At least 8 characters long</li>
                                                            <li id="uppercaseCondition<?php echo $row['id']; ?>" style="color: red;">Contains at least 1 uppercase character</li>
                                                            <li id="numberCondition<?php echo $row['id']; ?>" style="color: red;">Contains at least 1 number</li>
                                                            <li id="specialCharCondition<?php echo $row['id']; ?>" style="color: red;">Contains at least 1 special character</li>
                                                            <li id="matchCondition<?php echo $row['id']; ?>" style="color: red;">Passwords match</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <button type="submit" name="updateEmployee" class="btn btn-primary">Save Changes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

    <script> //Real-time display of Username and Email while filling-out the ADD employee form
        function updateUserEmail() {
            // Get first and last names, trim them, and replace spaces with empty strings
            const firstName = document.getElementById('firstName').value.trim().toLowerCase().replace(/\s+/g, '');
            const lastName = document.getElementById('lastName').value.trim().toLowerCase().replace(/\s+/g, '');
            
            const usernameField = document.getElementById('username');
            const emailField = document.getElementById('email');

            // If both first and last names are present, construct the username and email
            if (firstName && lastName) {
                const username = `${firstName}.${lastName}`;
                usernameField.value = username; // Update the username field
                emailField.value = `${username}@brigade.com`; // Update the email field
            } else {
                // Clear username and email if names are incomplete
                usernameField.value = "";
                emailField.value = "";
            }
        }

        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

    <script> //Real-time EDIT Module changes
        // Toggle Password Form
        function togglePasswordForm(id) {
            const passwordForm = document.getElementById(`passwordForm${id}`);
            const toggleButton = document.getElementById(`togglePasswordForm${id}`);
            const cancelButton = document.getElementById(`cancelPasswordUpdate${id}`);

            if (passwordForm.style.display === "none") {
                passwordForm.style.display = "block";
                toggleButton.classList.add("d-none");
                cancelButton.classList.remove("d-none");
            } else {
                passwordForm.style.display = "none";
                toggleButton.classList.remove("d-none");
                cancelButton.classList.add("d-none");
            }
        }

        // Update Username and Email
        function updateUsernameEmail(id) {
            const firstName = document.getElementById(`firstName${id}`).value.toLowerCase().replace(/\s+/g, '');
            const lastName = document.getElementById(`lastName${id}`).value.toLowerCase().replace(/\s+/g, '');
            const username = `${firstName}.${lastName}`;
            const email = `${username}@brigade.com`;

            document.getElementById(`username${id}`).value = username;
            document.getElementById(`email${id}`).value = email;
        }

        // Validate Password
        function validatePassword(id) {
            const newPassword = document.getElementById(`newPassword${id}`).value;
            const reenterPassword = document.getElementById(`reenterNewPassword${id}`).value;
            const lengthCondition = newPassword.length >= 8;
            const uppercaseCondition = /[A-Z]/.test(newPassword);
            const numberCondition = /\d/.test(newPassword);
            const specialCharCondition = /[!@#$%^&*(),.?":{}|<>]/.test(newPassword);
            const matchCondition = newPassword === reenterPassword;

            document.getElementById(`lengthCondition${id}`).style.color = lengthCondition ? "green" : "red";
            document.getElementById(`uppercaseCondition${id}`).style.color = uppercaseCondition ? "green" : "red";
            document.getElementById(`numberCondition${id}`).style.color = numberCondition ? "green" : "red";
            document.getElementById(`specialCharCondition${id}`).style.color = specialCharCondition ? "green" : "red";
            document.getElementById(`matchCondition${id}`).style.color = matchCondition ? "green" : "red";
        }
    </script>
    
</body>
</html>
