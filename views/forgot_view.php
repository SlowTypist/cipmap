<?php include('_header.php'); ?> 

<?php echo $result?><br>
<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') {?>
<form action="forgot.php" method="post">         
            <fieldset>
                <legend>Forgot password</legend>
                <label>Email: <input type="email" name="email" value="@uni-bonn.de"/></label>
                <input type="submit" name="action" value="Send verification e-mail" />
            </fieldset>
        </form>
<?php }?>

<a href="index.php"><?php echo "Back to main page"; ?></a>

<?php include('_footer.php'); ?>


