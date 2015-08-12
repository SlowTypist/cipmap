<?php

/**
 * Created by IntelliJ IDEA.
 * User: cryptexis
 * Date: 8/3/15
 * Time: 1:59 AM
 */
session_start();
$_SESSION['LAST_ACTIVITY'] = time();
//var_dump($_SESSION);
if( isset($_SESSION['role'])){
    if ($_SESSION['role'] == 0)
    {
        header('Location: home.php');
    }
    if ($_SESSION['role'] == 1)
    {
        header('Location: tutor/tutor.php');
    }
    if ($_SESSION['role'] == 2)
    {
        header('Location: teacher/teacher.php');
    }
    if ($_SESSION['role'] == 3)
    {
        header('Location: admin/admin.php');
    }
}
