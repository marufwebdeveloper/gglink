<?php 
	$cartEmpty = true;
	if(isset($_SESSION['mp-cart']) && is_array($_SESSION['mp-cart']) && count($_SESSION['mp-cart'])){
		$cartEmpty = false;
		echo "<table class='table table-bordered'>
			<tr>
	    		<th>Product Name</th>
	    		<th>Quantity</th>
	    		<th>Price</th>
	    	</tr>";
	    	$totalPrice = 0;
		foreach($_SESSION['mp-cart'] as $pid=>$qty){			
		    $product =get_post($pid);
		    $price = get_post_meta( $product->ID, 'm-product-price', true );

		    $tprice = (float)$price *(float)$qty;

		    $totalPrice += $tprice;
		    ?>
		    
	    	<tr>
	    		<td><?php echo $product->post_title; ?></td>
	    		<td><?php echo $qty; ?></td>
	    		<td><?php echo $tprice; ?></td>
	    	</tr>
		    
		    <?php
		}
		echo "<tr>
				<td colspan='2'>Total Price</td>
	    		<td>$totalPrice</td>
	    	</tr>
	    	</table>";

	}else{
		echo '<h3 style="text-align:center">Cart Empty</h3>';
	}

	if(!$cartEmpty){
		echo "<a href='".get_site_url()."/m-checkout'>Checkout</a>";
	}
?>
