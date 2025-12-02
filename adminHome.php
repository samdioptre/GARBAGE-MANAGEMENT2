<?php

session_start();
require_once 'main.php';
if (!isset($mysqli)) {
    require_once 'db_config.php';
    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
}

$user=new User($mysqli);


$uid = isset($_SESSION['adminId']) ? $_SESSION['adminId'] : null;

if(!$user->get_session()){
    header("location:admin.php");
    exit;
}

if (isset($_GET['q'])){
    $user->user_logout();
    header("location:admin.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Garbage Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to bottom, #f0fdf4, #ffffff);

            min-block-size: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            max-inline-size: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .dashboard-header {
            background: white;
            border-radius: 15px;
            padding: 25px 30px;
            margin-block-end: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            inline-size: 50px;
            block-size: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .header-info h1 {
            font-size: 24px;
            color: #333;
            margin-block-end: 5px;
        }

        .header-info p {
            color: #666;
            font-size: 14px;
        }

        .header-right {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: #666;
        }

        .logout-btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-icon.collections {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-icon.reports {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-icon.complaints {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-content h3 {
            font-size: 32px;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-content p {
            color: #666;
            font-size: 14px;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #667eea;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid transparent;
            border-radius: 12px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }

        .action-btn:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
        }

        .action-btn i {
            font-size: 24px;
            margin-bottom: 10px;
            display: block;
        }

        .action-btn span {
            display: block;
            font-weight: 600;
            font-size: 14px;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-content h4 {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .activity-content p {
            font-size: 12px;
            color: #666;
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                text-align: center;
            }

            .header-left {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-recycle"></i>
                </div>
                <div class="header-info">
                    <h1>Admin Dashboard</h1>
                    <p>Garbage Management System</p>
                </div>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <span class="user-name"><?php echo htmlspecialchars($user-email);?></span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
                <a href="adminHome.php?q=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>1,247</h3>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon collections">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>3,456</h3>
                    <p>Collections</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon reports">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>892</h3>
                    <p>Reports</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon complaints">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>45</h3>
                    <p>Pending Issues</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2 class="section-title">
                <i class="fas fa-bolt"></i>
                Quick Actions
            </h2>
            <div class="actions-grid">
                <a href="#" class="action-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Add User</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Schedule Collection</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-file-alt"></i>
                    <span>Generate Report</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>View Map</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                Recent Activity
            </h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="activity-content">
                        <h4>New User Registration</h4>
                        <p>John Doe registered as a buyer - 5 minutes ago</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-trash"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Collection Completed</h4>
                        <p>Zone A collection completed successfully - 1 hour ago</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-comment"></i>
                    </div>
                    <div class="activity-content">
                        <h4>New Complaint</h4>
                        <p>Missed collection reported in Zone C - 2 hours ago</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Payment Processed</h4>
                        <p>Monthly subscription payment received - 3 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>