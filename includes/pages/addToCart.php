<div class="subSpace">
	<div class="subSpaceContent">
		<?=$_GET["itemName"]?>
	</div>
</div>

<div id="content">

	<!-- This is the main content, we need to use this for the logic -->
	<script>
		function changeSum() {
			var elem = document.getElementById("qty");
			var sum = document.getElementById("addToCartSum");
			sum.innerHTML = <?=$_GET["itemPrice"]?> * elem.value;
		}
	</script>

	<div id="addToCartCalculate">
		<?=$_GET["itemPrice"]?> X 
		<input type="text" placeholder="1" id="qty" onkeyup="changeSum()"> <?=$_GET["itemUnit"]?> =
	</div>
	<div id="addToCartSum">
		<?=$_GET["itemPrice"]?>
	</div>
	<div id="addBtn" class="btn" onclick="history.go(-1);">
		Add To Cart
	</div>
	
	<!-- End of content -->
	
</div>

<div class="subSpaceBottom">
	<div class="subSpaceContent">
		<div id="btnBack" class="btn btnSmall" onclick="history.go(-1);">
			Back
		</div>
	</div>
</div>