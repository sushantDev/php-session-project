<?php
# Initialize the session
session_start();

// Regenerate the session ID
session_regenerate_id(true);

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
            <a class="nav-link" href="./index.php"><?php echo $_SESSION["nepaliMode"] ? 'होम' : 'Home'; ?> <span class="sr-only">(<?php echo $_SESSION["nepaliMode"] ? 'वर्तमान' : 'current'; ?>)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./preferences.php"><?php echo $_SESSION["nepaliMode"] ? 'प्राथमिकताहरू' : 'Preferences'; ?></a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="alert alert-success my-5">
      <?php echo $_SESSION["nepaliMode"] ? 'स्वागत छ! तपाईं अब आफ्नो खातामा साइन इन हुनुहुन्छ।' : 'Welcome ! You are now signed in to your account.'; ?>
    </div>
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
  </div>
</body>

</html>