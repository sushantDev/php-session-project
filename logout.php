<?php
# Initialize the session
session_start();

# Unset all session variables
$_SESSION = array();

# Regenerate the session ID
session_regenerate_id(true);

# Destroy the session
session_destroy();

# Redirect to login page
echo "<script>" . "window.location.href='./login.php';" . "</script>";
exit;
