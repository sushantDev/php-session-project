<?php
# Include connection
require_once "./config.php";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $err = "";
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $newPass = $_POST['new_password'];

    $email_exists_sql = "SELECT * FROM `password_change_request` WHERE email = '$email' ORDER BY id DESC LIMIT 1";
    // var_dump($email_exists_sql);
    // die();
    $result = $link->query($email_exists_sql);

    if ($result->num_rows > 0) {
        $lastRow = $result->fetch_assoc();

        if ($lastRow['otp'] == $otp) {
            $newPassword = password_hash($newPass, PASSWORD_DEFAULT);

            $update_password_sql = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
            if ($link->query($update_password_sql) === TRUE) {
                echo "<script>" . "alert('Password updated successfully. Login to continue.');" . "</script>";
                echo "<script>" . "window.location.href='./login.php';" . "</script>";
                exit;
            } else {
                $err = 'Error updating password!';
            }

            $link->close();
        } else {
            $err = 'You have entered incorrect OTP!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
    <script defer src="./js/script.js"></script>
</head>

<body>
    <div class="container">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-lg-5">
                <?php
                if (!empty($err)) {
                    echo "<div class='alert alert-danger'>" . $err . "</div>";
                }
                ?>
                <div class="form-wrap border rounded p-4">
                    <h1>Reset Password</h1>
                    <p>You can reset your password here.</p>
                    <!-- form starts here -->
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input type="text" class="form-control" name="otp" id="otp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="text" class="form-control" name="new_password" id="password">
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-primary form-control" name="submit" value="Submit">
                        </div>
                    </form>
                    <!-- form ends here -->
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/main.js"></script>

</html>