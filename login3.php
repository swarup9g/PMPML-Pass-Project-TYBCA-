<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMPML Digital Bus Pass Portal</title>
	
	<style>
		 * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
		
		body
		{
			line-height:2;
			background-color:#f0f0f0;
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
		
		h2
		{
			font-family: Monospace;
			}
		
		.form-container
		{
			flex: 1;
			background: #ffffff;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
			border-radius: 10px;
			width: 400px;
			margin-top: 100px;
			margin-left: 450px;
			margin-bottom: 50px;
			display: flex;
			justify-content: center;
			padding: 10px;
			font-family: 'Inter', sans-serif;
		}
		
		.input-box
		{
			padding: 10px;
			border-radius: 7px;
			font-size: 15px;
			font-family: Verdana, Geneva, sans-serif;
			font-weight: 500;
			outline: none;
			border-color: #4f46e5;
		}
		
		.input-box input
		{
			padding: 10px;
			width: 300px;
			height: 40px;
			border: 1.5px solid;
			border-color: #c9302c;
			border-radius: 10px;
			outline: none;
			font-family: 'Inter', sans-serif;
		}
		
		.input-box Select
		{
			padding: 10px;
			width: 300px;
			height: 40px;
			border: 1.5px solid;
			border-radius: 10px;
			border-color: #c9302c;
			transition: border-color 0.3s;
		}
		
		.login-btn
		{
			border: 1px solid;
			border-radius: 8px;
			padding: 5px;
			width: 300px;
			background-color: #d9534f;
			color: white;
			height: 40px;
		}
		
		.login-btn:hover
		{
			background-color: #c9302c;			
		}
		
		.reset-btn
		{
			border: 1px solid;
			border-radius: 8px;
			padding: 5px;
			width: 250px;
			background-color: ;
			color: white;
		}
		
	</style>
	
</head>
<body>

	 <!-- 1. Navigation Header -->
    <header class="navbar">
		<div class="brand">
        <a href="index.php" class="logo"> <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTd-ljfEKUB_La7f2v83g66aitjT1aT47WQPMEAwqvH_LPVkwrAN2ytrizZ&s=10" alt="LOGO">  PMPML Pass Portal</a>
        <ul class="nav-links">
            <li><a href="prog.php">Home</a></li>
            <li><a href="login3.php">Login</a></li>
            <li><a href="verify_pass.php">Conductor Verification</a></li>
            <li><a href="studpass.php">Register</a></li>
        </ul>
		</div>
    </header>
	
	<div class="form-container">
		<div class="login-wrap">
		<form method="POST" action="">
		
			<center>
					<h2><label>User Login</label></h2>
					<p><h5> please enter the details for login.</h5></p>
				<div class="input-box">
					<label> Username </label><br>
					<input type="text" name="username" placeholder="Username" required><br>
				</div>
				
				<div class="input-box">
					<label> Password</label><br>
					<input type="password" name="password" placeholder="Password" required><br>
				</div>
				
				<div class="input-box">
					<label> Email address </label><br>
					<input type="email" name="email" placeholder="Email" required><br>
				</div>
				
				<div class="input-box">
					<label> Select Login type </label><br>
					<Select name="login-type" id="logtype" required>
						<option value="passenger"> Commuter/Passenger </option>
						<option value="conductor"> Conductor/Verifier </option>
						<option value="admin"> PMPML Admin </option>
					</Select><br>
				</div>
				
				<div class="input-box">
					<button type="submit" name="loginbtn" class="login-btn"> Login </button><br>
				</div>
				
				<div class="card-footer">
					<p>Don't have an account? <a href="register.php">Register Here</a></p>
				</div>
			
			</center>
		</div>
	</div>
	
</body>
</html>