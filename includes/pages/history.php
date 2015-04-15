<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="panel panel-default">
        		<div class="panel-heading">History</div>
            	<div class="panel-body">

	<!-- This is the main content, we need to use this for the logic -->
	<?php
		$transactionsList = transaction::listTransactions($user->get("uid"));
		
		if(count($transactionsList) > 0) {
			?><div class="list-group"><?php
		
			for($i = 0; $i < count($transactionsList); $i++) {
				$transaction = $transactionsList[$i];
				$amount = $transaction->get("amount");
				$toID = $transaction->get("uid_to");
				$fromID = $transaction->get("uid_from");
				$date = $transaction->get("send_date");
			
				$transIn = true;
			
				if($toID != $user->get("uid")) {
					$mUser = new user($toID);
					$transIn = false;
				}
				else if($fromID != $user->get("uid")) {
					$mUser = new user($fromID);
					$transIn = true;
				}
				
				$newAmount = $amount;
				
				if($transIn) {
					// Calculate correct currency
					$curValue = $tCurrency->get("value");
					$mCurrency = new currency($mUser->get("cid"));
					$mCurValue = $mCurrency->get("value");
				
					$newAmount = (double) round((($amount / $mCurValue) * $curValue), 2);
				}
			
				$arrow = "";
			
				if($transIn) {
					$arrow = "images/arrow_in.png";
				}
				else {
					$arrow = "images/arrow_out.png";
				}
			
				?>
				<a class="list-group-item">
					<h4 class="list-group-item-heading">
						<?php echo $mUser->get("first_name")." ".$mUser->get("last_name"); ?>
					</h4>
					<p class="list-group-item-text">
						<img src="<?php echo $arrow; ?>"/>
						<?php echo $userCurrency." ".$newAmount; ?>
						<?php echo " ( on: ".$date.")"; ?>
					</p>
				</a>
				<?php
			}
			?>
			</div>
			<?php
		}
		else
		{
			echo "<p>No transactions yet.</p>";
		}
	?>
	
	<a class="btn btn-default" href="index.php?p=home">Back</a>
	
	<!-- End of content -->
				
				</div>
            </div> 
        </div>
    </div>
</div>