<?php include('_header.php'); ?>
<b>Logged in as <?php echo $_SESSION['email'];?></b><br>
<b>Available lectures:</b><br>
<?php
foreach ($allLectures as $key => $value) {
	echo "<a href=lecture_info.php?id=".$value->id.">".$value->name."</a><br>";
}
?>
<br>
<a href="pwchange.php">Change password</a><br>
<a href="index.php?logout">Logout</a>
<?php include('_footer.php'); ?>