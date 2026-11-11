<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express - Complete System</title>
    <!-- QR Code Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f4f4; padding: 20px; }
        .box { background: #fff; padding: 30px; border-radius: 15px; max-width: 400px; margin: 20px auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn { width: 100%; padding: 12px; background: #002b5c; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px; }
        #ticket-view { display: none; text-align: center; }
        .hidden { display: none; }
    </style>
</head>
<body>

    <!-- 1. SEHEMU YA MALIPO (Payment Integration) -->
    <div class="box" id="payment-box">
        <h2 style="color: #002b5c;">Checkout</h2>
        <p>Selected Seat: <span id="selected-seat-text">A12</span></p>
        <input type="text" id="phone-number" placeholder="Enter Phone Number" style="width: 90%; padding: 10px;">
        
        <!-- Hapa ndipo tunalink kwenda kwenye tiketi -->
        <button class="btn" onclick="processPayment()">Confirm Payment</button>
    </div>

    <!-- 2. SEHEMU YA TIKETI (Ticket Generation) -->
    <div class="box" id="ticket-view">
        <h2 style="color: #002b5c;">Ibraah Express Ticket</h2>
        <div id="qrcode" style="display: flex; justify-content: center;"></div>
        <p><strong>Seat:</strong> <span id="final-seat"></span></p>
        <p>Your ticket is successfully generated!</p>
        <button class="btn" onclick="window.print()">Print/Save Ticket</button>
    </div>

    <script>
        function processPayment() {
            // Hapa unaweza kuweka logic ya ku-validate malipo (mfano API ya M-Pesa/Tigo Pesa)
            const phone = document.getElementById('phone-number').value;
            
            if(phone === "") {
                alert("Please enter your phone number!");
                return;
            }

            // Kubadilisha view kutoka Malipo kwenda Tiketi
            document.getElementById('payment-box').style.display = 'none';
            document.getElementById('ticket-view').style.display = 'block';

            // Kuchukua namba ya siti
            const seat = document.getElementById('selected-seat-text').innerText;
            document.getElementById('final-seat').innerText = seat;

            // Kutengeneza QR Code kulingana na data ya malipo
            new QRCode(document.getElementById("qrcode"), {
                text: "Ibraah Express | Seat: " + seat + " | Paid by: " + phone,
                width: 150,
                height: 150
            });
        }
    </script>
</body>
</html>