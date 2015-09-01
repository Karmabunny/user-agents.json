<?php

/**
* Sample implementation of parser for user-agents.json file
**/
class UserAgentsJson
{
	private $rules;
	
	
	/**
	* Load the fules file
	*
	* @param string $filename Filename of the rules file to load
	**/
	public function __construct($filename)
	{
		$json = @file_get_contents($filename);
		if (!$json) die('Rules file missing or empty');

		$json = @json_decode($json);
		if (!$json) die('Rules file not valid json');

		$this->rules = $json;
	}


	/**
	* Return info about a given user-agent
	**/
	public function getInfo($ua)
	{
		// Extra space makes the regexes much simpler
		return $this->process(' ' . $ua . ' ', $this->rules);
	}


	/**
	* Internal recursive processing method
	**/
	private function process($ua, $rules)
	{
		$out = array();
	
		foreach ($rules as $obj) {
			if (! preg_match($obj->regex, $ua, $matches)) continue;

			if (isset($obj->on)) $out['on'] = $this->preg_inject($obj->on, $matches);
			if (isset($obj->ov)) $out['ov'] = $this->preg_inject($obj->ov, $matches);
			if (isset($obj->ot)) $out['ot'] = $this->preg_inject($obj->ot, $matches);
			if (isset($obj->bn)) $out['bn'] = $this->preg_inject($obj->bn, $matches);
			if (isset($obj->bv)) $out['bv'] = $this->preg_inject($obj->bv, $matches);
			if (isset($obj->dc)) $out['dc'] = $this->preg_inject($obj->dc, $matches);

			if (isset($obj->rules)) {
				$sub = $this->process($ua, $obj->rules);
				foreach ($sub as $key => $val) {
					$out[$key] = $val;
				}
			}
		}

		foreach ($out as $key => $val) {
			if (!$val) unset($out[$key]);
		}

		return $out;
	}


	/**
	* Replace values in a way similar to preg_replace
	**/
	function preg_inject($text, $matches)
	{
		foreach ($matches as $idx => $str) {
			$text = str_replace('$' . $idx , $str, $text);
		}
		return $text;
	}
}

