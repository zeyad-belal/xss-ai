<?php
require_once '../xss_checker.php';

$result = null;
$input = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input'])) {
    $input = $_POST['input'];
    $result = validateInput($input);
    
    // If it's an AJAX request, only return the result container
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        if ($result) {
            echo '<div class="result-container">';
            if (isset($result['error'])) {
                echo '<div class="error">Error: ' . htmlspecialchars($result['error']) . '</div>';
            } else {
                echo '<div class="result ' . ($result['is_xss'] ? 'danger' : 'safe') . '">';
                echo '<p>Status: ' . ($result['is_xss'] ? 'Potential XSS Detected!' : 'Safe') . '</p>';
                echo '<p>Confidence: ' . number_format($result['confidence'] * 100, 2) . '%</p>';
                if (!empty($result['matches'])) {
                    echo '<p>Detected patterns:</p>';
                    echo '<ul>';
                    foreach ($result['matches'] as $pattern) {
                        echo '<li>' . htmlspecialchars($pattern) . '</li>';
                    }
                    echo '</ul>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Vulnerability Scanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div id="menu-btn" class="fas fa-bars"></div>
        
        <?php include 'header.php'; ?>

        <section class="scanner">
            <h1 class="heading">XSS Vulnerability Scanner</h1>
            
            <div class="scanner-container">
                <form method="POST" action="">
                    <textarea name="input" placeholder="Enter text to scan for XSS vulnerabilities..." required><?php echo htmlspecialchars($input); ?></textarea>
                    <button type="submit" class="btn">Scan for XSS</button>
                </form>

                <?php if ($result): ?>
                <div class="result-container">
                    <?php if (isset($result['error'])): ?>
                        <div class="error">Error: <?php echo htmlspecialchars($result['error']); ?></div>
                    <?php else: ?>
                        <div class="result <?php echo $result['is_xss'] ? 'danger' : 'safe'; ?>">
                            <p>Status: <?php echo $result['is_xss'] ? 'Potential XSS Detected!' : 'Safe'; ?></p>
                            <p>Confidence: <?php echo number_format($result['confidence'] * 100, 2); ?>%</p>
                            <?php if (!empty($result['matches'])): ?>
                                <p>Detected patterns:</p>
                                <ul>
                                    <?php foreach ($result['matches'] as $pattern): ?>
                                        <li><?php echo htmlspecialchars($pattern); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <?php include 'footer.php'; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
