<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13.08.15
 * Time: 01:37
 */
session_start();
if (isset($_SESSION['LAST_ACTIVITY'])==0 || (time() - $_SESSION['LAST_ACTIVITY'] > 1800) || $_SESSION['loggedin'] != true) {
    // last request was more than 30 minutes ago
    $_SESSION = array();    // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header('Location: login.php');
}
else{
    $_SESSION['LAST_ACTIVITY'] = time();
}
?>