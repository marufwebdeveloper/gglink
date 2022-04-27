<?php 

	$totalPrice = 0;
	$c = 0;

	$cart = [];

	$checkout = true;

	if(isset($_SESSION['mp-cart'])){
		foreach($_SESSION['mp-cart'] as $pid=>$qty){
			$c += $qty;			
		    $product =get_post($pid);
		    $price = get_post_meta( $product->ID, 'm-product-price', true );

		    if($checkout==true && get_post_meta( $product->ID, 'm-product-turn-on-off-checkout', true )!=1){
		    	$checkout = false;
		    }

		    $totalPrice += (float)$price *(float)$qty;

		    $cart[$pid] = $qty;
			    
		}
	}
	if(isset($_POST['m-order-now'])){
		$success = wp_insert_post([
	       'post_type'     => 'm-order',
	       'post_title'    => $_POST['mc-email'],
	       'post_content'  => json_encode([
	       		'name' => $_POST['mc-name'],
	       		'email' => $_POST['mc-email'],
	       		'address' => $_POST['mc-address']
	       ]),
	       'post_excerpt'  => json_encode($cart),	       
	       'post_status'   => 'publish',
	       'comment_status' => 'closed',
	       'ping_status' => 'closed',
	       
	    ]);

	    if($success){
	    	wp_mail($_POST['mc-name'], "Order Confirmation", "Thanks for order.");

	    	unset($_SESSION['mp-cart']);

	    	echo "<script>alert('Order Successfull')</script>";
	    }
	}
if($checkout){
?>
<table class="table table-bordered">
	<tr>
		<td>Total Item</td>
		<td><?php echo $c; ?></td>
		<td>Total Price</td>
		<td><?php echo $totalPrice; ?></td>
		
	</tr>	
</table>
<form method="post">
	<div class="">
		<label>Full Name</label>
		<input type="text" name="mc-name" class="form-control" placeholder="Enter Full Name">
	</div>
	<div class="">
		<label>Email</label>
		<input type="email" name="mc-email" class="form-control" placeholder="Enter Email">
	</div>
	<div class="">
		<label>Address</label>		
		<textarea class="form-control" name="mc-address" placeholder="Enter Address"></textarea>
	</div>
	<button class="btn btn-primary mt-1" name="m-order-now">Order Now</button>
</form>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?php 
}else{
	echo "Checkout Disabled For Some Product.";
}
?>