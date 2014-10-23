<?php

class HomeController extends Controller{
    
    public function __construct($model, $action) {
        parent::__construct($model, $action);
    }
    
    public function index(){
        $this->_view->set('greeting', 'Site under construction.');
        return $this->_view->output();
    }
    
}

?>
