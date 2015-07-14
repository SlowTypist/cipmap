<?php include('_header.php'); ?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	echo $result;
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET')
{?>
		<form action="addlecture.php" method="post">         
            <fieldset>
                <legend>Add lecture</legend>
                <label>Name: <input type="text" name="name" value=""></label>Please write a name in format (Semester)ModuleNumber - Lecture name. <br>(e.g. (WS15)101 - Basics in creating lecture names)<br>
                <label>Teacher: <input type="text" name="teacher" value=""></label><br>
                <label>Maximum group size:<br> <input type="number" name="max_group_size" value="" min="1"></label><br>
                <input type="submit" name="Add" value="Add new lecture" />
            </fieldset>
        </form>
<?php 
}
?>

<br><a href="teacher.php">Back to lecture list</a><br>



<br><br><a href="../index.php">Back to main menu</a><br>
<a href="../index.php?logout">Logout</a>
<?php include('_footer.php'); ?>