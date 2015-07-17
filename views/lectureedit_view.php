<?php include('_header_lectureedit.php'); ?>
<?php 
if (isset($_GET['add']) || isset($_GET['homework_id']))
{
	echo "<b>Lecture: </b>".$lectureinfo[0]['name']."<b> Teacher: </b>".$lectureinfo[0]['teacher']."<br><b>Maximum group size:</b>".$lectureinfo[0]['max_group_size'];
	echo "<br><b>Homeworks:</b><br>";
	foreach ($allhomeworks as $key => $value) 
	{
		echo "<a href=lectureedit.php?homework_id=".$allhomeworks[$key]['id'].">".$allhomeworks[$key]['name']."</a>  
				 <a href=\"lectureedit.php?deleteid=".$allhomeworks[$key]['id']."\"onclick=\"return confirm('Do you really want to delete ".$allhomeworks[$key]['name']."? It might be better to edit existing information.')\"".">Delete ".$allhomeworks[$key]['name']."</a>	<br>";
	}
	if (!isset($_GET['add']) && !isset($_GET['homework_id']))
	{
		echo "<br><a href=lectureedit.php?add=".$_GET["getid"].">Add new homework</a>";
	}
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getid']))
{?>
        <form action="lectureedit.php" method="post" enctype="multipart/form-data">         
            <fieldset>
                <legend>Change lecture information</legend>
                <input type="hidden" name="lecture_id" value="<?php echo $_GET['getid'] ?>">
                <label>Name: <input type="text" name="name" value="<?php echo $lectureinfo[0]['name'] ?>" required></label>
                <label>Teacher: <input type="text" name="teacher" value="<?php echo $lectureinfo[0]['teacher'] ?>" ></label>
                <label>Max Group Size:<br> <input type="number" name="max_group_size" value="<?php echo $lectureinfo[0]['max_group_size'] ?>" min = "1"required></label><br>
                <input type="submit" name="Change_lecture" value="Change lecture information" />
            </fieldset>
        </form>
        <?php
        foreach ($allhomeworks as $key => $value) 
        {
             echo "<a href=lectureedit.php?homework_id=".$allhomeworks[$key]['id'].">".$allhomeworks[$key]['name']."</a>  
                <a href=\"lectureedit.php?deleteid=".$allhomeworks[$key]['id']."\"onclick=\"return confirm('Do you really want to delete ".$allhomeworks[$key]['name']."? It might be better to edit existing information.')\"".">Delete ".$allhomeworks[$key]['name']."</a>   <br>";
         }
        echo "<br><a href=lectureedit.php?add=".$_GET["getid"].">Add new homework</a>";

}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['add']))
{?>
		<form action="lectureedit.php" method="post" enctype="multipart/form-data">         
            <fieldset>
                <legend>Add homework</legend>
                <label>Name: <input type="text" name="name" value="" required></label>
                <input type="hidden" name="lecture_id" value=<?php echo $_GET['add'] ?>>
                <label>Start date: <input type="text" name="start_date" value="" id="fromDate" required></label>
                <label>End date: <input type="text" name="end_date" value="" id="toDate" required></label>
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
        <br><a href=lectureedit.php?getid=<?php echo $_GET['add'];?>>Cancel</a>
<?php 
}
else if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['homework_id']))
{?>
        <form action="lectureedit.php" method="post" enctype="multipart/form-data">         
            <fieldset>
                <legend>Change homework</legend>
                <input type="hidden" name="homework_id" value=<?php echo $_GET["homework_id"] ?>>
                <label>Name: <input type="text" name="name" value="<?php echo $homework_info['name'];  ?>" required></label>
                <input type="hidden" name="lecture_id" value=<?php echo $homework_info["lecture_id"] ?>>
                <label>Start date: <input type="text" name="start_date" value="<?php echo $homework_info['start'];  ?>" id="fromDate" required></label>
                <label>End date: <input type="text" name="end_date" value="<?php echo $homework_info['end'];  ?>" id="toDate" required></label>
                <label>Max Points:<br> <input type="number" name="max_points" value="<?php echo $homework_info['max_points'];?>" min = "1"required></label><br>     
                <label>Choose locations:<br>
                <?php
                    foreach ($alllocations as $key1 => $value1) {
                        echo "<label>".$alllocations[$key1]['name'].":<input type='checkbox' name= ".$alllocations[$key1]['id'];
                        foreach ($homework_location as $key2 => $value2) {
                            if ($value2["location_id"] == $alllocations[$key1]['id'])
                            {
                                echo " checked ";
                            }
                        }
                        echo " ></label><br>";
                    }
                ?>
                </label> 
                <input type = "hidden" name = "old_task" value=<?php echo $homework_info["link_task"];?>>
                <input type = "hidden" name = "old_solution" value=<?php echo $homework_info["link_solution"];?>>   
                <label>Task:<?php echo $homework_info["link_task"];?> <input type="file" name="task"></label><br>
                <label>Solution (for tutors):<?php echo $homework_info["link_solution"];?><input type="file" name="solution"></label><br>
                <input type="submit" name="Change" value="Change homework" />
            </fieldset>
        </form>
        <br><a href=lectureedit.php?getid=<?php echo $homework_info["lecture_id"];?>>Cancel</a>


<?php
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($addtask)){echo $addtask."<br>";}
	if (!empty($addsolution)){echo $addsolution."<br>";}
    if (!empty($addresult)){echo $addresult."<br>";}
    if (!empty($changeresult)){echo $changeresult."<br>";}
	echo "<br><a href=lectureedit.php?getid=".$_POST["lecture_id"].">Back to lecture (You will be redirected automatically in 5 seconds)</a><br>";
	header( "refresh:5;url=lectureedit.php?getid=".$_POST["lecture_id"] );
}
else if (isset($_GET["deleteid"]))
{
    echo $deleteresult."<br>";
    echo "<a href=lectureedit.php?getid=".$lecture_id.">Back to lecture (You will be redirected automatically in 5 seconds)</a><br>";
    header( "refresh:5;url=lectureedit.php?getid=".$lecture_id );
}

?>


<br><br><a href="../index.php">Back to main menu</a><br>
<a href="../index.php?logout">Logout</a>
<?php include('_footer.php'); ?>