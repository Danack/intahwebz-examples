<?php


function getLinesFromFile($fileName) {
	if (!$fileHandle = fopen($fileName, 'r')) {
		return;
	}

	while (false !== $line = fgets($fileHandle)) {
		yield $line;
    }

	fclose($fileHandle);
}

$lines = getLinesFromFile($fileName);

foreach ($lines as $line) {
	// do something with $line
}


?>