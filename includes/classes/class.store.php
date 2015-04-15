<?php
class store{

    var $uid = 0;
	var $name = "";
	var $photo = "";
     
    function __construct($uid = 0){
        $this->uid = $uid;
        $this->fetch();
    }
    
    private function fetch(){
        if(!is_null($this->uid) && $this->uid > 0){
            $SQL = "SELECT * FROM store WHERE uid = '".$this->uid."'";
            
            $RS = mysql_query($SQL) or die("Fout bij het ophalen van de $classNaam: ".mysql_error());
            
            if($row = mysql_fetch_assoc($RS)){
                foreach($row as $key => $value){
                    $this->$key = $value;
                }
                return true;
            }
        }
        return false;
    }
	
    public function get($field){
        
        switch($field){
        
            default:
                return $this->$field;
            break;
        }
    }
    
    public function set($field, $value){
        
        switch($field){
     
            default:    
                $this->$field = $value;
            break;
        }
    }

    function save(){
    	if($this->uid > 0){
        	/**
             *  Object bestaat, bestaande rij in de database bijwerken.
             */
        	$SQL = "UPDATE store SET uid = '".mysql_real_escape_string($this->uid).
                "', name = '".mysql_real_escape_string($this->name).
                "',  photo = '".mysql_real_escape_string($this->photo)."' WHERE uid = '".$this->uid."'";
			
            if(@mysql_query($SQL)){
            	return true;
            }else{
            	print("Error saving store point into table store: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
                return false;
            }           
        }else{
    		$SQL = "INSERT INTO store (uid, name, photo, quantity, tid, amount) VALUES ('".
                        mysql_real_escape_string($this->uid).
                        "', '".mysql_real_escape_string($this->name).
                        "', '".mysql_real_escape_string($this->photo)."');"; 
            
            $RS = mysql_query($SQL) or print("Error saving store point into table store: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");

            if($uid = @mysql_insert_uid()){
            	$this->uid = $uid;
                return true;
            }else{
            	return false;
            }
        }
		return false;
    }
    
    public function delete(){
    	if($this->uid > 0){
        	
        	$SQL = "DELETE FROM store WHERE uid = '".$this->uid."' LIMIT 1; "; 
			
            $RS = mysql_query($SQL) or die("Error deleting store point from table store: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
            
            if(mysql_affected_rows() > 0){
 				return true;
			}
        }else{
        	return false;
        }        
    }
	
	public static function listStores(){
		
		$SQL = "SELECT uid FROM store";
		
		$RS = mysql_query($SQL);
		
        $num_rows = mysql_num_rows($RS);
        
		$stores = array();
		while ($row = mysql_fetch_assoc($RS)){
			 $stores[] = new store($row['uid']); 
		}
		
		return $stores;
	}

    public static function overzichtFilter($name){
        
        $SQL = "SELECT uid FROM store WHERE quantity > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 DAY) AND name = ".$name." ORDER BY quantity ASC";
        
        $RS = mysql_query($SQL);
        
        $stores = array();
        while ($row = mysql_fetch_assoc($RS)){
             $stores[] = new store($row['uid']); 
        }
        
        return $stores;
    }
	
    function __toString(){
    	$output = "<pre>Object type: store \n";
        $output .= "Gekoppelde tabel: store \n";
        $output .= "uidentifier (uid): ".$this->uid."\n\n";
        $output .= "------Veldgegevens------------\n";        
        $output .= "name (int): ".$this->name." \n";
		$output .= "photo (varchar): ".$this->photo." \n";
		
        $output .= "------Einde Veldgegevens------\n\n</pre>"; 
        return $output;    	
    }
}
?>