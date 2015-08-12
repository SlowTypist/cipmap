<?php
require_once("./header.php");
require_once("./controller/UserController.php");
if ($_SESSION['loggedin'] == true){
    header('Location: index.php');
}
if($_POST["action"] == "Send verification e-mail") {
    $userController = new UserController();
    $result = $userController->forgot();
}

include("views/forgot_view.php");
?> 