<?php

require_once 'model.php';

class InfoLinks extends Model{
    
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

    public function get_fetch_date() {
        return $this->_fetch_date;
    }

    public function set_fetch_date($_fetch_date) {
        $this->_fetch_date = $_fetch_date;
    }

    public function get_url() {
        return $this->_url;
    }

    public function set_url($_url) {
        $this->_url = $_url;
    }

    public function get_last_modified() {
        return $this->_last_modified;
    }

    public function set_last_modified($_last_modified) {
        $this->_last_modified = $_last_modified;
    }
}

?>
