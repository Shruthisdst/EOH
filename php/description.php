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
$footNote = '';
if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$mng = $row['text'];
		$id = $row['entry_id'];
		$word = $row['word'];
		
		$xmlObj=simplexml_load_string($mng);
		
		echo '<div class="word">';
		echo '<div class="whead">';
		//echo "<span class='crossref'><a href='img/thumbs/abhayahasta.png' data-lightbox='imgae-".$id."' data-title='". $xmlObj->head->word . "'><img src='img/main/abhayahasta.png' alt='Figure:" . $xmlObj->head->word . "' /></a></span><br />";
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
		echo '<div class="grammarLabel">';
		foreach ($xmlObj->head->note as $note)
		{
			if($note != '')
			{
				echo '<span>'.$note.'</span>';
			}
			else
			{
				echo '<span></span>';
			}
		}
		echo '</div>';
		echo '<div class="wBody">';
		foreach ($xmlObj->description->children() as $child)
		{
			$xmlVal = $child->asXML();
			$xmlVal = replaceHeadings($xmlVal);
			//$xmlVal = preg_replace('/<aside>(.*)<\/aside>/', "*", $xmlVal);
			if(preg_match('#<figure>#', $xmlVal, $match))
			{
				echo "<span class='crossref'><a href='img/thumbs/$word.png' data-lightbox='imgae-".$id."' data-title='". $xmlObj->head->word . "'><img src='img/main/$word.png' alt='Figure:" . $xmlObj->head->word . "' /></a></span><br />";
			}
			if(preg_match('#<aside>(.*?)<\/aside>#', $xmlVal, $match))
			{
				$xmlVal = preg_replace('/<aside>(.*)<\/aside>/', "<span class=\"fntsymbol\">*</span>", $xmlVal);
				echo $xmlVal;
				$footNote = $match[1];
			}
			else
			{
				echo $xmlVal;
			}
		}
		if($footNote != '')
		{
			echo "<div class=\"FootNote\"><span class=\"fntsymbol\">*</span>$footNote</div>";
		}
		echo '</div>';
		//echo '<div class="wBody">'. $xmlObj->description->asXML() . '</div>';
		echo '</div>';
		$footNote = '';
	}
}

if($result){$result->free();}
$db->close();

?>
				</div>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
