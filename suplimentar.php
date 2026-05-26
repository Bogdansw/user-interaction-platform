<?php

$message = "yoo, script is running ";

if (php_sapi_name() === 'cli') {
    echo $message . PHP_EOL;
    echo "Scriptul rulează în terminal." . PHP_EOL;
} else {
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mesaj</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            padding: 50px; 
        }
        h1 { color: #0066cc; }
    </style>
</head>
<body>
    <h1><?= htmlspecialchars($message) ?></h1>
    <p>Scriptul rulează ca aplicație web.</p>

    <script>
        console.log("<?= addslashes($message) ?>");
        console.log("Scriptul rulează ca aplicație web.");
    </script>
</body>
</html>
<?php
}