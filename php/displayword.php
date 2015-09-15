<?php include("include_header.php");?>
<main class="cd-main-content">
		<div class="cd-scrolling-bg cd-color-2">
			<div class="cd-container">
<?php

include("connect.php");
require_once("common.php");

if(isset($_GET['word'])){$word = $_GET['word'];}else{$word = '';}

if(!(isValidWord($word)))
{
	exit(1);
}

$query = "select * from  EOH where word = '$word'";
$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;
if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$mng = $row['text'];
		
		$xmlObj=simplexml_load_string($mng);
		
		echo '<div class="word">';
		echo '<div class="whead">';
		echo '<span class="engWord clr1">'.$xmlObj->head->word;
		foreach ($xmlObj->head->alias as $alias)
		{
			if($alias != '')
			{
				echo ', ' . $alias;
			}
		}
		echo '</span>';
		echo '</div>';
		
		foreach ($xmlObj->head->note as $note)
		{
			echo '<div class="grammarLabel">';
			if($note != '')
			{
				echo '<span>'.$note.'</span>';
			}
			else
			{
				echo '<span></span>';
			}
			echo '</div>';
		}
		echo '<div class="wBody">';
		foreach ($xmlObj->description->children() as $child)
		{
			$xmlVal = $child->asXML();
			$xmlVal = preg_replace('/<subhead>(.*)<\/subhead>/', "<p class=\"subhead\">$1</p>", $xmlVal);
			$xmlVal = preg_replace_callback('/<ref>(.*?)<\/ref>/', "EncodeAndLower", $xmlVal);
			echo $xmlVal;
			
		}
		echo '</div>';
		//echo '<div class="wBody">'. $xmlObj->description->asXML() . '</div>';
		
		echo '</div>';
	}
}
else
{
	echo "<br />No data in the database";
}

if($result){$result->free();}
$db->close();

function EncodeAndLower($paraMeters)
{
	$tmp = $paraMeters[1];
	$tmp = strtolower($tmp);
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
	$tmp = "<a href=\"displayword.php?word=" . $tmp . "\">". $paraMeters[1]. "</a>";
	return $tmp;
}

?>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
