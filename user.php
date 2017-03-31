<?php
/**
 * Created by PhpStorm.
 * User: Παναγιώτης
 * Date: 16/6/2016
 * Time: 10:54 μμ
 */
class user{

    var $_user = null;
    var $_password = null;
    var $_id=null;
    var $_time=null;

    function setusername($value) {
        $this->_user = $value;
    }
    function setpassword($value) {
        $this->_password = $value;
    }
    function getUsername(){
        return $this->_user ;
    }
    function getpassword(){
        return $this->_password;
    }
    function setid($value){
        $this->_id=$value;
    }
    function settime($value){
        $this->_time=$value;
    }


}
?>