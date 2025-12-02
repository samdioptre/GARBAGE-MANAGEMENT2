<?php 
session_start();
require_once 'main.php';


$error_message = '';
$email_value = '';

if(isset($_REQUEST['submit'])){
    extract($_REQUEST);
    $email_value = $email;
    
    $login = $user->Adminlogin($email, $password);

    if($login){
        //login success
        header("location:adminH.php");
        exit();
    }
    else{
        //login is failed
        $error_message = 'Invalid admin credentials. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - Garbage Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .admin-login-container {
            width: 100%;
            max-width: 480px;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        
        .admin-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            backdrop-filter: blur(10px);
        }
        
        .admin-icon i {
            font-size: 36px;
            color: white;
        }
        
        .login-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .login-header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: none;
            animation: shake 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .alert-danger {
            background: #fee;
            color: #c33;
        }
        
        .alert i {
            font-size: 20px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        .input-group-custom {
            position: relative;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 16px;
            z-index: 1;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .btn-admin-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .btn-admin-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-admin-login:active {
            transform: translateY(0);
        }
        
        .security-note {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }
        
        .security-note i {
            color: #667eea;
            margin-right: 8px;
        }
        
        .security-note p {
            margin: 0;
            color: #666;
            font-size: 13px;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: opacity 0.3s ease;
        }
        
        .back-link a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }
        
        @media (max-width: 576px) {
            .login-header {
                padding: 30px 20px;
            }
            
            .login-header h2 {
                font-size: 24px;
            }
            
            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<div class="admin-login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="admin-icon">
                <i class="fas fa-shield-halved"></i>
            </div>
            <h2>Admin Portal</h2>
            <p>Garbage Management System</p>
        </div>
        
        <div class="login-body">
            <?php if($error_message): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo $error_message; ?></span>
            </div>
            <?php endif; ?>
            
            <form action="" method="post" name="login">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Admin Email
                    </label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope"></i>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            placeholder="Enter admin email address" 
                            name="email" 
                            value="<?php echo htmlspecialchars($email_value); ?>"
                            required
                        >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            placeholder="Enter admin password" 
                            name="password" 
                            required
                        >
                    </div>
                </div>
                
                <button type="submit" class="btn-admin-login" name="submit" value="Adminlogin">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Secure Login</span>
                </button>
                
                <div class="security-note">
                    <p>
                        <i class="fas fa-lock"></i>
                        This is a secure admin area. All access is monitored.
                    </p>
                </div>
            </form>
        </div>
    </div>
    
    <div class="back-link">
        <a href="login.php">
            <i class="fas fa-arrow-left"></i> Back to User Login
        </a>
    </div>
</div>

</body>
</html>
