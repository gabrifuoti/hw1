<?php
session_start();
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["username"]) && isset($_POST["year"]) && isset($_POST["month"]) && isset($_POST["day"])) {
    require_once("sql/config.php");

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $query3 = "SELECT username FROM account WHERE username = '$username'";
    $res3 = mysqli_query($conn, $query3);
    $error = false;
    if (mysqli_num_rows($res3) > 0) {
        // "Username già esistente";
        $error = true;
    }

    if (strlen($_POST["password"]) <= 2) {
        // "Password troppo corta";
        $error = true;
    }

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $query4 = "SELECT email FROM account WHERE email = '$email'";
    $res4 = mysqli_query($conn, $query4);
    if (mysqli_num_rows($res4) > 0) {
        // "Email già esistente";
        $error = true;
    }

    if (!$error) {
        $year = mysqli_real_escape_string($conn, $_POST["year"]);
        $month = mysqli_real_escape_string($conn, $_POST["month"]);
        $day = mysqli_real_escape_string($conn, $_POST["day"]);
        $date = $year . "-" . $month . "-" . $day;

        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $hashpassword = password_hash($password, PASSWORD_BCRYPT);

        $query1 = "INSERT INTO `user`(`name`, `birth`) VALUES ('$username','$date')";

        $query2 = "INSERT INTO `account`(`email`, `username`, `password`, `realPassword`) 
                        VALUES ('$email','$username','$hashpassword','$password')";


        if (mysqli_query($conn, $query1) && mysqli_query($conn, $query2)) {
            $_SESSION["username"] = $username;
            mysqli_close($conn);
            header("Location: index.php");
            exit;
        }
    }
}
?>

<html>

<head>
    <title>Sign up • Spotify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/logo.png" rel="icon">
    <link href="css/signup.css" rel="stylesheet">
    <script src="js/signup.js" defer></script>
    <script src="js/showPassword.js" defer></script>
</head>

