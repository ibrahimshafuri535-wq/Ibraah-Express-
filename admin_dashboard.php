<?php
// 0. ZUIA ERROR ZA XAMPP USIZIONE KWENYE BROWSER
error_reporting(0);
ini_set('display_errors', 0);

// Anzisha session
session_start(); 

// --- 1. USALAMA (Security) ---
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Unganisha na Database yako sahihi ya (ibraah epress) kupitia db_connect.php
require_once 'db_connect.php';

// --- 2. LOGIC YA MFUMO (Backend Processing) ---

// A: Badilisha hali ya booking (Imeboreshwa kuzuia SQL Injection)
if (isset($_POST['update_status'])) {
    $b_id = (int)$_POST['b_id'];
    $new_status = $conn->real_escape_string($_POST['status']);
    
    // Tumesafisha query ili isilete tatizo
    $conn->query("UPDATE bookings SET status = '$new_status' WHERE booking_id = $b_id");
    header("Location: admin_dashboard.php?msg=updated");
    exit;
}

// B: Update taarifa za mteja (Imeboreshwa kuzuia SQL Injection)
if (isset($_POST['update_customer'])) {
    $u_id = (int)$_POST['u_id'];
    $u_name = $conn->real_escape_string($_POST['full_name']);
    $u_phone = $conn->real_escape_string($_POST['phone_number']);
    
    $conn->query("UPDATE users SET full_name = '$u_name', phone_number = '$u_phone' WHERE user_id = $u_id");
    header("Location: admin_dashboard.php?msg=customer_updated");
    exit;
}

// C: Futa data (Imeboreshwa kwa usalama zaidi)
if (isset($_GET['delete_id']) && isset($_GET['type'])) {
    $id = (int)$_GET['delete_id'];
    $type = $_GET['type'];
    
    if ($type == 'booking') $conn->query("DELETE FROM bookings WHERE booking_id = $id");
    if ($type == 'payment') $conn->query("DELETE FROM payments WHERE payment_id = $id");
    if ($type == 'user') $conn->query("DELETE FROM users WHERE user_id = $id");
    
    header("Location: admin_dashboard.php?msg=deleted");
    exit;
}

// --- 3. TAKWIMU (Dashboard Stats) ---
// Imeboreshwa: Kama hakuna malipo, ionyeshe 0 badala ya kubaki tupu
$revenue_query = $conn->query("SELECT SUM(amount) as total FROM payments WHERE payment_status = 'Success' OR payment_status = 'Confirmed'");
$revenue_row = $revenue_query->fetch_assoc();
$total_revenue = $revenue_row['total'] ?? 0;

