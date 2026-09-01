<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMPML Digital Bus Pass Portal</title>
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

        /* Hero Banner */
        .hero {
            background-color: #ffffff;
            text-align: center;
            padding: 60px 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .hero h1 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: #222;
        }

        .hero p {
            font-size: 1.1rem;
            color: #666;
            max-width: 650px;
            margin: 0 auto 30px auto;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #d9534f;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #c9302c;
        }

        .btn-secondary {
            background-color: transparent;
            color: #555;
            border: 2px solid #ccc;
        }

        .btn-secondary:hover {
            background-color: #fff777;
        }

        /* Main Container for Cards */
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: #222;
        }

        /* Pass Rates Grid Layout */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
		
		.card:hover{
			transform: scale(1.03);
		}
		
		
        .card {
            background: white;
            border: 1px solid #e2e2e2;
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-popular {
            border: 2px solid #d9534f;
            position: relative;
        }

        .badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: #d9534f;
            color: white;
            padding: 3px 12px;
            font-size: 0.8rem;
            border-radius: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .card h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .price {
            font-size: 2.2rem;
            font-weight: bold;
            color: #222;
            margin-bottom: 15px;
        }

        .price span {
            font-size: 0.9rem;
            color: #777;
            font-weight: normal;
        }

        .card p {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 25px;
        }

        /* How It Works Section */
        .steps-container {
            background-color: white;
            border-radius: 8px;
            padding: 40px 20px;
            margin-top: 50px;
            border: 1px solid #e2e2e2;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            text-align: center;
            margin-top: 25px;
        }

        .step-item h4 {
            color: #d9534f;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .step-item p {
            font-size: 0.9rem;
            color: #666;
        }

        /* Footer */
        .footer {
            background-color: #222;
            color: #aaa;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            font-size: 0.9rem;
        }

        /* Mobile Responsiveness Adjustment */
        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                gap: 10px;
            }
            .hero-buttons {
                flex-direction: column;
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
            <li><a href="admin_verify.php">Admin Verification</a></li>
            <li><a href="studpass.php">Register</a></li>
        </ul>
		</div>
    </header>

    <!-- 2. Hero Section -->
    <section class="hero">
        <h1>PMPML Monthly Bus Pass Online Portal</h1>
        <p>Skip long counter queues! Apply for your monthly bus pass online, upload required ID proofs, and download your digital pass instantly.</p>
        <div class="hero-buttons">
            <a href="register.php" class="btn btn-primary">Apply For Pass</a>
            <a href="login.php" class="btn btn-secondary">Renew Pass</a>
        </div>
    </section>

    <!-- 3. Pass Categories and Fares -->
    <main class="container">
        <h2 class="section-title">Available Pass Types & Rates</h2>
        
        <div class="cards-grid">
            <!-- Student Pass -->
            <div class="card">
                <div>
                    <h3 style="color: #0275d8;">Student Monthly</h3>
                    <div class="price">₹750 <span>/ Month</span></div>
                    <p>Concession pass valid for school & college students upon submitting educational ID proof.</p>
                </div>
                <a href="studpass.php" class="btn btn-primary">Apply Now</a>
            </div>

            <!-- General All-Route Pass -->
            <div class="card card-popular">
                <span class="badge">Most Popular</span>
                <div>
                    <h3 style="color: #d9534f;">General All-Route</h3>
                    <div class="price">₹1,500 <span>/ Month</span></div>
                    <p>Unlimited travel across all PMC & PCMC urban/suburban routes for general commuters.</p>
                </div>
                <a href="allroutepass.php" class="btn btn-primary">Apply Now</a>
            </div>

            <!-- Senior Citizen Pass -->
            <div class="card">
                <div>
                    <h3 style="color: #5cb85c;">Senior Citizen</h3>
                    <div class="price">₹500 <span>/ Month</span></div>
                    <p>Special discounted rate for commuters aged 60+ upon uploading Aadhaar/Age verification.</p>
                </div>
                <a href="seniorcitizen.php" class="btn btn-primary">Apply Now</a>
            </div>
        </div>

        <!-- 4. How It Works Section -->
        <section class="steps-container">
            <h2 class="section-title" style="margin-bottom: 10px;">How It Works</h2>
            <div class="steps-grid">
                <div class="step-item">
                    <h4>1. Register</h4>
                    <p>Create your personal account with phone and email details.</p>
                </div>
                <div class="step-item">
                    <h4>2. Upload ID</h4>
                    <p>Fill out the application form and upload your Student/Aadhaar ID proof.</p>
                </div>
                <div class="step-item">
                    <h4>3. Admin Approval</h4>
                    <p>PMPML staff verify your documents and approve the pass request.</p>
                </div>
                <div class="step-item">
                    <h4>4. Get Digital Pass</h4>
                    <p>Access your pass with validity dates and photo directly on your smartphone.</p>
                </div>
            </div>
        </section>
    </main>

</body>
</html>