<?php
require_once 'config.php';

$token = $_GET['token'] ?? '';
$application = null;

if ($token) {
    $stmt = $conn->prepare("SELECT * FROM pass_applications WHERE application_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();
    $stmt->close();
}

if (!$application) {
    die("Invalid Application Token!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Receipt - PMPML</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
			margin:10px;
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
		
        .receipt-card { max-width:550px; margin:0 auto; background:#fff; border:2px dashed #d9534f; border-radius:8px; padding:25px; }
        .header { text-align:center; border-bottom:2px solid #eee; padding-bottom:15px; margin-bottom:20px; }
        .token-box { background:#eef7ff; border:1px solid #b8daff; text-align:center; padding:15px; border-radius:6px; margin-bottom:20px; }
        .token-box h1 { color:#0275d8; letter-spacing:1px; }
        .row { display:flex; justify-content:space-between; margin-bottom:10px; font-size:0.95rem; }
        .label { font-weight:bold; color:#555; }
        .btn-print { display:block; width:100%; padding:10px; background:#28a745; color:#fff; border:none; border-radius:4px; font-size:1rem; font-weight:bold; cursor:pointer; margin-top:20px; }
        @media print { .btn-print { display:none; } }
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
            <li><a href="admin_verify.php">Admin Verification</a></li>
            <li><a href="studpass.php">Register</a></li>
        </ul>
		</div>
    </header>

        <div class="token-box">
            <span>Your Unique Application ID:</span>
            <h1><?php echo htmlspecialchars($application['application_token']); ?></h1>
        </div>

        <div class="row">
            <span class="label">Full Name:</span>
            <span><?php echo htmlspecialchars($application['fullname']); ?></span>
        </div>
        <div class="row">
            <span class="label">College:</span>
            <span><?php echo htmlspecialchars($application['college_name']); ?></span>
        </div>
        <div class="row">
            <span class="label">Roll No / PRN:</span>
            <span><?php echo htmlspecialchars($application['roll_no']); ?></span>
        </div>
		<div class="row">
            <span class="label">Course:</span>
            <span><?php echo htmlspecialchars($application['course']); ?></span>
        </div>
		<div class="row">
            <span class="label">City:</span>
            <span><?php echo htmlspecialchars($application['city']); ?></span>
        </div>
        <div class="row">
            <span class="label">Assigned Center:</span>
            <span><?php echo htmlspecialchars($application['pass_center']); ?></span>
        </div>
        <div class="row">
            <span class="label">Appointment Date:</span>
            <span><?php echo htmlspecialchars($application['appointment_date']); ?></span>
        </div>
        <div class="row">
            <span class="label">Verification Status:</span>
            <span style="color:#d9534f; font-weight:bold;"><?php echo htmlspecialchars($application['status']); ?></span>
        </div>

        <button onclick="window.print()" class="btn-print">🖨️ Print Receipt</button>
    </div>
</body>
</html>