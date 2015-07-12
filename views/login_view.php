<?php include('_header.php'); ?>
<?php echo $loginerror?><br>
<form method="post" action="login.php" name="loginform">
    <label for="Email:">E-mail:</label>
    <input id="email" type="email" name="email" required />
    <label for="Password">Password:</label>
    <input id="pw" type="password" name="pw" autocomplete="off" required />
       <input type="submit" name="login" value="Login" />
</form>

<a href="register.php">Register</a><br>
<a href="forgot.php">Forgot password?</a>

<?php include('_footer.php'); ?>