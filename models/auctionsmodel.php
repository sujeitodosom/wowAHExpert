<?php

class AuctionsModel extends Model{
    private $_insert_date;
    private $_lastModified;
    private $_faction;
    private $_auc;
    private $_item;
    private $_owner;
    private $_ownerRealm;
    private $_bid;
    private $_buyout;
    private $_quantity;
    private $_timeLeft;
    private $_rand;
    private $_seed;
    private $_petSpeciesId;
    private $_petBreedId;
    private $_petLevel;
    private $_petQualityId;
    private $_rand;
    
    public function get_insert_date() {
        return $this->_insert_date;
    }

    public function set_insert_date($_insert_date) {
        $this->_insert_date = $_insert_date;
    }

    public function get_lastModified() {
        return $this->_lastModified;
    }

    public function set_lastModified($_lastModified) {
        $this->_lastModified = $_lastModified;
    }

    public function get_faction() {
        return $this->_faction;
    }

    public function set_faction($_faction) {
        $this->_faction = $_faction;
    }

    public function get_auc() {
        return $this->_auc;
    }

    public function set_auc($_auc) {
        $this->_auc = $_auc;
    }

    public function get_item() {
        return $this->_item;
    }

    public function set_item($_item) {
        $this->_item = $_item;
    }

    public function get_owner() {
        return $this->_owner;
    }

    public function set_owner($_owner) {
        $this->_owner = $_owner;
    }

    public function get_ownerRealm() {
        return $this->_ownerRealm;
    }

    public function set_ownerRealm($_ownerRealm) {
        $this->_ownerRealm = $_ownerRealm;
    }

    public function get_bid() {
        return $this->_bid;
    }

    public function set_bid($_bid) {
        $this->_bid = $_bid;
    }

    public function get_buyout() {
        return $this->_buyout;
    }

    public function set_buyout($_buyout) {
        $this->_buyout = $_buyout;
    }

    public function get_quantity() {
        return $this->_quantity;
    }

    public function set_quantity($_quantity) {
        $this->_quantity = $_quantity;
    }

    public function get_timeLeft() {
        return $this->_timeLeft;
    }

    public function set_timeLeft($_timeLeft) {
        $this->_timeLeft = $_timeLeft;
    }

    public function get_rand() {
        return $this->_rand;
    }

    public function set_rand($_rand) {
        $this->_rand = $_rand;
    }

    public function get_seed() {
        return $this->_seed;
    }

    public function set_seed($_seed) {
        $this->_seed = $_seed;
    }

    public function get_petSpeciesId() {
        return $this->_petSpeciesId;
    }

    public function set_petSpeciesId($_petSpeciesId) {
        $this->_petSpeciesId = $_petSpeciesId;
    }

    public function get_petBreedId() {
        return $this->_petBreedId;
    }

    public function set_petBreedId($_petBreedId) {
        $this->_petBreedId = $_petBreedId;
    }

    public function get_petLevel() {
        return $this->_petLevel;
    }

    public function set_petLevel($_petLevel) {
        $this->_petLevel = $_petLevel;
    }

    public function get_petQualityId() {
        return $this->_petQualityId;
    }

    public function set_petQualityId($_petQualityId) {
        $this->_petQualityId = $_petQualityId;
    }

}

?>
