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


?>
