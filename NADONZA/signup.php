<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to homepage after successful signup
            header("Location: login.php");
            exit();
        } else {
            if(strpos($stmt->error, 'Duplicate entry') !== false){
                echo "<script>alert('Username or Email already exists!');</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Cute Anime Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700&family=Quicksand:wght@400;600&display=swap');
        * { box-sizing: border-box; }
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #fce4ec, #f3e5f5, #e1bee7); 
            margin: 0; 
            padding: 0; 
            color: #333; 
            overflow-x: hidden; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column;
        }
        .header-container { 
            position: fixed; 
            top: 0; 
            width: 100%; 
            background: linear-gradient(90deg, #f48fb1, #ec407a); 
            z-index: 1000; 
            padding: 20px 0; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
            animation: slideDown 0.5s ease-out;
        }
        @keyframes slideDown { from { transform: translateY(-100%); } to { transform: translateY(0); } }
        .header-inner { 
            max-width: 1200px; 
            margin: 0 auto; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 0 20px;
        }
        h1 { 
            margin: 0; 
            font-size: 2.5em; 
            color: white; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3); 
            font-family: 'Baloo 2', cursive;
        }
        .back-btn { 
            background: linear-gradient(45deg, #ff6b9d, #c44569); 
            color: white; 
            border: none; 
            padding: 12px 24px; 
            border-radius: 50px; 
            font-size: 1em; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
            position: relative; 
            overflow: hidden;
        }
        .back-btn::before { 
            content: ''; 
            position: absolute; 
            top: 0; 
            left: -100%; 
            width: 100%; 
            height: 100%; 
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); 
            transition: left 0.5s; 
        }
        .back-btn:hover::before { left: 100%; }
        .back-btn:hover { 
            transform: translateY(-3px) scale(1.05); 
            box-shadow: 0 8px 25px rgba(0,0,0,0.3); 
            background: linear-gradient(45deg, #c44569, #ff6b9d);
        }
        .back-btn:active { 
            transform: translateY(0) scale(0.98); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .signup-container { 
            flex: 1; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 120px 20px 40px 20px;
        }
        .signup-form { 
            background: linear-gradient(145deg, #fff, #f8f9fa); 
            border-radius: 20px; 
            padding: 40px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            max-width: 500px; 
            width: 100%; 
            text-align: center; 
            position: relative; 
            overflow: hidden; 
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(50px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        .signup-form::before { 
            content: ''; 
            position: absolute; 
            top: 0; 
            left: -100%; 
            width: 100%; 
            height: 100%; 
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); 
            transition: left 0.5s; 
        }
        .signup-form:hover::before { left: 100%; }
        .signup-form h2 { 
            font-size: 2em; 
            margin-bottom: 20px; 
            color: #ad1457; 
            font-family: 'Baloo 2', cursive;
        }
        .form-group { 
            margin-bottom: 20px; 
            position: relative;
        }
        .form-group input { 
            width: 100%; 
            padding: 15px 20px; 
            border: 2px solid #f06292; 
            border-radius: 50px; 
            outline: none; 
            font-size: 1em; 
            transition: all 0.3s ease; 
            background: rgba(255,255,255,0.9);
        }
        .form-group input:focus { 
            box-shadow: 0 0 15px rgba(240,98,146,0.6); 
            border-color: #ec407a; 
            background: white; 
            transform: scale(1.02);
        }
        .form-group label { 
            position: absolute; 
            top: 15px; 
            left: 20px; 
            color: #f06292; 
            transition: all 0.3s ease; 
            pointer-events: none; 
            font-weight: 600;
        }
        .form-group input:focus + label, 
        .form-group input:not(:placeholder-shown) + label { 
            top: -10px; 
            left: 15px; 
            font-size: 0.8em; 
            color: #ec407a; 
            background: white; 
            padding: 0 5px;
        }
        .signup-btn-form { 
            background: linear-gradient(45deg, #ff6b9d, #c44569); 
            color: white; 
            border: none; 
            padding: 15px 30px; 
            border-radius: 50px; 
            font-size: 1.2em; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); 
            position: relative; 
            overflow: hidden; 
            width: 100%;
        }
        .signup-btn-form::before { 
            content: ''; 
            position: absolute; 
            top: 0; 
            left: -100%; 
            width: 100%; 
            height: 100%; 
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); 
            transition: left 0.5s; 
        }
        .signup-btn-form:hover::before { left: 100%; }
        .signup-btn-form:hover { 
            transform: translateY(-3px) scale(1.05); 
            box-shadow: 0 8px 25px rgba(0,0,0,0.3); 
            background: linear-gradient(45deg, #c44569, #ff6b9d);
        }
        .signup-btn-form:active { 
            transform: translateY(0) scale(0.98); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .login-link { 
            margin-top: 20px; 
            color: #ec407a; 
            text-decoration: none; 
            font-weight: 600; 
            transition: color 0.3s ease;
        }
        .login-link:hover { 
            color: #ad1457; 
            text-decoration: underline;
        }
        footer { 
            background: #f48fb1; 
            color: white; 
            text-align: center; 
            padding: 20px; 
            margin-top: auto;
        }
        @media (max-width: 768px) { 
            .signup-form { padding: 30px 20px; } 
            h1 { font-size: 2em; } 
            .signup-btn-form { font-size: 1em; }
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="header-inner">
            <h1><i class="fas fa-heart"></i> Cute Anime Hub <i class="fas fa-heart"></i></h1>
            <button class="back-btn" onclick="window.history.back()">Back</button>
        </div>
    </div>

    <div class="signup-container">
        <form class="signup-form" action="signup.php" method="post">
    <h2>Join the Cute Anime Community!</h2>
    <div class="form-group">
        <input type="text" id="username" name="username" required placeholder=" ">
        <label for="username">Username</label>
    </div>
    <div class="form-group">
        <input type="email" id="email" name="email" required placeholder=" ">
        <label for="email">Email</label>
    </div>
    <div class="form-group">
        <input type="password" id="password" name="password" required placeholder=" ">
        <label for="password">Password</label>
    </div>
    <div class="form-group">
        <input type="password" id="confirm-password" name="confirm-password" required placeholder=" ">
        <label for="confirm-password">Confirm Password</label>
    </div>
    <button type="submit" class="signup-btn-form">Sign Up</button>
    <p>Already have an account? <a href="login.php" class="login-link">Log In</a></p>
</form>
    </div>

    <footer>
        <p>&copy; 2023 Cute Anime Hub. Made with <i class="fas fa-heart" style="color: #ec407a;"></i> for anime lovers.</p>
    </footer>

    <script>
        // Add some interactive features
        

        // Add focus animations
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'scale(1)';
            });
        });

        // Simple form validation (client-side)
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            // In a real app, you'd send this to the server
            alert('Signup successful! Welcome to Cute Anime Hub!');
            // Redirect or handle success
        });
    </script>
</body>
</html>