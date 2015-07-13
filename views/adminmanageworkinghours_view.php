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
		<td><input type="checkbox" name="0" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "08:00:00" &&  "08:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="1" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "09:00:00" &&  "09:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="2" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "10:00:00" &&  "10:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="3" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "11:00:00" &&  "11:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="4" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "12:00:00" &&  "12:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="5" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "13:00:00" &&  "13:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="6" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "14:00:00" &&  "14:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="7" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "15:00:00" &&  "15:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="8" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "16:00:00" &&  "16:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="9" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "17:00:00" &&  "17:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="10" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "18:00:00" &&  "18:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="11" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "19:00:00" &&  "19:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="12" <?php foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "MONDAY" && $workinghours[$key]['open_time'] <= "20:00:00" &&  "20:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
	</tr>
		<tr>
		<td>Tuesday</td>
		<td><input type="checkbox" name="13" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "08:00:00" &&  "08:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="14" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "09:00:00" &&  "09:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="15" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "10:00:00" &&  "10:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="16" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "11:00:00" &&  "11:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="17" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "12:00:00" &&  "12:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="18" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "13:00:00" &&  "13:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="19" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "14:00:00" &&  "14:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="20" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "15:00:00" &&  "15:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="21" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "16:00:00" &&  "16:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="22" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "17:00:00" &&  "17:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="23" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "18:00:00" &&  "18:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="24" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "19:00:00" &&  "19:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="25" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "TUESDAY" && $workinghours[$key]['open_time'] <= "20:00:00" &&  "20:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
	</tr>
		<tr>
		<td>Wednesday</td>
		<td><input type="checkbox" name="26" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "08:00:00" &&  "08:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="27" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "09:00:00" &&  "09:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="28" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "10:00:00" &&  "10:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="29" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "11:00:00" &&  "11:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="30" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "12:00:00" &&  "12:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="31" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "13:00:00" &&  "13:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="32" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "14:00:00" &&  "14:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="33" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "15:00:00" &&  "15:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="34" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "16:00:00" &&  "16:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="35" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "17:00:00" &&  "17:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="36" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "18:00:00" &&  "18:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="37" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "19:00:00" &&  "19:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="38" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "WEDNESDAY" && $workinghours[$key]['open_time'] <= "20:00:00" &&  "20:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
	</tr>
		<tr>
		<td>Thursday</td>
		<td><input type="checkbox" name="39" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "08:00:00" &&  "08:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="40" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "09:00:00" &&  "09:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="41" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "10:00:00" &&  "10:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="42" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "11:00:00" &&  "11:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="43" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "12:00:00" &&  "12:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="44" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "13:00:00" &&  "13:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="45" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "14:00:00" &&  "14:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="46" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "15:00:00" &&  "15:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="47" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "16:00:00" &&  "16:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="48" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "17:00:00" &&  "17:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="49" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "18:00:00" &&  "18:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="50" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "19:00:00" &&  "19:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="51" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "THURSDAY" && $workinghours[$key]['open_time'] <= "20:00:00" &&  "20:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
	</tr>
		<tr>
		<td>Friday</td>
		<td><input type="checkbox" name="52" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "08:00:00" &&  "08:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="53" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "09:00:00" &&  "09:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="54" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "10:00:00" &&  "10:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="55" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "11:00:00" &&  "11:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="56" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "12:00:00" &&  "12:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="57" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "13:00:00" &&  "13:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="58" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "14:00:00" &&  "14:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="59" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "15:00:00" &&  "15:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="60" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "16:00:00" &&  "16:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="61" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "17:00:00" &&  "17:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="62" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "18:00:00" &&  "18:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="63" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "19:00:00" &&  "19:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
		<td><input type="checkbox" name="64" <?php  foreach ($workinghours as $key => $value) {if ($workinghours[$key]['day'] == "FRIDAY" && $workinghours[$key]['open_time'] <= "20:00:00" &&  "20:00:00" < $workinghours[$key]['close_time']) {echo "checked";} }?>></td>
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