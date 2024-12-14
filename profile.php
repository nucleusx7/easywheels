<?php
session_start();
require_once "config.php"; // Include the database connection file

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

// Get the username from the session
$username = $_SESSION["username"];

// Fetch user details from the database
$sql = "SELECT username, fullname, contact, email FROM users WHERE username = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($fetched_username, $fullname, $contact, $email);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Error: Could not fetch user details.";
    exit;
}

// Handle password change request
$password_change_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate new passwords
    if (empty($new_password) || empty($confirm_password)) {
        $password_change_message = "Both password fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $password_change_message = "Passwords do not match.";
    } else {
        // Hash the new password and update it in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($update_sql)) {
            $stmt->bind_param("ss", $hashed_password, $username);
            if ($stmt->execute()) {
                $password_change_message = "Password successfully changed.";
            } else {
                $password_change_message = "Error changing password.";
            }
            $stmt->close();
        }
    }
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .profile-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .profile-item {
            margin: 10px 0;
            text-align: left;
        }
        .profile-item span {
            font-weight: bold;
        }
        .button-group {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .change-password-form {
            display: none;
            margin-top: 20px;
        }
        .form-field {
            margin-bottom: 10px;
            text-align: left;
        }
        .form-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-field input {
            width: 150px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .message {
            margin-top: 10px;
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
    </style>
    <script>
        function togglePasswordForm() {
            const form = document.querySelector(".change-password-form");
            form.style.display = form.style.display === "none" || form.style.display === "" ? "block" : "none";
        }
    </script>
</head>
<body>
    <div class="profile-container">
        <h1>User Profile</h1>
        <div class="profile-item"><span>Username:</span> <?php echo htmlspecialchars($fetched_username); ?></div>
        <div class="profile-item"><span>Full Name:</span> <?php echo htmlspecialchars($fullname); ?></div>
        <div class="profile-item"><span>Contact:</span> <?php echo htmlspecialchars($contact); ?></div>
        <div class="profile-item"><span>Email:</span> <?php echo htmlspecialchars($email); ?></div>
        <div class="button-group">
            <a href="index.php" class="btn">Back to Home</a>
            <button class="btn" onclick="togglePasswordForm()">Change Password</button>
        </div>
        <form method="post" class="change-password-form">
            <div class="form-field">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" placeholder="enter a new password" required>
            </div>
            <div class="form-field">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="re-type new password" required>
            </div>
            <button type="submit" name="change_password" class="btn">Confirm</button>
        </form>
        <?php if (!empty($password_change_message)): ?>
            <div class="message <?php echo strpos($password_change_message, "successfully") !== false ? '' : 'error'; ?>">
                <?php echo $password_change_message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
