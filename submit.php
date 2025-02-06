<?php
include 'db.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preia datele din formular
    $nume = $_POST['name'];
    $prenume = $_POST['prenume'];
    $email = $_POST['email'];
    $nrTelefon = $_POST['phone'];
    $parola = $_POST['password'];
    $confirmParola = $_POST['confirm-password'];

    // Verifică dacă parolele se potrivesc
    if ($parola !== $confirmParola) {
        echo "Parolele nu se potrivesc!";
        exit();
    }

    // Criptează parola
    $parolaCriptata = password_hash($parola, PASSWORD_BCRYPT);

    // Verifică dacă emailul nu există deja
    $sql = "SELECT * FROM utilizatori WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Există deja un cont cu acest email!";
    } else {
        // Inserare utilizator nou în baza de date
        $sql = "INSERT INTO utilizatori (nume, prenume, email, nr_telefon, parola) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nume, $prenume, $email, $nrTelefon, $parolaCriptata);
        
        if ($stmt->execute()) {
            echo "Contul a fost creat cu succes!";
            // Poți redirecționa utilizatorul către pagina de login, de exemplu:
            header("Location: order.php");
            exit();
        } else {
            echo "Eroare la crearea contului: " . $conn->error;
        }
    }
}
?>
