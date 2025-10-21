<?php
session_start();
include 'db_connect.php';  // This should define $conn (MySQLi)

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    if (empty($usernameOrEmail) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Prepare statement
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $success = "Login successful! Redirecting...";
            header("refresh:2;url=index.php");
            exit();
        } else {
            $error = "Invalid username/email or password.";
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
    <title>Log In - Cute Anime Hub</title>
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
        .login-container { 
            flex: 1; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 120px 20px 40px 20px;
        }
        .login-form { 
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
        .login-form::before { 
            content: ''; 
            position: absolute; 
            top: 0; 
            left: -100%; 
            width: 100%; 
            height: 100%; 
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); 
            transition: left 0.5s; 
        }
        .login-form:hover::before { left: 100%; }
        .login-form h2 { 
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
        .login-btn-form { 
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
        .login-btn-form::before { 
            content: ''; 
            position: absolute; 
            top: 0; 
            left: -100%; 
            width: 100%; 
            height: 100%; 
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); 
            transition: left 0.5s; 
        }
        .login-btn-form:hover::before { left: 100%; }
        .login-btn-form:hover { 
            transform: translateY(-3px) scale(1.05); 
            box-shadow: 0 8px 25px rgba(0,0,0,0.3); 
            background: linear-gradient(45deg, #c44569, #ff6b9d);
        }
        .login-btn-form:active { 
            transform: translateY(0) scale(0.98); 
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .login-btn-form:disabled { 
            opacity: 0.6; 
            cursor: not-allowed; 
            transform: none;
        }
        .links { 
            margin-top: 20px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }
        .links a { 
            color: #ec407a; 
            text-decoration: none; 
            font-weight: 600; 
            transition: color 0.3s ease;
        }
        .links a:hover { 
            color: #ad1457; 
            text-decoration: underline;
        }
        .error-msg { 
            color: #d32f2f; 
            font-weight: 600; 
            margin-bottom: 10px;
        }
        .success-msg { 
            color: #388e3c; 
            font-weight: 600; 
            margin-bottom: 10px;
        }
        .loading { 
            display: inline-block; 
            width: 20px; 
            height: 20px; 
            border: 3px solid rgba(255,255,255,0.3); 
            border-radius: 50%; 
            border-top-color: #fff; 
            animation: spin 1s ease-in-out infinite; 
            margin-left: 10px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        footer { 
            background: #f48fb1; 
            color: white; 
            text-align: center; 
            padding: 20px; 
            margin-top: auto;
        }
        @media (max-width: 768px) { 
            .login-form { padding: 30px 20px; } 
            h1 { font-size: 2em; } 
            .login-btn-form { font-size: 1em; }
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

    <div class="login-container">
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="loginForm">
            <h2>Welcome Back to Cute Anime Hub!</h2>
            <?php if ($error) echo "<p class='error-msg'>$error</p>"; ?>
            <?php if ($success) echo "<p class='success-msg'>$success</p>"; ?>
            <div class="form-group">
                <input type="text" id="username_or_email" name="username_or_email" required placeholder=" ">
                <label for="username_or_email">Username or Email</label>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Password</label>
            </div>
            <button type="submit" class="login-btn-form" id="loginBtn">
                Log In <span class="loading" id="loadingSpinner" style="display: none;"></span>
            </button>
            <div class="links">
                <a href="forgot-password.php">Forgot Password?</a>
                <a href="signup.php">Sign Up</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2023 Cute Anime Hub. Made with <i class="fas fa-heart" style="color: #ec407a;"></i> for anime lovers.</p>
    </footer>

    <script>
        // Interactive features
        const form = document.querySelector('.login-form');
        const inputs = document.querySelectorAll('.form-group input');
        const loginBtn = document.getElementById('loginBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const loginForm = document.getElementById('loginForm');

        // Animate form on load
        window.addEventListener('load', () => {
            form.style.opacity = '1';
        });

        // Add focus animations
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'scale(1)';
            });
        });

        // Show loading spinner on submit
        loginForm.addEventListener('submit', () => {
            loginBtn.disabled = true;
            loginBtn.innerHTML = 'Logging In... <span class="loading" id="loadingSpinner"></span>';
            loadingSpinner.style.display = 'inline-block';
        });

        // Simple client-side validation (optional, as server-side is primary)
        loginForm.addEventListener('submit', (e) => {
            const usernameOrEmail = document.getElementById('username_or_email').value.trim();
            const password = document.getElementById('password').value.trim();
            if (!usernameOrEmail || !password) {
                e.preventDefault();
                alert('Please fill in all fields.');
            }
        });
    </script>
</body>
</html>
