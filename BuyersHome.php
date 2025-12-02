<?php
session_start();
require_once 'main.php';
$user = new User($mysqli);
$uid = $_SESSION['userId'];

if(!$user->get_session()){
    header("location:home.php");
}

if (isset($_GET['q'])){
    $user->user_logout();
    header("location:home.php");
}

include 'dbconn.php';
$data = new Databases();
$soldnew = new Sold($data->con);

$success_message = '';
if(isset($_POST["submit"])){
    $insert_data = array(
        'PolQty' => mysqli_real_escape_string($data->con, $_POST['PolQty']),
        'MetalQty' => mysqli_real_escape_string($data->con, $_POST['MetalQty']),
        'BuildQty' => mysqli_real_escape_string($data->con, $_POST['BuildQty'])
    );
    
    if($data->insert('buyitem', $insert_data)){
        $success_message = 'Record Added Successfully';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Waste Management - Place Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <style>
        :root {
            --primary-green: #10b981;
            --secondary-green: #059669;
            --dark-green: #047857;
            --light-green: #d1fae5;
            --gray-bg: #f8fafc;
            --gray-border: #e2e8f0;
        }

       body {
    background-image: url("img/case/dubai.png");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

        .main-container {
            max-inline-size: 1200px;
            margin: 0 auto;
        }

        .page-header {
            background: white;
            border-radius: 15px;
            padding: 1.5rem 2rem;
            margin-block-end: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0;
        }

        .page-title i {
            font-size: 2rem;
            color: var(--primary-green);
        }

        .page-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-custom {
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-user {
            background: var(--light-green);
            color: var(--dark-green);
        }

        .btn-home {
            background: #3b82f6;
            color: white;
        }

        .btn-home:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-logout {
            background: #ef4444;
            color: white;
        }

        .btn-logout:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        }

        .alert-success-custom {
            background: var(--light-green);
            border: 2px solid var(--primary-green);
            border-radius: 10px;
            padding: 1rem 1.5rem;
            color: var(--dark-green);
            font-weight: 600;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info-banner {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid var(--primary-green);
        }

        .info-banner h5 {
            color: #1e293b;
            font-weight: 700;
            margin: 0;
        }

        .waste-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .waste-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-top: 5px solid transparent;
        }

        .waste-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .waste-card.plastic {
            border-top-color: #f59e0b;
        }

        .waste-card.metal {
            border-top-color: #6366f1;
        }

        .waste-card.building {
            border-top-color: #8b5cf6;
        }

        .waste-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .waste-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }

        .plastic .waste-icon {
            background: #fef3c7;
            color: #f59e0b;
        }

        .metal .waste-icon {
            background: #e0e7ff;
            color: #6366f1;
        }

        .building .waste-icon {
            background: #ede9fe;
            color: #8b5cf6;
        }

        .waste-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .availability-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--light-green);
            color: var(--dark-green);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .availability-badge i {
            color: var(--primary-green);
        }

        .form-control-custom {
            border: 2px solid var(--gray-border);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
            outline: none;
        }

        .action-buttons {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-submit {
            background: var(--primary-green);
            color: white;
            padding: 0.875rem 2.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: var(--secondary-green);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-reset {
            background: #64748b;
            color: white;
            padding: 0.875rem 2.5rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: #475569;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .waste-cards-container {
                grid-template-columns: 1fr;
            }

            .page-title h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container main-container">
        <!-- Header -->
        <div class="page-header">
            <div class="page-title">
                <i class="fas fa-recycle"></i>
                <h1>Waste Management Order</h1>
            </div>
            <div class="header-actions">
                <button class="btn btn-custom btn-user">
                    <i class="fas fa-user"></i> Hello <?php $user->get_firstname($uid); ?>
                </button>
                <a href="home.php" class="btn btn-custom btn-home">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="sellerHome.php?q=logout" class="btn btn-custom btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Success Message -->
        <?php if (!empty($success_message)): ?>
        <div class="alert-success-custom">
            <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
            <span><?php echo $success_message; ?></span>
        </div>
        <?php endif; ?>

        <!-- Info Banner -->
        <div class="info-banner">
            <h5><i class="fas fa-info-circle text-primary"></i> Please select the quantity of waste materials you want to order</h5>
        </div>

        <!-- Order Form -->
        <form method="post">
            <div class="waste-cards-container">
                <!-- Plastic Card -->
                <div class="waste-card plastic">
                    <div class="waste-card-header">
                        <div class="waste-icon">
                            <i class="fas fa-bottle-water"></i>
                        </div>
                        <h3 class="waste-card-title">Polythene & Plastic</h3>
                    </div>
                    <div class="availability-badge">
                        <i class="fas fa-box"></i>
                        <span>Available: <?php $soldnew->calPlastic(); ?> kg</span>
                    </div>
                    <input type="number" min="0" name="PolQty" id="PolQty" 
                           class="form-control form-control-custom" 
                           placeholder="Enter quantity in kg">
                </div>

                <!-- Metal Card -->
                <div class="waste-card metal">
                    <div class="waste-card-header">
                        <div class="waste-icon">
                            <i class="fas fa-industry"></i>
                        </div>
                        <h3 class="waste-card-title">Metal Waste</h3>
                    </div>
                    <div class="availability-badge">
                        <i class="fas fa-box"></i>
                        <span>Available: <?php $soldnew->calcMetal(); ?> kg</span>
                    </div>
                    <input type="number" min="0" name="MetalQty" id="MetalQty" 
                           class="form-control form-control-custom" 
                           placeholder="Enter quantity in kg">
                </div>

                <!-- Building Waste Card -->
                <div class="waste-card building">
                    <div class="waste-card-header">
                        <div class="waste-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 class="waste-card-title">Building Waste</h3>
                    </div>
                    <div class="availability-badge">
                        <i class="fas fa-box"></i>
                        <span>Available: <?php $soldnew->calcBuilding(); ?> kg</span>
                    </div>
                    <input type="number" min="0" name="BuildQty" id="BuildQty" 
                           class="form-control form-control-custom" 
                           placeholder="Enter quantity in kg">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button type="submit" name="submit" value="submit" id="submit" class="btn-submit">
                    <i class="fas fa-cart-plus"></i> Place Order
                </button>
                <button type="reset" name="reset" value="reset" id="reset" class="btn-reset">
                    <i class="fas fa-redo"></i> Clear Form
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</body>
</html>
