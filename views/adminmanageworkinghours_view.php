<?php include('_header.php'); ?>
<?php 
if (!isset($_GET["getid"]))
{
	echo $manageresult."<br>";
	echo "<b>Choose location:</b><br>";
	foreach ($alllocations as $key => $value) 
	{
		echo "<a href=adminmanageworkinghours.php?getid=".$alllocations[$key]['id'].">".$alllocations[$key]['name']."</a><br>";
	}
}

else if (isset($_GET["getid"]))
{
	echo("<b>".$locationinfo[0]['name']."</b><br><br>");
?>
<form action="adminmanageworkinghours.php" align = "center" method="post">
<input type="hidden" name="id" value=<?php echo $_GET['getid'] ?>>
<table border = "2">
<thead>
<tr>
<td></td>
<td>08:00-09:00</td>
<td>09:00-10:00</td>
<td>10:00-11:00</td>
<td>11:00-12:00</td>
<td>12:00-13:00</td>
<td>13:00-14:00</td>
<td>14:00-15:00</td>
<td>15:00-16:00</td>
<td>16:00-17:00</td>
<td>17:00-18:00</td>
<td>18:00-19:00</td>
<td>19:00-20:00</td>
<td>20:00-21:00</td>
</tr>
</thead>
<tbody>
	<tr>
		<td>Monday</td>
		<td><input type="checkbox" name="0" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="1" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="2" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="3" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="4" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="5" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="6" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="7" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="8" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="9" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="10" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="11" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="12" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
	</tr>
		<tr>
		<td>Tuesday</td>
		<td><input type="checkbox" name="13" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="14" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="15" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="16" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="17" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="18" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="19" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="20" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="21" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="22" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="23" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="24" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="25" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
	</tr>
		<tr>
		<td>Wednesday</td>
		<td><input type="checkbox" name="26" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="27" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="28" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="29" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="30" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="31" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="32" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="33" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="34" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="35" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="36" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="37" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="38" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
	</tr>
		<tr>
		<td>Thursday</td>
		<td><input type="checkbox" name="39" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="40" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="41" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="42" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="43" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="44" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="45" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="46" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="47" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="48" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="49" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="50" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="51" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
	</tr>
		<tr>
		<td>Friday</td>
		<td><input type="checkbox" name="52" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="53" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="54" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="55" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="56" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="57" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="58" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="59" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="60" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="61" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="62" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="63" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
		<td><input type="checkbox" name="64" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></td>
	</tr>

</tbody>
</table>
<br><input type="submit" name="Submit" value="Submit changes" />
</form>
<a href="adminmanageworkinghours.php">Back to list of locations</a><br>
<?php }
?>


<br><br><a href="../index.php">Back to main menu</a><br>
<a href="../index.php?logout">Logout</a>
<?php include('_footer.php'); ?>