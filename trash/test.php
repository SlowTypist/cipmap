<?php
$email = "s6vaosip@uni-bonn.de";
echo sha1(uniqid(mt_rand(), true));
echo "<br>";
echo sha1(uniqid(mt_rand(), true));
echo "<br>";
$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
$pass = "johnlennon"; //remember to declare $pass as an array
$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
//for ($i = 0; $i < 8; $i++) {
//    $n = rand(0, $alphaLength);
//    $pass[] = $alphabet[$n];
//}
//$pass = implode($pass);

echo $pass;
echo "<br>";
echo sha1($pass);
echo "<br>";

if (!preg_match("/@uni-bonn.de/",$email)) {
  echo "Wrong<br>";
}
var_dump( $_SERVER['REMOTE_ADDR']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  echo("$email is a valid email address");
} else {
  echo("$email is not a valid email address");
}

//$myFile = 'testfile.php';
//$fh = fopen($myFile, 'w');
//$ata = 'BoobeBlooper';
//fwrite($fh, $ata);
//fclose($fh);

?> 