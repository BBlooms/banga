<?php
class transaction
{
    var $tid = 0;
	var $uid_from = "";
	var $uid_to = "";
	var $send_date = "";
	var $receive_date = "";
    var $amount = "";
     
    function __construct($tid = 0){
        $this->tid = $tid;
        $this->fetch();
    }
    
    private function fetch(){
        if(!is_null($this->tid) && $this->tid > 0){
            $SQL = "SELECT * FROM transaction WHERE tid = '".$this->tid."'";
            
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
    	if($this->tid > 0){
        	$SQL = "UPDATE transaction SET tid = '".mysql_real_escape_string($this->tid).
                "', uid_from = '".mysql_real_escape_string($this->uid_from).
                "',  uid_to = '".mysql_real_escape_string($this->uid_to).
                "',  send_date = '".mysql_real_escape_string($this->send_date).
                "',  receive_date = '".mysql_real_escape_string($this->receive_date).
                "', amount = '".mysql_real_escape_string($this->amount)."' WHERE tid = '".$this->tid."'";
			
            if(@mysql_query($SQL)){
            	return true;
            }else{
            	print("Error saving transaction point into table transaction: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
                return false;
            }           
        }else{
    		$SQL = "INSERT INTO transaction (tid, uid_from, uid_to, send_date, receive_date, amount) VALUES ('".
                        mysql_real_escape_string($this->tid).
                        "', '".mysql_real_escape_string($this->uid_from).
                        "', '".mysql_real_escape_string($this->uid_to).                        
                        "', '".mysql_real_escape_string($this->send_date).
                        "', '".mysql_real_escape_string($this->receive_date).
                        "','".mysql_real_escape_string($this->amount)."');"; 
            
            $RS = mysql_query($SQL) or print("Error saving transaction point into table transaction: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");

            if($tid = @mysql_insert_tid()){
            	$this->tid = $tid;
                return true;
            }else{
            	return false;
            }
        }
		return false;
    }
    
    public function delete(){
    	if($this->tid > 0){
        	
        	$SQL = "DELETE FROM transaction WHERE tid = '".$this->tid."' LIMIT 1; "; 
			
            $RS = mysql_query($SQL) or die("Error deleting transaction point from table transaction: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
            
            if(mysql_affected_rows() > 0){
 				return true;
			}
        }else{
        	return false;
        }        
    }
    
    public static function listTransactions($uid) {
    	$SQL = "SELECT tid FROM transaction WHERE uid_from = '".$uid."' OR uid_to = '".$uid."' ORDER BY send_date DESC";
		
		$RS = mysql_query($SQL);
		
        $num_rows = mysql_num_rows($RS);
        
		$transactions = array();
		while ($row = mysql_fetch_assoc($RS)){
			 $transactions[] = new transaction($row['tid']); 
		}
		
		return $transactions;
    }
	
	public static function listSent($uid){
		
		$SQL = "SELECT tid FROM transaction WHERE uid_from = '".$uid."' ORDER BY send_date DESC";
		
		$RS = mysql_query($SQL);
		
        $num_rows = mysql_num_rows($RS);
        
		$transactions = array();
		while ($row = mysql_fetch_assoc($RS)){
			 $transactions[] = new transaction($row['tid']); 
		}
		
		return $transactions;
	}
	
	public static function listReceived($uid){
		
		$SQL = "SELECT tid FROM transaction WHERE uid_to= '".$uid."' ORDER BY send_date DESC";
		
		$RS = mysql_query($SQL);
		
        $num_rows = mysql_num_rows($RS);
        
		$transactions = array();
		while ($row = mysql_fetch_assoc($RS)){
			 $transactions[] = new transaction($row['tid']); 
		}
		
		return $transactions;
	}
	
    function __toString(){
    	$output = "<pre>Object type: transaction \n";
        $output .= "Gekoppelde tabel: transaction \n";
        $output .= "tidentifier (tid): ".$this->tid."\n\n";
        $output .= "------Veldgegevens------------\n";        
        $output .= "uid_from (int): ".$this->uid_from." \n";
		$output .= "send_date (varchar): ".$this->send_date." \n";
		$output .= "receive_date (varchar): ".$this->receive_date." \n";
		$output .= "uid_to (varchar): ".$this->uid_to." \n";
		
        $output .= "------Einde Veldgegevens------\n\n</pre>"; 
        return $output;    	
    }
}
?>