<?php
require_once 'config.php';

$search_token = $_GET['search_token'] ?? '';
$application = null;
$msg = "";

if (isset($_POST['approve_btn'])) {
    $token_to_approve = $_POST['token_to_approve'];
    $image_data       = $_POST['live_photo_data'] ?? '';
    $file_path        = '';

    // Create uploads directory if not exists
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // 1. Check if camera snapshot was taken
    if (!empty($image_data)) {
        $image_parts = explode(";base64,", $image_data);
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = "live_" . time() . "_" . rand(1000, 9999) . ".jpg";
        $file_path = "uploads/" . $file_name;
        file_put_contents($file_path, $image_base64);
    } 
    // 2. Fallback to manual file upload if camera wasn't used
    elseif (isset($_FILES['file_photo']) && $_FILES['file_photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['file_photo']['name'], PATHINFO_EXTENSION);
        $file_name = "upload_" . time() . "_" . rand(1000, 9999) . "." . $ext;
        $file_path = "uploads/" . $file_name;
        move_uploaded_file($_FILES['file_photo']['tmp_name'], $file_path);
    }

    if (!empty($file_path)) {
        $current_time = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("UPDATE pass_applications SET status = 'APPROVED', live_photo = ?, approved_at = ? WHERE application_token = ?");
        $stmt->bind_param("sss", $file_path, $current_time, $token_to_approve);

        if ($stmt->execute()) {
            $msg = "Physical verification successful! Photo saved & status updated to APPROVED.";
        }
        $stmt->close();
    } else {
        $msg = "Error: Please capture a photo or upload an image before approving!";
    }
}

// Fetch Application Details
if ($search_token) {
    $stmt = $conn->prepare("SELECT * FROM pass_applications WHERE application_token = ?");
    $stmt->bind_param("s", $search_token);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PMPML Admin Verification Portal</title>
    <style>
        body
		{ 
			font-family:'Segoe UI',sans-serif; background:#f4f6f9;
		}
		
		.live-clock-bar 
		{ 
			background:#222; 
			color:#fff;
			padding:10px 20px; 
			text-align:right; 
			font-weight:bold;
			font-size:0.9rem; 
			margin-bottom:20px; 
			border-radius:4px;				
		}
		
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
		
        .container 
		{ 
			max-width:650px; margin:0 auto; background:#fff; padding:30px; border-radius:8px; border:1px solid #ddd;
			}
			
        h2 { color:#333; margin-bottom:20px; text-align:center; }
        .search-box { display:flex; gap:10px; margin-bottom:20px; }
		
        input[type="text"] 
		{ 
			flex:1; padding:10px; 
			border:1px solid #ccc;
			border-radius:4px; 
			margin: 30px;
			height: 30px;
		}
        .btn-search 
		{ 
			background:#0275d8; 
			color:#fff; 
			border:none;
			padding:10px 20px;
			font-weight:bold; 
			border-radius:4px; 
			cursor:pointer;
			margin: 30px; 
			height: 50px;
		}
		
		.webcam-section { text-align:center; margin-top:20px; padding:15px; background:#eef7ff; border:1px solid #b8daff; border-radius:6px; }
		video, canvas { border:2px solid #ccc; border-radius:6px; background:#000; width:100%; max-width:320px; height:240px; }
        .btn-snap { background:#ffc107; color:#333; border:none; padding:8px 15px; font-weight:bold; border-radius:4px; cursor:pointer; margin:10px 0; }
        .btn-approve { background:#28a745; color:#fff; border:none; padding:12px; width:100%; font-size:1rem; font-weight:bold; border-radius:4px; cursor:pointer; margin-top:15px; }
		
        .details-box { background:#f8f9fa; border:1px solid #eee; padding:20px; border-radius:6px; margin-top:15px; }
        .alert { background:#d4edda; color:#155724; padding:12px; border-radius:4px; margin-bottom:15px; }
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
		
        <!-- Real-time Clock Header -->
		<div class="live-clock-bar">
			🕒 Current Date & Time: <span id="current-clock">Loading...</span>
		</div>

		<div class="container">
			<h2>PMPML Counter Verification Portal</h2>

			<?php if ($msg): ?>
				<div class="alert"><?php echo $msg; ?></div>
			<?php endif; ?>

			<form method="GET" class="search-box">
				<input type="text" name="search_token" placeholder="Enter Unique ID (e.g. PMPML-STU-48291)" value="<?php echo htmlspecialchars($search_token); ?>" required>
				<button type="submit" class="btn-search">Search ID</button>
			</form>

        <?php if ($application): ?>
            <div class="details-box">
                <h3>Student Verification Record</h3>
                <hr style="margin:10px 0;"><br>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($application['fullname']); ?></p>
                <p><strong>College:</strong> <?php echo htmlspecialchars($application['college_name']); ?></p>
                <p><strong>Roll No:</strong> <?php echo htmlspecialchars($application['roll_no']); ?></p>
				<p><strong>Roll No:</strong> <?php echo htmlspecialchars($application['course']); ?></p>
				<p><strong>City:</strong> <?php echo htmlspecialchars($application['city']); ?></p>
                <p><strong>Appointment Date:</strong> <?php echo htmlspecialchars($application['appointment_date']); ?></p>
				<div class="row"><strong>Applying Date & Time:</strong> <span style="color:#0275d8;"><?php echo htmlspecialchars($application['created_at']); ?></span></div>
                
                <?php if ($application['approved_at']): ?>
                    <div class="row"><strong>Approving Date & Time:</strong> <span style="color:#28a745;"><?php echo htmlspecialchars($application['approved_at']); ?></span></div>
                <?php endif; ?>
				
                <p><strong>Current Status:</strong> 
                <div class="row"><span><strong>Current Status:</strong></span>
                    <span style="color: <?php echo ($application['status'] == 'APPROVED' || $application['status'] == 'ACTIVE') ? 'green' : 'red'; ?>; font-weight:bold;">
                        <?php echo htmlspecialchars($application['status']); ?>
                    </span>
                </div>
                </p>
				
				
                <!-- Show webcam capture only if not yet approved -->
                <?php if ($application['status'] == 'PENDING_VERIFICATION'): ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="webcam-section">
							<h4>📷 Capture Live Verification Photo</h4>
							<p style="font-size:0.8rem; color:#666; margin-bottom:10px;">Ensure student face is clearly visible</p>
							
							<video id="webcam" autoplay playsinline></video>
							<canvas id="canvas" style="display:none;"></canvas>
							<br>
							<button type="button" class="btn-snap" onclick="takeSnapshot()">📸 Take Photo</button>
							<input type="hidden" name="live_photo_data" id="live_photo_data">
							<div id="photo-preview-msg" style="color:green; font-weight:bold; margin-top:5px;"></div>

							<div style="margin-top:15px; border-top:1px dashed #ccc; padding-top:10px;">
								<p style="font-size:0.85rem; color:#555;">Or upload photo manually if camera fails:</p>
								<input type="file" name="file_photo" accept="image/*" style="margin-top:5px;">
							</div>
						</div>

                        <input type="hidden" name="token_to_approve" value="<?php echo htmlspecialchars($application['application_token']); ?>">
                        <button type="submit" name="approve_btn" class="btn-approve">Approve Pass & Save Verification</button>
                    </form>
                <?php else: ?>
                    <?php if ($application['live_photo']): ?>
                        <div style="text-align:center; margin-top:15px;">
                            <strong>Captured Live Photo:</strong><br>
                            <img src="<?php echo htmlspecialchars($application['live_photo']); ?>" style="width:150px; border-radius:6px; margin-top:5px; border:2px solid #ccc;">
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Live Clock Script -->
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('current-clock').innerText = now.toLocaleString();
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Camera Logic
        const video = document.getElementById('webcam');
        if (video) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => { video.srcObject = stream; })
                .catch(err => { alert("Camera access denied or unavailable!"); });
        }

        function takeSnapshot() {
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
            
            const dataURL = canvas.toDataURL('image/jpeg');
            document.getElementById('live_photo_data').value = dataURL;
            document.getElementById('photo-preview-msg').innerText = "✓ Photo Captured Successfully!";
        }
    </script>
</body>
</html>>