<?php include("include_header.php");?>
<main class="cd-main-content">
	<div class="cd-scrolling-bg cd-color-2">
		<div class="cd-container">
			<h1 class="clr1 gapBelowSmall">Volumes</h1>
<?php
include("connect.php");
require_once("common.php");

$query = "select distinct vnum from EOH";
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;
if($num_rows > 0)
{
	echo '<div class="volume">';
	while($row = $result->fetch_assoc())
	{
		$vnum = $row['vnum'];
		echo "<div class=\"vnum\"><a href=\"volumes.php?vnum=$vnum\">Volume-$vnum</a></div>";
	}
	echo '</div>';
}

?>

			<div class="head gapAbove">
				<h1 class="clr1 gapBelowSmall">Letters</h1>
				<span class="alpha_link"><a href="description.php?letter=A">A</a></span>
				<span class="alpha_link"><a href="description.php?letter=B">B</a></span>
				<span class="alpha_link"><a href="description.php?letter=C">C</a></span>
				<span class="alpha_link"><a href="description.php?letter=D">D</a></span>
				<span class="alpha_link"><a href="description.php?letter=E">E</a></span>
				<span class="alpha_link"><a href="description.php?letter=F">F</a></span>
				<span class="alpha_link"><a href="description.php?letter=G">G</a></span>
				<span class="alpha_link"><a href="description.php?letter=H">H</a></span>
				<span class="alpha_link"><a href="description.php?letter=I">I</a></span>
				<span class="alpha_link"><a href="description.php?letter=J">J</a></span>
				<span class="alpha_link"><a href="description.php?letter=K">K</a></span>
				<span class="alpha_link"><a href="description.php?letter=L">L</a></span>
				<span class="alpha_link"><a href="description.php?letter=M">M</a></span>
				<span class="alpha_link"><a href="description.php?letter=N">N</a></span>
				<span class="alpha_link"><a href="description.php?letter=O">O</a></span>
				<span class="alpha_link"><a href="description.php?letter=P">P</a></span>
				<span class="alpha_link"><a href="description.php?letter=R">R</a></span>
				<span class="alpha_link"><a href="description.php?letter=S">S</a></span>
				<span class="alpha_link"><a href="description.php?letter=T">T</a></span>
				<span class="alpha_link"><a href="description.php?letter=U">U</a></span>
				<span class="alpha_link"><a href="description.php?letter=V">V</a></span>
				<span class="alpha_link"><a href="description.php?letter=W">W</a></span>
				<span class="alpha_link"><a href="description.php?letter=Y">Y</a></span>
				<span class="alpha_link"><a href="description.php?letter=Z">Z</a></span>
            </div>
            <div class="head gapAbove">
				<h1 class="clr1 gapBelowSmall">Quick Search</h1>
			<form id="form_data" method="GET" action="displayword.php">
				<span class="label_word">Enter the word:</span>&nbsp;&nbsp;
				<input name="word" type="text" id="autocomplete" /><br />
<?php
include("connect.php");
require_once("common.php");

$query = "select * from EOH order by word";
$result = $db->query($query);
$num_rows = $result ? $result->num_rows : 0;
echo "<script type=\"text/javascript\">$( \"#autocomplete\" ).autocomplete({source: [ ";
$wordsList = '';
if($num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		$mng = $row['text'];
		$xmlObj=simplexml_load_string($mng);
		$wordsList = $wordsList . ",\n" . '"' . $xmlObj->head->word . '"';
		foreach ($xmlObj->head->alias as $alias)
		{
			if($alias != '')
			{
				$wordsList = $wordsList . ",\n" .  '"'. $alias . '"';
			}
		}		
	}
	
	$wordsList = preg_replace('/^,/','',$wordsList);
}

echo $wordsList . ']});</script>';
if($result){$result->free();}

?>				
				<button type="submit" value="Submit" class="submit">Submit</button> &nbsp;&nbsp;
				<button type="reset" value="Reset" class="reset">Reset</button>
			</form>
			</div>               

			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
