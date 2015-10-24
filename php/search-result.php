<?php include("include_header.php");?>
<main class="cd-main-content">
	<div class="cd-scrolling-bg cd-color-2">
		<div class="cd-container">
<?php

include("connect.php");

$searchWord = $_POST['word'];

$searchWord = rtrim($searchWord);
$searchWord = preg_replace("/[ ]+/", " ", $searchWord);
$searchWord = preg_replace("/^ /", "", $searchWord);
$searchWord = preg_replace("/ $/", "", $searchWord);
$footNote = '';

if($searchWord=='')
{
	$searchWord = '. *';
}
if(!empty($_POST['chk_list']))
{
	$chk_list = $_POST['chk_list'];
	$count = count($chk_list);
	
	if($count == '1')
	{
		foreach($chk_list as $chkval)
		{
			if($chkval == "word")
			{
				$word = $searchWord;
				$h_word = preg_replace("/[ ]+/", " ", $word);
				$h_word = preg_replace("/ $/", "", $h_word);
				$h_word = preg_replace("/^ /", "", $h_word);
				$query = "select * from EOH where word = '$h_word'";
				
			}
			elseif($chkval == "mng")
			{
				$wd_mng = $searchWord;
				$wd_mng = rtrim($wd_mng);
				$tx1 = preg_split('/ /',$wd_mng);
				$text1 = '';
				$i1 = 1;

				foreach($tx1 as $val1)
				{
					if($i1 > 1)
					{
						$text1 = $text1."|".$val1;
					}
					else
					{
						$text1 = $text1."".$val1;
					}
					$i1++;
				}
				$wd_mng = $text1;
				$query = "select * from EOH where text REGEXP '$wd_mng|$searchWord'";
			}
		}
	}
	elseif($count == '2')
	{
		$wd_mng = $chk_list[1];
		$h_word = preg_replace("/[ ]+/", " ", $wd_mng);
		$h_word = preg_replace("/ $/", "", $h_word);
		$h_word = preg_replace("/^ /", "", $h_word);

		$wd_mng = $searchWord;
		$wd_mng = rtrim($wd_mng);
		$tx1 = preg_split('/ /',$wd_mng);
		$text1 = '';
		$i1 = 1;

		foreach($tx1 as $val1)
		{	
			if($i1 > 1)
			{
				$text1 = $text1."|".$val1;
			}
			else
			{
				$text1 = $text1."".$val1;
			}
			$i1++;
		}
		$wd_mng = $text1;
		$query = "select * from EOH where word REGEXP '$wd_mng' union select * from EOH where text REGEXP '$wd_mng'";
	}

	$result = $db->query($query); 
	$num_rows = $result ? $result->num_rows : 0;
	echo '<h1 class="clr1 gapBelowSmall">Search Results : ' . $num_rows . '</h1>';
	if($num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			$mng = $row['text'];
			$id = $row['entry_id'];
			
			$xmlObj=simplexml_load_string($mng);
			
			echo '<div class="word">';
			echo '<div class="whead">';
			$word = $row['word'];
			
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
				if($count == 1)
				{
					if($chkval == "mng")
					{
						$span_mng = preg_split('/\|/',$wd_mng);
						foreach($span_mng as $mean)
						{
							$xmlVal = preg_replace("/$mean/i", "<span style=\"color: red\">$mean</span>", $xmlVal);
						}
					}
				}
				elseif($count == 2)
				{
					if($chk_list[1] == "mng")
					{
						$span_mng = preg_split('/\|/',$wd_mng);
						foreach($span_mng as $mean)
						{
							$xmlVal = preg_replace("/$mean/i", "<span style=\"color: red\">$mean</span>", $xmlVal);
						}
					}
				}
				$xmlVal = replaceHeadings($xmlVal);
				if(preg_match('#<figure>#', $xmlVal, $match))
				{
					echo "<span class='crossref'><a href='img/thumbs/$word.png' data-lightbox='imgae-".$id."' data-title='". $xmlObj->head->word . "'><img src='img/main/$word.png' alt='Figure:" . $xmlObj->head->word . "' /></a></span><br />";
				}
				if(preg_match('#<aside>(.*)<\/aside>#', $xmlVal, $match))
				{
					$xmlVal = preg_replace('/<aside>(.*?)<\/aside>/', "<span class=\"fntsymbol\">*</span>", $xmlVal);
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
	else
	{
		echo '<a href="search.php" class="sml clr2">Sorry! No results. Hit the back button or click here to try again.</a>';
	}
}
else
{
	echo '<a href="search.php" class="sml clr2">Please  Select Atleast One Option.</a>';
}
?>
            </div> <!-- cd-container -->
        </div> <!-- cd-scrolling-bg -->
    </main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
