<?php

$message = "yoo, de data asta sper da merge.";

$numere = [5, 12, 7, 18, 3, 25, 14, 9, 22, 11];
$contorPare = 0;
$contorImpare = 0;

for ($i = 0; $i < count($numere); $i++) {
	$num = $numere[$i];
	if ($num % 2 == 0) {
		$contorPare++;
	} else {
		$contorImpare++;
	}
}

if (php_sapi_name() === 'cli') {
	echo $message . PHP_EOL;
	echo "Numere pare: $contorPare" . PHP_EOL;
	echo "Numere impare: $contorImpare" . PHP_EOL;
	echo "Total numere: " . ($contorPare + $contorImpare) . PHP_EOL;
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
		h1 { color: #d4b0de; }
		pre { text-align: left; display: inline-block; }
	</style>
</head>
<body>
	<h1><?= $message ?></h1>
	<pre>
Numere pare: <?= $contorPare ?>
Numere impare: <?= $contorImpare ?>
Total numere: <?= $contorPare + $contorImpare ?>
	</pre>

	<script>
		console.log("<?= addslashes($message) ?>");
		console.log("Numere pare: <?= $contorPare ?>");
		console.log("Numere impare: <?= $contorImpare ?>");
		console.log("Total numere: <?= $contorPare + $contorImpare ?>");
	</script>
</body>
</html>
<?php
}
