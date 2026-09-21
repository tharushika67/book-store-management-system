<?php

session_start();

// Destroy all sessions
session_destroy();

// Redirect to homepage
header("Location: ../index.php");

exit();

?>