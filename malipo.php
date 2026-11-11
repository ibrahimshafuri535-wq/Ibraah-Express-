<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express - Full System</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        :root { --bluu: #002b5c; --kijani: #2ecc71; --dhahabu: #f1c40f; --nyekundu: #e74c3c; --asili: #f4f7f6; }
        
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; 
            background: linear-gradient(rgba(0, 43, 92, 0.7), rgba(0, 43, 92, 0.7)), url('om.png');
            background-size: cover; background-position: center; background-attachment: fixed;
            display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; 
        }
        
        .payment-container, .ticket-box { width: 100%; max-width: 500px; background: white; padding: 35px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); text-align: center; }
        .logo-area h1 { color: var(--bluu); margin: 0; letter-spacing: 2px; font-size: 28px; }
        .input-group { text-align: left; margin-bottom: 20px; }
        input, select { width: 100%; padding: 14px; border: 2px solid #ddd; border-radius: 10px; font-size: 16px; box-sizing: border-box; }
        .info-card { background: var(--bluu); color: white; padding: 20px; border-radius: 15px; margin: 25px 0; text-align: left; }
        .btn-pay-trigger { width: 100%; background: var(--dhahabu); border: none; padding: 16px; border-radius: 10px; font-size: 18px; font-weight: bold; cursor: pointer; }
        
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 1000; justify-content: center; align-items: center; }
        .modal-content { background: white; width: 90%; max-width: 400px; padding: 30px; border-radius: 20px; position: relative; }
        .method-list { display: flex; justify-content: space-between; margin: 25px 0; }
        .method-item { border: 2px solid #eee; padding: 10px; border-radius: 12px; cursor: pointer; width: 30%; }
        .method-item.active { border-color: var(--kijani); background: #f0fff0; }
        .btn-submit { width: 100%; background: var(--kijani); color: white; border: none; padding: 15px; border-radius: 10px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        
        /* Sehemu ya Ticket View Mpya */
        #ticket-view { display: none; background: #fff; border: 2px solid var(--bluu); border-radius: 20px; padding: 40px; position: relative; overflow: hidden; }
        .ticket-header { border-bottom: 2px dashed var(--bluu); margin-bottom: 20px; padding-bottom: 10px; }
        .scan-area { border: 4px solid var(--dhahabu); padding: 10px; display: inline-block; background: #f9f9f9; border-radius: 10px; position: relative; }
        .scan-label { font-size: 12px; color: var(--bluu); font-weight: bold; margin-top: 5px; text-transform: uppercase; }
        .ticket-info p { margin: 8px 0; font-size: 16px; text-align: left; }
        .ticket-num { font-size: 24px; font-weight: bold; color: var(--nyekundu); margin: 20px 0; display: block; }
        .close-x { position: absolute; right: 20px; top: 15px; font-size: 20px; cursor: pointer; color: var(--nyekundu); }
    </style>
</head>
<body>

<div class="payment-container" id="payment-box">
    <div class="logo-area">
        <h1>IBRAAH EXPRESS</h1>
        <p>Champion's Journey, Royal Service</p>
    </div>
e*`huyfyt7ew66wrewgy7tw6ugjgt65r2wuy6wtf3wgt3q//gow732frevc xs2e5672195124/
    <div class="input-group">
        <label>Passenger Full Name</label>
        <input type="text" id="name" placeholder="Enter your name here..." oninput="updateLive()">
    </div>

    <div class="input-group">
        <label>Select Route & Time</label>
        <select id="route" onchange="updatePrice()">
            <option value="35000|Dar - Dodoma (04:00 AM)">Dar - Dodoma (04:00 AM) - Tsh 35,000</option>
            <option value="50000|Dar - Mwanza (06:00 AM)">Dar - Mwanza (06:00 AM) - Tsh 50,000</option>
            <option value="45000|Dar - Arusha (07:15 AM)">Dar - Arusha (07:15 AM) - Tsh 45,000</option>
            <option value="50000|Dar - Mbeya (01:00 PM)">Dar - Mbeya (01:00 PM) - Tsh 50,000</option>
            <option value="80000|mwanza - Tabora (03:00 PM)">mwanza - Tabora (03:00 PM) - Tsh 65,000</option>
<option value="80000|Arusha - Kigoma (04:00 PM)">Arusha - Kigoma (04:00 PM) - Tsh 80,000</option>
<option value="55000|Dodoma - Mwanza (07:00 PM)">Dodoma - mwanza (07:00 PM) - Tsh 55,000</option>
        </select>
    </div>

    <div class="info-card">
        <div style="font-size: 14px; opacity: 0.8;">Passenger:</div>
        <div id="live_name" style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">---</div>
        <div style="font-size: 14px; opacity: 0.8;">Total Amount:</div>
        <div id="live_price" style="font-size: 24px; font-weight: 900; color: var(--dhahabu);">Tsh 35,000/=</div>
    </div>

    <button class="btn-pay-trigger" onclick="openPayment()">PROCEED TO PAYMENT</button>
</div>

<!-- Ticket View iliyoboreshwa -->
<div class="ticket-box" id="ticket-view">
    <div class="ticket-header">
        <h2 style="color: var(--bluu); margin: 0;">IBRAAH EXPRESS</h2>
        <span style="font-size: 14px;">Official Passenger Receipt</span>
    </div>
    
    <div class="scan-area">
        <div id="qrcode"></div>
        <div class="scan-label">Scan to Verify</div>
    </div>

    <div class="ticket-num" id="res-tkt-num"></div>
    
    <div class="ticket-info" style="background: #f4f7f6; padding: 15px; border-radius: 10px;">
        <p><strong>Passenger:</strong> <span id="res-name"></span></p>
        <p><strong>Journey:</strong> <span id="res-route"></span></p>
        <p><strong>Status:</strong> <span style="color:var(--kijani); font-weight:bold;">CONFIRMED</span></p>
    </div>
    
    <button class="btn-submit" style="margin-top: 25px;" onclick="window.print()">PRINT / DOWNLOAD TICKET</button>
</div>

<div class="modal" id="payModal">
    <div class="modal-content">
        <span class="close-x" onclick="closePayment()">×</span>
        <h3>Payment Method</h3>
        <div class="method-list">
            <div class="method-item active" onclick="setMethod(this)">M-Pesa</div>
            <div class="method-item" onclick="setMethod(this)">Tigo</div>
            <div class="method-item" onclick="setMethod(this)">Airtel</div>
        </div>
        <input type="number" id="phone" placeholder="Enter phone number..." style="width:100%; padding:14px; margin-bottom:15px; border-radius:10px; border:1px solid #ddd;">
        <button class="btn-submit" onclick="completePayment()">PAY NOW</button>
    </div>
</div>

<script>
    function updateLive() { document.getElementById('live_name').innerText = document.getElementById('name').value || "---"; }
    
    function updatePrice() {
        const val = document.getElementById('route').value.split('|')[0];
        document.getElementById('live_price').innerText = "Tsh " + parseInt(val).toLocaleString() + "/=";
    }

    function openPayment() {
        if(!document.getElementById('name').value) { alert("Please enter your name first."); return; }
        document.getElementById('payModal').style.display = 'flex';
    }

    function closePayment() { document.getElementById('payModal').style.display = 'none'; }

    function setMethod(el) {
        document.querySelectorAll('.method-item').forEach(m => m.classList.remove('active'));
        el.classList.add('active');
    }

    function completePayment() {
        const phone = document.getElementById('phone').value;
        if(phone.length < 9) { alert("Please enter a valid phone number."); return; }

        const name = document.getElementById('name').value;
        const routeData = document.getElementById('route').value.split('|');
        const tktNum = "IBX-" + Math.floor(10000 + Math.random() * 90000);

        document.getElementById('payment-box').style.display = 'none';
        document.getElementById('payModal').style.display = 'none';
        document.getElementById('ticket-view').style.display = 'block';
        
        document.getElementById('res-name').innerText = name;
        document.getElementById('res-route').innerText = routeData[1];
        document.getElementById('res-tkt-num').innerText = tktNum;

        document.getElementById("qrcode").innerHTML = "";
        new QRCode(document.getElementById("qrcode"), {
            text: "TICKET: " + tktNum + " | PASSENGER: " + name + " | JOURNEY: " + routeData[1],
            width: 160, height: 160
        });
    }
</script>

</body>
</html>