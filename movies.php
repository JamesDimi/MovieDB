<?php

/**
 * Created by PhpStorm.
 * User: linuxlite
 * Date: 16/6/2016
 * Time: 11:35 μμ
 */

class movies
{
    var $title = null;
    var $year = null;
    var $type = null;
    var $picture = null;
    var $synopsis = null;

    function setTitle($title){
        $this->title = $title;
    }

    function setYear($year){
        $this->year = $year;
    }

    function setType($type){
        $this->type = $type;
    }

    function setPicture($picture){
        $this->picture = $picture;
    }

    function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function getSynopsis()
    {
        return $this->synopsis;
    }
}