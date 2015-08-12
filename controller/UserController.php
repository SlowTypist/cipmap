<?php
/**
 * Created by IntelliJ IDEA.
 * User: cryptexis
 * Date: 8/3/15
 * Time: 1:33 AM
 */

include_once(dirname(__DIR__).'/config/config.php');
include_once dirname(__DIR__).'/includes/db.php';
require_once(dirname(__DIR__).'/model/User.php');
include_once(dirname(__DIR__).'/libraries/PHPMailer.php');

class UserController {

    public function login() {

        $loginerror = null;
        $_POST['email'] = trim($_POST['email']);
        $user = new User();
        $user->email = $_POST['email'];

        $user->getByEmail();

        if($user->id > 0) {
            if($user->password == sha1($_POST['email'].$_POST['pw'])){
                if ($user->active){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user'] = $user->id;
                    $_SESSION['role'] = $user->role;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['LAST_ACTIVITY'] = time();

                    header("Location: login.php");
                }
                else{
                    $loginerror =  "Account is not activated yet. Please confirm your account with a link sent to your email";
                }
            }
            else{
                $loginerror = "Wrong password";
            }
        }
        else if($user->id == 0){
            $loginerror = "No such user";
        }
        else if ($user->id == -1){
            $loginerror == "No such user";
        }

        return $loginerror;
    }


    public function register(){

        $result = array();

        $_POST['email'] = trim($_POST['email']);
        //validate data
        if (empty($_POST['surname']) ||
            empty($_POST['name']) ||
            empty($_POST['matrnr']) ||
            empty($_POST['email']) ||
            empty($_POST['pw']) ||
            empty($_POST['pw_repeat'])) {

            $result["type"] = "error";
            $result["message"] = "All fields must be filled";

        } elseif ($_POST['pw'] !== $_POST['pw_repeat']) {

            $result["type"] = "error";
            $result["message"] = "Passwords don't match";

        } elseif (strlen($_POST['pw']) < 6) {

            $result["type"] = "error";
            $result["message"] = "Passwords is too short";

        } elseif (strlen($_POST['matrnr']) != 7 || !is_numeric($_POST['matrnr'])) {

            $result["type"] = "error";
            $result["message"] = "Matriculation number must contain seven digits";

        } elseif (strlen($_POST['email']) > 64 ||
                    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
                    !preg_match("/uni-bonn.de/",$_POST['email'])) {

            $result["type"] = "error";
            $result["message"] = "Please enter correct e-mail";
        }

        if(isset($result["type"])) {
            return $result;
        }


        $user = new User();
        $user->email = $_POST['email'];
        $user->getByEmail();

        if ($user->id != 0) {
            $result["type"] = "error";
            $result["message"] = "Such e-mail is already registered";
        }

        if(isset($result["type"])) {
            return $result;
        }

        $user->name = $_POST['name'];
        $user->surname = $_POST['surname'];
        $user->matrikelnr = $_POST['matrnr'];
        $user->password = sha1($_POST['email'].$_POST['pw']);
        $user->activation_hash = sha1(uniqid(mt_rand(), true));
        $user->pwreset_hash = sha1(uniqid(mt_rand(), true));

        $user->save();

        if ($user->id > 0) {
            if (! ($this->sendVerificationEmail($user->id, $user->email, $user->activation_hash))) {
                $result["type"] = "error";
                $result["message"] = "Sending verification mail was unsuccessful. Please contact tutors";
            }
        } else {
            $result["type"] = "error";
            $result["message"] = "Database error";
        }

        if(isset($result["type"])) {
            return $result;
        }
        else{
            $result["type"] = "success";
            $result["message"] = "Successful registration. Please check your e-mail for activation link";
            return $result;
        }
    }

    public function sendVerificationEmail($user_id, $email, $activation_hash){
        $mail  = new PHPMailer;

        $mail->IsSMTP();
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        if (defined(EMAIL_SMTP_ENCRYPTION)) {
            $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
        }
        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;
        $mail->Port = EMAIL_SMTP_PORT;

        $mail->From = EMAIL_VERIFICATION_FROM;
        $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
        $mail->AddAddress($email);
        $mail->Subject = EMAIL_VERIFICATION_SUBJECT;

        $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($activation_hash);
        $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link;

        if(!$mail->Send()){
        //var_dump($mail);
            return false;
        }
        else{
            return true;
        }
    }
    public function verify(){
        $verifyresult = null;
        $user = new User();
        $user->id = $_GET['id'];
        $user->get();
        if ($user->id == $_GET['id']){
            if ($user->activation_hash == $_GET['verification_code']){
                $user->active = 1;
                $user->activation_hash = null;
                $user->update();
                if ($user->id == $_GET['id']){
                    $verifyresult = "Account successfully activated";
                }
                else{
                    $verifyresult = "Database error";
                }
            }
            else{
                $verifyresult = "Wrong activation code";
            }
        }
        else{
            $verifyresult = "No such user";
        }
        return $verifyresult;


    }
    public function forgot(){
        $user = new User();
        $user->email = trim($_POST['email']);

        $user->getByEmail();

        if($user->id == -1){
            return "Database error";
        }
        if ($user->id == 0){
            return "No such user";
        }
        if ($user->active == 0){
            return "Account is not active";
        }
        if ($this->sendForgotEmail($user->id, $user->email, $user->pwreset_hash)){
            return "Reset link send. Please check your e-mail";
        }
        else{
            return "E-mail wasn't sent. Please contact tutors";
        }

    }
    public function sendForgotEmail($user_id, $email, $pwreset_hash)
    {
        $mail  = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = EMAIL_SMTP_AUTH;
        if (defined(EMAIL_SMTP_ENCRYPTION)) {
            $mail->SMTPSecure = EMAIL_SMTP_ENCRYPTION;
        }
        // Specify host server
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;
        $mail->Port = EMAIL_SMTP_PORT;

        $mail->From = EMAIL_PASSWORDRESET_FROM;
        $mail->FromName = EMAIL_PASSWORDRESET_FROM_NAME;
        $mail->AddAddress($email);
        $mail->Subject = EMAIL_PASSWORDRESET_SUBJECT;
        //$mail->SMTPDebug = 2;
        $link = EMAIL_PASSWORDRESET_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($pwreset_hash);
        $mail->Body = EMAIL_PASSWORDRESET_CONTENT.' '.$link;
        if(!$mail->Send()) {
            return false;
        }
        else {
                return true;
        }
    }

