<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express - Full Background</title>
    <style>
        /* 1. MPANGILIO WA BACKGROUND YA UKURASA MZIMA */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            /* Hapa ndipo picha inapowekwa kama background */
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('ibu.png') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* 2. KICHWA CHA HABARI (LOGO/TITLE) */
        .header-brand {
            text-align: center;
            padding: 50px 0;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
        }

        .header-brand h1 {
            font-size: 3.5rem;
            margin: 0;
            color: #f1c40f;
            text-transform: uppercase;
        }

        .section-title {
            text-align: center;
            color: #f1c40f;
            text-transform: uppercase;
            margin-bottom: 30px;
            font-size: 2rem;
            text-shadow: 2px 2px 5px #000;
        }

        /* 3. MIKOA (GLASS EFFECT CARDS) */
        .mikoa-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 50px;
        }

        .mkoa-card {
            background: rgba(0, 43, 92, 0.7); /* Bluu ya Ibraah na uwazi kidogo */
            backdrop-filter: blur(5px); /* Inafanya background iwe na ukungu kidogo */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            transition: 0.3s;
        }

        .mkoa-card:hover {
            background: #f1c40f;
            color: #002b5c;
            transform: translateY(-5px);
        }

        /* 4. RATIBA NA PICHA NDOGO PEMBENI */
        .schedule-container {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }

        th {
            background: rgba(241, 196, 15, 0.8);
            color: #002b5c;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .muda-tag {
            background: #f1c40f;
            color: #002b5c;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .side-img-box img {
            width: 100%;
            border-radius: 10px;
            border: 3px solid #f1c40f;
        }

        /* 5. FOOTER */
        .footer {
            text-align: center;
            padding: 50px;
            margin-top: 50px;
            background: rgba(0,0,0,0.8);
        }

        @media (max-width: 850px) {
            .schedule-container { grid-template-columns: 1fr; }
            .header-brand h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Brand Header -->
        <div class="header-brand">
            <h1>Ibraah Express</h1>
            <p>Safari za Uhakika na Usalama • 2026</p>
        </div>

        <!-- Mikoa Section -->
        <h2 class="section-title">📍 Mikoa Tunayopita</h2>
        <div class="mikoa-grid">
            <div class="mkoa-card">DAR ES SALAAM</div>
            <div class="mkoa-card">PWANI</div>
            <div class="mkoa-card">MOROGORO</div>
            <div class="mkoa-card">DODOMA</div>
            <div class="mkoa-card">SINGIDA</div>
            <div class="mkoa-card">SHINYANGA</div>
            <div class="mkoa-card">MWANZA</div>
            <div class="mkoa-card">ARUSHA</div>
        </div>

        <!-- Schedule Section -->
        <h2 class="section-title">⏰ Ratiba ya Leo</h2>
        <div class="schedule-container">
            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th>Njia</th>
                            <th>Muda</th>
                            <th>Kituo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dar - Mwanza</td>
                            <td><span class="muda-tag">06:00 AM</span></td>
                            <td>Magufuli Terminal</td>
                        </tr>
                        <tr>
                            <td>Dar - Arusha</td>
                            <td><span class="muda-tag">06:30 AM</span></td>
                            <td>Magufuli Terminal</td>
                        </tr>
                        <tr>
                            <td>Dodoma - Mwanza</td>
                            <td><span class="muda-tag">07:00 AM</span></td>
                            <td>Nane Nane</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="side-img-box">
                <img src="ibu.png" alt="Mini Bus View">
                <p style="text-align: center; color: #f1c40f; font-weight: bold; margin-top: 10px;">Chaguo la Uhakika!</p>
            </div>
        </div>
    </div>
<h2tg38978670369t4387yu==-3r7546mvgf>hfgfhfafgtfagfFGFGF\0389t64mytt21'=uiw, nbuyh43t2iye b hgwhrhg[8y6r][[rrrjhwptffyfrflfy552=rfu87u6mrkgrfyffffui827t82tp3437t36t36tyo349t7
    <div class="footer">
        &copy; 2026 Ibraah Express. Haki zote zimehifadhiwa.
    </div>

</body>
</html>