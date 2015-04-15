<?php
	session_start();
	
	// ini_set('display_errors', 1); 
	// error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Banga: Transfer money around the globe
		</title>
		
		<!-- Some SEO -->
		<meta name="Generator" content="Notepad++"/>
		<meta name="Author" content="Banga"/>
		<meta name="Keywords" content="money, transfer, global, world, currency, bitcoins"/>
		<meta name="Description" content="Banga"/>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"/>
		
		<!-- Style sheets importeren -->
		<link rel="stylesheet" type="text/css" href="styles/bootstrap.css"/>
		
		<script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script>
		
		<script type="text/javascript" async="" src="http://s3.buysellads.com/ac/bsa.js"></script>
		<script type="text/javascript" id="_bsap_js_c466df00a3cd5ee8568b5c4983b6bb19" src="http://s3.buysellads.com/r/s_c466df00a3cd5ee8568b5c4983b6bb19.js?v=1382493600000" async="async"></script>
		
		<script src="scripts/jquery.js"></script>
		<script src="scripts/bootstrap.min.js"></script>
		<script src="scripts/bootswatch.js"></script>
	</head>
	<body style>
		<script src="scripts/bsa.js"></script>
		<?php
			// Import controller class
			require('includes/classes/class.controller.php');
			
			// Create instance of controller
			$controller = new Controller();
			$wrongLogin = false;

			if(isset($_POST['login'])) {
			
				// User tried to log in
				$user = user::checkLogin($_POST['username'], $_POST['userpass']);
			
				if($user->get("uid") >= 1)
				{
					$controller->setLoggedIn(true, $user);
				}
				else 
				{
					$wrongLogin = true;
				}
			}	
		?>
		
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div cass="navbar-header">
					<a class="navbar-brand" href="index.php?p=home">
						Banga
					</a>
				
					<?php
					if($controller->getLoggedIn()) {
						$user = new user($controller->getUserID());
						$tCurrency = new currency($user->get("cid"));
						$userCurrency = $tCurrency->get("cid");
						if ($userCurrency == 1) {
							$userCurrency = "&dollar;";
						} else if ($userCurrency == 2) {
							$userCurrency = "&euro;";
						} else if ($userCurrency == 3) {
							$userCurrency = "&pound;";
						} else if ($userCurrency == 4) {
							$userCurrency = "Rs";
						}
					?>
					
					<span class="navbar-brand">
						<?php
							echo $user->get("first_name");
							echo " (".$userCurrency." ".$user->get("deposit").")";
						?>
					</span>
					
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
				  	</button>
				  	
				<?php
					}
				?>
				</div>
				
				<?php
					if($controller->getLoggedIn()) {
						$user = new user($controller->getUserID());
				?>
				
				<div class="navbar-collapse collapse" id="navbar-main" style="height: auto;">		
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a id="btnHistory" href="index.php?p=history">
								Transactions
							</a>
						<li>
						<li>
							<a id="btnHistory" href="index.php?p=orderhistory">
								Orders
							</a>
						<li>
						<li>
							<a id="btnHistory" href="index.php?p=logout">
								Log out
							</a>
						</li>
					</ul>
				</div>
				
				<?php
					}
				?>
				
			</div>
		</div>
		
		<!-- This is the main content, switching it with a php switch -->
		<div class="container">
			<div class="page-header" id="banner">
				<div class="row">
					<div class="col-lg-6">
				  	</div>
				</div>
			</div>
		
			<?php
				if($controller->getLoggedIn()) {
					include('includes/pages.php');
				}
				else {
					if(!isset($_GET['p']))
						$_GET['p'] = "home";
					
					switch($_GET['p'])
					{	
						case "home":
							include ('includes/pages/login.php');
							break;
						case "register":
							include ('includes/pages/createAccount.php');
							break;
						default:
							include ('includes/pages/login.php');
							break;
					}
				}
			?>
		
			<footer>
				<div class="row">
					<div class="col-lg-12">
						<p>Copyright - Banga. 2013 beta</p>
					</div>
				</div>
			</footer>
		</div>
		<!-- End of content -->
	</body>
</html>
