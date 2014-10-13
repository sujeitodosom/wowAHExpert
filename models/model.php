<?php

require_once HOME . DS . 'utilities' . DS . 'meekrodb.2.3.class.php';

class Model{
    protected $_sql;
    
    public function __construct() {
    }
    
    public function _setSql($sql){
        $this->_sql = $sql;
    }
    
    public function getAll($data = null){
        if(!$this->_sql){
            throw new Exception('No SQL query.');
        }
        
        $sth = DB::query($this->_sql);
        
        return $sth;
    }
    
    public function getRow($data = null){
        if(!$this->_sql){
            throw new Exception('No SQL query.');
        }
        
        $sth = DB::query($this->_sql);
        
        return $sth;
    }

}
?>
