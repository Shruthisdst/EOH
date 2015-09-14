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
$query = "select word from EOH where word like '$letter%'";
$result = $db->query($query); 
$num_rows = $result ? $result->num_rows : 0;

if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$word = $row['word'];
		echo '<div class="word">';
		echo '<div class="whead">';
		echo '<span class="engWord clr1">' .$word . '</span>';
		echo '</div>';
		$query1 = "select * from EOH where word='$word'";
		$result1 = $db->query($query1); 
		$num_rows1 = $result ? $result1->num_rows : 0;
		if($num_rows1 > 0)
		{
			echo '<div class="grammarLabel">';
			echo '<span>(the first letter of the Sanskrit alphabet)</span>';
			echo '</div>';
		}


		
		echo '<div class="wBody">';
		echo '<p></p>';
		echo '<p>Being the first manifest sound that emerged out of the ḍamaru (miniature drum) of Lord Śiva during his famous dance (tāṇḍavanṛtya), it is the first letter of the Sanskrit alphabet and the fundamental sound without which no other letter can be pronounced. Hence it is identified with God himself or used as his symbol. The Sanskrit lexicons give as many as 31 meanings and it is used in six different ways in grammar.</p>';
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
