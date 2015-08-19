<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 13.08.15
 * Time: 02:36
 */
include_once dirname(__DIR__).'/includes/db.php';
include_once 'Lecture.php';

class LectureList{
    public $list = array();

    public function getAll(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id, name, teacher, max_group_size
                                      FROM cip_lecture
                                      ORDER BY id DESC");

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $lecture = new Lecture();
                    $lecture->id = $row['id'];
                    $lecture->name = $row['name'];
                    $lecture->teacher = $row['teacher'];
                    $lecture->max_group_size = $row['max_group_size'];
                    array_push($this->list, $lecture);
                }

            }
            catch (PDOException $e){
                $this->list = -1;		//db error
            }
        }
        else{
            $this->list = -1;		//db error
        }

    }

}
?>