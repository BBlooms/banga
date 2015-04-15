<?php
	$cartItems = cart_item::listCartItemsUser($user->get("uid"));
?>

<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="panel panel-default">
        		<div class="panel-heading">
        			Cart
        			
        			<?php
        			
        			if(count($cartItems) > 0) {	
        			
        			?>
					<a id="btnOrder" style="float: right;" class="btn btn-primary btn-sm" href="index.php?p=order">Order</a>
					<?php
					
					}
					
					?>
        		</div>
            	<div class="panel-body">
	<?php
		
		$cartSumPrice = 0;
		
		if(count($cartItems) > 0) {	
		
			?>
			<div class="list-group">
			<?php
			
			for($i = 0; $i < count($cartItems); $i++) {
				$cartItem = $cartItems[$i];
				$item = new item($cartItem->get("iid"));
			
				$itemName = $item->get("name");
				$price = $item->get("price");
				$currency = $userCurrency;
				$unit = $item->get("unit");
				$picture = $item->get("photo");
				$quantity = $cartItem->get("quantity");
				$productPrice = ($quantity * $price);
			
				$cartSumPrice += $productPrice;
			
				$picDir = explode("/", ROOT_DIR);
				$directory = "";
			
				for($j = 0; $j  < count($picDir) - 2; $j++ ) {
					$directory .= "/".$picDir[$j];
				}
			
				?>
				
				<a class="list-group-item">
					<h4 class="list-group-item-heading">
						<?php echo $itemName." (".$quantity.")"; ?>
					</h4>
					<p class="list-group-item-text" style="float: right;">
						<?php echo $currency." ".$productPrice; ?>
					</p>
					<img width="100" height="100" src="<?php echo $picture; ?>">
					<p class="list-group-item-text">
						<?php
							echo $item->get("description")."<br/>"; 
							echo $currency." ".$price." / ".$unit;
						?>
					</p>
				</a>
			
				<?php
			}
			
			?>
			
				<a class="list-group-item">
					<p class="list-group-item-text" style="float: right;">
						Total price: <?php echo $currency." ".$cartSumPrice; ?>
					</p>
					<p class="list-group-item-text">
						&nbsp;
					</p>
				</a>
			
			</div>
			<?php
		}
		else {
			echo "<p>The cart is empty.</p>";
		}
		?>
		
		<a class="btn btn-default" onclick="history.go(-1);">Back</a>
	
	<!-- End of content -->
				</div>
			</div>
		</div>
	</div>
</div>