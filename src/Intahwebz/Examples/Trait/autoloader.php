<?php


function classLoader($className) {
	$classPaths = array(
		$className.'.php'
	);

	foreach ($classPaths as $file) {
		if (file_exists($file)) {
			require_once($file);
			return true;
		}
	}

	return false;
}

spl_autoload_register('classLoader');


?>