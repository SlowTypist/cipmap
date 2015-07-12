<?php include('_header.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET["id"]))
{
	echo "<b>Choose user:</b><br>";
	foreach ($allusers as $key => $value) 
	{
		echo "<a href=adminedit.php?id=".$allusers[$key]['id'].">".$allusers[$key]['name']." ".$allusers[$key]['surname']."</a><br>";
	}
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["id"]))
{
	?>

	<form action="adminedit.php" method="post">         
            <fieldset>
                <legend>User info</legend>
                <label>Email: <input type="email" name="email" value=<?php echo $userinfo['email'] ?>></label><br>
                <label>Name: <input type="text" name="name" value=<?php echo $userinfo['name'] ?>></label>
                <label>Surname: <input type="text" name="surname" value=<?php echo $userinfo['surname'] ?>></label>
                <label>Matrikelnr.: <input type="text" name="matrnr" value=<?php echo $userinfo['matrikelnr'] ?>></label>
                <label>Active: <input type="checkbox" name="active" value="1" <?php  if ($userinfo['active'] == 1) {echo "checked";} ?>></label><br>
                <label>Role: <input type="text" name="role"  value=<?php echo $userinfo['role'] ?>></label>
                <input type="submit" name="Change" value="Submit changes" />
            </fieldset>
        </form>


	<a href="adminedit.php">Back to list of users</a><br><?php

}
?>
<br>
<a href="../index.php">Back to main menu</a><br>
<a href="../index.php?logout">Logout</a>
<?php include('_footer.php'); ?>