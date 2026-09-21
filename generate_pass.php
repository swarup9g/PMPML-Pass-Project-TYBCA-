<?php
require_once 'config.php';

$token = trim($_GET['token'] ?? $_POST['token_to_pay'] ?? '');
$application = null;
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
    $token_to_pay = $_POST['token_to_pay'];
    $txn_id = "TXN" . rand(10000000, 99999999);
	
	// Calculate start date (now) and expiry date (+30 days)
    $start_date = date('Y-m-d H:i:s');
    $expiry_date = date('Y-m-d H:i:s', strtotime('+30 days'));
    
	$stmt = $conn->prepare("UPDATE pass_applications SET status = 'ACTIVE', payment_status = 'COMPLETED', payment_id = ?, approved_at = ?, expiry_date = ? WHERE application_token = ?");
    $stmt->bind_param("ssss", $txn_id, $start_date, $expiry_date, $token_to_pay);
    
    if ($stmt->execute()) {
        header("Location: viewpass_stud.php?token=" . urlencode($token_to_pay));
        exit();
    }
    $stmt->close();
}

if ($token) {
    $stmt = $conn->prepare("SELECT * FROM pass_applications WHERE application_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $application = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Pass - Draft & Payment</title>
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
		
        .container { max-width:650px; margin:30px auto; background:#fff; padding:30px; border-radius:8px; border:1px solid #ddd; }
        .search-box { display:flex; gap:10px; margin-bottom:20px; }
        input[type="text"] { flex:1; padding:10px; border:1px solid #ccc; border-radius:4px; }
        button { padding:10px 20px; background:#d9534f; color:#fff; border:none; border-radius:4px; font-weight:bold; cursor:pointer; }
        .draft-card { background:#f8f9fa; border:2px dashed #0275d8; padding:20px; border-radius:6px; margin-top:15px; position:relative; }
        .draft-watermark { position:absolute; right:20px; top:20px; font-size:2rem; color:rgba(2, 117, 216, 0.15); font-weight:bold; transform:rotate(-15deg); }
        .row { display:flex; justify-content:space-between; margin-bottom:8px; font-size:0.95rem; }
        .pay-box { background:#eef7ff; border:1px solid #b8daff; padding:20px; border-radius:6px; margin-top:20px; text-align:center; }
        .btn-pay { background:#28a745; color:#fff; width:100%; padding:12px; font-size:1rem; border:none; border-radius:4px; cursor:pointer; font-weight:bold; margin-top:10px; }
		
		.pass-btn
		{
			border: 1px solid;
			border-radius: 10px;
			background-color: #FFD700;
			padding: 10px;
		}
		
		.pass-btn:hover
		{
			background-color: #FFF700;
		}
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
        <h2 style="text-align:center; margin-bottom:20px;">Generate Pass / Application Draft</h2>

        <form method="GET" class="search-box">
            <input type="text" name="token" placeholder="Enter Unique Application Token" value="<?php echo htmlspecialchars($token); ?>" required>
            <button type="submit">Load Application</button>
        </form>

        <?php if ($application): ?>
            <div class="draft-card">
                <div class="draft-watermark">
                    <?php echo ($application['status'] == 'APPROVED') ? 'VERIFIED DRAFT' : 'APPLICATION DRAFT'; ?>
                </div>

                <h3>Student Application Details</h3>
                <hr style="margin:10px 0;"><br>

                <div class="row"><strong>Application Token:</strong> <span><?php echo htmlspecialchars($application['application_token']); ?></span></div>
                <div class="row"><strong>Full Name:</strong> <span><?php echo htmlspecialchars($application['fullname']); ?></span></div>
                <div class="row"><strong>College Name:</strong> <span><?php echo htmlspecialchars($application['college_name']); ?></span></div>
                <div class="row"><strong>Roll / ID No:</strong> <span><?php echo htmlspecialchars($application['roll_no']); ?></span></div>
                <div class="row"><strong>Applying Date & Time:</strong> <span style="color:#0275d8;"><?php echo htmlspecialchars($application['created_at']); ?></span></div>
                
                <?php if ($application['approved_at']): ?>
                    <div class="row"><strong>Approving Date & Time:</strong> <span style="color:#28a745;"><?php echo htmlspecialchars($application['approved_at']); ?></span></div>
                <?php endif; ?>

                <div class="row"><strong>Status:</strong> 
                    <span style="font-weight:bold; color: <?php echo ($application['status'] == 'APPROVED') ? 'green' : 'orange'; ?>;">
                        <?php echo htmlspecialchars($application['status']); ?>
                    </span>
                </div>
            </div>

            <!-- If Admin Approved: Show Payment Section -->
            <?php if ($application['status'] == 'APPROVED'): ?>
                <div class="pay-box">
                    <h3>💳 Verification Completed!</h3>
                    <p style="font-size:0.9rem; color:#555; margin-top:5px;">Your documents and physical live photo were verified by Admin. Proceed to pay and generate pass.</p>
                    <form method="POST">
                        <input type="hidden" name="token_to_pay" value="<?php echo htmlspecialchars($application['application_token']); ?>">
                        <button type="submit" name="pay_now" class="btn-pay" >Pay ₹750 Online & Activate Pass</button	>
                    </form>
                </div>

            <!-- If Pending: Instructions -->
            <?php elseif ($application['status'] == 'PENDING_VERIFICATION'): ?>
                <div style="background:#fff3cd; color:#856404; padding:15px; border-radius:6px; margin-top:20px; text-align:center;">
                    ⏳ <strong>Verification Pending:</strong> Please visit the PMPML Pass Counter with your original documents for manual verification.
                </div>

            <!-- If Already Active: Redirect to View Pass -->
            <?php elseif ($application['status'] == 'ACTIVE'): ?>
                <div style="text-align:center; margin-top:20px;">
                    <a href="viewpass_stud.php?token=<?php echo urlencode($application['application_token']); ?>" class="pass-btn" style="color:#0275d8; font-weight:bold;">Your Pass is active! Click here to View Pass 🎫</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>
