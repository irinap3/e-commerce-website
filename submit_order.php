<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['utilizator_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve user input
    $userId = $_SESSION['utilizator_id'];
    $adresa = $conn->real_escape_string($_POST['address']);
    $modulPlata = $conn->real_escape_string($_POST['payment']);
    $modulLivrare = $conn->real_escape_string($_POST['delivery']);
    $total = floatval($_POST['total']);
    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    // Check if the cart is empty
    if (empty($cartItems)) {
        echo "Coșul este gol. Vă rugăm să adăugați produse înainte de a plasa comanda.";
        exit();
    }

    // Insert into `comenzi` table
    $stmt = $conn->prepare("INSERT INTO comenzi (id_utilizator, data_comanda, status, adresa, modul_plata, modul_livrare, total) VALUES (?, NOW(), 'în procesare', ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $userId, $adresa, $modulPlata, $modulLivrare, $total);
    $stmt->execute();

    // Get the ID of the newly created order
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Insert into `detalii_comanda` table
    $stmt = $conn->prepare("INSERT INTO detalii_comanda (id_comanda, id_produs, cantitate, pret,marime) VALUES (?, ?, ?, ?,?)");
    foreach ($cartItems as $item) {
        $idProdus = $item['id'];
        $cantitate = $item['quantity'];
        $pret = $item['price'];
        $marime = $item['size'];
        $stmt->bind_param("iiids", $orderId, $idProdus,$cantitate, $pret,$marime);
        $stmt->execute();
    }
    $stmt->close();

    // Clear the cart from the session
    unset($_SESSION['cart']);

    // Redirect to the success page
    header("Location: order_success.php");
    exit();
} else {
    header("Location: order.php"); // Redirect to order page if accessed directly
    exit();
}
?>
