<?php
	if(isset($_POST['register'])) {
		include 'createAccount.php';
	}
	else {
?>
<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="well">
				<form class="bs-example form-horizontal" method="post" action="index.php?p=home">
					<fieldset>
						<legend>Login</legend>
						<?php
							if($wrongLogin) {
						?>
							<div class="form-group"></div>
							<div class="form-group">
								<div class="col-lg-4">
									<div class="alert alert-dismissable alert-danger">
										<strong>The combination of the username and password is incorrect.</strong>
									</div>
								</div>
							</div>
						<?php
							}
						?>
						<div class="form-group">
							<label for="inputUsername" class="col-lg-2 control-label">Username</label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="username" placeholder="Username"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputUsername" class="col-lg-2 control-label">Password</label>
							<div class="col-lg-10">
								<input type="password" class="form-control" name="userpass" placeholder="Password"/>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<a class="btn btn-default" href="index.php?p=register">Register</a>
								<input class="btn btn-primary" type="submit" name="login" value="login"/>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>