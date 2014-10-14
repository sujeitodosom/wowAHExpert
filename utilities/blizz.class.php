<?php

class Blizz {
    
    private static $_ah_url = "http://us.battle.net/api/wow/auction/data/";
    
    private static function downloadFile ($url, $filename){

        $ret = 0;
        
        $file = fopen ($url, "rb");
        
        if ($file) {
            $newf = fopen ($filename, "wb");
            if ($newf){
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
                }
            }
        }

        if ($file) {
            $ret = 1;
            fclose($file);
        } else {
            $ret = 0;
        }

        if ($newf) {
            $ret = 1;
            fclose($newf);
        } else {
            $ret = 0;
        }

        return $ret;
    }

    public static function get_ah_info($server = "gallywix"){
        return json_decode(file_get_contents($this->_ah_url .= $server), true);
    }
    
    public static function get_auctions($json){
        if (file_exists("auctions.json")) unlink("auctions.json");
        
        $_c=0; $_lim=5;

        while(!file_exists("auctions.json")){
            $this->downloadFile($json["files"][0]["url"],"auctions.json");
            if (!file_exists("auctions.json")) ++$_c;
            if ($_c>=$_lim) { 
              break; 
              echo "Tentei por $_lim vezes abrir este arquivo e não consegui... sorry!\r\n";
            }
        }
    }



}
?>
