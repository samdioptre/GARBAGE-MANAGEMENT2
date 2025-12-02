<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'main.php';
$uid = $_SESSION['userId'];

if (!$user->get_session()) {
    header("location:home.php");
}

if (isset($_GET['q'])) {
    $user->user_logout();
    header("location:home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Portal - Conbusi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

       body {
    font-family: 'Inter', sans-serif;
    background: url('img/banner/accordion.png') no-repeat center center fixed;
    background-size: cover;
    color: #1f2937;
    line-height: 1.6;
}
section, header, footer, .container, .content-area {
    background: transparent !important;
}

        /* Header */
        header {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #059669;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #4b5563;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #059669;
        }

        .logout-btn {
            background: #dc2626;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        .user-greeting {
            color: #059669;
            font-weight: 600;
        }

        /* Hero Section */
        .hero {
                background: linear-gradient(135deg, #059669, #047857);

            padding: 3rem 2rem;
            text-align: center;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        /* Info Cards */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .info-card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .info-card-icon {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .info-card h3 {
            font-size: 1.25rem;
            color: #059669;
            margin-bottom: 0.5rem;
        }

        .info-card p {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Form Section */
        .form-section {
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-section h2 {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Material Cards */
        .materials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .material-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #10b981;
            border-radius: 0.75rem;
            padding: 1.5rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .material-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(5, 150, 105, 0.2);
        }

        .material-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .material-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .material-info h4 {
            font-size: 1.125rem;
            color: #065f46;
            font-weight: 600;
        }

        .material-info .price {
            font-size: 0.875rem;
            color: #059669;
            font-weight: 500;
        }

        .material-card input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #10b981;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .material-card input:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        /* Submit Button */
        .submit-section {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
        }

        .btn-submit {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            padding: 1rem 3rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1.125rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(5, 150, 105, 0.3);
        }

        /* Footer */
        footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 3rem 2rem 1.5rem;
            margin-top: 4rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h4 {
            color: white;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #10b981;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 2.5rem;
            height: 2.5rem;
            background: #374151;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .social-links a:hover {
            background: #059669;
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .materials-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">
                 Conbusi
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="home.php">Services</a></li>
                    <li><a href="contact_us.php">Contact</a></li>
                    <li class="user-greeting">Hello, <?php $user->get_firstname($uid); ?></li>
                    <li><a href="sellerHome.php?q=logout" class="logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <h1>Welcome to Your Seller Portal</h1>
            <p>Submit your recyclable materials and contribute to a greener future</p>
            
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-value">2,450+</div>
                    <div class="stat-label">Active Sellers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">15K+ Tons</div>
                    <div class="stat-label">Materials Collected</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">98%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Info Cards -->
        <div class="info-cards">
            <div class="info-card">
                <div class="info-card-icon">🚚</div>
                <h3>Free Pickup</h3>
                <p>We collect your materials directly from your location at no extra cost</p>
            </div>
            <div class="info-card">
                <div class="info-card-icon">💰</div>
                <h3>Fair Pricing</h3>
                <p>Get competitive rates for your recyclable materials instantly</p>
            </div>
            <div class="info-card">
                <div class="info-card-icon">⚡</div>
                <h3>Quick Processing</h3>
                <p>Fast approval and payment within 24-48 hours of collection</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h2>📦 Submit Your Materials</h2>
            
            <form action="inputSuccess.php" method="post">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="your.email@example.com" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" 
                           placeholder="+1 (555) 000-0000" required>
                </div>

                <div class="form-group">
                    <label for="address">Pickup Address</label>
                    <textarea class="form-control" id="address" name="address" 
                              placeholder="Enter your complete pickup address including street, city, and postal code" required></textarea>
                </div>

                <div class="form-group">
                    <label>Material Types & Quantities (in Kg)</label>
                    <div class="materials-grid">
                        <div class="material-card">
                            <div class="material-header">
                                <div class="material-icon">♻️</div>
                                <div class="material-info">
                                    <h4>Plastic / Polythene</h4>
                                    <span class="price">$0.50 per Kg</span>
                                </div>
                            </div>
                            <input type="number" class="form-control" name="plasticQty" 
                                   placeholder="Enter quantity in Kg (or 0)" min="0" step="0.01" required>
                        </div>

                        <div class="material-card">
                            <div class="material-header">
                                <div class="material-icon">🔩</div>
                                <div class="material-info">
                                    <h4>Metal</h4>
                                    <span class="price">$1.20 per Kg</span>
                                </div>
                            </div>
                            <input type="number" class="form-control" name="metalQty" 
                                   placeholder="Enter quantity in Kg (or 0)" min="0" step="0.01" required>
                        </div>

                        <div class="material-card">
                            <div class="material-header">
                                <div class="material-icon">🏗️</div>
                                <div class="material-info">
                                    <h4>Building Waste</h4>
                                    <span class="price">$0.30 per Kg</span>
                                </div>
                            </div>
                            <input type="number" class="form-control" name="buildingQty" 
                                   placeholder="Enter quantity in Kg (or 0)" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>

                <div class="submit-section">
                    <button type="submit" class="btn-submit">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>Conbusi
                    </h4>
                    <p>Your trusted partner in waste management and recycling solutions.</p>
                    <div class="social-links">
                        <a href="#">📘</a>
                        <a href="#">🐦</a>
                        <a href="#">📷</a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="#">Material Collection</a></li>
                        <li><a href="#">Recycling</a></li>
                        <li><a href="#">Waste Management</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <li>📧 info@ecocollect.com</li>
                        <li>📞 +1 (555) 123-4567</li>
                        <li>📍 123 Green Street, Eco City</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date("Y"); ?> Conbusi. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>