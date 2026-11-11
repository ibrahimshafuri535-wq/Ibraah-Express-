<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express - Reliable Travel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Hero section - All three images preserved */
        .hero-section {
            width: 100%;
            background-color: #fff;
            border-bottom: 8px solid #f1c40f;
            display: flex;
            gap: 5px;
        }

        .hero-section img {
            width: 33.33%;
            height: 300px;
            object-fit: cover;
            display: block;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Marketing section with translated content */
        .marketing-section {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-left: 5px solid #002b5c;
        }

        h2.title {
            text-align: center;
            color: #002b5c;
            text-transform: uppercase;
            font-size: 2.2rem;
            margin-bottom: 40px;
            padding-bottom: 10px;
            border-bottom: 3px solid #f1c40f;
        }

        .mikoa-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .mkoa-card {
            background: #002b5c;
            color: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s ease;
        }

        .mkoa-card:hover {
            transform: translateY(-8px);
            background: #f1c40f;
            color: #002b5c;
        }

        .mkoa-card h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 30px;
            background: #002b5c;
            color: white;
            margin-top: 50px;
        }

        @media (max-width: 768px) {
            .hero-section { flex-direction: column; }
            .hero-section img { width: 100%; height: 200px; }
        }
    </style>
</head>
<body>

 
    <div class="gallery-container">
        <!-- Marketing section in English -->
        <div class="marketing-section">
            <h2 style="color: #002b5c; margin-top: 0;">Welcome to Ibraah Express</h2>
            <p style="font-size: 1.2rem; line-height: 1.8;">
                We promise you an exceptional travel experience defined by <b>comfort, safety, and reliability</b>. 
                Our buses are specifically designed for long-distance travel to ensure you stay relaxed and reach your destination with a smile. 
                Choose Ibraah Express for travel that values your time and comfort!
            </p></div>
             <div class="hero-section">
        <img src="ibu.png" alt="Ibraah Express Bus 1">
        <img src="om.png" alt="Ibraah Express Bus 2">
        <img src="lo.png" alt="Ibraah Express Bus 3">
        <img src="en.jpg" alt="Ibraah Express Bus 4">
    </div>   
   <style>
    /* Ongeza CSS hii kwenye style yako ili picha zikae vizuri */
    .gallery-container {
        margin-bottom: 40px;
    }
    
    .hero-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Picha mbili mbili kila mstari */
        gap: 10px;
        width: 100%;
    }

    .hero-section img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .hero-section img:hover {
        transform: scale(1.02);
    }

    /* Kwenye simu, picha zikae moja moja */
    @media (max-width: 600px) {
        .hero-section {
            grid-template-columns: 1fr;
        }
    }
</style>
        <h2 class="title">📍 Routes We Serve</h2>

        <div class="mikoa-grid">
            <div class="mkoa-card"><h3>DAR ES SALAAM</h3></div>
            <div class="mkoa-card"><h3>PWANI</h3></div>
            <div class="mkoa-card"><h3>MOROGORO</h3></div>
            <div class="mkoa-card"><h3>DODOMA</h3></div>
            <div class="mkoa-card"><h3>SINGIDA</h3></div>
            <div class="mkoa-card"><h3>SHINYANGA</h3></div>
            <div class="mkoa-card"><h3>MWANZA</h3></div>
            <div class="mkoa-card"><h3>MANYARA</h3></div>
            <div class="mkoa-card"><h3>ARUSHA</h3></div>
            <div class="mkoa-card"><h3>MBEYA</h3></div>
            <div class="mkoa-card"><h3>SIMIYU</h3></div>
            <div class="mkoa-card"><h3>KILIMANJARO</h3></div>
        </div>
    </div>

    <div class="footer">
        &copy; 2026 Ibraah Express. Reliable and Safe Travel.
    </div>

</body>
</html>