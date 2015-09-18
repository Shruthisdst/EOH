<?php include("include_header.php");?>
<main class="cd-main-content">
        <div class="cd-scrolling-bg cd-color-2">
            <div class="cd-container">
<?php

include("connect.php");
require_once("common.php");
if(isset($_GET['letter'])){$letter = $_GET['letter'];}else{$letter = '';}

if(!(isValidalpha($letter)))
{
	exit(1);
}
$query = "select * from EOH where word like '$letter%'";
$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$mng = $row['text'];
		$id = $row['entry_id'];
		
		$xmlObj=simplexml_load_string($mng);
		
		echo '<div class="word">';
		echo '<div class="whead">';
		foreach ($xmlObj->head->image as $image)
		{
			if($image != '')
			{
				
				echo "<span class='crossref'><a href='img/thumbs/$image' data-lightbox='imgae-".$id."' data-title='". $xmlObj->head->word . "'><img src='img/main/$image' alt='Figure:" . $xmlObj->head->word . "' /></a></span><br />";
			}

		}
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
				echo '</div>';
			}
			else
			{
				echo '<br /></div>';
			}
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
	$tmp = "<a class=\"refWord\" href=\"displayword.php?word=" . $tmp . "\">". $paraMeters[1]. "</a>";
	return $tmp;
}


?>
				
				</div>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
