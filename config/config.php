<?php 
$host = 'localhost'; 
$username = 'cipdb'; 
$password = 'qwerty'; 
$dbname = 'cipdb';
/**
 * Configuration for: Email server credentials
 *
 * Here you can define how you want to send emails.
 * If you have successfully set up a mail server on your linux server and you know
 * what you do, then you can skip this section. Otherwise please set EMAIL_USE_SMTP to true
 * and fill in your SMTP provider account data.
 *
 * An example setup for using gmail.com [Google Mail] as email sending service,
 * works perfectly in August 2013. Change the "xxx" to your needs.
 * Please note that there are several issues with gmail, like gmail will block your server
 * for "spam" reasons or you'll have a daily sending limit. See the readme.md for more info.
 *
 * define("EMAIL_USE_SMTP", true);
 * define("EMAIL_SMTP_HOST", "ssl://smtp.gmail.com");
 * define("EMAIL_SMTP_AUTH", true);
 * define("EMAIL_SMTP_USERNAME", "xxxxxxxxxx@gmail.com");
 * define("EMAIL_SMTP_PASSWORD", "xxxxxxxxxxxxxxxxxxxx");
 * define("EMAIL_SMTP_PORT", 465);
 * define("EMAIL_SMTP_ENCRYPTION", "ssl");
 *
 * It's really recommended to use SMTP!
 *
 */


define("EMAIL_USE_SMTP", true);
define("EMAIL_SMTP_HOST", "ssl://smtp.yandex.ru");
define("EMAIL_SMTP_AUTH", true);
define("EMAIL_SMTP_USERNAME", "cippool@yandex.ru");
define("EMAIL_SMTP_PASSWORD", "uv1.1f69");
define("EMAIL_SMTP_PORT", 465);
define("EMAIL_SMTP_ENCRYPTION", "ssl");

/**
 * Configuration for: password reset email data
 * Set the absolute URL to password_reset.php, necessary for email password reset links
 */
define("EMAIL_PASSWORDRESET_URL", "http://127.0.0.1/cipmap/password_reset.php");
define("EMAIL_PASSWORDRESET_FROM", "cippool@yandex.ru");
define("EMAIL_PASSWORDRESET_FROM_NAME", "CIP Pool Team");
define("EMAIL_PASSWORDRESET_SUBJECT", "Password reset for CIP Pool");
define("EMAIL_PASSWORDRESET_CONTENT", "Please click on this link to reset your password:");
/**
 * Configuration for: verification email data
 * Set the absolute URL to register.php, necessary for email verification links
 */
define("EMAIL_VERIFICATION_URL", "http://127.0.0.1/cipmap/verify.php");
define("EMAIL_VERIFICATION_FROM", "cippool@yandex.ru");
define("EMAIL_VERIFICATION_FROM_NAME", "CIP Pool Team");
define("EMAIL_VERIFICATION_SUBJECT", "Account activation for CIP Pool");
define("EMAIL_VERIFICATION_CONTENT", "Please click on this link to activate your account:");

?>