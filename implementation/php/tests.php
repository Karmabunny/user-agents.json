<?php
/**
* Simple little tester for hthe UserAgentsJson class.
* Outputs results in TAP version 13 format.
**/

error_reporting(E_ALL);
require 'UserAgentsJson.php';


// List tests here
$tests = array(
	array(
		'ua' => 'Mozilla/5.0 (Linux; U; Android 4.0.3; de-de; Galaxy S II Build/GRJ22) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
		'on' => 'Android',          'ov' => '4.0.3',
		'bn' => 'Android Browser',  'bv' => '4.0',
		'dc' => 'Mobile',
	),
	array(
		'ua' => 'Mozilla/5.0 (Linux; Android 4.2.2; SM-T310 Build/JDQ39) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.82',
		'on' => 'Android',          'ov' => '4.2.2',
		'bn' => 'Chrome',           'bv' => '30.0.1599.82',
		'dc' => 'Tablet',
	),
	array(
		'ua' => 'Mozilla/5.0 (X11; Linux i686 on x86_64; rv:35.0) Gecko/20100101 Firefox/35.0',
		'on' => 'Linux',
		'bn' => 'Firefox',  'bv' => '35.0',
		'dc' => 'Desktop',
	),
	array(
		'ua' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko',
		'on' => 'Windows',            'ov' => '6.1',
		'bn' => 'Internet Explorer',  'bv' => '11.0',
		'dc' => 'Desktop',
	),
	array(
		'ua' => 'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)',
		'on' => 'Windows Phone',      'ov' => '7.5',
		'bn' => 'Internet Explorer',  'bv' => '9.0',
		'dc' => 'Mobile',
	),
);


$agents = new UserAgentsJson('../../data/user-agents.json');

echo "TAP version 13", PHP_EOL;
echo "1.." . count($tests), PHP_EOL;
foreach ($tests as $idx => $test) {
	$idx++;
	$ua = $test['ua'];
	unset($test['ua']);
	
	$got = $agents->getInfo($ua);
	
	ksort($got);
	ksort($test);
	
	if ($got === $test) {
		echo "ok {$idx} - {$ua}", PHP_EOL;
	} else {
		echo "not ok {$idx} - {$ua}", PHP_EOL;
		echo " ---", PHP_EOL;
		echo " got:", PHP_EOL; 
		foreach ($got as $key => $val) {
			echo "   {$key}: {$val}", PHP_EOL;
		}
		echo " expected:", PHP_EOL; 
		foreach ($test as $key => $val) {
			echo "   {$key}: {$val}", PHP_EOL;
		}
		echo " ...", PHP_EOL;
	}
}

