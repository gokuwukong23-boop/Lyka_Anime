<?php
include 'db_connect.php';
// 1. Database connection
$host = 'localhost';
$db_name = 'anime';
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

// 2. Check if ID exists
if (!isset($_GET['id'])) {
    header("Location: user_admin.php");
    exit();
}
$id = (int)$_GET['id'];

// 3. Fetch user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

// 4. Handle POST request (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->execute([$username, $email, $id]);

    header("Location: user_aadmin.php?msg=updated");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap');

body {
    font-family: 'Quicksand', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 400px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.container:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

h2 {
    margin-bottom: 20px;
    color: #c44569;
    font-size: 1.8em;
    transition: color 0.3s;
}

h2:hover {
    color: #ff6b9d;
}

label {
    display: block;
    margin-bottom: 5px;
    text-align: left;
    color: #555;
}

input[type="text"],
input[type="email"] {
    width: 95%;
    padding: 10px;
    margin-bottom: 20px;
    border: 2px solid #c44569;
    border-radius: 5px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="text"]:focus,
input[type="email"]:focus {
    border-color: #ff6b9d;
    outline: none;
    box-shadow: 0 0 5px rgba(255, 107, 157, 0.5);
}

button {
    background: #c44569;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s, transform 0.3s;
}

button:hover {
    background: #ff6b9d;
    transform: translateY(-2px);
}

.cancel-link {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #c44569;
    transition: color 0.3s, transform 0.3s;
}

.cancel-link:hover {
    color: #ff6b9d;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 480px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    h2 {
        font-size: 1.5em;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h2>Edit User</h2>
    <form method="POST">
        <label for="username">Name:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        
        <button type="submit">Update</button>
        <a href="user_adamin.php" class="cancel-link">Cancel</a>
    </form>
</div>

</body>
</html>
