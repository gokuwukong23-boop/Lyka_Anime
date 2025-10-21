<?php
session_start();

// Hardcoded admin credentials
define('ADMIN_USERNAME', 'admin');   // change as you like
define('ADMIN_PASSWORD', 'lykatampo123'); // change as you like

$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check credentials
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        // Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;

        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
input[type="password"] {
    width: 95%;
    padding: 10px;
    margin-bottom: 20px;
    border: 2px solid #c44569;
    border-radius: 5px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input[type="text"]:focus,
input[type="password"]:focus {
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

.error {
    color: red;
    margin-bottom: 20px;
    font-weight: bold;
    transition: opacity 0.3s;
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
    <h2>Admin Login</h2>
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
