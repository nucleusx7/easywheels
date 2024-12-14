<?php
session_start();

// Check if the user is logged in
$is_logged_in = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;

// Include database configuration
require_once "config.php";

// Fetch bicycles from the database
$sql = "SELECT id, name, description, rate FROM bicycles";
$result = mysqli_query($mysqli, $sql);
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
    <link rel="stylesheet" href="main.css">
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

    <main class="bicycles-table">
        <div class="container">
            <h2>Our Bicycles</h2>
            <table class="bicycles-list">
                <thead>
                    <tr>
                        <th>Bicycle Name</th>
                        <th>Description</th>
                        <th>Rate (per day)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        // Display each bicycle in a table row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                            echo '<td>' . htmlspecialchars($row["description"]) . '</td>';
                            echo '<td>$' . htmlspecialchars($row["rate"]) . '</td>';
                            echo '<td>';
                            if ($is_logged_in) {
                                echo '<a href="rent_bicycle.php?id=' . $row["id"] . '" class="btn-rent">Rent</a>';
                            } else {
                                echo '<a href="login.php" class="btn-rent">Rent</a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='4'>No bicycles available for rent at the moment.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="contact-info">
                    <p><i class="fa-sharp fa-solid fa-location-dot"></i> Chapagaun, Godawari-11, Lalitpur</p>
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
</body>
</html>

<?php
// Close database connection
mysqli_close($mysqli);
?>
