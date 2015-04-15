<?php
	// By default show the form to make the payment
	$showForm = true;
	$errorMessage = "";
	
	// If the user hits the pay button, process the values
	if(isset($_POST['btnRegister']))
	{
		$user = new User();
		
		// Collect and store all the variables sent by the user
		$countryCode = $_POST['countryCode'];
		$phonenumber = $_POST['phonenumber'];
		
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$country = $_POST['country'];
		
		$expMonth = $_POST['expMonth'];
		$expYear = $_POST['expYear'];
		$securityCode = $_POST['securityCode'];
		
		// Check inputs
		if($controller->get("inputControl")->checkInput($countryCode, 1, "country code", true) &&
			$controller->get("inputControl")->checkInput($phonenumber, 10, "phonenumber", true))
		{
			$cell_number = $countryCode."".$phonenumber;
			$user->set("cell_number", $cell_number);
		}
		
		if($controller->get("inputControl")->checkInput($password, 6, "password", true) &&
			$controller->get("inputControl")->areEqual($password, $password2)) 
		{
			$pass = md5($password);
			$user->set("password", $pass);
		}
		
		if($controller->get("inputControl")->checkInput($firstName, 2, "first name", true)) {
			$user->set("first_name", $firstName);
		}
		
		if($controller->get("inputControl")->checkInput($lastName, 2, "last name", true)) {
			$user->set("last_name", $lastName);
		}
		
		if($controller->get("inputControl")->checkInput($address, 6, "address", false)) {
			$user->set("address", $address);
		}
		
		if($controller->get("inputControl")->checkInput($city, 1, "city", false)) {
			$user->set("city", $city);
		}
		
		if($controller->get("inputControl")->checkInput($state, 2, "state", false)) {
			$user->set("state", $state);
		}
		
		if($controller->get("inputControl")->checkInput($zip, 5, "zip code", false)) {
			$user->set("zipcode", $zip);
		}
		
		if($controller->get("inputControl")->checkInput($country, 2, "country", false)) {
			$user->set("country", $country);
		}
		
		if($controller->get("inputControl")->checkInput($expMonth, 2, "expiration month", false) &&
			$controller->get("inputControl")->checkInput($expYear, 2, "expiration year", false)) 
		{
			$expiration = $expMonth."/".$expYear;
			$user->set("card_expiration", $expiration);
		}
		
		if($controller->get("inputControl")->checkInput($securityCode, 3, "cvv", false)) {
			$user->set("card_secret", $securityCode);
		}
		
		$user->set("deposit", 0);
		$user->set("currency", "$");
		
		$errorMessage .= $controller->get("inputControl")->getError();
		
		if(strlen($errorMessage) > 1)
		{
		}
		else
		{
			if($user->save()) {
				echo "Successfully registered.";
				?><META HTTP-EQUIV="refresh" content="1;URL=index.php?p=home"><?php
			}
			else {
				echo "Error creating acccount.";
			}
		}
	}
?>

<div id="content">
	
	<?php 
		if($showForm) {
	?>
	
	<div class="bs-docs-section">
		<div class="row">
			<div class="col-lg6">
				<div class="well">
					<form class="bs-example form-horizontal" method="post" action="index.php?p=register">
						<fieldset>
							<legend>Register</legend>
							
							<?php
							if(strlen($errorMessage) > 1)
							{
							?>
							
							<div class="form-group"></div>
							<div class="form-group">
								<div class="col-lg-4">
									<div class="alert alert-dismissable alert-danger">
										<strong>
										<?php
											echo "1 or more errors occured:<br/>";
											echo $errorMessage;
										?>
										</strong>
									</div>
								</div>
							</div>
							
							<?php
							}
							?>
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Phone number *</label>
							</div>
							
							<div class="input-group">
								<span class="input-group-addon">+</span>
								<input type="text" class="form-control" name="countryCode" placeholder="Country code *" maxlength="4">
								<span class="input-group-addon">-</span>
								<input type="text" class="form-control" name="phonenumber" placeholder="Phone number *" maxlength="13">
							</div>
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Password *</label>
							</div>
							
							<div class="input-group">
								<input type="password" class="form-control" name="password" placeholder="Password *">
								<span class="input-group-addon"> </span>
								<input type="password" class="form-control" name="password2" placeholder="Retype password *">
							</div>
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Name *</label>
							</div>
							
							<div class="input-group">
								<input type="text" class="form-control" name="firstName" placeholder="First name *">
								<span class="input-group-addon"> </span>
								<input type="text" class="form-control" name="lastName" placeholder="Last name *">
							</div>
							
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
								<label class="col-lg-2 control-label">Fields with a * are required.</label>
							</div>
							
							<div class="form-group">
								<div class="col-lg-10 col-lg-offset-2">
									<a class="btn btn-default" name="btnRegister" href="index.php?p=home">Back</a> 
									<input class="btn btn-primary" type="submit" name="btnRegister" value="Register"/> 
								</div>
							</div>
							
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
			
			<p class="txtSmall">
				
			</p>
		</div>
	</form>
	
	<?php
		}
	?>
	
	<!-- End of content -->
	
</div>