    public function verifyPasswordResetLink(){
        $verifyresult = null;
        $user = new User();
        $user->id = $_GET['id'];
        $user->get();
        if ($user->id == $_GET['id']){
            if ($user->pwreset_hash == $_GET['verification_code']){
                if ($user->active == 1){
                        $verifyresult = 1;
                }
                else {
                    $verifyresult = "Account is not active";
                }
            }
            else{
                $verifyresult = "Wrong reset code";
            }
        }
        else{
            $verifyresult = "No such user";
        }
        return $verifyresult;
    }
    public function resetPassword (){
        if ($_POST['new_pw'] != $_POST['new_pw_repeat']) {
            return "Passwords don't match. Please try again";
        }
        if (empty($_POST['new_pw'])){
            return "You didn't enter new password";
        }
        if (strlen($_POST['new_pw']) < 6) {
            return "Password must be at least 6 characters long";
        }

        $user = new User();
        $user->id = $_POST['id'];

        $user->get();
        if ($user->id != $_POST["id"]){
            return "No such user";
        }
        $user->password = sha1($user->email.$_POST['new_pw']);
        $user->pwreset_hash = sha1(uniqid(mt_rand(), true));

        $user->update();

        if ($user->id == $_POST['id']){
            return "Password successfully changed";
        }
        else{
            return "Error occurred. Please contact tutors";
        }

    }
   public function changePassword($user_id, $cur_pw, $new_pw, $new_pw_repeat)
            //1 success, 0 db problem, -1 wrong current password, -2 wrong repeat, -3 new password is empty -4 new password is too short
        {
            if ($new_pw != $new_pw_repeat)
            {
                return -2;
            }
            if (empty($new_pw))
            {
                return -3;
            }
            elseif (strlen($new_pw) < 6)
            {
                return -4;
            }

            $db = db_connect();
            if ($db)
            {
                try
                {
                    $stmt = $db->prepare('SELECT email, password FROM cip_user WHERE id = :user_id');
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->execute();
                    $fetchResult = $stmt->fetch(PDO::FETCH_NUM);
                    var_dump($table_email);
                    var_dump($table_pw);
                    if ($fetchResult[1] != sha1($fetchResult[0].$cur_pw))
                    {
                        $db = 0;
                        return -1;
                    }
                    else
                    {
                        $new_pw = sha1($fetchResult[0].$new_pw);
                        $stmt = $db->prepare("UPDATE cip_user
											  SET password = :new_pw
											  WHERE id = :user_id");
                        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                        $stmt->bindValue(':new_pw', $new_pw, PDO::PARAM_STR);
                        $stmt->execute();
                        if($stmt)
                        {
                            return 1;

                        }

                    }

                }
                catch (PDOException $e)
                {
                    $db = 0;
                    return 0;
                }

            }

        }
    public function getUserInformation($user_id){
    $db = db_connect();
    if ($db){
        try{
            $stmt = $db->prepare("SELECT email, name, surname, matrikelnr, active, role FROM cip_user WHERE 	id= :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $db = null;
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
                $db = null;
            }
            else {
                $db = null;
                return -1; //something wrong
            }
        }
        catch (PDOException $e) {
            $db = null;
            return 0;		//db error
        }
    }
    else {
        return 0;		//db error
    }
}

        public function listAllUsers()
        {
            $db = db_connect();
            if ($db)
            {

                try
                {
                    $stmt = $db->prepare("SELECT id, email, name, surname, matrikelnr, active, role  FROM cip_user ORDER BY surname");
                    $stmt->execute();
                    $db = null;
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
                }
                catch (PDOException $e)
                {

                    $db = null;
                    return 0;		//db error
                }
            }
            else
            {
                return 0;		//db error
            }

        }
        public function changeUserInformation($user_id, $email,  $name, $surname, $matrnr, $active, $role)
            // 0 - db error// 1 - success
        {
            $db = db_connect();
            if ($db)
            {
                try
                {
                    $stmt = $db->prepare ("UPDATE cip_user
											SET email = :email, name = :name, surname = :surname, matrikelnr = :matrnr, active = :active, role = :role
											WHERE id = :user_id");
                    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                    $stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
                    $stmt->bindValue(':matrnr', $matrnr, PDO::PARAM_INT);
                    $stmt->bindValue(':active', $active, PDO::PARAM_INT);
                    $stmt->bindValue(':role', $role, PDO::PARAM_INT);
                    $stmt->execute();
                    if ($stmt)
                    {

                        $db = null;
                        return 1;
                    }
                    else
                    {
                        $db = null;
                        return 0;
                    }


                }
                catch (PDOException $e)
                {
                    $db = null;
                    return 0;
                }

            }
            else
            {
                return 0;
            }
        }
    }
?>