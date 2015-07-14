<?php include('_header.php'); ?>
<b>Name:</b> <?php echo $userinfo['name']." ";echo $userinfo['surname']."   "?> <br>
<b>Available lectures:</b><br>
<?php
foreach ($alllectures as $key => $value) {
	echo "<a href=lectureedit.php?getid=".$alllectures[$key]['id'].">".$alllectures[$key]['name']."</a><br>";
}
?>


<br><a href="addlecture.php">Create new lecture</a><br><br>
<a href="../pwchange.php">Change password</a><br>
<a href="../index.php?logout">Logout</a>
<?php include('_footer.php'); ?>