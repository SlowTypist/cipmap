<?php
require_once("./header.php");
require_once("./controller/UserController.php");
if ($_SESSION['loggedin'] == true){
    header('Location: index.php');
}
if(isset($_GET['id']) && isset($_GET['verification_code'])) {
    $userController = new UserController();
    $result = $userController->verifyPasswordResetLink();
}
if ($_POST['action'] == "Change password"){
    $userController = new UserController();
    $result = $userController->resetPassword();
}
include("views/password_reset_view.php");
?> 