<?php include('_header.php'); ?> 
<?php echo $verifyerror;?>
<?php echo $changeresult;?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'GET' && $verifyresult == 1) {?>
<form action="password_reset.php" method="post">         
            <fieldset>
                <legend>Set new password</legend>
                <label>New password: <input type="password" name="new_pw"/></label>
                <label>Repeat new password: <input type="password" name="new_pw_repeat"/></label>
                <input type="hidden" name="id" value=<?php echo $_GET['id']?>>
                <input type="submit" name="Changepw" value="Change password" />
            </fieldset>
        </form>
<?php }?>

<a href="index.php"><?php echo "Back to main page"; ?></a>

<?php include('_footer.php'); ?>