$total_bookings = $conn->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'] ?? 0;
$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibraah Express | Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar: #001e3c; --accent: #f1c40f; --bg: #f4f7f6; --white: #ffffff; --danger: #e74c3c; --success: #2ecc71; --blue: #3498db; }
        
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; display: flex; background: var(--bg); }
        .sidebar { width: 260px; height: 100vh; background: var(--sidebar); color: white; position: fixed; }
        .sidebar-brand { padding: 30px 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .nav-links { list-style: none; padding: 20px 0; margin: 0; }
        .nav-item { padding: 15px 25px; cursor: pointer; transition: 0.3s; color: #bdc3c7; display: flex; align-items: center; gap: 12px; }
        .nav-item:hover, .nav-item.active { background: rgba(255,255,255,0.1); color: var(--accent); border-right: 4px solid var(--accent); }
        
        .main-content { margin-left: 260px; flex: 1; padding: 30px; min-height: 100vh; }
        .tab-content { display: none; animation: fadeIn 0.4s; }
        .tab-content.active { display: block; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--white); padding: 20px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .stat-card h3 { margin: 0 0 10px 0; color: #7f8c8d; font-size: 16px; }
        .stat-card p { margin: 0; font-size: 24px; font-weight: bold; color: var(--sidebar); }
        
        .table-container { background: var(--white); border-radius: 12px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); overflow-x: auto; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { text-align: left; padding: 15px; background: #f8f9fa; border-bottom: 2px solid #eee; color: #34495e; }
        td { padding: 15px; border-bottom: 1px solid #eee; color: #2c3e50; }
        
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 11px; color: white; font-weight: bold; }
        .status-confirmed { background: var(--success); }
        .status-pending { background: var(--accent); color: #000; }
        
        select { padding: 6px; border-radius: 4px; border: 1px solid #ccc; font-family: inherit; }
        .btn { padding: 8px 12px; border-radius: 6px; border: none; cursor: pointer; color: white; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; font-size: 13px; transition: 0.2s; }
        .btn:hover { opacity: 0.9; }
        .btn-print { background: #34495e; } 
        .btn-excel { background: #27ae60; }
        .btn-delete { background: var(--danger); } 
        .btn-edit { background: var(--blue); } 
        .btn-save { background: var(--success); }
        
        /* MUONEKANO WA PRINT - UMEBORESHWA KWA WINO MKALI */
        #printArea, #customerReportArea, #paymentReceiptArea, #individualCustomerArea { display: none; }
        
        @media print { 
            body * { visibility: hidden; } 
            #printArea, #printArea *, #customerReportArea, #customerReportArea *, #paymentReceiptArea, #paymentReceiptArea *, #individualCustomerArea, #individualCustomerArea * { 
                visibility: visible; 
            } 
            #printArea, #customerReportArea, #paymentReceiptArea, #individualCustomerArea { 
                display: block; 
                position: absolute; 
                top: 0; 
                left: 0; 
                width: 100%; 
                color: #000 !important; 
                background: #fff !important;
            }
            h2, h3, b, strong, p, span, td, th { 
                color: #000 !important; 
                font-weight: 600 !important; 
            }
            table { 
                width: 100%; 
                border: 1px solid #000 !important; 
                border-collapse: collapse; 
            }
            th, td { 
                border: 1px solid #000 !important; 
                padding: 12px; 
                text-align: left; 
                font-size: 14px; 
            }
            hr { border: 1px solid #000 !important; }
            .no-print { display: none !important; }
        }
        
        .edit-form-inline { display: none; gap: 5px; margin-top: 5px; flex-wrap: wrap; }
        .edit-form-inline input { padding: 5px; border: 1px solid #ccc; border-radius: 4px; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">
            <h2 style="color: var(--accent); margin: 0;">IBRAAH EXPRESS</h2>
            <small style="color: #888;">Admin Dashboard</small>
        </div>
        <ul class="nav-links">
            <li class="nav-item active" onclick="showTab('dashboard', event)"><i class="fas fa-home"></i> Dashboard</li>
            <li class="nav-item" onclick="showTab('bookings', event)"><i class="fas fa-ticket-alt"></i> Bookings</li>
            <li class="nav-item" onclick="showTab('payments', event)"><i class="fas fa-money-check-alt"></i> Payments</li>
            <li class="nav-item" onclick="showTab('customers', event)"><i class="fas fa-users"></i> Customers</li>
            <li class="nav-item" style="margin-top: 50px;"><a href="login.php" style="color: #e74c3c; text-decoration:none;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div id="dashboard" class="tab-content active">
            <h1>System Overview</h1>
            <div class="stats-grid">
                <div class="stat-card"><h3>Total Revenue</h3><p>Tsh <?php echo number_format($total_revenue); ?>/=</p></div>
                <div class="stat-card"><h3>Total Bookings</h3><p><?php echo $total_bookings; ?></p></div>
                <div class="stat-card"><h3>Registered Users</h3><p><?php echo $total_users; ?></p></div>
            </div>
            
            <div class="table-container">
                <h3>Recent Payments</h3>
                <table>
                    <thead>
                        <tr><th>Customer</th><th>Amount</th><th>Method</th><th>Transaction ID</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Imeboreshwa kusoma jina sahihi toka kwenye bookings la sivyo inaandika Guest
                        $p_res = $conn->query("SELECT p.*, b.passenger_name FROM payments p LEFT JOIN bookings b ON p.booking_id = b.booking_id ORDER BY p.payment_id DESC LIMIT 5");
                        while($p = $p_res->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['passenger_name'] ?? 'Guest User'); ?></td>
                            <td>Tsh <?php echo number_format($p['amount']); ?></td>
                            <td><?php echo htmlspecialchars($p['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($p['transaction_number'] ?? $p['transaction_id'] ?? 'N/A'); ?></td>
                            <td><span class="badge status-confirmed"><?php echo htmlspecialchars($p['payment_status']); ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="bookings" class="tab-content">
            <h1>Manage Bookings</h1>
            <div class="table-container">
                <table id="bookingsTable">
                    <thead>
                        <tr><th>Passenger</th><th>Route</th><th>Date</th><th>Seat</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $b_res = $conn->query("SELECT * FROM bookings ORDER BY booking_id DESC");
                        while($row = $b_res->fetch_assoc()): 
                            $t_date = ($row['travel_date']) ? date('d M, Y', strtotime($row['travel_date'])) : 'N/A';
                        ?>
                        <tr>
                            <td><b><?php echo htmlspecialchars($row['passenger_name']); ?></b></td>
                            <td><?php echo htmlspecialchars($row['departure']); ?> - <?php echo htmlspecialchars($row['destination']); ?></td>
                            <td><?php echo $t_date; ?></td>
                            <td><?php echo htmlspecialchars($row['seat_number']); ?></td>
                            <td><span class="badge <?php echo ($row['status'] == 'Confirmed') ? 'status-confirmed' : 'status-pending'; ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                            <td>
                                <form method="POST" style="display:inline-flex; gap:2px;">
                                    <input type="hidden" name="b_id" value="<?php echo $row['booking_id']; ?>">
                                    <select name="status">
                                        <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="Confirmed" <?php if($row['status']=='Confirmed') echo 'selected'; ?>>Confirm</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-save"><i class="fas fa-check"></i></button>
                                </form>
                                <button class="btn btn-print" onclick="printTicket('<?php echo $row['booking_id']; ?>', '<?php echo addslashes($row['passenger_name']); ?>', '<?php echo addslashes($row['departure']); ?>', '<?php echo addslashes($row['destination']); ?>', '<?php echo $row['seat_number']; ?>', '<?php echo $row['status']; ?>', '<?php echo $t_date; ?>')"><i class="fas fa-print"></i></button>
                                <a href="admin_dashboard.php?delete_id=<?php echo $row['booking_id']; ?>&type=booking" class="btn btn-delete" onclick="return confirm('Futa Booking hii?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="payments" class="tab-content">
            <h1>All Payments</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr><th>ID</th><th>Customer</th><th>Amount</th><th>Method</th><th>Transaction No</th><th>Date</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $all_p = $conn->query("SELECT p.*, b.passenger_name FROM payments p LEFT JOIN bookings b ON p.booking_id = b.booking_id ORDER BY p.payment_id DESC");
                        while($pay = $all_p->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $pay['payment_id']; ?></td>
                            <td><?php echo htmlspecialchars($pay['passenger_name'] ?? 'Guest'); ?></td>
                            <td>Tsh <?php echo number_format($pay['amount']); ?></td>
                            <td><?php echo htmlspecialchars($pay['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($pay['transaction_number']); ?></td>
                            <td><?php echo ($pay['payment_date']) ? date('d/m/Y', strtotime($pay['payment_date'])) : 'N/A'; ?></td>
                            <td>
                                <button class="btn btn-print" onclick="printReceipt('<?php echo $pay['payment_id']; ?>', '<?php echo addslashes($pay['passenger_name'] ?? 'Guest'); ?>', '<?php echo number_format($pay['amount']); ?>', '<?php echo addslashes($pay['payment_method']); ?>', '<?php echo addslashes($pay['transaction_number']); ?>', '<?php echo $pay['payment_date']; ?>')"><i class="fas fa-print"></i></button>
                                <a href="admin_dashboard.php?delete_id=<?php echo $pay['payment_id']; ?>&type=payment" class="btn btn-delete" onclick="return confirm('Futa malipo haya?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="customers" class="tab-content">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; gap:10px;">
                <h1>Registered Customers</h1>
                <div>
                    <button class="btn btn-excel" onclick="exportToExcel('customerTable', 'Wateja_Ibraah_Express_Full')"><i class="fas fa-file-excel"></i> Export All Excel</button>
                    <button class="btn btn-print" onclick="printCustomerReport()"><i class="fas fa-print"></i> Print List</button>
                </div>
            </div>
            <div class="table-container">
                <table id="customerTable">
                    <thead>
                        <tr><th>Name</th><th>Phone</th><th>Joined Date</th><th class="no-print">Action</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $u_res = $conn->query("SELECT * FROM users ORDER BY user_id DESC");
                        while($u = $u_res->fetch_assoc()): 
                            $join_date = ($u['created_at']) ? date('d M, Y', strtotime($u['created_at'])) : date('d M, Y');
                        ?>
                        <tr id="row_user_<?php echo $u['user_id']; ?>">
                            <td>
                                <span id="name_span_<?php echo $u['user_id']; ?>"><?php echo htmlspecialchars($u['full_name']); ?></span>
                                <form id="edit_form_<?php echo $u['user_id']; ?>" class="edit-form-inline" method="POST">
                                    <input type="hidden" name="u_id" value="<?php echo $u['user_id']; ?>">
                                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($u['full_name']); ?>" required>
                                    <input type="text" name="phone_number" value="<?php echo htmlspecialchars($u['phone_number']); ?>" required>
                                    <button type="submit" name="update_customer" class="btn btn-save">OK</button>
                                </form>
                            </td>
                            <td><?php echo htmlspecialchars($u['phone_number']); ?></td>
                            <td><?php echo $join_date; ?></td>
                            <td class="no-print">
                                <button class="btn btn-excel" onclick="exportSingleUser('<?php echo $u['user_id']; ?>', '<?php echo addslashes($u['full_name']); ?>')"><i class="fas fa-file-excel"></i></button>
                                <button class="btn btn-print" onclick="printIndividualCustomer('<?php echo $u['user_id']; ?>', '<?php echo addslashes($u['full_name']); ?>', '<?php echo addslashes($u['phone_number']); ?>', '<?php echo $join_date; ?>')"><i class="fas fa-print"></i></button>
                                <button class="btn btn-edit" onclick="toggleEdit(<?php echo $u['user_id']; ?>)"><i class="fas fa-edit"></i></button>
                                <a href="admin_dashboard.php?delete_id=<?php echo $u['user_id']; ?>&type=user" class="btn btn-delete" onclick="return confirm('Futa mteja huyu?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="printArea">
        <center><h2>IBRAAH EXPRESS</h2><p>Official Ticket</p></center>
        <hr>
        <div id="ticket_content" style="padding:10px;">
            <p><b>ID:</b> <span id="pr_id"></span></p>
            <p><b>Name:</b> <span id="pr_name"></span></p>
            <p><b>Route:</b> <span id="pr_route"></span></p>
            <p><b>Seat:</b> <span id="pr_seat"></span></p>
            <p><b>Date:</b> <span id="pr_date"></span></p>
            <p><b>Status:</b> <span id="pr_status"></span></p>
        </div>
    </div>

    <div id="paymentReceiptArea">
        <center><h2>IBRAAH EXPRESS</h2><p>Payment Receipt</p></center>
        <hr>
        <div style="padding:10px;">
            <p><b>Payment ID:</b> #<span id="p_id"></span></p>
            <p><b>Customer:</b> <span id="p_name"></span></p>
            <p><b>Amount Paid:</b> Tsh <span id="p_amount"></span>/=</p>
            <p><b>Method:</b> <span id="p_method"></span></p>
            <p><b>Transaction No:</b> <span id="p_trans"></span></p>
            <p><b>Date:</b> <span id="p_date"></span></p>
        </div>
        <hr>
        <center><p>Asante kwa kufanya malipo!</p></center>
    </div>

    <div id="customerReportArea">
        <center>
            <h2>IBRAAH EXPRESS</h2>
            <h3>Customer Registry Report</h3>
            <hr>
        </center>
        <div id="report_table_placeholder"></div>
        <br>
        <p style="font-size:11px;">Report Generated on: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <div id="individualCustomerArea">
        <center>
            <h2>IBRAAH EXPRESS</h2>
            <p>Customer Profile Information</p>
        </center>
        <hr>
        <div style="padding:10px;">
            <p><b>Customer ID:</b> #<span id="ind_id"></span></p>
            <p><b>Full Name:</b> <span id="ind_name"></span></p>
            <p><b>Phone Number:</b> <span id="ind_phone"></span></p>
            <p><b>Joined Date:</b> <span id="ind_date"></span></p>
        </div>
        <hr>
        <p style="font-size: 11px;">Printed on: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table id="tempExcelTable" style="display:none;">
        <thead>
            <tr><th>Field</th><th>Details</th></tr>
        </thead>
        <tbody id="tempExcelBody"></tbody>
    </table>

    <script>
        function showTab(tabId, event) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function toggleEdit(id) {
            const form = document.getElementById('edit_form_' + id);
            const span = document.getElementById('name_span_' + id);
            form.style.display = (form.style.display === 'flex') ? 'none' : 'flex';
            span.style.display = (span.style.display === 'none') ? 'inline' : 'none';
        }

        function exportToExcel(tableID, filename = ''){
            let downloadLink;
            let dataType = 'application/vnd.ms-excel';
            let tableSelect = document.getElementById(tableID).cloneNode(true);
            
            let rows = tableSelect.querySelectorAll('tr');
            rows.forEach(row => {
                if(row.lastElementChild) row.removeChild(row.lastElementChild);
            });

            let tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            filename = filename ? filename + '.xls' : 'excel_data.xls';
            downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            
            if(navigator.msSaveOrOpenBlob){
                let blob = new Blob(['\ufeff', tableHTML], { type: dataType });
                navigator.msSaveOrOpenBlob(blob, filename);
            } else {
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                downloadLink.download = filename;
                downloadLink.click();
            }
        }

        function exportSingleUser(id, name) {
            const phone = document.querySelector(`#row_user_${id} td:nth-child(2)`).innerText;
            const date = document.querySelector(`#row_user_${id} td:nth-child(3)`).innerText;
            
            const tbody = document.getElementById('tempExcelBody');
            tbody.innerHTML = `
                <tr><td>Customer ID</td><td>#${id}</td></tr>
                <tr><td>Full Name</td><td>${name}</td></tr>
                <tr><td>Phone Number</td><td>${phone}</td></tr>
                <tr><td>Joined Date</td><td>${date}</td></tr>
                <tr><td>System</td><td>Ibraah Express</td></tr>
            `;
            
            exportToExcel('tempExcelTable', 'Mteja_' + name.replace(/\s+/g, '_'));
        }

        function printTicket(id, name, from, to, seat, status, date) {
            document.getElementById('pr_id').innerText = "#" + id;
            document.getElementById('pr_name').innerText = name;
            document.getElementById('pr_route').innerText = from + " - " + to;
            document.getElementById('pr_seat').innerText = seat;
            document.getElementById('pr_status').innerText = status;
            document.getElementById('pr_date').innerText = date;
            window.print();
        }

        function printReceipt(id, name, amount, method, trans, date) {
            document.getElementById('p_id').innerText = id;
            document.getElementById('p_name').innerText = name;
            document.getElementById('p_amount').innerText = amount;
            document.getElementById('p_method').innerText = method;
            document.getElementById('p_trans').innerText = trans;
            document.getElementById('p_date').innerText = date;
            window.print();
        }

        function printCustomerReport() {
            let tableHtml = document.getElementById('customerTable').cloneNode(true);
            let rows = tableHtml.querySelectorAll('tr');
            rows.forEach(row => {
                if(row.lastElementChild) row.removeChild(row.lastElementChild);
            });
            document.getElementById('report_table_placeholder').innerHTML = "";
            document.getElementById('report_table_placeholder').appendChild(tableHtml);
            window.print();
        }

        function printIndividualCustomer(id, name, phone, date) {
            document.getElementById('ind_id').innerText = id;
            document.getElementById('ind_name').innerText = name;
            document.getElementById('ind_phone').innerText = phone;
            document.getElementById('ind_date').innerText = date;
            window.print();
        }
    </script>
</body>
</html>