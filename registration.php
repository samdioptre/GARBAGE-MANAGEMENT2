<?php 
	
	include_once 'main.php';
	//checking user logged in or not
	
	// Initialize error variables
	$fname_error = '';
	$lname_error = '';
	$email_error = '';
	$nic_error = '';
	$password_error = '';
	$address_error = '';
	$phone_error = '';
	$userType_error = '';
	$success_message = '';
	$error_message = '';

	if(isset($_REQUEST['submit'])){
		// Validate First Name
		if (empty($_POST["fname"])) {
			$fname_error = "First name is required";
		} else {
			if (!preg_match("/^[a-zA-Z ]*$/", $_POST["fname"])) {
				$fname_error = "Only letters and whitespace allowed";
			}
		}

		// Validate Last Name
		if (empty($_POST["lname"])) {
			$lname_error = "Last name is required";
		} else {
			if (!preg_match("/^[a-zA-Z ]*$/", $_POST["lname"])) {
				$lname_error = "Only letters and whitespace allowed";
			}
		}

		// Validate Email
		if (empty($_POST["email"])) {
			$email_error = "Email is required";
		} else {
			if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
				$email_error = "Invalid email format";
			}
		}

		// Validate NIC
		if (empty($_POST["nic"])) {
			$nic_error = "NIC is required";
		} else {
			if (!preg_match("/^[0-9vV]*$/", $_POST["nic"])) {
				$nic_error = "Invalid NIC format";
			}
		}

		// Validate Password
		if (empty($_POST["password"])) {
			$password_error = "Password is required";
		} else if (strlen($_POST["password"]) < 6) {
			$password_error = "Password must be at least 6 characters";
		}

		// Validate Address
		if (empty($_POST["address"])) {
			$address_error = "Address is required";
		}

		// Validate Phone
		if (empty($_POST["phone"])) {
			$phone_error = "Phone number is required";
		} else {
			if (!preg_match("/^[0-9]{10}$/", $_POST["phone"])) {
				$phone_error = "Please enter a valid 10-digit phone number";
			}
		}

		// Validate User Type
		if (empty($_POST["usertype"])) {
			$userType_error = "Please select a user type";
		}

		// If no errors, proceed with registration
		if ($fname_error == "" && $email_error == "" && $lname_error == "" && $nic_error == "" && 
		    $password_error == "" && $address_error == "" && $phone_error == "" && $userType_error == "") {
			extract($_REQUEST);
			$register = $user->reg_user($fname, $lname, $email, $nic, $password, $address, $phone, $usertype);

			if($register){
				$success_message = "Registration successful! Redirecting...";
				header("refresh:2;url=home.php");
			} else {
				$error_message = "Registration failed. Please try again.";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register - Garbage Management System</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		
		body {
			           
    background: url('img/banner/4.2.1-Image-2-Waste-segregation.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}


		
		
		
		.registration-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;

    /* TRANSPARENT EFFECT */
    background: rgba(255, 255, 255, 0.3);   /* transparent white */
    backdrop-filter: blur(10px);            /* frosted glass blur */

    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

		.registration-header h2 {
			font-size: 32px;
			font-weight: 700;
			margin-bottom: 10px;
		}
		
		.registration-header p {
			font-size: 16px;
			opacity: 0.95;
			margin: 0;
		}
		
		.registration-header i {
			font-size: 50px;
			margin-bottom: 15px;
			opacity: 0.9;
		}
		
		.registration-body {
			padding: 40px 30px;
		}
		
		.form-group {
			margin-bottom: 25px;
		}
		
		.form-group label {
			font-weight: 600;
			color: #333;
			margin-bottom: 8px;
			font-size: 14px;
		}
		
		.form-control {
			border: 2px solid #e0e0e0;
			border-radius: 10px;
			padding: 12px 15px;
			font-size: 15px;
			transition: all 0.3s ease;
		}
		
		.form-control:focus {
			border-color: #667eea;
			box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
		}
		
		textarea.form-control {
			resize: vertical;
			min-height: 100px;
		}
		
		.text-danger {
			color: #dc3545;
			font-size: 13px;
			margin-top: 5px;
			display: block;
		}
		
		.alert {
			border-radius: 10px;
			margin-bottom: 20px;
		}
		
		.user-type-group {
			background: #f8f9fa;
			padding: 20px;
			border-radius: 10px;
			border: 2px solid #e0e0e0;
		}
		
		.user-type-group label {
			margin-bottom: 10px;
		}
		
		.radio-option {
			display: flex;
			align-items: center;
			padding: 12px 15px;
			background: white;
			border: 2px solid #e0e0e0;
			border-radius: 8px;
			margin-bottom: 10px;
			cursor: pointer;
			transition: all 0.3s ease;
		}
		
		.radio-option:hover {
			border-color: #667eea;
			background: #f0f3ff;
		}
		
		.radio-option input[type="radio"] {
			margin-right: 10px;
			width: 20px;
			height: 20px;
			cursor: pointer;
		}
		
		.radio-option input[type="radio"]:checked + label {
			color: #667eea;
			font-weight: 600;
		}
		
		.radio-option label {
			margin: 0;
			cursor: pointer;
			flex: 1;
			font-size: 15px;
		}
		
		.btn-container {
			display: flex;
			gap: 15px;
			margin-top: 30px;
		}
		
		.btn-custom {
			flex: 1;
			padding: 14px 30px;
			font-size: 16px;
			font-weight: 600;
			border-radius: 10px;
			border: none;
			transition: all 0.3s ease;
			cursor: pointer;
		}
		
		.btn-primary-custom {
		background: linear-gradient(135deg, #059669 0%, #047857 100%);

			color: white;
		}
		
		.btn-primary-custom:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
		}
		
		.btn-secondary-custom {
			background: #6c757d;
			color: white;
		}
		
		.btn-secondary-custom:hover {
			background: #5a6268;
			transform: translateY(-2px);
		}
		
		.login-link {
			text-align: center;
			margin-top: 25px;
			padding-top: 25px;
			border-top: 1px solid #e0e0e0;
		}
		
		.login-link a {
			color: #667eea;
			font-weight: 600;
			text-decoration: none;
		}
		
		.login-link a:hover {
			text-decoration: underline;
		}
		
		@media (max-width: 768px) {
			.registration-container {
				margin: 0 15px;
			}
			
			.registration-body {
				padding: 30px 20px;
			}
			
			.btn-container {
				flex-direction: column;
			}
		}
	</style>
</head>
<body>

<div class="registration-container">
	<div class="registration-header">
		<i class="fas fa-recycle"></i>
		<h2>Create Account</h2>
		<p>Join our Garbage Management System</p>
	</div>
	
	<div class="registration-body">
		<?php if($success_message): ?>
			<div class="alert alert-success" role="alert">
				<i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
			</div>
		<?php endif; ?>
		
		<?php if($error_message): ?>
			<div class="alert alert-danger" role="alert">
				<i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
			</div>
		<?php endif; ?>
		
		<form action="" method="post" name="reg">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="fname"><i class="fas fa-user"></i> First Name</label>
						<input type="text" class="form-control" id="fname" placeholder="Enter first name" 
						       name="fname" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : ''; ?>">
						<?php if($fname_error): ?>
							<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $fname_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label for="lname"><i class="fas fa-user"></i> Last Name</label>
						<input type="text" class="form-control" id="lname" placeholder="Enter last name" 
						       name="lname" value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>">
						<?php if($lname_error): ?>
							<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $lname_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="email"><i class="fas fa-envelope"></i> Email Address</label>
				<input type="email" class="form-control" id="email" placeholder="Enter email address" 
				       name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
				<?php if($email_error): ?>
					<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $email_error; ?></span>
				<?php endif; ?>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="nic"><i class="fas fa-id-card"></i> NIC Number</label>
						<input type="text" class="form-control" id="nic" placeholder="Enter NIC" 
						       name="nic" value="<?php echo isset($_POST['nic']) ? htmlspecialchars($_POST['nic']) : ''; ?>">
						<?php if($nic_error): ?>
							<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $nic_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
						<input type="text" class="form-control" id="phone" placeholder="Enter phone number" 
						       name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
						<?php if($phone_error): ?>
							<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $phone_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="password"><i class="fas fa-lock"></i> Password</label>
				<input type="password" class="form-control" id="password" placeholder="Enter password (min 6 characters)" name="password">
				<?php if($password_error): ?>
					<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $password_error; ?></span>
				<?php endif; ?>
			</div>
			
			<div class="form-group">
				<label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
				<textarea class="form-control" id="address" placeholder="Enter your full address" 
				          name="address"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
				<?php if($address_error): ?>
					<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $address_error; ?></span>
				<?php endif; ?>
			</div>
			
			<div class="form-group">
				<div class="user-type-group">
					<label><i class="fas fa-user-tag"></i> Select User Type</label>
					<div class="radio-option">
						<input type="radio" name="usertype" value="Seller" id="seller" 
						       <?php echo (isset($_POST['usertype']) && $_POST['usertype'] == 'Seller') ? 'checked' : ''; ?>>
						<label for="seller">
							<i class="fas fa-store"></i> Seller - I want to sell recyclable materials
						</label>
					</div>
					<div class="radio-option">
						<input type="radio" name="usertype" value="Buyer" id="buyer"
						       <?php echo (isset($_POST['usertype']) && $_POST['usertype'] == 'Buyer') ? 'checked' : ''; ?>>
						<label for="buyer">
							<i class="fas fa-shopping-cart"></i> Buyer - I want to purchase recyclable materials
						</label>
					</div>
					<?php if($userType_error): ?>
						<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $userType_error; ?></span>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="btn-container">
				<button type="submit" class="btn-custom btn-primary-custom" name="submit" value="Register">
					<i class="fas fa-user-plus"></i> Register
				</button>
				<button type="reset" class="btn-custom btn-secondary-custom" name="reset">
					<i class="fas fa-redo"></i> Reset
				</button>
			</div>
			
			<div class="login-link">
				Already have an account? <a href="login.php">Login here</a>
			</div>
		</form>
	</div>
</div>

</body>
</html>
