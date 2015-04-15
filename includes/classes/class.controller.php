<?php
	define( 'ROOT_DIR', dirname(__FILE__) );

	//import classes
	require(ROOT_DIR.'/class.database.php');
	require(ROOT_DIR.'/class.inputcontrol.php');
	require(ROOT_DIR.'/class.user.php');
	require(ROOT_DIR.'/class.store.php');
	require(ROOT_DIR.'/class.item.php');
	require(ROOT_DIR.'/class.cart_item.php');
	require(ROOT_DIR.'/class.transaction.php');
	require(ROOT_DIR.'/class.currency.php');
	require(ROOT_DIR.'/class.order.php');
	require(ROOT_DIR.'/class.order_item.php');
	
	class Controller
	{
		var $inputControl = null;
		
		function __construct()
		{
			$this->inputControl = new InputControl();
			
			$this->sessionDefaults();
		}
		
		public function sessionDefaults()
		{
			if(!isset($_SESSION['loggedin']))
				$_SESSION['loggedin'] = false;
			if(!isset($_SESSION['adminid']))
				$_SESSION['adminid'] = 0;
			if(!isset($_SESSION['user']))
				$_SESSION['user'] = null;
			if(!isset($_SESSION['cart']))
				$_SESSION['cart'] = array();
		}
		
		public function setLoggedIn($bool, $user)
		{
			$_SESSION['loggedin'] = $bool;
			
			if($bool)
			{
				$_SESSION['uid'] = $user->get("uid");
				$_SESSION['user'] = $user;
			}
			else
			{
				$_SESSION['uid'] = 0;
				$_SESSION['user'] = null;
			}
		}
		
		public function getLoggedIn()
		{
			return $_SESSION['loggedin'];
		}
		
		public function getUserID()
		{
			return $_SESSION['uid'];
		}
		
		public function getCart() {
			return $_SESSION['cart'];
		}
		
		public function get($field)
		{
			switch($field)
			{
				default:
					return $this->$field;
				break;
			}
		}
		
		public function set($field, $value)
		{
			switch($field)
			{
				default:    
					$this->$field = $value;
				break;
			}
		}
	}
?>