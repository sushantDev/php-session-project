<?php

# Initialize the session
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["updateLangMode"])) {
        $_SESSION["nepaliMode"] = true;
        header("Location: preferences.php");
        exit();
    } else {
        $_SESSION["nepaliMode"] = false;
        header("Location: preferences.php");
        exit();
    }
} else {
    header("Location: index.php");
}
