<?php
class order
{
    var $oid = 0;
	var $uidf = "";
	var $uidt = "";
	var $amount = 0;
	var $date = "";
     
    function __construct($oid = 0){
        $this->oid = $oid;
        $this->fetch();
    }
    
    private function fetch(){
        if(!is_null($this->oid) && $this->oid > 0){
            $SQL = "SELECT * FROM orders WHERE oid = '".$this->oid."'";
            
            $RS = mysql_query($SQL) or die("Error fetching order: ".mysql_error());
            
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
    	if($this->oid > 0){
        	$SQL = "UPDATE orders SET oid = '".mysql_real_escape_string($this->oid).
                "',  uidf = '".mysql_real_escape_string($this->uidf).
                "',  uidt = '".mysql_real_escape_string($this->uidt).
                "',  amount = '".mysql_real_escape_string($this->amount).
                "',  date = '".mysql_real_escape_string($this->date)."' WHERE oid = '".$this->oid."'";
			
            if(@mysql_query($SQL)){
            	return true;
            }else{
            	print("Error saving order into table order: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
                return false;
            }           
        }else{
    		$SQL = "INSERT INTO orders (oid, uidf, uidt, amount, date) VALUES ('".
                        mysql_real_escape_string($this->oid).
                        "', '".mysql_real_escape_string($this->uidf).
                        "', '".mysql_real_escape_string($this->uidt).                        
                        "', '".mysql_real_escape_string($this->amount).
                        "', '".mysql_real_escape_string($this->date)."');"; 
            
            $RS = mysql_query($SQL) or print("Error saving order into table order: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");

            if($oid = @mysql_insert_id()){
            	$this->oid = $oid;
                return true;
            }else{
            	return false;
            }
        }
		return false;
    }
    
    public function delete(){
    	if($this->oid > 0){
        	
        	$SQL = "DELETE FROM orders WHERE oid = '".$this->oid."' LIMIT 1; "; 
			
            $RS = mysql_query($SQL) or die("Error deleting order from table order: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
            
            if(mysql_affected_rows() > 0){
 				return true;
			}
        }else{
        	return false;
        }        
    }
	
	public static function listOrders($uid){
		
		$SQL = "SELECT oid FROM orders WHERE uidf = '".$uid."' OR uidt = '".$uid."' ORDER BY date DESC";
		
		$RS = mysql_query($SQL);
		
		$orders = array();
		
		while ($row = mysql_fetch_assoc($RS)){
			 $orders[] = new order($row['oid']); 
		}
		
		return $orders;
	}
}
?>