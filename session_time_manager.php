<?php

# Initialize the session
# session_start();

# Check if the session has a last activity time
if (isset($_SESSION['last_activity'])) {
    # Defining the time interval for session regeneration
    $regeneration_interval = 1800; # 30 minutes in seconds

    # Defining the idle timeout for session expiration
    $idle_timeout = 3600; # 1 hour in seconds

    # Get the current time
    $current_time = time();

    # Calculate the time difference since the last activity
    $time_diff = $current_time - $_SESSION['last_activity'];

    # If the time difference exceeds the interval, regenerate the session ID
    if ($time_diff > $regeneration_interval) {
        session_regenerate_id(true);
    }

    # If the time difference exceeds the idle timeout, destroy the session and log out the user
    if ($time_diff > $idle_timeout) {
        # Redirect to the logout page
        header("Location: logout.php");
        exit();
    }
}

# Update the last activity time to the current time
$_SESSION['last_activity'] = time();
