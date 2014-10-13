<?php

define('DS', DIRECTORY_SEPARATOR);
define('HOME', dirname(__FILE__));

require_once HOME . DS . 'utilities' . DS . 'meekrodb.2.3.class.php';
require_once HOME . DS . 'utilities' . DS . 'toolbox.class.php';

//URL to JSON file containing the URL we will use to gather info regarding AH.
$url = 'http://us.battle.net/api/wow/auction/data/gallywix';

$json = json_decode(file_get_contents($url), true);
$json_url = $json["files"][0]["url"];

//Get current date time and format it.
$current_DateTime = new DateTime();
$now = date('Y-m-d H:i:s',$current_DateTime->getTimeStamp());

$lastModified = date('Y-m-d H:i:s',($json["files"][0]["lastModified"]/1000));	


//==================================================================//

if (file_exists("auctions.json")) unlink("auctions.json");

$_c=0; $_lim=5;

while(!file_exists("auctions.json")){
    Toolbox::downloadFile($json_url,"auctions.json");
   if (!file_exists("auctions.json")) ++$_c;
   if ($_c>=$_lim) { 
      break; 
      echo "Tentei por $_lim vezes abrir este arquivo e não consegui... sorry!\r\n";
   }
}

//==================================================================//

if (file_exists("auctions.json")){
    
    //Clean UP the database before update.
    DB::delete('auctions','%d',1);	
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

                    $aucIns = DB::insert('auctions',array( 
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
                    ));

                    ++$_row_counter;
                }
            }
        }
       fclose($fp);       
    } else {
        echo "Erro ao abrir o arquivo auctions.json";
    }
} else {
    echo "Desculpe, Garrosh deve ter feito algo pois o arquivo JSON não pode ser obtido... malditos Orcs!";
}

//==================================================================//

DB::insert(
        'infolinks', array( 
                    'fetch_date' => $now,
                    'url' => $json_url,
                    'last_modified' => $lastModified
            )
        );

//Delete rows on infolinks older than 30 days
//Verificar a disponibilidade de guardar pelos menos 30 dias de dados no server.
DB::delete("infolinks","fetch_date < DATE_SUB(NOW(), INTERVAL 30 DAY)");

//==================================================================//

$texto = "safadinha_BR";

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title></title>
    </head>
    <body>
        <?php
            echo $texto;
        ?>
    </body>
</html>
