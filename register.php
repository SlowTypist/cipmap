<?php
require_once("./header.php");
require_once("./controller/UserController.php");
if ($_SESSION['loggedin'] == true){
    header('Location: index.php');
}
if($_POST["action"] == "Register") {
    $userController = new UserController();
    $result = $userController->register();
    //$template_variables["error_msg"] = $result;
}
require_once("views/register_view.php");
?> 