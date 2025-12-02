<?php
include 'database.php';
$data = new Databases;
$success_message = '';

//validation
$name_error = '';
$email_error = '';
$message_error = '';

// Preserve form values
$cus_name = '';
$email = '';
$message = '';

if (isset($_POST["submit"])) {
    // Store form values
    $cus_name = $_POST["cus_name"] ?? '';
    $email = $_POST["email"] ?? '';
    $message = $_POST["message"] ?? '';
    
    if (empty($_POST["cus_name"])) {
        $name_error = "Please Enter Name";
    } else {
        if (!preg_match("/^[a-zA-Z ]*$/", $_POST["cus_name"])) {
            $name_error = "Only Letters and whitespace allowed";
        }
    }

    if (empty($_POST["email"])) {
        $email_error = "Please Enter Email";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid Email format";
        }
    }

    if (empty($_POST["message"])) {
        $message_error = "Please Enter Message";
    }

    if ($name_error == "" && $email_error == "" && $message_error == "") {
        $insert_data = array(
            'cus_name' => mysqli_real_escape_string($data->con, $_POST['cus_name']),
            'email' => mysqli_real_escape_string($data->con, $_POST['email']),
            'message' => mysqli_real_escape_string($data->con, $_POST['message'])
        );
        if ($data->insert('contact_us', $insert_data)) {
            $success_message = 'Your message has been sent successfully!';
            // Clear form values on success
            $cus_name = '';
            $email = '';
            $message = '';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contact Us - Garbage Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
     background: url('img/banner/contact_thumb.png') no-repeat center center fixed;
    background-size: cover;

            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .contact-container {
    background: rgba(255, 255, 255, 0.6); /* semi-transparent white */
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    max-width: 600px;
    width: 100%;
}

        .contact-header {
            
                background: rgba(102, 126, 234, 0.7); /* semi-transparent purple */
color: #111;
            padding: 40px;
            text-align: center;
        }

        .contact-header i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.95;
        }

        .contact-header h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .contact-header p {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }

        .contact-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control.error {
            border-color: #ef4444;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            padding-top: 14px;
        }

        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message i {
            font-size: 12px;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d1fae5;
            border: 2px solid #34d399;
            color: #065f46;
        }

        .alert-success i {
            color: #10b981;
            font-size: 20px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s ease;
        }

        .back-link a:hover {
            gap: 12px;
        }

        @media (max-width: 576px) {
            .contact-header {
                padding: 30px 20px;
            }

            .contact-header h2 {
                font-size: 26px;
            }

            .contact-header i {
                font-size: 40px;
            }

            .contact-body {
                padding: 30px 20px;
            }

            .form-control {
                padding: 12px 12px 12px 42px;
            }

            .btn-submit {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="contact-container">
        <div class="contact-header">
            <i class="fas fa-envelope"></i>
            <h2>Contact Us</h2>
            <p>We'd love to hear from you. Send us a message!</p>
        </div>

        <div class="contact-body">
            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo htmlspecialchars($success_message); ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="cus_name">Full Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            name="cus_name" 
                            class="form-control <?php echo $name_error ? 'error' : ''; ?>" 
                            id="cus_name" 
                            placeholder="Enter your name"
                            value="<?php echo htmlspecialchars($cus_name); ?>"
                        >
                    </div>
                    <?php if ($name_error): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?php echo $name_error; ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control <?php echo $email_error ? 'error' : ''; ?>" 
                            id="inputEmail" 
                            placeholder="Enter your email"
                            value="<?php echo htmlspecialchars($email); ?>"
                        >
                    </div>
                    <?php if ($email_error): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?php echo $email_error; ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="message">Your Message</label>
                    <div class="input-wrapper">
                        <i class="fas fa-comment-dots input-icon" style="top: 20px;"></i>
                        <textarea 
                            class="form-control <?php echo $message_error ? 'error' : ''; ?>" 
                            name="message" 
                            id="message" 
                            placeholder="Write your message here..."
                        ><?php echo htmlspecialchars($message); ?></textarea>
                    </div>
                    <?php if ($message_error): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?php echo $message_error; ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Message</span>
                </button>
            </form>

            <div class="back-link">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Home</span>
                </a>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
