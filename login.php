<?php
session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    require_once("sql/config.php");

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $query = "SELECT * FROM account WHERE username = '" . $username . "' OR email = '" . $username . "'";
    $res = mysqli_query($conn, $query);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($_POST['password'], $row['password'])) {
            if (isset($_POST["remember"])) {
                $session_lifetime = 86400;
                session_set_cookie_params($session_lifetime);
            }
            $_SESSION["username"] = $row['username'];
            header("Location: index.php");
            exit;
        } else {
            $errore = true;
        }
    } else {
        $errore = true;
    }
}

?>
<html>

<head>
    <title>Spotify • Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/logo.png" rel="icon">
    <link href="css/login.css" rel="stylesheet">
    <script src="js/showPassword.js" defer></script>
</head>

<body>
    <header>
        <img src="images/logo_login.png">
    </header>

    <div class="login">
        <h1> Log in to Spotify </h1>

        <?php
        if (isset($errore)) {
            echo "<div class='error-login'>";
            echo "<svg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 16 16'>";
            echo "<path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16' />";
            echo "<path d='M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z' />";
            echo "</svg> <p>Incorrect email or password.</p> </div>";
        }
        ?>

        <div class="access-app">
            <img src="images/logo_google.png">
            <p> Continue with Google </p>
        </div>
        <div class="access-app">
            <img src="images/logo_facebook.png">
            <p> Continue with Facebook </p>
        </div>
        <div class="access-app">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282" />
                <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282" />
            </svg>
            <p> Continue with Apple </p>
        </div>

        <div class="main-form">
            <form method="post">
                <label>
                    Email or username <br>
                    <input type="text" name="username" placeholder="Email or username" autocomplete="off">
                </label>
                <br>
                <label class="password-container">
                    Password <br>
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
                <br>
                <label class="remember">
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <br>
                <label>
                    <input type="submit" value="Log In">
                </label>
            </form>

            <p class="signup"><a href="forgotPassword.php"> Forgot your password? </a></p>
        </div>

        <p class="signup">Don't have an account? <a href="signup.php">Sign up for Spotify</a> </p>
    </div>

    <footer>
        <p>
            This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a>
            and <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
        </p>
    </footer>
</body>

</html>