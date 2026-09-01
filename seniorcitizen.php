<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Citizen Pass Registration - PMPML Portal</title>
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

        /* Registration Form Container */
        .form-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .form-card {
            background: #ffffff;
            width: 100%;
            max-width: 650px;
            padding: 35px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e0e0e0;
        }

        .form-card h2 {
            text-align: center;
            color: #d9534f;
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        .form-card p.subtitle {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }

        .badge-student {
            display: inline-block;
            background-color: #0275d8;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .section-header {
            font-size: 1rem;
            color: #d9534f;
            border-bottom: 2px solid #f4f6f9;
            padding-bottom: 5px;
            margin: 20px 0 15px 0;
            font-weight: 600;
        }

        /* Form Layout Grid */
        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.88rem;
            color: #444;
        }

        .form-group input, 
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            font-size: 0.92rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus, 
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #d9534f;
        }

        .form-group input[type="file"] {
            padding: 8px;
            font-size: 0.85rem;
            background-color: #f8f9fa;
        }

        .help-text {
            font-size: 0.78rem;
            color: #888;
            margin-top: 4px;
        }

        /* Fee Summary Box */
        .fee-box {
            background-color: #eef7ff;
            border: 1px solid #b8daff;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .fee-box .fee-title {
            font-weight: 600;
            color: #004085;
        }

        .fee-box .fee-amount {
            font-size: 1.4rem;
            font-weight: bold;
            color: #0275d8;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background-color: #d9534f;
            color: white;
            padding: 12px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #c9302c;
        }

        .card-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: #666;
        }

        .card-footer a {
            color: #d9534f;
            text-decoration: none;
            font-weight: 600;
        }

        /* Footer */
        .footer {
            background-color: #222;
            color: #aaa;
            text-align: center;
            padding: 15px;
            font-size: 0.85rem;
        }

        /* Mobile Responsive */
        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
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
            <li><a href="verify_pass.php">Conductor Verification</a></li>
            <li><a href="studpass.php">Register</a></li>
        </ul>
		</div>
    </header>

    <!-- Registration Form Card -->
    <div class="form-wrapper">
        <div class="form-card">
            <div style="text-align: center;">
                <span class="badge-student">Concession Pass</span>
            </div>
            <h2>Senior Citizen Pass Registration</h2>
            <p class="subtitle">Fill in your personal & educational details to apply for a monthly pass</p>

            <!-- Form includes enctype for handling image/document uploads -->
            <form action="register_student.php" method="POST" enctype="multipart/form-data">
                
                <!-- Section 1: Personal Details -->
                <div class="section-header">1. Personal Details</div>
                
					<div class="form-row">
						<div class="form-group">
							<label for="fullname">Full Name (As per College ID)</label>
							<input type="text" id="fullname" name="fullname" placeholder="e.g. Rahul Sharma" required>
						</div>
						<div class="form-group">
							<label for="dob">Date of Birth</label>
							<input type="date" id="dob" name="dob" required>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="email" id="email" name="email" placeholder="student@example.com" required>
						</div>
						<div class="form-group">
							<label for="phone">Mobile Number</label>
							<input type="tel" id="phone" name="phone" placeholder="10-digit phone number" pattern="[0-9]{10}" required>
						</div>
					</div>

					<div class="form-group">
						<label for="address">Residential Address</label>
						<textarea id="address" name="address" rows="2" placeholder="Enter your full local address in Pune/PCMC" required></textarea>
					</div>

                <!-- Section 2: Educational Details -->
                <div class="section-header">2. Bus Details</div>
				
					<div class="form-row">
						<div class="form-group">
							<label for="starting_stop">Starting Stop</label>
							<input type="text" id="starting_stop" name="starting_stop" placeholder="Enter the Starting Stop" required>
						</div>
						<div class="form-group">
							<label for="ending_stop">Starting Stop</label>
							<input type="text" id="ending_stop" name="ending_stop" placeholder="Enter the Ending Stop" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="route">Bus Route</label>
						<input type="text" id="route" name="route" placeholder="PCMC to PMC" required>
					</div>
					
					<div class="form-group">
						<label>Select Verification PMPML Center</label>
						<select name="pass_center" required>
							<option value="">-- Choose Nearest Counter --</option>
							<option value="Akurdi Station Pass Center">Akurdi Station Pass Center</option>
							<option value="Alandi PAss Counter">Alandi Pass Counter</option>
							<option value="Deccan Gymkhana Pass Center">Deccan Gymkhana Pass Center</option>
							<option value="Hadapsar-Bhekarai Nagar Pass Counter">Hadapsar-Bhekrai Nagar Pass Counter</option>
							<option value="Katraj Pass Counter">Katraj Pass Counter</option>
							<option value="Lonawala Pass Center">Lonawala Pass Center</option>
							<option value="Nigdi, Bhakti-Shakti Pass Counter">Nigdi, Bhakti-Shakti Pass Counter</option>
							<option value="PMC(MaNaPa) Pass Center">PMC(MaNaPa) Pass Center</option>
							<option value="Pune Station Pass Center">Pune Station Pass Center</option>
						</select>
					</div>

                <!-- Monthly Fee Summary Box -->
                <div class="fee-box">
                    <div>
                        <div class="fee-title">Monthly General All-Route Pass Fee</div>
                        <div style="font-size: 0.8rem; color: #555;">Valid for 30 days from approval date</div>
                    </div>
                    <div class="fee-amount">₹500</div>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="register_student_btn" class="btn-submit">Submit Application</button>
            </form>

            <div class="card-footer">
                <p>Already registered? <a href="login3.html">Log In Here</a></p>
            </div></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; Field Project - PMPML Monthly Bus Pass Management System</p>
    </footer>

</body>
</html>