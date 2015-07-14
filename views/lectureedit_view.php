<?php include('_header.php'); ?>
<?php 
if (isset($_GET["getid"]) || isset($_GET['add']))
{
	echo "<b>Lecture: </b>".$lectureinfo[0]['name']."<b> Teacher: </b>".$lectureinfo[0]['teacher']."<br><b>Maximum group size:</b>".$lectureinfo[0]['max_group_size'];
	echo "<br><b>Homeworks:</b><br>";
	foreach ($allhomeworks as $key => $value) 
	{
		echo "<a href=homework_edit.php?getid=".$allhomeworks[$key]['id'].">".$allhomeworks[$key]['name']."</a><br>";
	}
	if (!isset($_GET['add']))
	{
		echo "<br><br><a href=lectureedit.php?add=".$_GET["getid"].">Add new homework</a>";
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['add']))
{?>
		<form action="lectureedit.php" method="post" enctype="multipart/form-data">         
            <fieldset>
                <legend>Add homework</legend>
                <label>Name: <input type="text" name="name" value="" required></label><br>
                <input type="hidden" name="lecture_id" value=<?php echo $_GET['add'] ?>>
                <label>Start date: <input type="text" name="start_date" value="" id="fromDate" required></label><br>
                <label>End date: <input type="text" name="end_date" value="" id="toDate" required></label><br>
                <label>Max Points:<br> <input type="number" name="max_points" value="" min = "1"required></label><br>
                <label>Choose locations:<br>
                <?php
                	foreach ($alllocations as $key => $value) {
                		echo "<label>".$alllocations[$key]['name'].":<input type='checkbox' name= ".$alllocations[$key]['id']." ></label><br>";
                	}
                ?>
                </label>	
                <label>Task: <input type="file" name="task"></label><br>
                <label>Solution (for tutors): <input type="file" name="solution"></label><br>
                <input type="submit" name="Add" value="Add new homework" />
            </fieldset>
        </form>
<?php 
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	echo $addtask."<br>";
	echo $addsolution."<br>";
	echo $addresult."<br>";
	echo "<a href=lectureedit.php?getid=".$_POST["lecture_id"].">Back to lecture (You will be redirected automatically in 3 seconds)</a><br>";
	//header( "refresh:3;url=lectureedit.php?getid=".$_POST["lecture_id"] );
}
?>


<br><br><a href="../index.php">Back to main menu</a><br>
<a href="../index.php?logout">Logout</a>
<?php include('_footer.php'); ?>