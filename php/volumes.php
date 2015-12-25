<?php include("include_header.php");?>
<main class="cd-main-content">
        <div class="cd-scrolling-bg cd-color-2">
            <div class="cd-container">
<?php

include("connect.php");
require_once("common.php");
if(isset($_GET['vnum'])){$vnum = $_GET['vnum'];}else{$vnum = '';}

if(!(isValidVolume($vnum)))
{
	exit(1);
}
$query = "select * from EOH where vnum = '$vnum' order by word";

$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;
$footNote = '';
echo '<h1 class="clr1 gapBelowSmall">Volume : ' . $vnum . '</h1>';
if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$mng = $row['text'];
		$id = $row['entry_id'];
		$word = $row['word'];
		#$vnum = $row['vnum'];
		
		$xmlObj=simplexml_load_string($mng);
		$figNum = $word;
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
		$fig = $xmlObj->description->figure;
		
		foreach ($xmlObj->description->children() as $child)
		{
			$xmlVal = $child->asXML();
			$xmlVal = replaceHeadings($xmlVal);

			if(preg_match('#<aside>(.*?)<\/aside>#', $xmlVal, $match))
			{
				$xmlVal = preg_replace('/<aside>(.*)<\/aside>/', "<span class=\"fntsymbol\">*</span>", $xmlVal);
				echo $xmlVal;
				$footNote = $match[1];
			}
			elseif(preg_match('#<figure>#', $xmlVal, $match))
			{
				$f = 1;
				$count = count($fig);
				if($count > 1)
				{
					if($figNum <= $count)
					{
						$figNum = $figNum + $f;
						echo "<span class='crossref'><a href='img/thumbs/$word"."_".$figNum.".png' data-lightbox='imgae-".$id."' data-title='". $xmlObj->head->word . "'><img src='img/main/$word"."_".$figNum.".png' alt='Figure:" . $xmlObj->head->word . "' /></a></span><br />";
						echo $xmlVal;
					}
					$f++;
				}
				else
				{
					echo "<span class='crossref'><a href='img/thumbs/$word.png' data-lightbox='imgae-".$id."' data-title='". $xmlObj->head->word . "'><img src='img/main/$word.png' alt='Figure:" . $xmlObj->head->word . "' /></a></span><br />";
					echo $xmlVal;
				}
			}
			else
			{
				echo $xmlVal;
			}
			
		}
		if($footNote != '')
		{
			echo "<div class=\"FootNote\">";
			foreach ($xmlObj->description->children() as $child)
			{
				$xmlVal = $child->asXML();
				if(preg_match('#<aside>(.*?)<\/aside>#', $xmlVal, $match))
				{
					echo "<div><span class=\"fntsymbol\">*</span>$match[1]</div>";
				}
			}
			echo '</div>';
		}
		$footNote = '';
		echo '</div>';
		echo '</div>';
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