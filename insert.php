<?php
$host = $argv[1];
$database = $argv[2];
$user = $argv[3];
$password = $argv[4];
libxml_use_internal_errors(true);

//table structure
//entry_id, word, text

$db = mysql_connect($host, $user, $password) or die("Not connected to database");
$rs = mysql_select_db($database, $db) or die("No Database");
mysql_query("set names utf8");
mysql_query("DROP TABLE IF EXISTS EOH");
mysql_query("CREATE TABLE EOH (entry_id int(5) auto_increment, primary key(entry_id), vnum int(5), word varchar(1000), text varchar(200000))auto_increment=10001 ENGINE=MyISAM character set utf8 collate utf8_general_ci");
$myXMLData ="eoh.xml";

$xml = simplexml_load_file($myXMLData);
if ($xml === false) 
{
	echo "Failed loading XML: ";
	foreach(libxml_get_errors() as $error) 
	{
		echo "<br>", $error->message;
	}
} 
else 
{
	foreach ($xml->volume as $volume)
	{
		$vnum = $volume['vnum'];
		foreach ($volume->entry as $entry)
		{
			$word = addslashes($entry->head->word);
			#echo "\n" . $text . "\n";
			$text = addslashes($entry->asXML());
			#echo $desc . "\n";
		
			$query = "INSERT INTO EOH VALUES('', '$vnum', '$word', '$text')";
			mysql_query($query) or die("Query Problem" . mysql_error() . "\n");
		}

	}
}
?>


