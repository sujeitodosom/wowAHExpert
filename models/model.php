<?php

class Model{
    protected $_db;
    protected $_sql;
    
    public function __construct() {
    }
    
    public function _setSql($sql){
        $this->_sql = $sql;
    }
    
    public function _setDB($db){
        $this->_db = $db;
    }

    public function query(){
        if($this->_db){
            if($this->_sql){
                $this->_db->query($this->_sql);
            } else {
                throw new Exception('No SQL query.');
            }
        } else {
            throw new Exception('You need to set a database for this object.');
        }
    }

}
?>