<body>
    <header>
        <img src="images/logo_login.png">
    </header>

    <div class="signup">
        <!-- Step 1 -->
        <div class="step1">
            <h1> Sign up to start listening </h1>
            <form method="post" autocomplete="off">
                <div class="form-email">
                    <label>
                        Email address <br>
                        <input type="text" name="email" placeholder="name@domain.com">
                    </label>
                    <div id="error-email" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <span>This email is invalid. Make sure it's written like example@email.com or is longer than 50 characters</span>
                    </div>
                    <div class="already-exist-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <span>This address is already linked to an existing account. To continue, <a href="login.php">log in</a>.</span>
                    </div>
                    <label>
                        <input name="submit-email" type="submit" value="Next" disabled>
                    </label>
                </div>
                <div class="or">
                    <div class="line"></div>
                    or
                    <div class="line"></div>
                </div>
                <div class="social">
                    <div class="access-app">
                        <img src="images/logo_google.png">
                        <p> Sign up with Google </p>
                    </div>
                    <div class="access-app">
                        <img src="images/logo_facebook.png">
                        <p> Sign up with Facebook </p>
                    </div>
                    <div class="access-app">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282" />
                            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516s1.52.087 2.475-1.258.762-2.391.728-2.43m3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422s1.675-2.789 1.698-2.854-.597-.79-1.254-1.157a3.7 3.7 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56s.625 1.924 1.273 2.796c.576.984 1.34 1.667 1.659 1.899s1.219.386 1.843.067c.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758q.52-1.185.473-1.282" />
                        </svg>
                        <p> Sign up with Apple </p>
                    </div>
                </div>
        </div>

        <!-- Step 2 -->
        <div class="step2 hidden">
            <div class="loading">
                <span class="loading-step2"></span>
            </div>
            <div class="arrow-step">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" id="arrow-step1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                </svg>
                <div class="number-step">
                    <span> Step 1 of 3 </span>
                    Create a password
                </div>
            </div>
            <div class="form-password">
                <label class="password-container">
                    Password <br>
                    <input type="password" id="password" name="password" placeholder="Password">
                    <svg id="showPassword" xmlns="http://www.w3.org/2000/svg" fill="gray" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                    </svg>
                    <svg id="hiddenPassword" class="hidden" xmlns="http://www.w3.org/2000/svg" fill="gray" viewBox="0 0 16 16">
                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                    </svg>
                </label>
                <div class="main-check-password">
                    <div> Your password must contain at least </div>
                    <div>
                        <div class="check-password" id="check-password1"> </div> 1 letter
                    </div>
                    <div>
                        <div class="check-password" id="check-password2"> </div> 1 number or special character (example: # ? ! &)
                    </div>
                    <div>
                        <div class="check-password" id="check-password3"> </div> 10 characters and less then 20
                    </div>
                </div>
                <label>
                    <input name="submit-password" type="submit" value="Next" disabled>
                </label>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step3 hidden">
            <div class="loading">
                <span class="loading-step3"></span>
            </div>
            <div class="arrow-step">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" id="arrow-step2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                </svg>
                <div class="number-step">
                    <span> Step 2 of 3 </span>
                    Tell us about yourself
                </div>
            </div>
            <div class="form-aboutyou">
                <label>
                    Name <br>
                    <span> This name will appear on your profile</span> <br>
                    <input type="text" name="username">
                    <div id="error-name" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>Enter a name for your profile with more than 2 characters and less then 20</p>
                    </div>
                    <div class="already-exist-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>This username is already linked to an existing account. To continue, <a href="login.php">log in</a>.</p>
                    </div>
                </label>
                <label>
                    <br> Date of birth <br>
                    <span> Why do we need your date of birth?<a href="https://www.spotify.com/it/legal/end-user-agreement/">Learn more</a>.</span> <br>
                    <div class="insert-date">
                        <input type="number" name="year" placeholder="yyyy" maxlenght="9999">
                        <select id="months" name="month">
                            <option disabled selected> Month </option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <input type="number" name="day" placeholder="dd" max="99">
                    </div>
                    <div id="error-date" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>Please a valid date of birth.</p>
                    </div>
                    <div id="error-day" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>Please enter the day of your birth date by entering a number between 1 and 31.</p>
                    </div>
                    <div id="error-month" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>Select your birth month.</p>
                    </div>
                    <div id="error-year" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>Please enter a birth year from 1900 onwards.</p>
                    </div>
                    <div id="error-minor" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>You're too young to create a Spotify account.</p>
                    </div>
                </label>
                <label>
                    Gender <br>
                    <span> We use your gender to help personalize our content recommendations and ads for you.</span> <br>
                    <div class="container-gender">
                        <div class="insert-gender">
                            <svg class="ckeck-gender" xmlns="http://www.w3.org/2000/svg">
                                <circle class="hidden" r="6" cx="7.5" cy="7.5" stroke-width="4" stroke="#1ed760" fill="#121212" />
                            </svg> Male
                        </div>
                        <div class="insert-gender">
                            <svg class="ckeck-gender" xmlns="http://www.w3.org/2000/svg">
                                <circle class="hidden" r="6" cx="7.5" cy="7.5" stroke-width="4" stroke="#1ed760" fill="#121212" />
                            </svg> Woman
                        </div>
                        <div class="insert-gender">
                            <svg class="ckeck-gender" xmlns="http://www.w3.org/2000/svg">
                                <circle class="hidden" r="6" cx="7.5" cy="7.5" stroke-width="4" stroke="#1ed760" fill="#121212" />
                            </svg> Non-Binary
                        </div>
                        <div class="insert-gender">
                            <svg class="ckeck-gender" xmlns="http://www.w3.org/2000/svg">
                                <circle class="hidden" r="6" cx="7.5" cy="7.5" stroke-width="4" stroke="#1ed760" fill="#121212" />
                            </svg> Something else
                        </div>
                        <div class="insert-gender">
                            <svg class="ckeck-gender" xmlns="http://www.w3.org/2000/svg">
                                <circle class="hidden" r="6" cx="7.5" cy="7.5" stroke-width="4" stroke="#1ed760" fill="#121212" />
                            </svg> Prefer not to say
                        </div>
                    </div>
                    <div id="error-gender" class="error-div hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                        </svg>
                        <p>Select your gender.</p>
                    </div>
                </label>
                <label>
                    <input name="submit-aboutyou" type="submit" value="Next" disabled>
                </label>
            </div>
            </form>
        </div>
    </div>

    <footer>
        <p class="login">Already have an account? <a href="login.php">Login here</a>. </p>
        <p> This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a>
            and <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.
        </p>
    </footer>
    </div>

</body>

</html>
