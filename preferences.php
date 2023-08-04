<?php
# Initialize the session
session_start();

# If user is not logged in then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
    echo "<script>" . "window.location.href='./login.php';" . "</script>";
    exit;
}

require('./session_time_manager.php');

if (isset($_SESSION['total_sessions'])) {
    $_SESSION['total_sessions']++;
} else {
    $_SESSION['total_sessions'] = 1;
}

// var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User login system</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
</head>

<body class="<?php echo $_SESSION["darkMode"] ? 'dark-mode' : ''; ?>" <?php echo isset($_SESSION["fontSize"]) ? 'style="font-size:' . $_SESSION["fontSize"] . 'px"' : "" ?>>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <a class="navbar-brand" href="./index.php"><?php echo $_SESSION["nepaliMode"] ? 'मेरो असाइनमेन्ट' : 'My Assignment'; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="./index.php"><?php echo $_SESSION["nepaliMode"] ? 'होम' : 'Home'; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./preferences.php"><?php echo $_SESSION["nepaliMode"] ? 'प्राथमिकताहरू' : 'Preferences'; ?> <span class="sr-only">(<?php echo $_SESSION["nepaliMode"] ? 'वर्तमान' : 'current'; ?>)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- User profile -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-5 text-center">
                <img src="./img/blank-avatar.jpg" class="img-fluid rounded" alt="User avatar" width="180">
                <h4 class="my-4"><?php echo $_SESSION["nepaliMode"] ? 'नमस्कार' : 'Hello'; ?>, <?= htmlspecialchars($_SESSION["username"]); ?></h4>
                <p class="lead"><small><em><?php echo $_SESSION["nepaliMode"] ? 'पछिल्लो लगइन समय' : 'Last login time'; ?>: <?php echo date("Y-m-d H:i:s", $_SESSION["last_login_time"]) ?></em></small></p>
                <p class="lead"><small><em><?php echo $_SESSION["nepaliMode"] ? 'कुल सत्रहरू' : 'Total Sessions'; ?>: <?php echo $_SESSION["total_sessions"] ?></em></small></p>
                <a href="./logout.php" class="btn btn-primary"><?php echo $_SESSION["nepaliMode"] ? 'लग आउट' : 'Log Out'; ?></a>
            </div>
        </div>

        <hr>
        <h1 class="mb-4"><?php echo $_SESSION["nepaliMode"] ? 'प्राथमिकताहरू' : 'Preferences'; ?></h1>
        <ul class="list-group mb-4">
            <li class="list-group-item">
                <h4><?php echo $_SESSION["nepaliMode"] ? 'थेम' : 'Theme'; ?></h4>
                <!-- Dark mode switch -->
                <form class="theme-form" action="./dark_mode_switch.php" method="post" novalidate>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input theme-checkbox" id="darkModeSwitch" name="darkModeSwitch" <?php echo $_SESSION["darkMode"] ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="darkModeSwitch"><?php echo $_SESSION["nepaliMode"] ? 'डार्क मोड' : 'Dark Mode'; ?></label>
                    </div>
                </form>
            </li>
            <li class="list-group-item">
                <h4><?php echo $_SESSION["nepaliMode"] ? 'भाषा' : 'Language'; ?></h4>
                <form class="language-switch-form" action="./language_switch.php" method="post" novalidate>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input language-switch-checkbox" id="updateLangMode" name="updateLangMode" <?php echo $_SESSION["nepaliMode"] ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="updateLangMode"><?php echo $_SESSION["nepaliMode"] ? 'नेपाली' : 'Nepali'; ?> (🇳🇵)</label>
                    </div>
                </form>
            </li>
            <li class="list-group-item">
                <h4><?php echo $_SESSION["nepaliMode"] ? 'फन्ट साइज' : 'Font Size'; ?></h4>
                <!-- Dark mode switch -->
                <form class="font-size-form" action="./update_font_size.php" method="post" novalidate>
                    <div class="mb-3">
                        <label for="font-size" class="form-label"><?php echo $_SESSION["nepaliMode"] ? 'फन्ट साइज परिवर्तन गर्नुहोस्' : 'Change Font Size'; ?></label>
                        <input type="number" name="updateFontSize" class="form-control" id="font-size" placeholder="11" value="<?php echo $_SESSION["fontSize"] ? $_SESSION["fontSize"] : ''; ?>">
                    </div>
                    <input type="submit" value="<?php echo $_SESSION["nepaliMode"] ? 'पेश गर्नुहोस्' : 'Submit'; ?>" />
                </form>
            </li>
        </ul>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/main.js"></script>

</html>