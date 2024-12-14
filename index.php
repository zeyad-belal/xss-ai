<?php
require_once 'xss_checker.php';

$result = null;
$input = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input'])) {
    $input = $_POST['input'];
    $result = validateInput($input);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Vulnerability Scanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
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
                    <h2>Scan Results:</h2>
                    <?php if (isset($result['error'])): ?>
                        <div class="error">Error: <?php echo htmlspecialchars($result['error']); ?></div>
                    <?php else: ?>
                        <div class="result <?php echo $result['is_xss'] ? 'danger' : 'safe'; ?>">
                            <p>Status: <?php echo $result['is_xss'] ? 'Potential XSS Detected!' : 'Safe'; ?></p>
                            <p>Confidence: <?php echo number_format($result['confidence'] * 100, 2); ?>%</p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <?php include 'footer.php'; ?>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
