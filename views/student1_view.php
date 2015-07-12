<?php include('_header.php'); ?>
<b>Name:</b> <?php echo $userinfo['name']." ";echo $userinfo['surname']."   "?> <b>Matrikel-Nr.:</b> <?php echo $userinfo['matrikelnr'];?><br>
<b>Available lectures:</b><br>
<?php
foreach ($alllectures as $key => $value) {
	echo "<a href=lecture_info.php?id=".$alllectures[$key]['id'].">".$alllectures[$key]['name']."</a><br>";
}
?>
<a href="pwchange.php">Change password</a><br>
<a href="index.php?logout">Logout</a>
<?php include('_footer.php'); ?>