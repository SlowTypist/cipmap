<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.08.15
 * Time: 19:07
 */
include_once dirname(__DIR__).'/includes/db.php';
include_once 'Homework.php';

class HomeworkList{

    public $lecture_id = 0;
    public $list = array();

    public function getAll(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id, name, lecture_id, start, end, max_points, link_task, link_solution
                                      FROM cip_homework
                                      WHERE lecture_id = :lecture_id
                                      ORDER BY id ASC");
                $stmt->bindParam(':lecture_id', $this->lecture_id);

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $homework = new Homework();
                    $homework->id = $row['id'];
                    $homework->name = $row['name'];
                    $homework->lecture_id = $row['lecture_id'];
                    $homework->start = $row['start'];
                    $homework->end = $row['end'];
                    $homework->max_points = $row['max_points'];
                    $homework->link_task = $row['link_task'];
                    $homework->link_solution = $row['link_solution'];
                    array_push($this->list, $homework);
                }

            }
            catch (PDOException $e){
                $this->lecture_id = -1;		//db error
            }
        }
        else{
            $this->lecture_id = -1;		//db error
        }

    }

}
?>