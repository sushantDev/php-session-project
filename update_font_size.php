<?php

# Initialize the session
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["updateFontSize"])) {
        $_SESSION["fontSize"] = $_POST["updateFontSize"];
        header("Location: preferences.php");
        exit();
    } else {
        header("Location: preferences.php");
        exit();
    }
} else {
    header("Location: index.php");
}
