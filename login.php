<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db_connect.php'; 

$error_msg = "";
$success_msg = "";

if (isset($_GET['success'])) {
    $success_msg = "Account created successfully! Please log in.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identity = $conn->real_escape_string(trim($_POST['phone']));
    $password = trim($_POST['password']); 

    // --- 1. SPECIAL HARDCODED ADMIN BYPASS ---
    // Kama mtu akiandika admin na 1234, anaingia direct bila kuangalia database
    if ($identity === "admin" && $password === "1234") {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = 'admin';
        
        echo "<script>window.top.location.href = 'admin_dashboard.php';</script>";
        exit;
    }

    // --- 2. DATABASE ADMIN CHECK ---
    $sql_admin = "SELECT * FROM admins WHERE username = '$identity'";
    $result_admin = $conn->query($sql_admin);

    if ($result_admin && $result_admin->num_rows > 0) {
        $admin_data = $result_admin->fetch_assoc();
        
        if ($password === $admin_data['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $identity;
            
            echo "<script>window.top.location.href = 'admin_dashboard.php';</script>";
            exit;
        } else {
            $error_msg = "ERROR: Invalid Admin password!";
        }
    } else {
        // --- 3. DATABASE USERS CHECK ---
        $sql_user = "SELECT * FROM users WHERE phone_number = '$identity'";
        $result_user = $conn->query($sql_user);

        if ($result_user && $result_user->num_rows > 0) {
            $user_data = $result_user->fetch_assoc();
            
            if ($password === $user_data['password'] || password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['user_name'] = $user_data['full_name'];
                
                echo "<script>window.top.location.href = 'index.php';</script>";
                exit;
            } else {
                $error_msg = "ERROR: Invalid password!";
            }
        } else {
            $error_msg = "ERROR: The User or Admin '" . htmlspecialchars($identity) . "' was not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express - Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --blue: #002b5c; --gold: #f1c40f; --red: #e74c3c; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(rgba(0,43,92,0.8), rgba(0,0,0,0.7)), url('om.png'); background-size: cover; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .auth-box { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.3); width: 100%; max-width: 400px; text-align: center; border-top: 5px solid var(--gold); }
        .error-msg { background: #fde8e8; color: var(--red); padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; font-size: 13px; border: 1px solid var(--red); text-align: center; }
        .success-msg { background: #e8fdf0; color: #27ae60; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; font-size: 13px; text-align: center; }
        .input-group { margin-bottom: 20px; position: relative; text-align: left; }
        input { width: 100%; padding: 14px; border: 2px solid #eee; border-radius: 10px; box-sizing: border-box; font-size: 16px; transition: 0.3s; }
        input:focus { border-color: var(--blue); outline: none; }
        .toggle-password { position: absolute; right: 15px; top: 15px; cursor: pointer; color: #aaa; font-size: 18px; z-index: 10; }
        .btn-login { width: 100%; padding: 15px; background: var(--blue); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 18px; transition: 0.3s; }
        .btn-login:hover { background: #001a38; transform: translateY(-2px); }
        .footer-text { margin-top: 25px; color: #666; font-size: 14px; }
        .footer-text a { color: var(--blue); text-decoration: none; font-weight: bold; }
        .js-error { color: var(--red); font-size: 11px; margin-top: 5px; display: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="auth-box">
    <h2>SIGN IN</h2>
    <p style="color:#666; font-weight:bold; text-transform: uppercase;">Ibraah Express System</p>
    
    <?php if(!empty($error_msg)): ?> <div class="error-msg"><?php echo $error_msg; ?></div> <?php endif; ?>
    <?php if(!empty($success_msg)): ?> <div class="success-msg"><?php echo $success_msg; ?></div> <?php endif; ?>

    <form id="loginForm" method="POST" action="login.php">
        <div class="input-group">
            <input type="text" name="phone" id="phone" placeholder="Phone Number / Username" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            <div id="phoneError" class="js-error">Please enter your phone number or username</div>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password">
            <span class="toggle-password" onclick="togglePassword()">
                <i class="fas fa-eye" id="eyeIcon"></i>
            </span>
            <div id="passError" class="js-error">Please enter your password</div>
        </div>

        <button type="submit" class="btn-login" id="loginBtn">LOG IN</button>
    </form>
    
    <div class="footer-text">
        Don't have an account yet? <a href="registration.php">Sign up here</a>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }

    document.getElementById("phone").oninput = function() {
        document.getElementById("phoneError").style.display = "none";
        this.style.borderColor = "#eee";
    };

    document.getElementById("password").oninput = function() {
        document.getElementById("passError").style.display = "none";
        this.style.borderColor = "#eee";
    };

    document.getElementById("loginForm").onsubmit = function(e) {
        let isValid = true;
        const phone = document.getElementById("phone");
        const password = document.getElementById("password");

        if (phone.value.trim() === "") {
            document.getElementById("phoneError").style.display = "block";
            phone.style.borderColor = "var(--red)";
            isValid = false;
        }

        if (password.value.trim() === "") {
            document.getElementById("passError").style.display = "block";
            password.style.borderColor = "var(--red)";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        } else {
            document.getElementById("loginBtn").innerHTML = "<i class='fas fa-spinner fa-spin'></i> Processing...";
        }
    };
</script>
</body>
</html>