<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db_connect.php';

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string(trim($_POST['full_name']));
    $phone_number = $conn->real_escape_string(trim($_POST['phone_number']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($full_name) || empty($phone_number) || empty($password) || empty($confirm_password)) {
        $error_msg = "Please fill in all required fields!";
    } elseif ($password !== $confirm_password) {
        $error_msg = "ERROR: Passwords do not match!";
    } else {
        // Angalia kama namba ya simu ishatumika na mtu mwingine
        $check_phone = $conn->query("SELECT * FROM users WHERE phone_number = '$phone_number'");
        if ($check_phone && $check_phone->num_rows > 0) {
            $error_msg = "ERROR: This phone number is already registered! Please try another one.";
        } else {
            // Ficha Password kwa usalama (Bcrypt)
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Ingiza mteja kwenye database (Imebadilika kuwa phone_number tena)
            $sql = "INSERT INTO users (full_name, phone_number, password) VALUES ('$full_name', '$phone_number', '$hashed_password')";
            
            if ($conn->query($sql)) {
                header("Location: login.php?success=1");
                exit;
            } else {
                $error_msg = "Technical error occurred during registration: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express - Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --blue: #002b5c; --gold: #f1c40f; --red: #e74c3c; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(rgba(0,43,92,0.8), rgba(0,0,0,0.7)), url('om.png'); background-size: cover; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .auth-box { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.3); width: 100%; max-width: 400px; text-align: center; border-top: 5px solid var(--gold); }
        .error-msg { background: #fde8e8; color: var(--red); padding: 12px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; font-size: 13px; border: 1px solid var(--red); text-align: center; }
        .input-group { margin-bottom: 20px; position: relative; text-align: left; }
        input { width: 100%; padding: 14px; border: 2px solid #eee; border-radius: 10px; box-sizing: border-box; font-size: 16px; transition: 0.3s; padding-right: 40px; }
        input:focus { border-color: var(--blue); outline: none; }
        
        /* Imeongezwa kwa ajili ya jicho */
        .toggle-password { position: absolute; right: 15px; top: 16px; cursor: pointer; color: #888; }
        
        .btn-register { width: 100%; padding: 15px; background: #27ae60; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 18px; transition: 0.3s; }
        .btn-register:hover { background: #219150; transform: translateY(-2px); }
        .footer-text { margin-top: 25px; color: #666; font-size: 14px; }
        .footer-text a { color: var(--blue); text-decoration: none; font-weight: bold; }
        .js-error { color: var(--red); font-size: 11px; margin-top: 5px; display: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="auth-box">
    <h2>SIGN UP</h2>
    <p style="color:#666; font-weight:bold; text-transform: uppercase;">IBRAAH EXPRESS</p>
    
    <?php if($error_msg): ?> <div class="error-msg"><?php echo $error_msg; ?></div> <?php endif; ?>

    <form id="registerForm" method="POST" action="registration.php">
        <div class="input-group">
            <input type="text" name="full_name" id="full_name" placeholder="Full Names" value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
            <div id="nameError" class="js-error">Please enter your full name</div>
        </div>

        <div class="input-group">
            <input type="tel" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>" autocomplete="off">
            <div id="phoneError" class="js-error">Please enter your phone number</div>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Create Password">
            <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
            <div id="passError" class="js-error">Please enter a password</div>
        </div>

        <div class="input-group">
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
            <i class="fas fa-eye toggle-password" onclick="togglePassword('confirm_password', this)"></i>
            <div id="confirmError" class="js-error">Passwords do not match!</div>
        </div>

        <button type="submit" class="btn-register" id="regBtn">CREATE ACCOUNT</button>
    </form>
    
    <div class="footer-text">
        Already have an account? <a href="login.php">Sign in here</a>
    </div>
</div>

<script>
    // Kazi ya Jicho
    function togglePassword(id, icon) {
        const input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    // 1. INPUT RESTRICTIONS
    document.getElementById("full_name").onkeypress = function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32) {
            e.preventDefault();
            return false;
        }
    };

    document.getElementById("phone_number").onkeypress = function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            e.preventDefault();
            return false;
        }
    };

    // 2. CLEAR ERROR MESSAGES
    document.getElementById("full_name").oninput = function() {
        document.getElementById("nameError").style.display = "none";
        this.style.borderColor = "#eee";
    };
    document.getElementById("phone_number").oninput = function() {
        document.getElementById("phoneError").style.display = "none";
        this.style.borderColor = "#eee";
    };
    document.getElementById("password").oninput = function() {
        document.getElementById("passError").style.display = "none";
        this.style.borderColor = "#eee";
    };
    document.getElementById("confirm_password").oninput = function() {
        document.getElementById("confirmError").style.display = "none";
        this.style.borderColor = "#eee";
    };

    // 3. FORM VALIDATION
    document.getElementById("registerForm").onsubmit = function(e) {
        let isValid = true;
        const name = document.getElementById("full_name");
        const phone = document.getElementById("phone_number");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm_password");
        const confirmError = document.getElementById("confirmError");

        if (name.value.trim() === "") {
            document.getElementById("nameError").style.display = "block";
            name.style.borderColor = "var(--red)";
            isValid = false;
        }
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
        if (confirmPassword.value.trim() === "") {
            confirmError.innerText = "Please confirm your password";
            confirmError.style.display = "block";
            confirmPassword.style.borderColor = "var(--red)";
            isValid = false;
        } else if (password.value !== confirmPassword.value) {
            confirmError.innerText = "Passwords do not match!";
            confirmError.style.display = "block";
            confirmPassword.style.borderColor = "var(--red)";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        } else {
            document.getElementById("regBtn").innerHTML = "<i class='fas fa-spinner fa-spin'></i> Registering...";
        }
    };
</script>
</body>
</html>