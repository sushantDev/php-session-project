<?php

# Initialize the session
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the 'darkModeSwitch' checkbox was submitted
    // var_dump($_POST);
    // die();
    if (isset($_POST["darkModeSwitch"])) {
        $_SESSION["darkMode"] = true;
        header("Location: preferences.php");
        exit();
    } else {
        $_SESSION["darkMode"] = false;
        header("Location: preferences.php");
        exit();
    }
} else {
    header("Location: index.php");
}
