<?php
// Include database connection
include 'db.php';

// Path to the JSON file
$jsonFilePath = 'products.json';

// Read and decode JSON file
$jsonData = file_get_contents($jsonFilePath);
$products = json_decode($jsonData, true);

if ($products === null) {
    die("Error decoding JSON file.");
}

// Prepare SQL insert query
$stmt = $conn->prepare("INSERT INTO produse (nume, descriere, pret, imagine, categorie) VALUES (?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("MySQL prepare error: " . $conn->error);
}

// Loop through each product and insert into database
foreach ($products as $product) {
    $categorie = $product['category'];
    $nume = $product['name'];
    $pret = str_replace(' RON', '', $product['price']); // Remove 'RON' and convert to numeric
    $pret = floatval($pret);
    $descriere = $product['description'];
    $imagine = $product['images'][0]; // Use the first image as the main image

    // Bind and execute
    $stmt->bind_param("ssdss", $nume, $descriere, $pret, $imagine, $categorie);
    $stmt->execute();
}

// Close statement and connection
$stmt->close();
$conn->close();

echo "Products imported successfully!";
?>