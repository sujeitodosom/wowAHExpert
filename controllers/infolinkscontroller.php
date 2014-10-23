<?php

class InfolinksController extends Controller{
    
    public function __construct($model, $action) {
        parent::__construct($model, $action);
        $this->__setModel($model);
    }
    
    public function index(){
        $links = $this->_model->get_info_links();
        $this->_view->set('infolinks', $links);
        $this->_view->set('title', 'Last file downloaded from Auction House.');
        $this->_view->set('greeting', 'Bom dia é o caralho!');
        
        return $this->_view->output();
    }
    
    public function get_links(){
        
    }

}

?>
