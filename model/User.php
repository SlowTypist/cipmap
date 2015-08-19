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
    public $matrikelnr = "";
    public $password = "";
    public $active = false;
    public $activation_hash = "";
    public $pwreset_hash = "";
    public $role = 0;

    public function save(){
        $db = db_connect();
        if ($db){
            try{
                $this->email = trim($this->email);
                $stmt = $db->prepare("INSERT INTO cip_user(email, name, surname, matrikelnr, password, active, activation_hash, pwreset_hash, role)
                                      VALUES (:email, :name, :surname, :matrikelnr, :password, :active,  :activation_hash, :pwreset_hash, :role)");
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':surname', $this->surname);
                $stmt->bindParam(':matrikelnr', $this->matrikelnr);
                $stmt->bindParam(':password', $this->password);
                $stmt->bindParam(':active', $this->active);
                $stmt->bindParam(':activation_hash', $this->activation_hash);
                $stmt->bindParam(':pwreset_hash', $this->pwreset_hash);
                $stmt->bindParam(':role', $this->role);

                $stmt->execute();
                $this->id = $db->lastInsertId();

            }
            catch (PDOException $e){
                $db = null;
                $this->id = -1;
            }
        }
        else
        {
            $this->id = -1;		//db error
        }

    }

    public function update(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("UPDATE cip_user
                                      SET email = :email, name = :name, surname = :surname,
                                      matrikelnr = :matrikelnr, password = :password, active = :active,
                                      activation_hash = :activation_hash, pwreset_hash = :pwreset_hash, role = :role
                                      WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':surname', $this->surname);
                $stmt->bindParam(':matrikelnr', $this->matrikelnr);
                $stmt->bindParam(':password', $this->password);
                $stmt->bindParam(':active', $this->active);
                $stmt->bindParam(':activation_hash', $this->activation_hash);
                $stmt->bindParam(':pwreset_hash', $this->pwreset_hash);
                $stmt->bindParam(':role', $this->role);

                $stmt->execute();

                if ($stmt->rowCount() < 1){
                    $this->id = 0;
                }
            }
            catch(PDOException $e){
                $this->id = -1;
            }

        }
        else
        {
            $this->id = -1;		//db error
        }
    }

    public function get(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id,email,name,surname, matrikelnr, password, active,activation_hash, pwreset_hash, role FROM cip_user WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $this->id = $result["id"];
                    $this->email = $result["email"];
                    $this->name = $result['name'];
                    $this->surname = $result['surname'];
                    $this->matrikelnr = $result['matrikelnr'];
                    $this->password = $result['password'];
                    $this->active = $result['active'];
                    $this->activation_hash = $result['activation_hash'];
                    $this->pwreset_hash = $result['pwreset_hash'];
                    $this->role = $result["role"];
                }
                else{
                    $this->id = 0;
                }
            }
            catch(PDOException $e){
                $db = null;
                $this->id = -1;
            }
        }
        else
        {
            $this->id = -1;		//db error
        }

    }

    public function getByEmail(){

        $db = db_connect();
        if ($db) {

            try {

                $this->email = trim($this->email);
                // preparing the query template
                $stmt = $db->prepare("SELECT id,name,surname, matrikelnr, password, active,
                                      activation_hash, pwreset_hash, role
                                      FROM cip_user WHERE email= :email");
                // setting variables
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $this->id = $result["id"];
                    $this->name = $result['name'];
                    $this->surname = $result['surname'];
                    $this->matrikelnr = $result['matrikelnr'];
                    $this->password = $result['password'];
                    $this->active = $result['active'];
                    $this->activation_hash = $result['activation_hash'];
                    $this->pwreset_hash = $result['pwreset_hash'];
                    $this->role = $result["role"];
                }
            }
            catch (PDOException $e) {

                $db = null;
                $this->id = -1;		//db error
            }
        }
        else
        {
            $this->id = -1;		//db error
        }

    }

}