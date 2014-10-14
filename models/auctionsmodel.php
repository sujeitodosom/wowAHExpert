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
    private $_seed;
    private $_petSpeciesId;
    private $_petBreedId;
    private $_petLevel;
    private $_petQualityId;
    private $_rand;
    

    public function set_data($auction){
        $this->_insert_date = $auction->insert_date;
        $this->_lastModified = $auction->lastModified;
        $this->_faction = $auction->faction;
        $this->_auc = $auction->auc;
        $this->_item = $auction->item;
        $this->_owner = $auction->owner;
        $this->_ownerRealm = $auction->ownerRealm;
        $this->_bid = $auction->bid;
        $this->_buyout = $auction->buyout;
        $this->_quantity = $auction->quantity;
        $this->_timeLeft = $auction->timeLeft;
        $this->_seed = $auction->seed;
        $this->_petSpeciesId = $auction->petSpeciesId;
        $this->_petBreedId = $auction->petBreedId;
        $this->_petLevel = $auction->petLevel;
        $this->_petQualityId = $auction->petQualityId;
        $this->_rand = $auction->rand;
    }
    
    public function insert(){
        $this->_setSql("INSERT INTO auctions (
                            insert_date, lastModified, faction, auc, item, owner,
                            ownerRealm, bid, buyout, quantity, timeLeft, seed, petSpeciesId, 
                            petBreedId, petLevel, petQualityId, rand
                        ) VALUES (
                            '$this->_insert_date', '$this->_lastModified', '$this->_faction', 
                            '$this->_auc', '$this->_item', '$this->_owner', '$this->_ownerRealm', 
                            '$this->_bid', '$this->_buyout', '$this->_quantity', '$this->_timeLeft', 
                            '$this->_seed', '$this->_petSpeciesId', '$this->_petBreedId', '$this->_petLevel', 
                            '$this->_petQualityId', '$this->_rand')");
        
        $this->query();
    }
    
}

?>
