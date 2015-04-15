<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="panel panel-default">
        		<div class="panel-heading">Deposit</div>
            	<div class="panel-body">

<?php
	if(isset($_GET["uid"])) {
		$uid = $_GET["uid"];
		$mUser = new user($uid);
		
		if(isset($_POST["btnPay"]) || isset($_GET["btnPay"])) {
			if (isset($_GET["btnPay"])) {
				$amount = $_GET["amount"];
			} else {
				$amount = $_POST["amount"];
			}
			
			if($controller->get("inputControl")->checkInput($amount, 1, "money amount", true)) {}
			
			$errorMessage = "";
			$errorMessage .= $controller->get("inputControl")->getError();
			
			if(strlen($errorMessage) == 0)
			{
				$currentAmount = $user->get("deposit");
			
				if($currentAmount >= $amount) {
					$user->sendMoney($amount);
					
					// Calculate new currency:
					$curValue = $tCurrency->get("value");
					$mCurrency = new currency($mUser->get("cid"));
					$mCurValue = $mCurrency->get("value");
					
					$newAmount = (($amount / $curValue) * $mCurValue);
					
					$mUser->deposit($newAmount);
				
					$transaction  = new transaction();
					$transaction->set("uid_from", $user->get("uid"));
					$transaction->set("uid_to", $mUser->get("uid"));
					$transaction->set("amount", $amount);
					$today = date("m/d/y");
					$transaction->set("send_date", $today);
				
					if($user->save() && $mUser->save()) {
					?>	
						<div class="alert alert-dismissable alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong><?php echo "Successfully sent $userCurrency $amount to ".$mUser->get('first_name')."."; ?></strong>
						</div>
					
						<a class="btn btn-default" href="index.php?p=home">
							Home
						</a>
					<?php
						$transaction->save();
					}
					else {
						?>
				
						<div class="alert alert-dismissable alert-danger">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Error sending the money.</strong>
						</div>
				
						<?php
					}
				}
				else {
					?>
				
					<div class="alert alert-dismissable alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>Insufficient funds.</strong>
					</div>
				
					<?php
				}
			}
			else {
			?>
				<div class="alert alert-dismissable alert-danger">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>
						<?php
							echo "1 or more errors occured:<br/>";
							echo $errorMessage;
						?>
					</strong>
				</div>
			<?php
			}
		}
	?>
		<div class="well">
			<form class="bs-example form-horizontal" action="index.php?p=sendmoney&uid=<?php echo $uid; ?>" method="post">
				<fieldset>
					<legend>Send money to <?php echo $mUser->get("first_name")." ".$mUser->get("last_name"); ?>.</legend>
					
					<div class="input-group">
						<span class="input-group-addon"><?php echo $userCurrency; ?></span>
						<input type="text" class="form-control" name="amount">
					</div>
					
					<div class="form-group"></div>
				
					<div class="form-group">
						<div class="col-lg-10 col-lg-offset-2">
							<a class="btn btn-default" href="index.php?p=sendmoney">Back</a>
							<input class="btn btn-primary" type="submit" name="btnPay" value="Pay"/>
						</div>
					</div>
				
				</fieldset>
			</form>
		</div>
	<?php
	}
	else {
?>



	<!-- This is the main content, we need to use this for the logic -->
	<?php 
		$users = user::listUsers();
		
		if(count($users) > 1) {
		?>
			<div class="list-group">
				<?php
					
				for($i = 0; $i < count($users); $i++) {
					$cUser = $users[$i];
			
					if($cUser->get("uid") != $user->get("uid")) {
						?>
							<a href="index.php?p=sendmoney&uid=<?php echo $cUser->get("uid"); ?>" class="list-group-item">
								<?php
									echo $cUser->get("first_name")." ".$cUser->get("last_name");
								?>
							</a>
						<?php
					}
				}
					
				?>
            </div>
		<?php
		}
		else {
			echo "There are no other users.";
		}
	?>
	
	<a class="btn btn-default" href="index.php?p=home">Back</a>
	
	<!-- End of content -->
				</div>
			</div>
		</div>
	</div>
</div>	

<?php
	}
?>