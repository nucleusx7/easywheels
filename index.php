<?php
session_start();

// Check if the user is logged in
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyWheels</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">
            <h1>EasyWheels</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="bicycle.php">Bicycles</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="about.html">About</a></li>
                <li>
                    <a href="profile.php" class="no-shadow"><i class="fa-solid fa-user"></i></a>
                    <?php if ($is_logged_in): ?>
                        <a href="logout.php" class="btn-logout">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-login">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <main class="hero-section">
        <div class="hero-content">
            <h2>Explore with EasyWheels</h2>
            <p>Discover our range of bicycles and start your journey now.</p>
            <a href="bicycle.php" class="cta-button">Rent a Bicycle</a>
        </div>
    </main>

    <section class="info-section">
        <div class="container">
            <h2>Why Choose Us?</h2>
            <div class="info-cards">
                <div class="info-card">
                    <i class="fas fa-check-circle"></i>
                    <h3>Quality Bikes</h3>
                    <p>Our bicycles are well-maintained and ready for your adventure.</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-clock"></i>
                    <h3>Flexible Rentals</h3>
                    <p>Rent for a few hours or a whole day—it's up to you!</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Affordable Prices</h3>
                    <p>Competitive rates to make cycling accessible to everyone.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="contact-info">
                    <p><i class="fa-sharp fa-solid fa-location-dot"></i> Chapagaun, Godawari-10, Lalitpur</p>
                    <p><i class="fa-solid fa-phone"></i> +977 9800000000</p>
                    <p><i class="fa-solid fa-envelope"></i> info@easywheels.com.np</p>
                </div>
                <div class="social-icons">
                    <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.x.com/" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/" target="_blank"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>


    <script src="script.js"></script>
</body>
</html>