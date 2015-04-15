<div class="bs-docs-section">
	<div class="row">
		<div class="col-lg6">
			<div class="panel panel-default">
        		<div class="panel-heading">
        			Market
        			<a id="btnCart" style="float: right;" class="btn btn-primary btn-sm" href="index.php?p=cart">Cart</a>
        		</div>
            	<div class="panel-body">



	<!-- This is the main content, we need to use this for the logic -->
	
	<?php 
		if(isset($_GET["uid"])) {
			$uid = $_GET["uid"];
			$mStore = new store($uid);
			
			if(isset($_GET["iid"])) {
				$iid = $_GET['iid'];
				$mItem = new item($iid);
				
				if(isset($_POST["btnCart"])) {
					$quantity = $_POST["quantity"];
					
					if($controller->get("inputControl")->checkInput($quantity, 1, "quantity", true)) {
						$cartItem = new cart_item();
						$cartItem->set("uid", $user->get("uid"));
						$cartItem->set("iid", $iid);
						$cartItem->set("quantity", $quantity);
						
						// Check whether the item allready exists in the cart (merge quantity)
						$listCartItems = cart_item::listCartItemsUser($user->get("uid"));
						
						$exists = false;
						
						for($i = 0; $i < count($listCartItems); $i++) {
							if($listCartItems[$i]->get("iid") == $iid) {
								// The list exists
								$exists = true;
								$prevQuant = $listCartItems[$i]->get("quantity");
								$newQuant = $prevQuant + $quantity;
								$listCartItems[$i]->set("quantity", $newQuant);
								$listCartItems[$i]->save();
							}
						}
						?>
						
						<div class="alert alert-dismissable alert-success">
							<strong><?php echo "Successfully added ".$mItem->get('name')." to the cart."; ?></strong>
						</div>
						
						<?php
						if(!$exists) {
							$cartItem->save();
						}
					}
				}
				
				?>
				<div class="well">	
					<form action="index.php?p=market&uid=<?php echo $uid;?>&iid=<?php echo $iid; ?>" method="post">
						<fieldset>
							<legend>
								<?php echo $mItem->get("name"); ?>
							</legend>
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Quantity</label>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="quantity" placeholder="Quantity"/>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-lg-10 col-lg-offset-2">
									<input class="btn btn-primary" type="submit" name="btnCart" value="Add to cart"/>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<?php
			}
			else {
				$items = item::listByShop($uid);
			
				if(count($items) > 0) {
					 //echo $mStore->get("name");
					 
					 ?>
					 <div class="list-group">
					 <?php
				
					for($j = 0; $j < count($items); $j++) {
						$item = $items[$j];
						?>
							<a class="list-group-item" href="index.php?p=market&uid=<?php echo $uid; ?>&iid=<?php echo $item->get("iid"); ?>">
								<h4 class="list-group-item-heading">
									<?php echo $item->get("name"); ?>
								</h4>
								<img width="100" height="100" src="<?=$item->get("photo")?>">
								<p class="list-group-item-text">
									<?php
										echo $item->get("description")."<br/>"; 
										echo $userCurrency." ".$item->get("price")." / ".$item->get("unit");
									?>
								</p>
							</a>
						<?php
					}
					?>
					</div>
					<?php
				}
				else {
					echo "There are no items in this shop.";
				}
			}
		}
		else {
	
			$stores = store::listStores();
			
			if(count($stores) > 0) {	
			?>
				<div class="list-group">
			<?php
				for($i = 0; $i < count($stores); $i++) {
					$store = $stores[$i];
			?>
					
					<a class="list-group-item" href="index.php?p=market&uid=<?php echo $store->get("uid"); ?>">
                  		<h4 class="list-group-item-heading">
                  			<?php 
                  			
                  			echo $store->get("name");
							?><br/><div><?php
                  			for ($j = 0; $j < $store->get("reputation"); $j++) {
							?>
								<div style="width: 20px; float: left;">
									<img width="20px" height="20px" src="images/star_gold.png">
								</div>
							<?php
							}
							?>
							</div><br/>
                  		</h4>
                  		<img style="z-index: 10;" width="150" height="150" src="<?php echo $store->get('photo'); ?>"/>
               		</a>
            <?php
				}
			?>
				</div>
			<?php
			}
		}

		if(isset($_GET["uid"])) {
			?>
			<a id="btnBack" class="btn btn-default" href="index.php?p=market">Back</a>
			<?php
		}
		else {
			?>
			<a id="btnBack" class="btn btn-default" href="index.php?p=home">Back</a>
			<?php
		}
	?>
	<!-- End of content -->
				</div>
			</div>
		</div>
	</div>
</div>