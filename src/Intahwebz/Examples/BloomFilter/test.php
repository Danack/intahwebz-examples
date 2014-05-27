<?php

//echo phpinfo();

$isLoaded = extension_loaded("bitset");

echo "isLoaded = $isLoaded";

exit(0);


//http://pecl.php.net/package/Bitset

//initialize the bloom filter
$bf = new BloomFilter(3000000);

$f = fopen('/usr/share/dict/words','r');
while(!feof($f)) $bf->add(trim(fgets($f)));

//write the bit field to file for later use
file_put_contents('bloom',$bf->field);


//initialize the bloom filter from file
$bf = BloomFilter::init(file_get_contents('bloom'));

//test some membership queries
$test_words = array('this','library','does','bloom','filters','in','php');

foreach ($test_words as $word) if ($bf->has($word)) echo $word."\n";




?> 