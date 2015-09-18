<?php include("include_header.php");?>
<main class="cd-main-content">
	<div class="cd-scrolling-bg cd-color-2">
		<div class="cd-container">

			<div class="alpha_list">
				<span class="alpha_link"><a href="description.php?letter=A">A</a></span>	
				<span class="alpha_link"><a href="#">B</a></span>	
				<span class="alpha_link"><a href="#">C</a></span>	
				<span class="alpha_link"><a href="#">D</a></span>	
				<span class="alpha_link"><a href="#">E</a></span>	
				<span class="alpha_link"><a href="#">F</a></span>	
				<span class="alpha_link"><a href="#">G</a></span>	
				<span class="alpha_link"><a href="#">H</a></span>	
				<span class="alpha_link"><a href="#">I</a></span>	
				<span class="alpha_link"><a href="#">J</a></span>	
				<span class="alpha_link"><a href="#">K</a></span>	
				<span class="alpha_link"><a href="#">L</a></span>	
				<span class="alpha_link"><a href="#">M</a></span>	
				<span class="alpha_link"><a href="#">N</a></span>	
				<span class="alpha_link"><a href="#">O</a></span>	
				<span class="alpha_link"><a href="#">P</a></span>	
				<span class="alpha_link"><a href="#">Q</a></span>	
				<span class="alpha_link"><a href="#">R</a></span>	
				<span class="alpha_link"><a href="#">S</a></span>	
				<span class="alpha_link"><a href="#">T</a></span>	
				<span class="alpha_link"><a href="#">U</a></span>	
				<span class="alpha_link"><a href="#">V</a></span>	
				<span class="alpha_link"><a href="#">W</a></span>	
				<span class="alpha_link"><a href="#">X</a></span>	
				<span class="alpha_link"><a href="#">Y</a></span>	
				<span class="alpha_link"><a href="#">Z</a></span>	
            </div>
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
				<button type="submit" value="Submit">Submit</button> &nbsp;&nbsp;
				<button type="reset" value="Reset">Reset</button>
			</form>                
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
