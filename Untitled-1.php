<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Schedules | Ibraah Express</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0F172A;
            --accent: #F59E0B;
            --accent-light: #FEF3C7;
            --bg-main: #F8FAFC;
            --card-bg: #FFFFFF;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --success: #10B981;
            --blue-clean: #3B82F6;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --radius: 16px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: url('om.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            margin: 0;
            padding: 40px 20px;
            color: var(--text-dark);
            min-height: 100vh;
        }

        .dashboard-header {
            max-width: 1200px;
            margin: 0 auto 30px auto;
            text-align: left;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
        }

        .dashboard-header p {
            margin: 5px 0 0 0;
            color: var(--text-muted);
            font-size: 15px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 35px;
        }

        @media (min-width: 950px) {
            .container {
                grid-template-columns: 380px 1fr;
            }
        }

        .modern-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid #E2E8F0;
            padding: 25px;
            box-sizing: border-box;
            height: fit-content;
        }

        .card-title {
            margin: 0 0 20px 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--blue-clean);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 16px;
        }

        label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            color: var(--text-muted);
        }

        input, select {
            padding: 12px 14px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-dark);
            background: #FAFAFA;
            transition: all 0.2s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--blue-clean);
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-search {
            width: 100%;
            padding: 14px;
            background: var(--blue-clean);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .btn-search:hover {
            background: #2563EB;
            transform: translateY(-1px);
        }

        .schedules-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .bus-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid #E2E8F0;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        @media (min-width: 650px) {
            .bus-card {
                grid-template-columns: 260px 1fr;
            }
        }

        .bus-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .bus-image-wrapper {
            position: relative;
            background: transparent; 
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bus-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
        }

        .bus-class-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(4px);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
        }

        .bus-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .bus-main-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 10px;
        }

        .bus-name-plate h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .bus-name-plate .plate {
            display: inline-block;
            font-size: 11px;
            font-weight: 800;
            background: #FEF3C7;
            color: #D97706;
            border: 1px solid #FCD34D;
            padding: 2px 6px;
            border-radius: 4px;
            margin-top: 5px;
        }

        .bus-rating {
            margin-top: 6px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--text-muted);
        }
        
        .bus-rating .stars {
            color: var(--accent);
        }

        .bus-rating .quality-badge {
            background: #E0F2FE;
            color: #0369A1;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .price-box {
            text-align: right;
        }

        .price-box .amount {
            font-size: 20px;
            font-weight: 800;
            color: var(--blue-clean);
            display: block;
        }

        .price-box .label {
            font-size: 11px;
            color: var(--text-muted);
        }

        .route-timeline {
            display: flex;
            align-items: center;
            margin: 15px 0;
            background: #F8FAFC;
            padding: 12px 15px;
            border-radius: 10px;
            gap: 15px;
        }

        .timeline-point {
            display: flex;
            flex-direction: column;
        }

        .timeline-point .time {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
        }

        .timeline-point .station {
            font-size: 12px;
            color: var(--text-muted);
        }

        .timeline-line {
            flex: 1;
            height: 2px;
            background: #CBD5E1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .timeline-line i {
            background: #F8FAFC;
            padding: 0 5px;
            color: var(--blue-clean);
            font-size: 12px;
            z-index: 1;
        }

        .duration-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            background: #F1F5F9;
            padding: 2px 8px;
            border-radius: 20px;
            margin-top: -3px;
            position: absolute;
            top: -15px;
        }

        .bus-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #F1F5F9;
            padding-top: 15px;
            margin-top: 5px;
        }

        .features {
            display: flex;
            gap: 12px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .features span i {
            color: var(--blue-clean);
            margin-right: 4px;
        }

        .btn-view {
            background: #F1F5F9;
            color: var(--primary);
            border: 1px solid #E2E8F0;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view:hover {
            background: #E2E8F0;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="dashboard-header">
        <h1>Available Bus Schedules</h1>
        <p>Check schedules, routes, and estimated travel times from Ibraah Express.</p>
    </div>

    <div class="container">
        <div class="modern-card">
            <div class="card-title">
                <i class="fas fa-search-location"></i>
                <span>Filter Schedules</span>
            </div>
            
            <form action="" method="GET">
                <div class="form-group">
                    <label>From</label>
                    <input type="text" name="from" id="route_from" placeholder="e.g. Arusha" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label>To</label>
                    <input type="text" name="to" id="route_to" placeholder="e.g. Dar es Salaam" required autocomplete="off">
                </div>

                <div class="form-group">
                    <label>Travel Date</label>
                    <input type="date" name="travel_date" required>
                </div>

                <button type="submit" class="btn-search">Search Schedule</button>
            </form>
        </div>

        <div class="schedules-grid">
            <div class="bus-card">
                <div class="bus-image-wrapper">
                    <span class="bus-class-badge" style="background: #1e3a8a;">Luxury Setra</span>
                    <img src="lo.png" alt="Ibraah Express Setra">
                </div>
                
                <div class="bus-details">
                    <div class="bus-main-info">
                        <div class="bus-name-plate">
                            <h3>Ibraah Express Luxury</h3>
                            <span class="plate">T 789 DGA</span>
                            <div class="bus-rating">
                                <span class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
                                <span class="quality-badge">Excellent</span>
                            </div>
                        </div>
                        <div class="price-box">
                            <span class="amount">Tsh 40,000</span>
                            <span class="label">Standard Fare</span>
                        </div>
                    </div>

                    <div class="route-timeline">
                        <div class="timeline-point">
                            <span class="time">06:00 AM</span>
                            <span class="station">Arusha</span>
                        </div>
                        <div class="timeline-line">
                            <span class="duration-label">10 Hours</span>
                            <i class="fas fa-bus"></i>
                        </div>
                        <div class="timeline-point" style="text-align: right;">
                            <span class="time">04:00 PM</span>
                            <span class="station">Dar es Salaam</span>
                        </div>
                    </div>

                    <div class="bus-footer">
                        <div class="features">
                            <span><i class="fas fa-wifi"></i> Free WiFi</span>
                            <span><i class="fas fa-snowflake"></i> AC</span>
                            <span><i class="fas fa-bolt"></i> Charger</span>
                        </div>
                        <button type="button" class="btn-view" onclick="alert('This is just a schedule demonstration.')">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <div class="bus-card">
                <div class="bus-image-wrapper">
                    <span class="bus-class-badge" style="background: #0284c7;">Premium Scania</span>
                    <img src="om.png" alt="Ibraah Express Scania">
                </div>
                
                <div class="bus-details">
                    <div class="bus-main-info">
                        <div class="bus-name-plate">
                            <h3>Ibraah Express Premium</h3>
                            <span class="plate">T 456 DGB</span>
                            <div class="bus-rating">
                                <span class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></span>
                                <span class="quality-badge">New Vehicle</span>
                            </div>
                        </div>
                        <div class="price-box">
                            <span class="amount">Tsh 35,000</span>
                            <span class="label">Standard Fare</span>
                        </div>
                    </div>

                    <div class="route-timeline">
                        <div class="timeline-point">
                            <span class="time">06:30 AM</span>
                            <span class="station">Arusha</span>
                        </div>
                        <div class="timeline-line">
                            <span class="duration-label">10 Hours</span>
                            <i class="fas fa-bus"></i>
                        </div>
                        <div class="timeline-point" style="text-align: right;">
                            <span class="time">04:30 PM</span>
                            <span class="station">Dar es Salaam</span>
                        </div>
                    </div>

                    <div class="bus-footer">
                        <div class="features">
                            <span><i class="fas fa-snowflake"></i> AC</span>
                            <span><i class="fas fa-bolt"></i> Charger</span>
                            <span><i class="fas fa-couch"></i> 2x2 Comfort</span>
                        </div>
                        <button type="button" class="btn-view" onclick="alert('This is just a schedule demonstration.')">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            <div class="bus-card">
                <div class="bus-image-wrapper">
                    <span class="bus-class-badge" style="background: #475569;">Royal Class</span>
                    <img src="ibu.png" alt="Ibraah Express White">
                </div>
                
                <div class="bus-details">
                    <div class="bus-main-info">
                        <div class="bus-name-plate">
                            <h3>Ibraah Express Royal</h3>
                            <span class="plate">T 327 DGC</span>
                            <div class="bus-rating">
                                <span class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></span>
                                <span class="quality-badge">Standard</span>
                            </div>
                        </div>
                        <div class="price-box">
                            <span class="amount">Tsh 30,000</span>
                            <span class="label">Standard Fare</span>
                        </div>
                    </div>

                    <div class="route-timeline">
                        <div class="timeline-point">
                            <span class="time">08:00 AM</span>
                            <span class="station">Arusha</span>
                        </div>
                        <div class="timeline-line">
                            <span class="duration-label">6 Hours</span>
                            <i class="fas fa-bus"></i>
                        </div>
                        <div class="timeline-point" style="text-align: right;">
                            <span class="time">02:00 PM</span>
                            <span class="station">Dodoma</span>
                        </div>
                    </div>

                    <div class="bus-footer">
                        <div class="features">
                            <span><i class="fas fa-snowflake"></i> AC</span>
                            <span><i class="fas fa-tv"></i> Entertainment</span>
                        </div>
                        <button type="button" class="btn-view" onclick="alert('This is just a schedule demonstration.')">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const restrictLetters = function(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32) {
                e.preventDefault();
                return false;
            }
        };
        document.getElementById("route_from").onkeypress = restrictLetters;
        document.getElementById("route_to").onkeypress = restrictLetters;
    </script>
</body>
</html>