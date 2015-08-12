<?php
/**
 * Created by IntelliJ IDEA.
 * User: cryptexis
 * Date: 8/3/15
 * Time: 12:40 AM
 */

require_once 'Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache' => false,
    'debug' => true
));