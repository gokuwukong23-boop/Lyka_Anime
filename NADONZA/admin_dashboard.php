<?php
include 'db_connect.php';

$host = 'localhost';
$db_name = 'anime';
$db_username = 'root';
$db_password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

try {
    $pdo = new PDO($dsn, $db_username, $db_password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch counts only for existing tables
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// If sessions table doesn't exist, set to 0
$activeSessions = 0;

// If requests table doesn't exist, set to 0
$pendingRequests = 0;

// New signups today (if users table has 'created_at')
try {
    $newSignups = $pdo->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()")->fetchColumn();
} catch (PDOException $e) {
    $newSignups = 0;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap');

* { box-sizing: border-box; margin:0; padding:0; }
body {
    font-family: 'Quicksand', sans-serif;
    background: #f5f6fa;
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: linear-gradient(180deg, #ff6b9d, #c44569);
    color: white;
    height: 100vh;
    position: fixed;
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: width 0.3s;
    z-index: 1000;
}
.sidebar h2 {
    text-align: center;
    font-weight: 700;
    margin-bottom: 30px;
    font-size: 1.5em;
    letter-spacing: 1px;
}
.sidebar a {
    display: flex;
    align-items: center;
    color: white;
    text-decoration: none;
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-weight: 600;
    transition: 0.3s;
}
.sidebar a i {
    margin-right: 15px;
    font-size: 1.2em;
}
.sidebar a:hover {
    background: rgba(255,255,255,0.2);
    transform: translateX(5px);
}

/* Main Content */
.main-content {
    margin-left: 250px;
    flex: 1;
    transition: margin-left 0.3s;
    padding: 20px 30px;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}
.header h1 {
    font-size: 1.6em;
    font-weight: 700;
    color: #333;
}
.header .toggle-btn {
    background: linear-gradient(45deg, #ff6b9d, #c44569);
    border: none;
    padding: 10px 15px;
    border-radius: 50px;
    color: white;
    cursor: pointer;
    font-size: 1.2em;
    transition: transform 0.3s;
}
.header .toggle-btn:hover {
    transform: scale(1.1);
}

/* Cards */
.content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}
.card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    text-align: center;
}
.card h3 {
    margin-bottom: 15px;
    color: #c44569;
    font-weight: 700;
}
.card p {
    font-size: 1.4em;
    color: #333;
    font-weight: 600;
}
.card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

/* Footer */

/* Responsive */
@media (max-width: 768px) {
    .sidebar { width: 200px; }
    .main-content { margin-left: 200px; }
    .header h1 { font-size: 1.3em; }
    .card p { font-size: 1.2em; }
}

/* Sidebar collapsed */
.sidebar.collapsed { width: 60px; }
.sidebar.collapsed a span { display: none; }
.main-content.collapsed { margin-left: 60px; }
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h2>Admin Panel</h2>
    <a href="#"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
    <a href="user_aadmin.php"><i class="fas fa-users"></i><span>Users</span></a>
    <a href="#"><i class="fas fa-cog"></i><span>Settings</span></a>
    <a href="admin_login.php"><i class="fas fa-sign-out-alt"></i><span>Log Out</span></a>
</div>

<div class="main-content" id="mainContent">
    <div class="header">
        <h1>Welcome to Admin Dashboard</h1>
        <button onclick="toggleSidebar()" class="toggle-btn"><i class="fas fa-bars"></i></button>
    </div>

   <div class="content">
    <div class="card">
        <h3>Total Users</h3>
        <p><?php echo $totalUsers; ?></p>
    </div>
    <div class="card">
        <h3>Active Sessions</h3>
        <p><?php echo $activeSessions; ?></p>
    </div>
    <div class="card">  
        <h3>New Signups</h3>
        <p><?php echo $newSignups; ?></p>
    </div>
    <div class="card">
        <h3>Pending Requests</h3>
        <p><?php echo $pendingRequests; ?></p>
    </div>
</div>

</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('collapsed');
}
</script>
</body>
</html>
