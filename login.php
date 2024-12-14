<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before validating credentials
    if (empty($username_err) && empty($password_err)) {
        // First check in admin table
        $sql_admin = "SELECT id, username, password FROM admin WHERE username = ?";
        if ($stmt_admin = mysqli_prepare($mysqli, $sql_admin)) {
            mysqli_stmt_bind_param($stmt_admin, "s", $param_username);
            $param_username = $username;

            if (mysqli_stmt_execute($stmt_admin)) {
                mysqli_stmt_store_result($stmt_admin);
                if (mysqli_stmt_num_rows($stmt_admin) == 1) {
                    mysqli_stmt_bind_result($stmt_admin, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt_admin)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["is_admin"] = true;

                            // Redirect to admin dashboard
                            header("location: admin/admin.php");
                            exit;
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                }
            }
            mysqli_stmt_close($stmt_admin);
        }

        // Then check in users table
        $sql_user = "SELECT id, username, password FROM users WHERE username = ?";
        if ($stmt_user = mysqli_prepare($mysqli, $sql_user)) {
            mysqli_stmt_bind_param($stmt_user, "s", $param_username);

            if (mysqli_stmt_execute($stmt_user)) {
                mysqli_stmt_store_result($stmt_user);
                if (mysqli_stmt_num_rows($stmt_user) == 1) {
                    mysqli_stmt_bind_result($stmt_user, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt_user)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect to user page
                            header("location: index.php");
                            exit;
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                }
            }
            mysqli_stmt_close($stmt_user);
        }

        $login_err = "Invalid username or password.";
    }

    // Close connection
    mysqli_close($mysqli);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <?php 
        if (!empty($login_err)) {
            echo '<div class="error">' . $login_err . '</div>';
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>" class="<?php echo (!empty($username_err)) ? 'error' : ''; ?>">
                <span><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="<?php echo (!empty($password_err)) ? 'error' : ''; ?>">
                <span><?php echo $password_err; ?></span>
            </div>
            <button type="submit" class="btn">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
        </form>
    </div>
</body>
</html>
