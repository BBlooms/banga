<?php
class user{

    var $uid = 0;
    var $cell_number = "";
    var $password = "";
	var $first_name = "";
    var $last_name = "";
	var $address = "";
	var $zipcode = "";
	var $city = "";
    var $state = "";
	var $country = "";
	var $deposit = "";
    var $card_number = "";
    var $card_expiration = "";
    var $card_secret = "";
    var $cid = "";
     
    function __construct($uid = 0){
        $this->uid = $uid;
        $this->fetch();
    }
    
    private function fetch(){
        if(!is_null($this->uid) && $this->uid > 0){
            $SQL = "SELECT * FROM user WHERE uid = '".$this->uid."'";
            
            $RS = mysql_query($SQL) or die("Error while fetching $classNaam: ".mysql_error());
            
            if($row = mysql_fetch_assoc($RS)){
                foreach($row as $key => $value){
                    $this->$key = $value;
                }
                return true;
            }
        }
        return false;
    }
    
    public static function checkLogin($username = "", $password = ""){
		
		$password = md5($password);
		
		$SQL = "SELECT * FROM user WHERE password = '".$password."' AND cell_number = '".$username."'";
		$RS = mysql_query($SQL);
		
		while ($row = mysql_fetch_assoc($RS)){
			 $user = new user($row['uid']);
			 return $user;
		}
		
		return new user(0);
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
    
    public function deposit($amount) {
    	if($this->deposit == 0) {
    		$this->deposit = $amount;
    	}
    	else {
    		$this->deposit += $amount;
    	}
    }
    
    public function sendMoney($amount) {
    	$this->deposit -= $amount;
    }

    function save(){
    	if($this->uid > 0){
        	/**
             *  Edit row in db because object exists.
             */
        	$SQL = "UPDATE user SET uid = '" . mysql_real_escape_string($this->uid) . 
                    "',  cell_number = '" . mysql_real_escape_string($this->cell_number) . 
                    "',  password = '" . mysql_real_escape_string($this->password) . 
                    "',  first_name = '" . mysql_real_escape_string($this->first_name) . 
                    "',  last_name = '" . mysql_real_escape_string($this->last_name) . 
                    "',  address = '" . mysql_real_escape_string($this->address) . 
                    "',  zipcode = '" . mysql_real_escape_string($this->zipcode) . 
                    "',  city = '" . mysql_real_escape_string($this->city) . 
                    "',  state = '" . mysql_real_escape_string($this->state) . 
                    "',  country = '" . mysql_real_escape_string($this->country) . 
                    "',  card_number = '" . mysql_real_escape_string($this->card_number) . 
                    "',  card_expiration = '" . mysql_real_escape_string($this->card_expiration) . 
                    "',  card_secret = '" . mysql_real_escape_string($this->card_secret) . 
                    "',  deposit = '" . mysql_real_escape_string($this->deposit) . 
                    "',  cid = '" . mysql_real_escape_string($this->cid) . 
                    "' WHERE uid = '" . $this->uid . "'";  
			
            if(@mysql_query($SQL)){
            	return true;
            }else{
            	print("Error saving user into table user: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
                return false;
            }           
        }else{
        	// create new row in database
    		$SQL = "INSERT INTO user (uid, cell_number, password, first_name, last_name, address, zipcode, city, state, country, card_number, card_expiration, card_secret, cid, deposit) VALUES ('" . 
                mysql_real_escape_string($this->uid).
                "', '".mysql_real_escape_string($this->cell_number).
                "', '" . mysql_real_escape_string($this->password) . 
                "', '" . mysql_real_escape_string($this->first_name) . 
                "', '" . mysql_real_escape_string($this->last_name) . 
                "', '" . mysql_real_escape_string($this->address) . 
                "', '" . mysql_real_escape_string($this->zipcode) . 
                "', '" . mysql_real_escape_string($this->city) . 
                "', '" . mysql_real_escape_string($this->state) . 
                "', '" . mysql_real_escape_string($this->country) . 
                "', '" . mysql_real_escape_string($this->card_number) . 
                "', '" . mysql_real_escape_string($this->card_expiration) . 
                "', '" . mysql_real_escape_string($this->card_secret) . 
                "', '" . mysql_real_escape_string($this->cid) . 
                "', '" . mysql_real_escape_string($this->deposit) . "');"; 
            
            $RS = mysql_query($SQL) or print("Error saving user into table user: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");

            if($id = @mysql_insert_id()){
            	$this->uid = $id;
                return true;
            }else{
            	return false;
            }
        }
		return false;
    }
    
    public function delete(){
    	if($this->uid > 0){
        	
        	$SQL = "DELETE FROM user WHERE uid = '".$this->uid."' LIMIT 1; "; 
			
            $RS = mysql_query($SQL) or die("Error deleting user from table user: <br /><pre>".mysql_error()."<br />".$SQL."</pre>");
            
            if(mysql_affected_rows() > 0){
 				return true;
			}
        }else{
        	return false;
        }        
    }
	
	public static function listUsers(){
		
		$SQL = "SELECT uid FROM user";
		
		$RS = mysql_query($SQL);
		
		$users = array();
		while ($row = mysql_fetch_assoc($RS)){
			 $users[] = new user($row['uid']); 
		}
		
		return $users;
	}
	
    function __toString(){
    	$output = "<pre>Object type: user \n";
        $output .= "Table: user \n";
        $output .= "Identifier (uid): ".$this->uid."\n\n";
        $output .= "------Fields------------\n";        
		$output .= "cell_number (varchar): ".$this->cell_number." \n";
        $output .= "first_name (varchar): ".$this->first_name." \n";
        $output .= "last_name (varchar): ".$this->last_name." \n";
		$output .= "address (varchar): ".$this->address." \n";
		$output .= "zipcode (varchar): ".$this->zipcode." \n";
		$output .= "city (varchar): ".$this->city." \n";
		$output .= "country (varchar): ".$this->country." \n";
		$output .= "deposit (varchar): ".$this->deposit." \n";
		
        $output .= "------End fields------\n\n</pre>"; 
        return $output;    	
    }
}
?>