<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="panel panel-default">
        		<div class="panel-heading">
        			Order
        		</div>
            	<div class="panel-body">

	<?php
		if(isset($_GET["uid"])) {
			$uid = $_GET["uid"];
			$mUser = new user($uid);
			
			$cartItems = cart_item::listCartItemsUser($user->get("uid"));
			$cartSumPrice = 0;
	
			if(count($cartItems) > 0) {		
				for($i = 0; $i < count($cartItems); $i++) {
					$cartItem = $cartItems[$i];
					$item = new item($cartItem->get("iid"));
					$price = $item->get("price");
					$quantity = $cartItem->get("quantity");
					$productPrice = ($quantity * $price);
					$cartSumPrice += $productPrice;
				}
			}
			
			if(isset($_GET["payment"])) {
				$payment = $_GET["payment"];
				
				if($payment == 1) {
					// Pay with account = done
					$user->sendMoney($cartSumPrice);
					
					if($user->save()) {
						?>
						
						<div class="alert alert-dismissable alert-success">
							<strong>
						
						
						<?php
						if($uid != $user->get("uid")) {
							echo $cartSumPrice." is sent to the merchant. ".$mUser->get("first_name")." ".$mUser->get("last_name")." is notified.";
						}
						else {
							echo $cartSumPrice." is sent to the merchant. You can pickup your goods.";
						}
						?>
							</strong>
						</div>
						
						<?php
						
						$today = date("m/d/Y");
						
						$order = new order();
						$order->set("uidf", $user->get("uid"));
						$order->set("uidt", $mUser->get("uid"));
						$order->set("date", $today);
						$order->set("amount", $cartSumPrice);
						$order->save();
						
						$order_id = $order->get("oid");
						
						for($i = 0; $i < count($cartItems); $i++) {
							$cartItem = $cartItems[$i];
							$cartItem->set("checked_out", 1);
							$cartItem->set("checkout_date", $today);
							$cartItem->set("amount", $productPrice);
							$cartItem->save();
							
							$order_item = new order_item();
							$order_item->set("oid", $order_id);
							$order_item->set("iid", $cartItem->get("ciid"));
							$order_item->save();
						}
					}
    			}
			}
			else {
			
				if($cartSumPrice <= $user->get("deposit")) {
				?>
				<div class="box">
					<p>
						<?php
						if($uid != $user->get("uid")) {
						?>
							Pay <?php echo $userCurrency." ".$cartSumPrice." for user '".$mUser->get("first_name")." ".$mUser->get("last_name")."'?"; 
						} 
						else {
							echo "Pay ".$userCurrency." ".$cartSumPrice." for yourself?";
						}
						?>
					</p>
				</div>
			
				<?php
				}
				?>
			
				<?php
			}
		}
		else {
		
			$users = user::listUsers();
			
			if(count($users) > 1) {
				
				?><div class="list-group"><?php
				
				for($i = 0; $i < count($users); $i++) {
					$cUser = $users[$i];
			
					if($cUser->get("uid") != $user->get("uid")) {
						?>
							<a href="index.php?p=order&uid=<?php echo $cUser->get("uid"); ?>" class="list-group-item">
								<?php
								echo $cUser->get("first_name")." ".$cUser->get("last_name");
								?>
							</a>
						<?php
					}
				}
			}
			
			?>
				<a href="index.php?p=order&uid=<?php echo $user->get("uid"); ?>" class="list-group-item">
					Self
				</a>
			</div>
			<?php
		}
	?>
		<!-- End of content -->
		
					<?php
						if(isset($_GET["payment"])) {
					?>
						<a id="btnBack" class="btn btn-default" href="index.php?p=home">
							Home
						</a>
					<?php
					}
					else {
					?>
						<div id="btnBack" class="btn btn-default" onclick="history.go(-1);">
							Back
						</div>
					<?php
					}
					
					if(isset($_GET["uid"]) && !isset($_GET["payment"])) {
					?>
					
					<a class="btn btn-primary" href="index.php?p=order&uid=<?php echo $uid; ?>&payment=1">
						Pay now
					</a>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>