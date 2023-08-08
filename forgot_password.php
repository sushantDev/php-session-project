<?php

require "./vendor/autoload.php";
require "./config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $err = "";
    $email = $_POST['email'];

    $email_exists_sql = "SELECT * FROM `users` WHERE email = '$email'";
    // var_dump($email_exists_sql);
    // die();
    $result = $link->query($email_exists_sql);

    if ($result->num_rows > 0) {
        // Generate a random 6-digit OTP
        $otp = sprintf('%06d', mt_rand(0, 999999));

        // Store OTP and email in the database
        $sql = "INSERT INTO password_change_request (email, otp) VALUES ('$email', '$otp')";
        $link->query($sql);

        $link->close();

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        # SMTP SERVICE START
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = '7486a712dc0640';                     //SMTP username
            $mail->Password   = '68a7ef2359ac3d';                               //SMTP password
            $mail->Port       = 587;                                 //TCP port to connect to; use 587 if you have set

            $mail->setFrom('anisha@gmail.com', 'My Assignment');
            $mail->addAddress($email, $email);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body    = 'Your OTP is: <b>' . $otp . '</b>';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            die();
        }

        // Redirect user to OTP verification and password reset page
        header("Location: password_reset.php");
        exit();
    } else {
        $err = "The email you have entered is not available in our database.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
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
                    <h1>Forget Password</h1>
                    <p>You can get OTP to reset your password here.</p>
                    <!-- form starts here -->
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <div class="mb-3">
                            <label for="user_login" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="user_login">
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-primary form-control" name="submit" value="Send OTP">
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