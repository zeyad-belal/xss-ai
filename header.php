<?php
require_once 'xss_checker.php';

// Initialize session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to check if a string contains XSS
function checkForXSS($input) {
    return validateInput($input);
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
