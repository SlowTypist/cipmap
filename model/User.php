<?php

include_once dirname(__DIR__).'/includes/db.php';
/**
 * Created by IntelliJ IDEA.
 * User: cryptexis
 * Date: 8/3/15
 * Time: 1:09 AM
 */
class User{


    public $id = 0;
    public $email = "";
    public $name = "";
    public $surname = "";
    public $matrikelNr = "";
    public $password = "";
    public $active = false;
    public $activation_hash = "";
    public $pw_reset = "";
    public $role = 0;

    public function save(){

    }

    public function update(){

    }

    public function get(){

    }

    public function getByEmail(){

        $db = db_connect();
        if ($db) {

            try {

                $this->email = trim($this->email);
                // preparing the query template
                $stmt = $db->prepare("SELECT id, password, active, role FROM cip_user WHERE email= :email");
                // setting variables
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result && $result["password"] == sha1($this->email.$this->password)) {

                    if($result["active"]) {

                        $out['id'] = $result["id"];
                        $out['role'] = $result["role"];
                        return($out);
                    } else {
                        return -2;	//return inactive
                    }
                } else {
                    return -1; //return wrong password or no such user
                }
            } catch (PDOException $e) {

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