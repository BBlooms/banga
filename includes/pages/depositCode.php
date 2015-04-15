<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="panel panel-default">
        		<div class="panel-heading">Deposit Code</div>
            	<div class="panel-body">
	<?php
	
	$showForm = true;
	
	// If the user hits the pay button, process the values
	if(isset($_POST['btnRedeem']))
	{
		$code = $_POST['moneyCode'];
		
		if($controller->get("inputControl")->checkInput($code, 12, "code", true)) {
			$user->deposit(10);
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
					<strong><?php echo "Successfully deposited ".$userCurrency." 10."; ?></strong>
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
	<!-- This is the main content, we need to use this for the logic -->
	<div class="well">
		<form class="bs-example form-horizontal" action="index.php?p=depositCode" method="post">
			<fieldset>
				<div class="form-group">
					<label class="col-lg-2 control-label">Insert code</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="moneyCode" placeholder="Code"/>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<a class="btn btn-default" href="index.php?p=deposit">Back</a>
						<input class="btn btn-primary" type="submit" name="btnRedeem" value="Redeem code"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	
	<?php
	}
	?>
	
	<!-- End of content -->
	
				</div>
            </div> 
        </div>
    </div>
</div>