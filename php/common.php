<?php


function isValidLetter($letter)
{
	return is_array($letter) ? false : true;
}
function isValidalpha($letter)
{
	if(is_array($letter)){return false;}
	return preg_match("/^[A-Za-z]$/", $letter) ? true : false;
}


function isValidWord($word)
{
	return is_array($word) ? false : true;
}

function replaceHeadings($xmlVal)
{
	$xmlVal = preg_replace('/<strong>(.*)<\/strong>/', "<span class=\"boldText\">$1</span>", $xmlVal);
	$xmlVal = preg_replace('/<h1>(.*)<\/h1>/', "<p class=\"normalText\">$1</p>", $xmlVal);
	$xmlVal = preg_replace('/<h2>(.*)<\/h2>/', "<p class=\"italicText\">$1</p>", $xmlVal);
	$xmlVal = preg_replace('/<p type="poem">(.*)<\/p>/', "<p class=\"poem\">$1</p>", $xmlVal);
	$xmlVal = preg_replace('/<h3>(.*)<\/h3>/', "<p class=\"italicBold\">$1</p>", $xmlVal);
	$xmlVal = preg_replace_callback('/<ref href="(.*?)">(.*?)<\/ref>/', "EncodeAndLower", $xmlVal);
	return($xmlVal);
}
function EncodeAndLower($paraMeters)
{
	$tmp = $paraMeters[1];
	if($paraMeters[1] == '')
	{
		$tmp = "<a class=\"refWord\" href=#\">". $paraMeters[0]. "</a>";
	}
	else
	{

		//$tmp = strtolower($tmp);
		$tmp = preg_replace('/Ā/','ā',$tmp);
		$tmp = preg_replace('/Ś/','ś',$tmp);
		$tmp = preg_replace('/Ū/','ū',$tmp);
		$tmp = preg_replace('/Ṣ/','ṣ',$tmp);
		$tmp = preg_replace('/Ī/','ī',$tmp);
		$tmp = preg_replace('/Ṅ/','ṅ',$tmp);
		$tmp = preg_replace('/Ṛ/','ṛ',$tmp);
		$tmp = preg_replace('/Ṭ/','ṭ',$tmp);
		$tmp = preg_replace('/Ṇ/','ṇ',$tmp);
		$tmp = preg_replace('/Ḍ/','ḍ',$tmp);
		$tmp = preg_replace('/Ṁ/','ṁ',$tmp);
		$tmp = preg_replace('/Ñ/','ñ',$tmp);
		$tmp = preg_replace('/Ḥ/','ḥ',$tmp);
		$tmp = preg_replace('/Ḷ/','ḷ',$tmp);
		$tmp = preg_replace('/Ṝ/','ṝ',$tmp);
		$tmp = "<a class=\"refWord\" href=\"displayword.php?word=" . $tmp . "\">". $paraMeters[0]. "</a>";
	}
	return $tmp;
}

?>
