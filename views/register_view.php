<?php include('_header.php'); ?> 

<?php ?>
<?php echo $registerresult?><br>
<?php if ($_SERVER['REQUEST_METHOD'] != 'POST') {?>
<form action="register.php" method="post">         
            <fieldset>
                <legend>Register</legend>
                <label>Email: <input type="email" name="email" value="@uni-bonn.de"/>Only uni-bonn.de email accounts are allowed</label><br>
                <label>Surname: <input type="text" name="surname" value=""/></label>
                <label>Name: <input type="text" name="name" value=""/></label>
                <label>Matrikelnr.: <input type="text" name="matrnr" value=""/></label>
                <label>Password: <input type="password" name="pw"/></label>
                <label>Repeat password: <input type="password" name="pw_repeat" value=""/></label>
                <input type="submit" name="Register" value="Register" />
            </fieldset>
        </form>
<?php }?>

    <a href="index.php"><?php echo "Back to main page"; ?></a>

<?php include('_footer.php'); ?>