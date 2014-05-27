<?php
require('BloomFilter.php');

function getRandomString($length) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz';
    $s = '';
    for ($i = 0; $i < $length; $i++){
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand($seed);
        $s .= $alphabet[mt_rand(0,25)];
    }
    return $s;
}


$bf = new BloomFilter(3000000);

$f = fopen('/usr/share/dict/words','r');
while(!feof($f)) $bf->add(trim(fgets($f)));

file_put_contents('bloom', $bf->field);




/*
$bf = BloomFilter::init(file_get_contents('bloom'));
echo $bf->len."\n";

$test_words = array('this','library','does','bloom','filters','in','php');

foreach ($test_words as $word) if ($bf->has($word)) echo $word."\n";

//*/



/*
$bf = BloomFilter::init(file_get_contents('bloom'));
while (++$i<=10000) {
        $word =         getRandomString(8);
        if ($bf->has($word)) echo $word."\n";
}

//*/


/*
$bf = BloomFilter::init(file_get_contents('bloom'));
echo $bf->falsePositiveRate(95000)."\n";
//*/
?>