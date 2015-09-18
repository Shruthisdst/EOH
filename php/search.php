<?php include("include_header.php");?>
<main class="cd-main-content">
        <div class="cd-scrolling-bg cd-color-2">
            <div class="cd-container">
                <h1 class="clr1 gapBelow">Search</h1>
<?php

include("connect.php");
require_once("common.php");

?>

				<div class="archive_search">
<?php include("keyboard.php"); ?>

					<form method="POST" action="search-result.php">
							<table>
                                <tr>
									<td class="right">
										<span class="stitle"><input type="checkbox" name="chk_list[]" value="word" checked/>Word</span>
									</td>
									<td class="right">
										<span class="stitle"><input type="checkbox" name="chk_list[]" value="mng" />Description</span>
									</td>
								</tr>
								<tr>
									<td class="left"><span class="titlespan">Type your Input Here</span></td>
									<td class="right"><input name="word" type="text" class="titlespan wide" id="autocomplete" onfocus="SetId('autocomplete')" maxlength="150" />

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
								 <tr>
									<td class="left">&nbsp;</td>
									<td class="submit">
										<input name="button1" type="submit" class="titlespan" id="button" value="Search"/>
										<input name="button2" type="reset" class="titlespan" id="button2" value="Reset"/>
									</td>
								</tr>
							</table>
						</form>
				</div>
			</div> <!-- cd-container -->
		</div> <!-- cd-scrolling-bg -->
	</main> <!-- cd-main-content -->
<?php include("include_footer.php");?>
