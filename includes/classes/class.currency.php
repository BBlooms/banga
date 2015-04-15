<?php
class currency
{
    var $cid = 0;
	var $symbol = "";
	var $name = "";
	var $value = 0;
     
    function __construct($cid = 0){
        $this->cid = $cid;
        $this->fetch();
    }
    
    private function fetch(){
        if(!is_null($this->cid) && $this->cid > 0){
            $SQL = "SELECT * FROM currency WHERE cid = '".$this->cid."'";
            
            $RS = mysql_query($SQL) or die("Error fetching currency: ".mysql_error());
            
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
    	if($this->ciid > 0){
        	$SQL = "UPDATE currency SET cid = '".mysql_real_escape_string($this->cid).
                "',  symbol = '".mysql_real_escape_string($this->symbol).
                "',  name = '".mysql_real_escape_string($this->name).
                "',  value = '".mysql_real_escape_string($this->value)."' WHERE cid = '".$this->cid."'";
			
            if(@mysql_query($SQL)){
            	return true;
            }else{
            	print("Error saving currency into table currency: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
                return false;
            }           
        }else{
    		$SQL = "INSERT INTO currency (cid, symbol, name, value) VALUES ('".
                        mysql_real_escape_string($this->cid).
                        "', '".mysql_real_escape_string($this->symbol).                     
                        "', '".mysql_real_escape_string($this->name).
                        "', '".mysql_real_escape_string($this->value)."');"; 
            
            $RS = mysql_query($SQL) or print("Error saving currency point into table currency: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");

            if($cid = @mysql_insert_id()){
            	$this->cid = $cid;
                return true;
            }else{
            	return false;
            }
        }
		return false;
    }
    
    public function delete(){
    	if($this->cid > 0){
        	
        	$SQL = "DELETE FROM currency WHERE cid = '".$this->cid."' LIMIT 1; "; 
			
            $RS = mysql_query($SQL) or die("Error deleting currency from table currency: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
            
            if(mysql_affected_rows() > 0){
 				return true;
			}
        }else{
        	return false;
        }        
	}
	
	public static function listCurrencies(){
		
		$SQL = "SELECT cid FROM currency";
		
		$RS = mysql_query($SQL);
		
        $num_rows = mysql_num_rows($RS);
        
		$currencies = array();
		
		while ($row = mysql_fetch_assoc($RS)){
			 $currencies[] = new currency($row['cid']); 
		}
		
		return $currencies;
	}
}
?>