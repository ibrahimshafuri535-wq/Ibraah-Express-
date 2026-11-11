<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express Dashboard</title>
    <style>
        /* COLORS AND BASICS */
        :root {
            --dark-blue: #001f3f;
            --green: #2ecc71;
            --gold: #f1c40f;
            --white: #ffffff;
            --red: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #eee;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background-color: var(--dark-blue);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.2);
            z-index: 100;
        }

        .sidebar h2 {
            font-size: 20px;
            text-align: center;
            border-bottom: 3px solid var(--green);
            padding-bottom: 10px;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .sidebar nav { flex-grow: 1; }

        .sidebar button {
            background: none;
            border: none;
            color: white;
            padding: 15px;
            text-align: left;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 10px;
            border-radius: 4px;
            transition: 0.3s;
        }

        .sidebar button:hover, .sidebar button.active {
            background-color: var(--green);
            font-weight: bold;
        }

        .logout-btn {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--red) !important;
            border: 1px solid var(--red) !important;
            margin-top: auto;
            text-align: center !important;
            font-weight: bold;
        }

        .logout-btn:hover { background-color: var(--red) !important; color: white !important; }

        /* MAIN CONTAINER */
        .main-container {
            flex-grow: 1;
            position: relative;
            background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('om.png');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 50px;
            color: white;
            text-align: center;
        }

        /* TYPING ANIMATION (Imeongezwa) */
        .brand-title {
            font-size: 65px;
            font-weight: 900;
            color: var(--gold);
            text-shadow: 4px 4px 0px var(--dark-blue), 7px 7px 15px rgba(0,0,0,0.8);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 3px;
            
            /* Typing logic */
            overflow: hidden;
            white-space: nowrap;
            display: inline-block;
            animation: typing 8s steps(30, end) forwards;
        }

        @keyframes typing {
            0% { width: 0; }
            100% { width: 100%; }
        }

        .brand-subtitle {
            font-size: 20px;
            color: var(--white);
            font-style: italic;
            margin-top: -5px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.9);
        }

        /* FEATURES LINE */
        .features-line { display: flex; gap: 20px; margin-bottom: 40px; }
        .feature-item { background: rgba(0, 0, 0, 0.6); padding: 8px 15px; border-radius: 50px; border: 1px solid var(--green); font-size: 13px; font-weight: bold; }

        /* CONTENT CARD */
        .content-card { background: rgba(255, 255, 255, 0.98); color: #333; padding: 30px; border-radius: 20px; width: 90%; max-width: 600px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); display: none; border-top: 5px solid var(--green); }
        .content-card.active { display: block; animation: slideUp 0.4s ease-out; }

        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        .notification { border-left: 5px solid var(--gold); background: #fffdf0; padding: 15px; margin-top: 20px; color: #5f5a2b; text-align: left; border-radius: 8px; }
        h3 { color: var(--dark-blue); margin: 0 0 15px 0; font-size: 24px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2> IBRAAH EXPRESS</h2>
        <nav>
            <button onclick="openTab('home')" class="active">🏠 Home</button>
            <a href="seet.php"><button>🎫 Book Ticket</button></a>
            <a href="mikoa.php"><button>📍 All Regions</button></a>
            <a href="Untitled-1.php"><button>🕒 Bus Schedule</button></a>
            <a href="about.php"><button>🕒 About</button></a>
        </nav>
        
        <a href="login.php" style="text-decoration: none;">
            <button class="logout-btn" onclick="alert('You have logged out successfully!')">🚪 Logout</button>
        </a>
    </div>

    <div class="main-container">
        <div class="brand-header">
            <h1 class="brand-title">WELCOME IBRAAH EXPRESS</h1>
            <div class="brand-subtitle">"Champion's Journey, Royal Service"</div>
        </div>

        <div class="features-line">
            <div class="feature-item">📶 WiFi</div>
            <div class="feature-item">❄️ A/C</div>
            <div class="feature-item">🔌 Charging</div>
            <div class="feature-item">🥤 Drinks</div>
        </div>

        <div id="home" class="content-card active">
            <h3>Welcome Back!</h3>
            <p>This is your main Ibraah Express dashboard. Manage your bookings and view schedules all in one secure place.</p>
            <div class="notification">
                <strong>📢 NOTICE:</strong> All buses depart on time. Please ensure your payments are completed in advance.
            </div>
        </div>
    </div>

    <script>
        function openTab(tabId) {
            document.querySelectorAll('.content-card').forEach(card => card.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelectorAll('.sidebar button').forEach(btn => btn.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }
    </script>

</body>
</html>