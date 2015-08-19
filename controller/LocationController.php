<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.08.15
 * Time: 02:34
 */
require_once(dirname(__DIR__).'/model/Location.php');
require_once(dirname(__DIR__).'/model/LocationList.php');
class LocationController{

    public function locationInfo($id){
        $location = new Location();
        $location->id = $id;

        $location->get();

        return $location;

    }

    public function listAll(){
        $locationList = new LocationList();

        $locationList->getAll();

        return $locationList->list;
    }

    public function listAllAvailable($homework_id){
        $locationList = new LocationList();
        $locationList->homework_id = $homework_id;

        $locationList->getAllFromHomework();

        return $locationList->list;
    }

}