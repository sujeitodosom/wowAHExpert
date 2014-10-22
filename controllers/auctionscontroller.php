<?php

class AuctionsController extends Controller{
    
    public function __construct($model, $action) {
        parent::__construct($model, $action);
        $this->__setModel($model);
    }
    
    public function index(){
        $this->_view->set('title', 'wowAHExpert.');
        return $this->_view->output();
    }
    
    public function save_action_house($auction){
        $auc = new AuctionsModel();
        $auc->set_data($auction);
        $auc->insert();
    }
    
    public function process_auctions_file(){
        if (file_exists("auctions.json")){

            AuctionsModel::clean_up();
           
            $fp = fopen("auctions.json","r");
            
            if ($fp!=null){
                $_row_counter=0;
                //Parser do arquivo json.
                while (($buffer = fgets($fp, 4096)) !== false){
                    //Identifica facção.
                    if ((strlen($buffer)<100) && 
                        ((strpos($buffer, "alliance")) || 
                        (strpos($buffer, "horde")) || 
                        (strpos($buffer, "neutral")) )){
                            if (strpos($buffer, "alliance")) $faction = "alliance";
                            else if (strpos($buffer, "horde")) $faction = "horde";
                            else if (strpos($buffer, "neutral")) $faction = "neutral";
                            else $faction = "Not defined";
                    }

                    //Identifica ação.
                    if ((strpos($buffer, "auc")) && (strpos($buffer, "buyout"))){
                        $buffer = trim($buffer);
                        //Removes the colon at the end of buffer string to decode it as json
                        $buffer[strlen($buffer)-1] = " ";
                        $buffer = trim($buffer);      	   	
                        $auction = json_decode($buffer,true);      	   	


                        //Check if the $auction is not null to then check array keys
                        //This is necessary bacause we just can't guarantee we will receive a complete json object.
                        if (!is_null($auction)){	

                            if (!array_key_exists("auc",$auction)) $auction["auc"] = "";      	   	
                            if (!array_key_exists("item",$auction)) $auction["item"] = "";
                            if (!array_key_exists("owner",$auction)) $auction["owner"] = "";
                            if (!array_key_exists("ownerRealm",$auction)) $auction["ownerRealm"] = "";

                            if (!array_key_exists("bid",$auction)) $auction["bid"] = "";      	   	
                            if (!array_key_exists("buyout",$auction)) $auction["buyout"] = "";
                            if (!array_key_exists("quantity",$auction)) $auction["quantity"] = "";
                            if (!array_key_exists("timeLeft",$auction)) $auction["timeLeft"] = "";

                            if (!array_key_exists("rand",$auction)) $auction["rand"] = "";      	   	
                            if (!array_key_exists("seed",$auction)) $auction["seed"] = "";

                            if (!array_key_exists("petSpeciesId",$auction)) $auction["petSpeciesId"] = "";      	   	
                            if (!array_key_exists("petBreedId",$auction)) $auction["petBreedId"] = "";
                            if (!array_key_exists("petLevel",$auction)) $auction["petLevel"] = "";
                            if (!array_key_exists("petQualityId",$auction)) $auction["petQualityId"] = "";

                            $aucIns = array( 
                                'insert_date' => $now,
                                'lastModified' => $lastModified,
                                'faction' => $faction,
                                'auc' => $auction["auc"],
                                'item' => $auction["item"],
                                'owner' => $auction["owner"],
                                'ownerRealm' => $auction["ownerRealm"],
                                'bid' => $auction["bid"],
                                'buyout' => $auction["buyout"],
                                'quantity' => $auction["quantity"],
                                'timeLeft' => $auction["timeLeft"],
                                'rand' => $auction["rand"],
                                'seed' => $auction["seed"],
                                'petSpeciesId' => $auction["petSpeciesId"],
                                'petBreedId' => $auction["petBreedId"],
                                'petLevel' => $auction["petLevel"],
                                'petQualityId' => $auction["petQualityId"]					
                            );
                            
                            $this->save_action_house($aucIns);
                            ++$_row_counter;
                        }
                    }
                }
               fclose($fp);       
            } else {
                echo "Erro ao abrir o arquivo auctions.json";

            }
        }
    }

}

?>
