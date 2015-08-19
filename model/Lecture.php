<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13.08.15
 * Time: 01:50
 */
include_once dirname(__DIR__).'/includes/db.php';
class Lecture{
    public $id = 0;
    public $name = "";
    public $teacher = "";
    public $max_group_size = "";

    public function save(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("INSERT INTO cip_lecture(name, teacher, max_group_size)
                                      VALUES (:name, :teacher, :max_group_size)");
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':teacher', $this->teacher);
                $stmt->bindParam(':max_group_size', $this->max_group_size);

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
                $stmt = $db->prepare("UPDATE cip_lecture
                                      SET name = :name, teacher = :teacher, max_group_size = :max_group_size
                                      WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':teacher', $this->teacher);
                $stmt->bindParam(':max_group_size', $this->max_group_size);

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
                $stmt = $db->prepare("SELECT id,name, teacher, max_group_size
                                      FROM cip_lecture WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $this->id = $result["id"];
                    $this->name = $result["name"];
                    $this->teacher = $result['teacher'];
                    $this->max_group_size = $result['max_group_size'];
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
}