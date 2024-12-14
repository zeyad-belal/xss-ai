<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header">
    <a href="index.php" class="logo">Rana's Security Scanner</a>
    <nav class="navbar">
        <a href="index.php">home</a>
        <a href="about.php">about</a>
        <a href="pricing.php">pricing</a>
        <a href="contact.php">contact</a>
    </nav>
</header>
