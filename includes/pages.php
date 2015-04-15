<?php
	if(!isset($_GET['p']))
		$_GET['p'] = "home";
	
	switch($_GET['p'])
	{
		case "home":
			include ('includes/pages/home.php');
			break;
		case "deposit":
			include ('includes/pages/deposit.php');
			break;
		case "depositCard":
			include ('includes/pages/depositCard.php');
			break;
		case "depositCode":
			include ('includes/pages/depositCode.php');
			break;
		case "sendmoney":
			include ('includes/pages/sendmoney.php');
			break;
		case "market":
			include ('includes/pages/market.php');
			break;
		case "history":
			include ('includes/pages/history.php');
			break;
		case "orderhistory":
			include ('includes/pages/orderhistory.php');
			break;
		case "logout":
			include ('includes/pages/logout.php');
			break;
		case "cart":
			include ('includes/pages/cart.php');
			break;
		case "order":
			include ('includes/pages/order.php');
			break;
		case "addToCart":
			include ('includes/pages/addToCart.php');
			break;
		default:
			include ('includes/pages/home.php');
			break;
	}
?>