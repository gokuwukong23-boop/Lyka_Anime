<?php
include 'db_connect.php';
$host = 'localhost';
$db_name = 'anime';   // your database name
$db_username = 'root'; 
$db_password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

try {
    $pdo = new PDO($dsn, $db_username, $db_password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch all users from the database
try {
    $stmt = $pdo->query("SELECT id, username, email FROM users ORDER BY id ASC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching users: " . $e->getMessage());
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Management</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap');

body {
    font-family: 'Quicksand', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    display: flex;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: linear-gradient(135deg, #ff6b9d, #c44569);
    color: white;
    height: 100vh;
    position: fixed;
    padding: 20px;
}
.sidebar h2 { text-align: center; margin-bottom: 30px; }
.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 12px;
    border-radius: 8px;
    margin: 10px 0;
    font-weight: 500;
    transition: 0.3s;
}
.sidebar a:hover { background: rgba(255,255,255,0.2); }

/* Main content */
.main-content {
    margin-left: 250px;
    padding: 30px;
    flex: 1;
    width: 95%;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 15px 25px 15px 50px; /* extra 25px on the left */
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
.header-inner {
    padding-left: 20px;  /* space from the sidebar */
    width: 100%;
}
.header h1 { margin: 0; font-size: 1.7em; color: #333; }

/* Table */
/* Card container for table */
.table-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    max-width: 900px;      /* Keep table contained */
    margin: 0 auto 40px;   /* Center and add spacing below */
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    overflow-x: auto;      /* Scroll horizontally on small screens */
}

/* Table styling */
.user-table {
    width: 100%;
    min-width: 600px;      /* Prevent columns from collapsing */
    border-collapse: collapse;
}

.user-table th, .user-table td {
    padding: 12px 15px;
}

.user-table th {
    background: linear-gradient(135deg, #ff6b9d, #c44569);
    color: #fff;
    font-weight: 600;
    text-align: left;
}

.user-table tr:nth-child(even) {
    background: #f9f9f9;
}

.user-table tr:hover {
    background: #ffe1eb;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .main-content {
        margin-left: 200px;
        padding: 20px;
    }
    .header h1 {
        font-size: 1.4em;
    }
    .table-card {
        padding: 15px;
        margin-bottom: 30px;
    }
}

/* Buttons */
.action-btn {
    background: #c44569;
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    margin-right: 5px;
    font-weight: 500;
}
.action-btn:hover { background: #ff6b9d; }

/* Footer */
.footer {
    text-align: center;
    padding: 20px;
    background: #ff6b9d;
    color: white;
    margin-top: 30px;
    border-radius: 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar { width: 200px; }
    .main-content { margin-left: 200px; padding: 20px; }
    .header h1 { font-size: 1.4em; }
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="user_admin.php"><i class="fas fa-users"></i> Users</a>
    <a href="#"><i class="fas fa-cog"></i> Settings</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>User Management</h1>
    </div>

    <!-- Table card container -->
    <div class="table-card">
        <table class="user-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                <a href="edit_user.php?id=<?= $user['id'] ?>" class="action-btn">Edit</a>
                <a href="delete_user.php?id=<?= $user['id'] ?>" class="action-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<script>
function editUser(userId) {
    alert("Edit user with ID: " + userId);
    // Implement edit functionality (open modal or redirect)
}

function deleteUser(userId) {
    if (confirm("Are you sure you want to delete user with ID: " + userId + "?")) {
        alert("User with ID " + userId + " deleted.");
        // Implement delete functionality (AJAX or redirect)
    }
}
</script>

</body>
</html>
