<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['utilizator_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Retrieve cart data from the session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id = "header" >
        <a href ="index.html"><img src="images/logo.png" class="logo" alt=""></a>
        <div>
            <ul id = "navbar">
                <li><a class="active" href="index.html">Home</a></li>
                <li><a href="shop.html">Shop</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <div style="position: relative;" >
                <li id="lg-bag" style="display: inline;">
                    <a href="cart.html"><i class="fas fa-shopping-cart"></i></a>
                    <span class="cart-count" id="cart-count">0</span>
                </li>
                </div>
                <a href="#" id="close"><i class="fa-solid fa-square-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.html"><i class="fas fa-shopping-cart"></i></a>
            <i id="bar" class="fas fa-outdent"></i> 
        </div>
    </section>
    <br><br>
    <h1 style ="margin-top: 20px" >Bine ai venit, <?php echo htmlspecialchars($_SESSION['nume']); ?>!</h1><br>

    <h2>Cosul tau</h2>
    <br><br>
    <?php if (!empty($cartItems)): ?>
        <table border="1">
            <tr>
                <th>Produs</th>
                <th>Mărime</th>
                <th>Cantitate</th>
                <th>Pret</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $total = 0;
            foreach ($cartItems as $item): 
                $subtotal = $item['quantity'] * $item['price'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['size']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo number_format($subtotal, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br><br>
        <h3>Total: <?php echo number_format($total, 2); ?></h3>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>

    <br> <br>
    <h2 style="text-align:center">Detaliile comenzii</h2>
    <section id = "inregistrare">
    <div class="container">
    <form action="submit_order.php" method="POST">
        <label for="address">Adresa:</label><br>
        <input type="text" id="address" name="address" required><br>

        <br><br>
        <label for="payment">Metoda de plata:</label><br><br>
        <select id="payment" name="payment" required>
            <option value="credit_card">Card de credit</option>
            <option value="paypal">PayPal</option>
            <option value="cash_on_delivery">Ramburs</option>
        </select><br>

        <br><br>
        <label for="delivery">Metoda de livrare:</label><br><br>
        <select id="delivery" name="delivery" required>
            <option value="standard">Standard (FAN Courier)</option>
            <option value="express">Pickup Point</option>
        </select><br>

        <input type="hidden" name="total" value="<?php echo number_format($total, 2); ?>">

        <button type="submit">Trimite comanda!</button>
    </form>
    </div>
    </section>
    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="images/logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Adresa:</strong> Strada 9 Mai, nr.512, Brașov </p>
            <p><strong>Ore:</strong> 10:00 - 18:00, Luni-Vineri </p>
            <div class="follow">
                <h4>Urmărește-ne</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-twitter"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>Despre</h4>
            <a href="#">Despre noi</a>
            <a href="#">Informații despre livrare</a>
            <a href="#">Politica de confidențialitate</a>
            <a href="#">Termeni și condiții</a>
            <a href="#">Contactează-ne</a>
        </div>

        <div class="col">
            <h4>Contul Meu</h4>
            <a href="#">Înregistează-te</a>
            <a href="#">Vezi coșul</a>
            <a href="#">Lista de favorite</a>
            <a href="#">Urmărește comanda</a>
            <a href="#">Ajutor</a>
        </div>

        <div class="col install">
            <h4>Instalează aplicația</h4>
            <p>De pe App Store sau Google Play</p>
            <div class="row">
                <img src="images/app-store-badge.png" alt="">
                <img src="images/images.png" alt="">
            </div>
            <p>Plată securizată</p>
            <img src="images/pay.jpg" alt="">
        </div>

        <div class="copyright">
            <p>© 2024, Irina Popa - PureLines Online Shop</p>
        </div>
    </footer>
    <script src = "cart.js"></script> 
</body>
</html>
