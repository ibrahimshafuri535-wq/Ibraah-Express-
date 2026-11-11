<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express - Ticketing System</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --bluu: #002b5c;
            --kijani: #2ecc71;
            --dhahabu: #f1c40f;
            --nyekundu: #e74c3c;
            --asili: #f4f7f6;
            --machungwa: #e67e22;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            /* BACKGROUND IMAGE */
            background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('ibu.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .booking-container {
            width: 100%;
            max-width: 1000px;
            /* TRANSPARENT GLASS EFFECT */
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(15px); 
            -webkit-backdrop-filter: blur(15px);
            padding: 30px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .header-section { 
            width: 100%; 
            text-align: center; 
            border-bottom: 1px solid rgba(255,255,255,0.3); 
            padding-bottom: 15px; 
        }
        
        .header-section h1 { 
            color: var(--bluu); 
            margin: 0; 
            text-transform: uppercase; 
            letter-spacing: 2px;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.5);
        }

        .header-section p { color: #000; font-weight: bold; }

        /* FORM SIDE */
        .form-side { flex: 1; min-width: 300px; }
        .input-group { margin-bottom: 15px; }
        label { display: block; font-weight: 900; margin-bottom: 5px; color: var(--bluu); }
        
        input, select { 
            width: 100%; padding: 12px; border: 1px solid rgba(255,255,255,0.5); 
            border-radius: 10px; 
            font-size: 16px; transition: 0.3s; box-sizing: border-box;
            background: rgba(255, 255, 255, 0.8);
        }

        /* BUS SIDE */
        .bus-side { flex: 1; min-width: 350px; display: flex; flex-direction: column; align-items: center; }
        
        .bus-body {
            width: 320px;
            background: rgba(255, 255, 255, 0.9);
            border: 5px solid #333;
            border-radius: 50px 50px 20px 20px;
            padding: 20px;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .front-cabin {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 3px double #ccc;
        }
        .entrance { width: 50px; height: 10px; background: var(--kijani); border-radius: 5px; font-size: 10px; text-align: center; color: white; }
        .steering { 
            width: 45px; height: 45px; background: #333; color: white; 
            border-radius: 50%; display: flex; align-items: center; 
            justify-content: center; font-size: 10px; font-weight: bold;
        }

        .seats-container { display: grid; grid-template-columns: 1fr 1fr 40px 1fr 1fr; gap: 12px; }
        .seat {
            width: 45px; height: 45px; background: #f0f0f0; border: 2px solid #ccc;
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: bold; cursor: pointer; transition: 0.2s;
        }
        .seat:hover { border-color: var(--bluu); background: #eef; }
        .seat.selected { background: var(--kijani); color: white; border-color: #1e8449; }
        .seat.taken { background: #9f0505; color: #white; cursor: not-allowed; opacity: 0.8; }
        .aisle { grid-column: 3; }

        .summary-box {
            width: 100%; background: var(--bluu); color: white;
            padding: 20px; border-radius: 15px; margin-top: 20px; text-align: center;
        }

        .payment-action-box {
            background: rgba(255, 255, 255, 0.7);
            border: 2px dashed var(--bluu);
            padding: 15px;
            border-radius: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .btn-pay {
            width: 100%; 
            background: linear-gradient(135deg, var(--dhahabu), var(--machungwa));
            border: none; 
            padding: 18px;
            border-radius: 12px; 
            font-size: 18px; 
            font-weight: 900; 
            color: white;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-pay:hover { 
            transform: scale(1.02);
            filter: brightness(1.1);
        }

        h3 { color: var(--bluu); text-shadow: 1px 1px 1px white; }

    </style>
</head>
<body>

<div class="booking-container">
    <div class="header-section">
        <h1>IBRAAH EXPRESS</h1>
        <p>Reliable and Safe Transportation</p>
    </div>

    <!-- REGISTRATION FORM -->
    <div class="form-side">
        <h3>1. Passenger Information</h3>
        <div class="input-group">
            <label>Passenger Name</label>
            <input type="text" id="nameInput" placeholder="Example: John Doe">
        </div>
        <div class="input-group">
            <label>Phone Number</label>
            <input type="tel" id="phoneInput" placeholder="07XXXXXXXX">
        </div>
        <div class="input-group">
            <label>Departure City</label>
            <select>
                <option>Dar es Salaam (Magufuli)</option>
                <option>Mwanza</option>
                <option>Arusha</option>
                <option>Dodoma</option>
            </select>
        </div>
        <div class="input-group">
            <label>Destination City</label>
            <select>
                <option>Mbeya</option>
                <option>Tabora</option>
                <option>Kigoma</option>
                <option>Mwanza</option>
            </select>
        </div>

        <div class="summary-box">
            <div style="font-size: 14px; opacity: 0.8;">Ticket for:</div>
            <div id="disp_name" style="font-size: 20px; font-weight: bold;">---</div>
            <div style="margin-top: 10px;">Seat Number: <span id="disp_seat" style="color: var(--dhahabu); font-weight: 900; ETRE8WWFW8T7326O36U437T74WTYWEJEW6GW6TWYO3YU3763Y75Y98ET3666OYfont-size: 22px;">None</span></div>
        </div>

        <div class="payment-action-box">
            <button type="button" class="btn-pay" onclick="finishBooking()">
                3Y3OUTW8UYT2LD7VTE PROCEED TO PAYMENT <i class="fas fa-chevron-right"></i>Y34Y
</BUTL;SAKDKJLPEWOWNCFDMJ;WEA';KFJODUFRMENOG;NJEFIAOJJGFREGKDPQFU8WTGEGFEHOIR873Y>
        </div>
    </div>

    <!-- BUS MAP -->
    <div class="bus-side">
        <h3>2. Select Your Seat</h3>
        <div class="bus-body">TW8TW7TW6T23Q75267546536Y89736T3Y
            4TW7T563Q2653QAY54YUTEW6T436T   526U3Y6YYU54U54U[]
            <div class="front-cabin">
                <div class="entrance" title="Front Door">DOOR</div>
                <div class="Y54YI789U BN1B H45HY5YNT /J">DRIVER</div>
            </div>

            <div class="seats-container" id="busSeats">
                <!-- Generated by Script -->
            </div>

            <div class="back-section" style="display: flex; justify-content: space-between; margin-top: 15px; border-top: 2px dashed #ccc; padding-top: 10px;">
                <div style="width: 100px; height: 60px; background: #95a5a6; color: white; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-weight: bold; font-size: 12px;">TOILET 🚽</div>
                <div style="font-size: 10px; color: #999; align-self: flex-end;">Back Window</div>
            </div>
        </div>
        
        <div style="display: flex; gap: 15px; margin-top: 15px; font-size: 12px; font-weight: bold; color: white;">
            <div style="display: flex; align-items: center; gap: 5px;"><div style="width: 15px; height: 15px; background: var(--kijani); border-radius: 3px;"></div> Selected</div>
            <div style="display: flex; align-items: center; gap: 5px;"><div style="width: 15px; height: 15px; background: #9f0505; border-radius: 3px;"></div> Booked</div>
        </div>
    </div>
</div>

<script>
    const seatContainer = document.getElementById('busSeats');
    const rows = ['A', 'B', 'C', 'D', 'E', 'F'];
    let selectedSeatId = null;

    rows.forEach(row => {
        for (let i = 1; i <= 4; i++) {
            const seat = document.createElement('div');
            seat.className = 'seat';
            const id = row + i;
            seat.innerText = id;

            // Example booked seats
            if (id === 'A3' || id === 'B1' || id === 'D4') {
                seat.classList.add('taken');
            }

            seat.onclick = () => {
                if (seat.classList.contains('taken')) return;
                const allSeats = document.querySelectorAll('.seat');
                allSeats.forEach(s => s.classList.remove('selected'));

                seat.classList.add('selected');
                selectedSeatId = id;
                document.getElementById('disp_seat').innerText = id;
            };

            seatContainer.appendChild(seat);

            if (i === 2) {
                const aisle = document.createElement('div');
                aisle.className = 'aisle';
                seatContainer.appendChild(aisle);
            }
        }
    });

    document.getElementById('nameInput').addEventListener('input', function() {
        document.getElementById('disp_name').innerText = this.value || "---";
    });

    function finishBooking() {
        const name = document.getElementById('nameInput').value;
        if (!name || !selectedSeatId) {
            alert("Please provide your name and select a seat first!");
        } else {
            alert("Success! " + name + ", you are being redirected to the payment page for seat " + selectedSeatId);
            window.location.href = "malipo.php"; 
        }
    }
</script>

</body>
</html>