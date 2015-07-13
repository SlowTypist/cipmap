<?php include('_header.php'); ?>
<?php 
if (!isset($_GET["getid"]) && !isset($_GET['add']))
{
	echo $deleteresult;
	echo "<b>Choose location:</b><br>";
	foreach ($alllocations as $key => $value) 
	{
		echo "<a href=adminmanagelocations.php?getid=".$alllocations[$key]['id'].">".$alllocations[$key]['name']."</a><br>";
	}
	echo "<br><a href=adminmanagelocations.php?add>Add New location</a>";
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["getid"]) && !isset($_GET["deleteid"]))
{
?>
	<form action="adminmanagelocations.php" method="post">         
            <fieldset>
                <legend>Location</legend>
                <input type="hidden" name="id" value=<?php echo $_GET['getid'] ?>>
                <label>Name: <input type="text" name="name" value="<?php echo $locationinfo[0]['name'] ?>"></label><br>
                <input type="submit" name="Change" value="Submit changes" />
            </fieldset>
        </form>
    <?php echo "<a href=\"adminmanagelocations.php?deleteid=".$_GET['getid']."\"onclick=\"return confirm('Do you really want to delete this location?')\"".">Delete ".$locationinfo[0]['name']."</a><br><br>";?>

	<a href="adminmanagelocations.php">Back to list of locations</a><br>
<?php
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['add']))
{?>
		<form action="adminmanagelocations.php" method="post">         
            <fieldset>
                <legend>Add location</legend>
                <label>Name: <input type="text" name="name" value=""></label><br>
                <input type="submit" name="Add" value="Add new location" />
            </fieldset>
        </form>
<?php 
}
?>


<br><br><a href="../index.php">Back to main menu</a><br>
<a href="../index.php?logout">Logout</a>
<?php include('_footer.php'); ?>