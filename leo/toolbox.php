<?


//Toolbox

function readItem ( $item_code )
{
	$url = "http://eu.battle.net/api/wow/item/$item_code?locale=pt_PT";
    return json_decode(file_get_contents($url), true);	
}


	//$item = readItem("1935");
	//print_r($item);


 function downloadFile ($url, $path) {

  $ret = 0;	
  $newfname = $path;
  $file = fopen ($url, "rb");
  if ($file) {
    $newf = fopen ($newfname, "wb");

    if ($newf)
    while(!feof($file)) {
      fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
    }
  }

  if ($file) {
  	$ret = 1;
    fclose($file);
  }
  else $ret = 0;

  if ($newf) {
  	$ret = 1;
    fclose($newf);
  }
  else $ret = 0;

  return $ret;

 }

//Receive a bid or buyout string from Battle.net Armory and translate into int values, separated by gold, silver and bronze. 
function translateAmount($value)
{
    
    //Pad with zeros on the left in case the bid string is smaller than 4 chars.
    $value = str_pad($value, 4, "0", STR_PAD_LEFT);

    $bronze = (int) substr($value,-2); //Gather the last 2 chars of the bid string.
    $silver = (int) substr($value,-4,2); //From the backwards get the characters 4 and 3 from the bid string.
	$gold = (int) substr($value,0,-4); //Get all characters in the string minus the last four.
    
    //Amount is all the gold, silver and bronze converted to bronze.
	$amount = $bronze + ($silver * 100) + ($gold * 10000);

	$values = array("value" => $value,
					"gold" => $gold,
					"silver" => $silver,
					"bronze" => $bronze,
					"amount" => $amount
					);

	return $values;
}	

?>