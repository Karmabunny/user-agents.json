<?php
/**
* Simple little tester for hthe UserAgentsJson class.
* Outputs results in TAP version 13 format.
**/

error_reporting(E_ALL);
require 'UserAgentsJson.php';


// Load tests
$tests = array();
foreach(glob('../../tests/*.json') as $filename) {
	$json = file_get_contents($filename);
	if (!$json) die('Tests file ' . $filename . ' is empty');

	$json = @json_decode($json, true);
	if (!$json) die('Tests file ' . $filename . ' is invalid');

	$tests = array_merge($tests, $json);
}

$agents = new UserAgentsJson('../../data/user-agents.json');

// Run tests
$out = "TAP version 13" . PHP_EOL;
$out .= "1.." . count($tests) . PHP_EOL;
foreach ($tests as $idx => $test) {
	$idx++;
	$ua = $test['ua'];
	unset($test['ua']);

	$got = $agents->getInfo($ua);

	ksort($got);
	ksort($test);

	if ($got === $test) {
		$out .= "ok {$idx} - {$ua}" . PHP_EOL;
	} else {
		$out .= "not ok {$idx} - {$ua}" . PHP_EOL;
		$out .= " ---" . PHP_EOL;
		$out .= " got:" . PHP_EOL; 
		foreach ($got as $key => $val) {
			$out .= "   {$key}: {$val}" . PHP_EOL;
		}
		$out .= " expected:" . PHP_EOL; 
		foreach ($test as $key => $val) {
			$out .= "   {$key}: {$val}" . PHP_EOL;
		}
		$out .= " ..." . PHP_EOL;
	}
}
echo $out;

