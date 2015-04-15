<?php
	class InputControl
	{
        private $result = null;
		private $_conn = null;
		
		private $errorMsg = "";
       
		public function __construct()
		{
        }
		
		public function checkInput($input, $minLength, $name, $required)
		{
			if(strlen($input) > 0)
			{
				if(strlen($input) >= $minLength)
				{
					$input2 = htmlspecialchars($input);
					
					if($input == $input2)
					{
						return true;
					}
					else
					{
						$this->errorMsg .= "- $name cannot include special characters.<br/>";
						return false;
					}
				}
				else
				{
					$this->errorMsg .= "- $name should have at least $minLength characters.<br/>";
					return false;
				}
			}
			else
			{
				if($required)
				{
					// Input is a required field
					$this->errorMsg .= "- The field $name cannot be empty.<br/>";
					return false;
				}
				else
				{
					// pass validation, input was not required
					return true;
				}
			}
		}
		
		public function areEqual($value, $value2) {
			if($value == $value2) {
				return true;
			}
			else {
				$this->errorMsg .= "- The passwords are not equal.<br/>";
				return false;
			}
		}
		
		public function checkEmail($email)
		{
			if(strlen($email) > 0)
			{
				if(strlen($email) > 7)
				{
					if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
					{
						return true;
					}
					else
					{
						 $this->errorMsg .= '- The email address should have at least an @ and a dot.<br/>';
						 return false;
					}
				}
				else
				{
					$this->errorMsg .= "- An email address should have at least 8 characters.<br/>";
					return false;
				}
			}
			else
			{
				$this->errorMsg .= "- Email is a required field.<br/>";
				return false;
			}
		}
		
		public function checkZipcode($zipcode)
		{
			if(strlen($zipcode) > 0)
			{
				if(strlen($zipcode) > 4)
				{
					if(ctype_digit($zipcode))
					{
						return true;
					}
					else
					{
						 $this->errorMsg .= '- The zipcode should be 5 digits.<br/>';
						 return false;
					}
				}
				else
				{
					$this->errorMsg .= "- A zip code should be 5 digits long.<br/>";
					return false;
				}
			}
			else
			{
				// Required field
				$this->errorMsg .= "- Zip code is a required field.<br/>";
				return false;
			}
		}
		
		public function checkPhonenumber($phonenumber)
		{
			if(strlen($phonenumber) > 0)
			{
				$phonenumber2 = str_replace("+", "00", $phonenumber);
				
				if(strlen($phonenumber2) > 9)
				{
					if(ctype_digit($phonenumber2))
					{
						return true;
					}
					else
					{
						$this->errorMsg .= "- The telephone number should be exist of digits only.<br/>";
					}
				}
				else
				{
					$this->errorMsg .= "- Please fill in a phonenumber with a minimum of 10 characters.<br/>";
				}
			}
			else
			{
				// Required field, could not be empty
				$this->errorMsg .= "- Phonenumber is required and was still empty, please fill in a phonenumber.<br/>";
				return false;
			}
		}
		
		public function isNumeric($number)
		{
			if(strlen($number) > 0)
			{
				if(ctype_digit($number))
				{
					return true;
				}
				else
				{
					$this->errorMsg .= "- Please make sure to fill in a number.<br/>";
					return false;
				}
			}
			else
			{
				$this->errorMsg .= "- Please fill in the required field.<br/>";
				return false;
			}
		}
		
		public function checkPrice($price)
		{
			if(strlen($price) > 0)
			{
				$goodPrice = str_replace(",", ".", $price);
				$prices = explode(".", $goodPrice);
				
				if(count($prices[0]) > 0)
				{
					$amount = $prices[0];
				}
				else
				{
					$amount = $price;
				}
					
				if(isset($prices[1]) && strlen($prices[1]) > 0)
				{
					$digits = $prices[1];
					
					if(ctype_digit($amount) && ctype_digit($digits))
					{
						return true;
					}
					else
					{
						$this->errorMsg .= "- Please fill in a price in the form of 0.00.<br/>";
					}
				}
				else
				{
					if(ctype_digit($amount))
					{
						return true;
					}
					else
					{
						$this->errorMsg .= "- Could not validate the price entered, make sure it exists of numbers.<br/>";
					}
				}
			}
			else
			{
				// This field was still empty and not required, so pass the validation
				return true;
			}
		}
		
		public function isNull($choise, $type)
		{
			if($choise == 0)
			{
				$this->errorMsg .= "- Please make a selection for $type.<br/>";
				return false;
			}
			else
			{
				return true;
			}
		}
		
		public function getError()
		{
			return $this->errorMsg;
		}
		
		public function specialChars($input)
		{
			$input = str_replace("'", "&#39;", $input);
			$input = str_replace("\"", "&quot;", $input);
			$input = str_replace("é", "&eacute;", $input);
			$input = str_replace("ë", "&euml;", $input);
			
			return $input;
		}
	}
?>