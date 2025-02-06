<?php
session_start();

// Clear the cart explicitly
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);

}

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: login.html");
exit();
?>
