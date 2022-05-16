<?php

if(isset($_SESSION["cart_products"])) {		/*Whenever products are added to cart from PLP/PDP page it is added in session array*/
	$total_quantity = 0;
?>
	<table>
		<tbody>
			<tr>
				<th style="text-align:left;">Name</th>
				<th style="text-align:left;">SKU</th>
				<th style="text-align:right;">Quantity</th>
				<th style="text-align:right;">Unit Price(£)</th>
				<th style="text-align:right;">Special Price(£)</th>
			</tr>
			<?php
				foreach ($_SESSION["cart_products"] as $product) {
				?>
					<tr>
						<td><?php echo $product["name"]; ?></td>
						<td><?php echo $product["sku"]; ?></td>
						<td style="text-align:right;"><?php echo $product["quantity"]; ?></td>
						<td style="text-align:right;"><?php echo $product["price"]; ?></td>
						<td id="<?php echo $product['sku'].'_special_price'; >?" class="special-price" style="text-align:right;"><?php echo getSpecialPrice($product["sku"], $product["quantity"]); ?></td>
					</tr>
				}
				$total_quantity += $product["quantity"];
			?>
			<tr>
				<td align="right">Total Quantity : <?php echo $total_quantity; ?></td>
				<td align="right" id="total_price"></td>
			</tr>
		</tbody>
	</table>
<?php
} else {
?>
	<div>Your Cart is Empty</div>
<?php
}

?>

<script type="text/javascript">

function getSpecialPrice(product_sku, product_quantity) {			/* This function will calculate the offer/special price for each SKU based on the product quantity*/
	$.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('/Checkout/getSpecialPrice'); ?>',
                data:{product_sku : product_sku, product_quantity : product_quantity},
                success:function(data) {
                    $(product_sku+'_special_price').html(data.special_price);		/*Assigning special price to respective cell*/
			var sum = 0;
    			$(".special-price").each(function(){
        			sum += parseInt($(this).html());
    			});
    			$("#total_price").html("Total Price: "+sum);		/*Assigning total cart price*/
                },
                error: function(data) {
                    console.log(data);
                }
            });

}
</script>