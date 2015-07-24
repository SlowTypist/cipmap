<?php include('_header.php'); ?> 

<?php echo $pwchangeresult?><br>
<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') {?>
<form action="pwchange.php" method="post">         
            <fieldset>
                <legend>Change password</legend>
                <label>Current password : <input type="password" name="current_pw" /></label>
                <label>New password: <input type="password" name="new_pw"/></label>
                <label>Repeat new password: <input type="password" name="new_pw_repeat"/></label>
                <input type="submit" name="Changepw" value="Change password" />
            </fieldset>
        </form>
<?php }?>

<a href="index.php"><?php echo "Back to main page"; ?></a>

<?php include('_footer.php'); ?>
