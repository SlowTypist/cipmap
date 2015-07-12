<?php
	include(dirname(__DIR__).'/config/config.php');
	include_once dirname(__FILE__).'/db.php';
	include(dirname(__DIR__).'/libraries/PHPMailer.php');
	class user
	{
		public function login($email, $pw)
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, password, active, role FROM cip_user WHERE email= :email");
					$stmt->bindParam(':email', $email);
					$stmt->execute();
					$db = null;
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result && $result["password"] == sha1($pw))
					{
						if($result["active"])
						{
							$out['id'] = $result["id"];
							$out['role'] = $result["role"];
							return($out);
						}
						else
						{
							return -2;	//return unactive
						}
					}
					else
					{
						return -1; //return wrong password or no such user
					}
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

		public function register($email, $surname, $name, $matrnr, $pw, $pw_repeat)
		//0 - db error,-1 email exists in db, -2 one of the fields is empty, -3 pw and pw_repeat don't match, -4 pw too short, -5 matrnt is of wrong length or is not numeric, -6 email did not validate,
		//-7 verification email failed
		{
			$email = trim($email);

			//validate data
			if (empty($surname) || empty($name) || empty($matrnr) || empty($email) || empty($pw) || empty($pw_repeat)) 
			{
				return -2;
            }
            elseif ($pw !== $pw_repeat) 
            {
            	return -3;
            }
            elseif (strlen($pw) < 6) 
            {
            	return -4;
        	} 
            elseif (strlen($matrnr) != 7 || !is_numeric($matrnr)) 
            {
            	return -5;
            } 
            elseif (strlen($email) > 64 || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/uni-bonn.de/",$email)) 
            {
           	 	return -6;
        	}

			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt_check_email = $db->prepare("SELECT email FROM cip_user WHERE email=:email ");
					$stmt_check_email->bindValue(':email', $email, PDO::PARAM_STR);
					$stmt_check_email->execute();
					$result = $stmt_check_email->fetchAll();

					if(count($result)>0)
					{
						return -1;		//email already exists in db
					}
					else
					{
						$pw = sha1($pw);
						$activation_hash = sha1(uniqid(mt_rand(), true));
						$pwreset_hash = sha1(uniqid(mt_rand(), true));
						$stmt = $db->prepare("INSERT INTO cip_user(email, name, surname, matrikelnr, password, activation_hash, pwreset_hash)
											VALUES (:email, :name, :surname, :matrikelnr, :password, :activation_hash, :pwreset_hash)");
						$stmt->bindValue(':email', $email, PDO::PARAM_STR);
						$stmt->bindValue(':name', $name, PDO::PARAM_STR);
						$stmt->bindValue(':surname', $surname, PDO::PARAM_STR);
						$stmt->bindValue(':matrikelnr', $matrnr, PDO::PARAM_INT);
						$stmt->bindValue(':password', $pw, PDO::PARAM_STR);
						$stmt->bindValue(':activation_hash', $activation_hash, PDO::PARAM_STR);
						$stmt->bindValue(':pwreset_hash', $pwreset_hash, PDO::PARAM_STR);

						$stmt->execute();

						$user_id =$db->lastInsertId();
						if($stmt)
						{
							if($this->sendVerificationEmail($user_id, $email, $activation_hash))
							{
								$db = null;
								return $user_id;
							}
							else
							{
								$stmt_delete_user = $db->prepare("DELETE FROM cip_user WHERE id = :user_id");
								$stmt_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
								//$stmt_delete_user->execute();
								$db = null;
								return -7;
							}
						}

					}
				}
				catch(PDOException $e)
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
		


		public function sendVerificationEmail($user_id, $email, $activation_hash)
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

            $mail->From = EMAIL_VERIFICATION_FROM;
            $mail->FromName = EMAIL_VERIFICATION_FROM_NAME;
            $mail->AddAddress($email);
            $mail->Subject = EMAIL_VERIFICATION_SUBJECT;

            $link = EMAIL_VERIFICATION_URL.'?id='.urlencode($user_id).'&verification_code='.urlencode($activation_hash);
            $mail->Body = EMAIL_VERIFICATION_CONTENT.' '.$link;
            
            if(!$mail->Send()) 
            {
            	//var_dump($mail);
            	return false;
            }
            else 
            {
           		return true;
            }
		}
		public function sendForgot($email)
		//0 - success -1 - no such user -2 - inactive -3 - failed to send email
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, pwreset_hash, active FROM cip_user WHERE email= :email");
					$stmt->bindParam(':email', $email);
					$stmt->execute();
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result)
					{
						if($result["active"])
						{
							if($this->sendForgotEmail($result['id'], $email, $result["pwreset_hash"]))
							{
								$db = null;
								return 1;
							}
							else
							{
								$db = null;
								return -4;
							}
							var_dump($result);
						}
						else
						{
							return -2;	//return unactive
						}
					}
					else
					{
						return -1; //no such user
					}
				}
				catch (PDOException $e)
				{

					$db = null;
					return -3;		//db error
				}
			}
			else
			{
				return -3;		//db error
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
            
            if(!$mail->Send()) 
            {
            	var_dump($mail);
            	return false;
            }
            else 
            {
            	//var_dump($mail);
           		return true;
            }
		}
		public function verifyPasswordResetLink($user_id, $pwresethash)
		//1 - true, -1 = false 0 = dbproblem
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT pwreset_hash FROM cip_user WHERE id= :user_id");
					$stmt->bindParam(':user_id', $user_id);
					$stmt->execute();
					$db = null;
					$result = $stmt->fetch(PDO::FETCH_NUM);
					if ($result[0] == $pwresethash)
					{
						return 1;
					}
					else
					{
						return -1; //something wrong
					}
				}
				catch (PDOException $e)
				{

					$db = null;
					return 0;		//db error
				}
			}
			else
			{
				return 0;
			}
		}
		public function getUserInformation($user_id)
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT email, name, surname, matrikelnr, active, role FROM cip_user WHERE 	id= :user_id");
					$stmt->bindParam(':user_id', $user_id);
					$stmt->execute();
					$db = null;
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result)
					{
						return $result;
						$db = null;
					}
					else
					{
						$db = null;
						return -1; //something wrong
					}
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
		public function verifyNewUser($user_id, $user_activation_hash)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt_verify_user = $db->prepare('UPDATE cip_user SET active = 1, activation_hash = NULL WHERE id = :user_id AND activation_hash = :user_activation_hash');
					$stmt_verify_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
					$stmt_verify_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
					$stmt_verify_user->execute();	

					if ($stmt_verify_user->rowCount()>0)
					{
						$db = 0;
						return 1;
					}
					else
					{
						$db = 0;
						return -1;
					}
				}
				catch(PDOException $e)
				{
					
					$db = 0;
					return 0;
				}

			}
			else
			{
				
				$db = 0;
				return 0;
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
					$stmt = $db->prepare('SELECT password FROM cip_user WHERE id = :user_id');
					$stmt->bindParam(':user_id', $user_id);
					$stmt->execute();
					$table_pw = $stmt->fetch(PDO::FETCH_NUM)[0];
					if ($table_pw != sha1($cur_pw))
					{
						$db = 0;
						return -1;
					}
					else
					{
						$new_pw = sha1($new_pw);
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
		public function resetPassword ($user_id, $new_pw, $new_pw_repeat)
		//1 success, 0 - db problem, -1 passwords don't match, -2 password field is empty, -3 password is too short
		{
			if ($new_pw != $new_pw_repeat)
			{
				return -1;
			}
			if (empty($new_pw))
			{
				return -2;
			}
			elseif (strlen($new_pw) < 6) 
            {
            	return -3;
        	} 
        	$db = db_connect();
        	if ($db)
			{
				try
				{
					$new_pw = sha1($new_pw);
					$pwreset_hash = sha1(uniqid(mt_rand(), true));
					$stmt = $db->prepare("UPDATE cip_user
										SET password = :new_pw, pwreset_hash = :pwreset_hash
										WHERE id = :user_id");
					$stmt->bindParam(':user_id', $user_id);
					$stmt->bindParam(':new_pw', $new_pw);
					$stmt->bindParam(':pwreset_hash', $pwreset_hash);
					$stmt->execute();
					if ($stmt)
					{
						return 1;
					}
					else
					{
						return 0;
					}

				}
				catch (PDOException $e)
				{
					$db = 0;
					return 0;
				}

			}
			else
			{
				return 0;
			}

		}
		public function listAllUsers()
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, email, name, surname, matrikelnr, active, role  FROM cip_user");
					$stmt->execute();
					$db = null;
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $result;
					$db = null;
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
	}

?>