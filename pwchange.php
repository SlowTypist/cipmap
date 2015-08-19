<?php
require_once("./includes/refresh_session.php");
require_once("./header.php");
require_once("./controller/UserController.php");

if($_POST["action"] == "Change password") {
    $userController = new UserController();
    $result = $userController->changePassword();
}

include("views/pwchange_view.php");
?> 