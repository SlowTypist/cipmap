<?php
require_once("./header.php");
require_once('config/config.php');

$template = $twig->loadTemplate('index.html');
echo $template->render(array('title' => 'Login page', 'go' => 'here'));

require_once('includes/user.php');
include('handlers/login_handler.php');
//include("views/login_view.php");
?> 

