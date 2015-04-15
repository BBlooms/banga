<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="panel panel-default">
        		<div class="panel-heading">Deposit Card</div>
            	<div class="panel-body">

<?php
	// By default show the form to make the payment
	$showForm = true;
	
	$cardNumber = $user->get("card_number");
	
	// If the user hits the pay button, process the values
	if(isset($_POST['btnPay']))
	{
		$amountMoney = $_POST['amount'];
		
		if(strlen($cardNumber) == 0) {
			// Collect and store all the variables sent by the user
		
			$address = $_POST['address'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$zip = $_POST['zip'];
			$country = $_POST['country'];
		
			$cardnumber = $_POST['cardnumber'];
			$expMonth = $_POST['expMonth'];
			$expYear = $_POST['expYear'];
			$securityCode = $_POST['securityCode'];
		
			if($controller->get("inputControl")->checkInput($address, 6, "address", true)) {
				$user->set("address", $address);
			}
		
			if($controller->get("inputControl")->checkInput($city, 1, "city", true)) {
				$user->set("city", $city);
			}
		
			if($controller->get("inputControl")->checkInput($state, 2, "state", true)) {
				$user->set("state", $state);
			}
		
			if($controller->get("inputControl")->checkInput($zip, 5, "zip code", true)) {
				$user->set("zipcode", $zip);
			}
			
			if($controller->get("inputControl")->checkInput($country, 2, "country", true)) {
				$user->set("country", $country);
			}
			
			if($controller->get("inputControl")->checkInput($cardnumber, 16, "card number", true)) {
				$user->set("card_number", $cardnumber);
			}
		
			if($controller->get("inputControl")->checkInput($expMonth, 2, "expiration month", true) &&
				$controller->get("inputControl")->checkInput($expYear, 2, "expiration year", true)) 
			{
				$expiration = $expMonth."/".$expYear;
				$user->set("card_expiration", $expiration);
			}
		
			if($controller->get("inputControl")->checkInput($securityCode, 3, "cvv", true)) {
				$user->set("card_secret", $securityCode);
			}
		}
		
		$errorMessage = "";
		$errorMessage .= $controller->get("inputControl")->getError();
		
		if(strlen($errorMessage) == 0)
		{
			if($controller->get("inputControl")->checkInput($amountMoney, 1, "money amount", true)) {
				$user->deposit($amountMoney);
			}
		}
		
		$errorMessage = "";
		$errorMessage .= $controller->get("inputControl")->getError();
		
		if(strlen($errorMessage) > 1)
		{
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
		else
		{
			if($user->save()) {
				$showForm = false;
				?>
				<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong><?php echo "Successfully deposited $userCurrency $amountMoney."; ?></strong>
				</div>
				
				<a class="btn btn-default" href="index.php?p=home">
					Home
				</a>
				<?php
			}
			else {
			?>
				<div class="alert alert-dismissable alert-danger">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<strong>Error depositing the money.</strong>
				</div>
			<?php
			}
		}
	}

	if($showForm) {
	?>
	
	<div class="well">
		<form class="bs-example form-horizontal" action="index.php?p=depositCard" method="post">
			<!-- This is the main content, we need to use this for the logic -->
			<fieldset>
				<legend>Deposit with card</legend>
				
				<div class="input-group">
					<span class="input-group-addon"><?php echo $userCurrency; ?></span>
					<input type="text" class="form-control" name="amount">
				</div>
		
				<?php
					if(strlen($cardNumber) > 10) {
				?>
				
				<div class="form-group"></div>

				<div class="alert alert-dismissable alert-info">
					<strong>Card ending with:</strong> 
					<?php 
						$cardNumber = substr($cardNumber, -4);
						echo $cardNumber;
					?>
				</div>
				
				<?php
					}
					else {
				?>
					
					<div class="form-group">
					</div>
					
					<legend>Register a new card.</legend>
		
					<div class="form-group">
						<label class="col-lg-2 control-label">Address</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="address" placeholder="Address"/>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-10">
							<input type="text" class="form-control" name="city" placeholder="City"/>
						</div>
					</div>
					
					<div class="input-group">
						<input type="text" class="form-control" name="state" placeholder="State" maxlength="16">
						<span class="input-group-addon"> </span>
						<input type="text" class="form-control" name="zip" placeholder="Zip" maxlength="5">
						<span class="input-group-addon"> </span>
						<input type="text" class="form-control" name="country" placeholder="Country">
					</div>
					
					<div class="form-group">
						<label class="col-lg-2 control-label">Credit card</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" name="cardnumber" placeholder="Card number" maxlength="16"/>
						</div>
					</div>
					
					<div class="input-group">
						<input type="text" class="form-control" name="expMonth" placeholder="Exp M" maxlength="2">
						<span class="input-group-addon">/</span>
						<input type="text" class="form-control" name="expYear" placeholder="Exp Y" maxlength="2">
						<span class="input-group-addon"> </span>
						<input type="text" class="form-control" name="securityCode" placeholder="CVV" maxlength="4">
					</div>
					
					<div class="form-group">
					</div>
		
				<?php
					}
				?>

				<input class="btn btn-primary" type="submit" name="btnPay" value="Pay"/>
			</fieldset>
		</form>
	</div>
	<a id="btnBack" class="btn btn-default" href="index.php?p=deposit">Back</a>
	<?php
		}
	?>
	
	<!-- End of content -->
					
				</div>
            </div> 
        </div>
    </div>
</div>