<?php

class InfolinksModel extends Model{
    
    private $_fetch_date;
    private $_url;
    private $_last_modified;
    
    public function insert(){
        if($this->_fetch_date && $this->_last_modified && $this->_url){
            $this->_setSql( "INSERT INTO infolinks (fetch_date, url, last_modified) 
                            VALUES ('$this->_fetch_date', '$this->_url', '$this->_last_modified')");
            $this->query();
        } else {
            echo "This object is empty!";
        }
    }
    
    public function set_data($fetch_date, $last_modified, $url, $db){
        $this->_fetch_date = $fetch_date;
        $this->_last_modified = $last_modified;
        $this->_url = $url;
        $this->_db = $db;
    }
    
    public function get_info_links(){
        $this->_setSql("SELECT * FROM infolinks");
        $result = array();
        return $this->query($result);
    }

    public function get_fetch_date() {
        return $this->_fetch_date;
    }

    public function get_url() {
        return $this->_url;
    }

    public function get_last_modified() {
        return $this->_last_modified;
    }
}

?>
