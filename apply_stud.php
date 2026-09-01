<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

$error_msg = "";

if (isset($_POST['submit_application'])) {
    $fullname         = trim($_POST['fullname']);
    $email            = trim($_POST['email']);
    $phone            = trim($_POST['phone']);
    $college_name     = trim($_POST['college_name']);
    $roll_no          = trim($_POST['roll_no']);
    $course           = trim($_POST['course']);
    $pass_center      = trim($_POST['pass_center']);
    $appointment_date = trim($_POST['appointment_date']);

    // Generate Unique Application ID (e.g., PMPML-STU-48291)
    $application_token = "PMPML-STU-" . rand(10000, 99999);

    $stmt = $conn->prepare("INSERT INTO pass_applications (application_token, fullname, email, phone, college_name, roll_no, course, pass_center, appointment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $application_token, $fullname, $email, $phone, $college_name, $roll_no, $course, $pass_center, $appointment_date);

    if ($stmt->execute()) {
        header("Location: receipt.php?token=" . urlencode($application_token));
        exit();
    } else {
        $error_msg = "Error submitting application: " . $conn->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Pass Application - PMPML</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
        body { background:#f4f6f9; color:#333; }
		
        .navbar
		{
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
		
        .container { max-width:650px; margin:40px auto; background:#fff; padding:30px; border-radius:8px; border:1px solid #ddd; }
        h2 { color:#d9534f; text-align:center; margin-bottom:20px; }
        .form-group { margin-bottom:15px; }
        label { display:block; font-weight:bold; margin-bottom:5px; font-size:0.9rem; }
        input, select { width:100%; padding:10px; border:1px solid #ccc; border-radius:4px; font-size:0.95rem; }
        .btn { background:#d9534f; color:#fff; padding:12px; border:none; width:100%; font-size:1rem; font-weight:bold; border-radius:4px; cursor:pointer; margin-top:10px; }
        .btn:hover { background:#c9302c; }
        .error { background:#f8d7da; color:#721c24; padding:10px; border-radius:4px; margin-bottom:15px; }
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

    <div class="container">
        <h2>Student Pass Application</h2>
        <?php if ($error_msg): ?>
            <div class="error"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form action="apply_stud.php" method="POST">
            <div class="form-group">
                <label>Full Name (As per College ID)</label>
                <input type="text" name="fullname" required placeholder="e.g. Rahul Sharma">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required placeholder="student@example.com">
            </div>
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="tel" name="phone" pattern="[0-9]{10}" required placeholder="10-digit mobile number">
            </div>
            <div class="form-group">
                <label>College / Educational Institute Name</label>
                <input type="text" name="college_name" required placeholder="e.g. COEP Pune">
            </div>
            <div class="form-group">
                <label>Roll Number / PRN</label>
                <input type="text" name="roll_no" required placeholder="e.g. CS202688">
            </div>
            <div class="form-group">
                <label>Course & Year</label>
                <input type="text" name="course" required placeholder="e.g. B.Tech Computer Engineering - 2nd Year">
            </div>
            <div class="form-group">
                <label>Select Verification PMPML Center</label>
                <select name="pass_center" required>
                    <option value="">-- Choose Nearest Counter --</option>
                    <option value="Swargate Bus Stand Counter">Swargate Bus Stand Counter</option>
                    <option value="Deccan Gymkhana Bus Station">Deccan Gymkhana Bus Station</option>
                    <option value="Pune Station Counter">Pune Station Counter</option>
                    <option value="Pimpri Chowk Counter">Pimpri Chowk Counter</option>
                </select>
            </div>
            <div class="form-group">
                <label>Preferred Visit Date for Document Verification</label>
                <input type="date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
            </div>

            <button type="submit" name="submit_application" class="btn">Generate Unique ID & Book Appointment</button>
        </form>
    </div>
</body>
</html>