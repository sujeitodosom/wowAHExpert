<?php

class InfoLinks extends Model{
    private $_fetch_date;
    private $_url;
    private $_last_modified;
    
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
