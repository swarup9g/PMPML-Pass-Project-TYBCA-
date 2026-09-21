<?php
require_once 'config.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$token = trim($_GET['token'] ?? $_POST['token'] ?? $_SESSION['application_token'] ?? '');
$application = null;

if ($token) {
    $stmt = $conn->prepare("SELECT * FROM pass_applications WHERE application_token = ? AND status = 'ACTIVE'");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $application = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Determine valid expiry date with safety fallback
if (!empty($application['expiry_date']) && $application['expiry_date'] !== '0000-00-00 00:00:00') {
    $expiry_timestamp = strtotime($application['expiry_date']);
} else {
    // Fallback: 30 days after approval date or creation date
    $base_date = !empty($application['approved_at']) ? $application['approved_at'] : $application['created_at'];
    $expiry_timestamp = strtotime('+30 days', strtotime($base_date));
}

// Calculate Days Left
$current_timestamp = time();
$seconds_left = $expiry_timestamp - $current_timestamp;
$days_left = ceil($seconds_left / (60 * 60 * 24));

if ($days_left < 0) {
    $days_left = 0;
    $is_expired = true;
} else {
    $is_expired = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Digital Pass - PMPML</title>
    <style>
	
		/* CSS Reset & Global Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 2;
			content: "";
        }

        /* Navigation Bar */
        .navbar {
            background-color: #d9534f; /* PMPML Red Theme */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            font-size: 1.4rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .nav-links {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links a {
            background-color: white;
            color: #d9534f;
            padding: 7px;
            border-radius: 10px;
            font-weight: bold;
        }

        .nav-links a:hover {
            color: green;
        }
		
		.brand{
			display:flex;
			align-items: center;
			gap:400px;
		}
		
		.logo img{
			width: 50px;
			height:50px;
			object-fit: cover;
			border-radius:50%;
			align-items:center;
		}
		
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
        body { background:#f4f6f9; }
        .container { max-width:600px; margin:30px auto; background:#fff; padding:25px; border-radius:8px; border:1px solid #ddd; }
        .search-box { display:flex; gap:10px; margin-bottom:20px; }
        input[type="text"] { flex:1; padding:10px; border:1px solid #ccc; border-radius:4px; }
        button { padding:10px 20px; background:#d9534f; color:#fff; border:none; border-radius:4px; font-weight:bold; cursor:pointer; }
        
        /* Digital Pass Design */
        .pass-card { background:linear-gradient(135deg, #1e3c72, #2a5298); color:#fff; border-radius:12px; padding:25px; position:relative; box-shadow:0 8px 16px rgba(0,0,0,0.2); }
        .pass-header { display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid rgba(255,255,255,0.3); padding-bottom:10px; margin-bottom:15px; }
        .pass-body { display:flex; gap:20px; align-items:center; }
        .pass-photo { width:110px; height:130px; object-fit:cover; border-radius:6px; border:2px solid #fff; }
        .pass-info p { margin-bottom:6px; font-size:0.9rem; }
        .pass-footer { margin-top:15px; border-top:1px solid rgba(255,255,255,0.3); padding-top:10px; display:flex; justify-content:space-between; font-size:0.8rem; opacity:0.9; }
        .badge-active { background:#28a745; color:#fff; padding:3px 8px; border-radius:4px; font-size:0.75rem; font-weight:bold; }
    </style>
</head>
<body>

	<!-- 1. Navigation Header -->
    <header class="navbar">
		<div class="brand">
        <a href="prog.html" class="logo"> <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTd-ljfEKUB_La7f2v83g66aitjT1aT47WQPMEAwqvH_LPVkwrAN2ytrizZ&s=10" alt="LOGO">  PMPML Pass Portal</a>
        <ul class="nav-links">
            <li><a href="prog.php">Home</a></li>
            <li><a href="login3.php">Login</a></li>
            <li><a href="admin_verify.php">Admin</a></li>
            <li><a href="studpass.php">Register</a></li>
			<li><a href="viewpass_stud.pass">View Pass</a></li>
        </ul>
		</div>
    </header>
	
    <div class="container">
        <h2 style="text-align:center; margin-bottom:20px;">PMPML Student Digital Pass Portal</h2>

        <form method="GET" class="search-box">
            <input type="text" name="token" placeholder="Enter Unique Token to view Pass" value="<?php echo htmlspecialchars($token); ?>" required>
            <button type="submit">View Pass</button>
        </form>

        <?php if ($application): ?>
            <div class="pass-card">
                <div class="pass-header">
                    <div>
                        <h3 style="margin:0;">PMPML STUDENT MONTHLY PASS</h3>
                        <small>Pune Mahanagar Parivahan Mahamandal Ltd.</small>
                    </div>
                    <span class="badge-active">ACTIVE PASS</span>
                </div>

                <div class="pass-body">
                    <img src="<?php echo htmlspecialchars($application['live_photo'] ?? 'uploads/default.jpg'); ?>" class="pass-photo" alt="Verified Student Photo">
                    
                    <div class="pass-info">
                        <p><strong>Token:</strong> <?php echo htmlspecialchars($application['application_token']); ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($application['fullname']); ?></p>
                        <p><strong>College:</strong> <?php echo htmlspecialchars($application['college_name']); ?></p>
                        <p><strong>Roll No:</strong> <?php echo htmlspecialchars($application['roll_no']); ?></p>
                        <p><strong>Txn ID:</strong> <?php echo htmlspecialchars($application['payment_id']); ?></p>
                    </div>
                </div>

                <div class="pass-footer">
                    <div><strong>Applied:</strong> <?php echo htmlspecialchars($application['created_at']); ?></div>
                    <div><strong>Approved:</strong> <?php echo htmlspecialchars($application['approved_at']); ?></div>
                </div>
            </div>
			
			<!-- Start Date, Expiry Date & Remaining Days Counter -->
                <div style="margin-top:15px; border-top:1px solid rgba(255,255,255,0.3); padding-top:12px;">
                    <div style="display:flex; justify-content:space-between; font-size:0.85rem;">
						<div><strong>Valid From:</strong><br> <?php echo date('d-M-Y', !empty($application['approved_at']) ? strtotime($application['approved_at']) : strtotime($application['created_at'])); ?></div>
						<div style="text-align:right;"><strong>Valid Till:</strong><br> <?php echo date('d-M-Y', $expiry_timestamp); ?></div>
                    </div>

                    <div style="text-align:center;">
                        <?php if (!$is_expired): ?>
                            <div class="counter-badge">
                                ⏳ <strong><?php echo $days_left; ?> Days Left</strong> until pass expires
                            </div>
                        <?php else: ?>
                            <div class="counter-badge expired-badge">
                                ❌ Pass Expired on <?php echo date('d-M-Y', strtotime($application['expiry_date'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div style="text-align:center; margin-top:15px;">
                <button onclick="window.print()" style="background:#5bc0de; color:#fff; border:none; padding:10px 20px; font-weight:bold; border-radius:4px; cursor:pointer;">🖨️ Print Pass / Download PDF</button>
            </div>
        <?php elseif ($token): ?>
            <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:6px; text-align:center;">
                ⚠️ Pass not found or payment is pending! Please verify status on the <strong>Generate Pass</strong> page.
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
