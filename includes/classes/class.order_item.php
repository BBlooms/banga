<?php
class order_item
{
    var $oiid = 0;
	var $oid = 0;
	var $iid = 0;
     
    function __construct($oiid = 0){
        $this->oiid = $oiid;
        $this->fetch();
    }
    
    private function fetch(){
        if(!is_null($this->oiid) && $this->oiid > 0){
            $SQL = "SELECT * FROM order_item WHERE oiid = '".$this->oiid."'";
            
            $RS = mysql_query($SQL) or die("Error fetching order_item: ".mysql_error());
            
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
    	if($this->oiid > 0){
        	$SQL = "UPiid order_item SET oiid = '".mysql_real_escape_string($this->oiid).
                "',  oid = '".mysql_real_escape_string($this->oid).
                "',  iid = '".mysql_real_escape_string($this->iid)."' WHERE oiid = '".$this->oiid."'";
			
            if(@mysql_query($SQL)){
            	return true;
            }else{
            	print("Error saving order_item into table order_item: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
                return false;
            }           
        }else{
    		$SQL = "INSERT INTO order_item (oiid, oid, iid) VALUES ('".
                        mysql_real_escape_string($this->oiid).
                        "', '".mysql_real_escape_string($this->oid).
                        "', '".mysql_real_escape_string($this->iid)."');"; 
            
            $RS = mysql_query($SQL) or print("Error saving order_item into table order_item: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");

            if($oiid = @mysql_insert_id()){
            	$this->oiid = $oiid;
                return true;
            }else{
            	return false;
            }
        }
		return false;
    }
    
    public function delete(){
    	if($this->oiid > 0){
        	
        	$SQL = "DELETE FROM order_item WHERE oiid = '".$this->oiid."' LIMIT 1; "; 
			
            $RS = mysql_query($SQL) or die("Error deleting order_item from table order_item: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
            
            if(mysql_affected_rows() > 0){
 				return true;
			}
        }else{
        	return false;
        }        
    }
	
	public static function listOrderItems($oid){
		
		$SQL = "SELECT oiid FROM order_item WHERE oid = '".$oid."'";
		
		$RS = mysql_query($SQL);
		
        $num_rows = mysql_num_rows($RS);
        
		$order_items = array();
		while ($row = mysql_fetch_assoc($RS)){
			 $order_items[] = new order_item($row['oiid']); 
		}
		
		return $order_items;
	}
}
?>