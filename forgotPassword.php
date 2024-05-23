<?php
session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        require_once("sql/config.php");
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $query = "SELECT * FROM account WHERE username = '" . $username . "' OR email = '" . $username . "'";
        $res = mysqli_query($conn, $query);
        if (mysqli_num_rows($res) > 0) {

            if (strlen($_POST["password"]) < 10 || strlen($_POST["password"]) > 20) {
                $errore_password = true;
            } else {
                $password = mysqli_real_escape_string($conn, $_POST["password"]);
                $hashpassword = password_hash($password, PASSWORD_BCRYPT);

                $query1 = "UPDATE `account`
                            SET `password`='$hashpassword', `realPassword`='$password' 
                            WHERE username = '" . $username . "' OR email = '" . $username . "'";

                if (mysqli_query($conn, $query1)) {
                    $_SESSION["username"] = $username;
                    header("Location: index.php");
                    exit;
                }
            }
        } else {
            $errore_username = true;
        }
    } else {
        $errore_input = true;
    }
}
?>

<html>

<head>
    <title>Spotify • Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/logo.png" rel="icon">
    <link href="css/forgot.css" rel="stylesheet">
    <script src="js/showPassword.js" defer></script>
</head>

<body>
    <header>
        <img src="images/logo_login.png">
    </header>
    <?php
    if (isset($errore_input) || isset($errore_username) || isset($errore_password)) {
        echo "<div class='error-forgot'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 16 16'>";
        echo "<path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16' />";
        echo "<path d='M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z' />";
        echo "</svg>";
        if (isset($errore_input)) {
            echo "<p>Enter the username and the password.</p> ";
        }
        if (isset($errore_username)) {
            echo "<p>This email or username doesn't exist.</p> ";
        }
        if (isset($errore_password)) {
            echo "<p>The password doesn't follow the parameter: 
            <br> 1. At least 10 and less then 20 character. 
            <br> 2. 1 number or special character.
            <br> 3. 1 letter. </p> ";
        }
        echo "</div>";
    }
    ?>

    <div class="forgot">
        <h2> Reset your password </h2>
        <span>Enter your email address or username, and we'll send you a link to get back into your account.</span>
        <div class="main-form">
            <form method="post" autocomplete="off">
                <label>
                    Email address or username <br>
                    <input type="text" name="username" placeholder="Email or username" autocomplete="off">
                </label>
                <label class="password-container">
                    New password <br>
                    <input type="password" id="password" name="password" placeholder="Password" autocomplete="off">
                    <svg id="showPassword" xmlns="http://www.w3.org/2000/svg" fill="gray" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                    </svg>
                    <svg id="hiddenPassword" class="hidden" xmlns="http://www.w3.org/2000/svg" fill="gray" viewBox="0 0 16 16">
                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                    </svg>
                </label>
                <p> <a href="https://support.spotify.com/it/article/reset-password/"> Need support?</a> or back to <a href="login.php">log in.</a></p>
                <input name="submit-email" type="submit" value="Reset password">
            </form>
        </div>
        <footer>
            <p>
                This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a>
                and <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
            </p>
        </footer>
    </div>
</body>

</html>