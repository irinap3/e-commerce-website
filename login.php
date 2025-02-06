<?php
session_start();
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $email = $conn->real_escape_string($_POST['email']);
    $parola = $_POST['parola']; // No need to escape password for password_verify

    // Query to check if the user exists
    $stmt = $conn->prepare("SELECT * FROM utilizatori WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists and password is correct
    if ($user && password_verify($parola, $user['parola'])) {
        // Set session variables for the logged-in user
        $_SESSION['utilizator_id'] = $user['id'];
        $_SESSION['nume'] = $user['nume'];

        // Transfer cart data from localStorage to the session
        if (!empty($_POST['cart'])) {
            $_SESSION['cart'] = json_decode($_POST['cart'], true);
        }

        // Redirect to the order page
        header("Location: order.php");
        exit();
    } else {
        // Invalid email or password
        echo "Email sau parolă incorecte!";
    }

    // Close the prepared statement
    $stmt->close();
}
?>
