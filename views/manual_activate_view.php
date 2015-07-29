<?php include('_header.php'); ?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'GET'):?>
	<form action="manual_activate.php" method="post">         
        <fieldset style="width:25%">
            <legend>Search account</legend>
            <label>Email: <input type="email" name="email" value="@uni-bonn.de"/></label><br>
            <input type="submit" name="Search" value="Search" />
        </fieldset>
	<br><a href="index.php">Back to main menu</a>
</form>
<?php elseif (isset($searchResult)):?>
	<?php if ($searchResult == -1):?>
		<b>No account found</b><br>
		<br><a href="manual_activate.php">Try again</a>
		<br><a href="index.php">Back to main menu</a>
	<?php elseif ($searchResult == 0):?>
		<b>Database error</b><br>
		<br><a href="manual_activate.php">Try again</a>
		<br><a href="index.php">Back to main menu</a>
	<?php else:?>
	 	<b>Email: </b><?php echo $searchResult['email']; ?><br>
	 	<b>Name: </b><?php echo $searchResult['name']; ?><br>
	 	<b>Surname: </b><?php echo $searchResult['surname']; ?><br>
	 	<b>MatrikelNr: </b><?php echo $searchResult['matrikelnr']; ?><br>
	 	<?php if ($searchResult['active']): ?>
	 		<b>Account is active</b>
	 	<?php else: ?>
	 		<form action="manual_activate.php" method="post">         
               	<input type="hidden" name="id" value="<?php echo $searchResult["id"] ?>"/>
                <input type="submit" name="Activate" value="Activate" />
			</form>
	 	<?php endif;?>
	 	<br><a href="manual_activate.php">Try again</a>
		<br><a href="index.php">Back to main menu</a>
	<?php endif;?>
<?php elseif ($activateResult == 1):?>
	<b>Account succesfully activated</b>
	<br><a href="index.php">Back to main menu</a>
<?php elseif ($activateResult == 0):?>
	<b>Database error</b>
	<br><a href="index.php">Back to main menu</a>
<?php endif;?>
<?php include('_footer.php'); ?>