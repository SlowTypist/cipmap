<?php
require_once("./header.php");
require_once("./controller/UserController.php");
if ($_SESSION['loggedin'] == true){
    header('Location: index.php');
}

if(isset($_GET['id']) && isset($_GET['verification_code'])) {
    $userController = new UserController();
    $result = $userController->verify();
}
else {
    header('Location:index.php');
}
require_once("views/verify_view.php");
?> 