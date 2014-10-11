<?
	//Include the lightweight API MeekroDB to help interfacing with MySQL.
	require_once 'meekrodb.2.3.class.php';
	//Include my helping functions
	require_once 'toolbox.php';

	//Tell PHP to wait 600 seconds instead of the deafult 30 secs. 
  set_time_limit(600);

  //Tick start time to calculate script elapsed time
	$start = microtime(true); 

	//URL to JSON file containing the URL we will use to gather info regarding AH.
	$url = 'http://us.battle.net/api/wow/auction/data/gallywix';
	
  //Convert to a JSON objet the contents of our first instructions. 
  $json = json_decode(file_get_contents($url), true);

	//Get the JSON File Address from the URL.
	$json_url = $json["files"][0]["url"];

	//The Timestamp provided by Blizzard is in Milliseconds
	//while PHP works with seconds, to work around this we
	//divide the timestamp per 1000.	
	$lastModified = date('Y-m-d H:i:s',($json["files"][0]["lastModified"]/1000));	
	
  //Get current date time and format it.
  $current_DateTime = new DateTime();
	$now = date('Y-m-d H:i:s',$current_DateTime->getTimeStamp());


	//Uncomment this if you would like to troubleshoot the SQL transactions
	DB::debugMode();  	


  //Insert the instructions to the database for future reference
	DB::insert('infolinks',array( 
		'fetch_date' => $now,
		'url' => $json_url,
		'last_modified' => $lastModified	
		));
	

  //Delete rows on infolinks older than 30 days
  DB::delete("infolinks","fetch_date < DATE_SUB(NOW(), INTERVAL 30 DAY)");


  //Remove old AH JSON file.
  if (file_exists("auctions.json")) unlink("auctions.json");


  //Is recognized by Blizzard that for some unknow reason the fecth for their URL
  //might return 404 (file not found) and to work around this issue the implementation
  //bellow will try to download the file for a limited amount of times. 
  //The flag to control this is $_lim and is highly recommended to not setup this flag
  //to a value higher than 10. If you already checked the URL for 10 times is quite obvious that
  //the service is currently down for maintance and there is no need to keep bothering with constant
  //access. 
  $_c=0; $_lim=5;
  while(!file_exists("auctions.json"))
  {
     downloadFile($json_url,"auctions.json");
     if (!file_exists("auctions.json")) ++$_c;
     if ($_c>=$_lim) { 
     	break; 
     	echo "Tentei por $_lim vezes abrir este arquivo e não consegui... sorry!\r\n";
  }   
  }


   //All the logic goes here... if the json file was download we will do the tricks otherwise we abort and report. 	
   if (file_exists("auctions.json"))   		
   {
   	  //Clean UP the database before update.
      DB::delete('auctions','%d',1);	
   	  $fp = fopen("auctions.json","r");
	  if ($fp!=null) 
      {
   	  		
      	$_row_counter=0;
      	while (($buffer = fgets($fp, 4096)) !== false) 
      	{
      		if (
      			(strlen($buffer)<100) && 
      			( (strpos($buffer, "alliance")) || (strpos($buffer, "horde")) || (strpos($buffer, "neutral")) )
      		   )
      		{
   			   if (strpos($buffer, "alliance")) $faction = "alliance";
   			   else if (strpos($buffer, "horde")) $faction = "horde";
   			   else if (strpos($buffer, "neutral")) $faction = "neutral";
   			   else $faction = "Not defined";
      		}

      	  if ((strpos($buffer, "auc")) && (strpos($buffer, "buyout"))) 
      	   {
      	   	$buffer = trim($buffer);
      	   	//Removes the colon at the end of buffer string to decode it as json
      	   	$buffer[strlen($buffer)-1] = " ";
      	   	$buffer = trim($buffer);      	   	
      	   	$auction = json_decode($buffer,true);      	   	

      	   	
      	   	//Check if the $auction is not null to then check array keys
      	   	//This is necessary bacause we just can't guarantee we will receive a complete json object.
      	   	if (!is_null($auction))
      	   	{	

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
			//print_r($auction);




      	 }
        
       }
 

      //Tick the end time to calculate the script's elapsed time
      $end = (microtime(true) - $start);
	   

       //Report to the user the amount of auctions inserted and how long did it take.
       if ($_row_counter>0) 
       	{
       		echo "Auctions inserted to DB: ".$_row_counter."\r\n";	
       		echo "Elapsed time: ".$end;
       	}	
       fclose($fp);       
   }
   else
   {
   	echo "Erro ao abrir o arquivo auctions.json";
   }
   	  
   }
   else echo "Desculpe, Garrosh deve ter feito algo pois o arquivo JSON não pode ser obtido... malditos Orcs!";



?>