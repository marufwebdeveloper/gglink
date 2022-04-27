<?php
	$orders = [];
	$email = ''; 
	if(isset($_POST['view_account'])){
		global $wpdb;
		$orders = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_title = '" . $_POST['email'] . "'" );
		$email = $_POST['email'];

	}
?>

<form method="post">
	<input type="email" name="email" placeholder="Enter Email To See Order" class="form-control" value="<?php echo $email; ?>">
	<button name="view_account" class="btn btn-primary">Submit</button>
</form>
<table class="table table-bordered">
	<tr>
		<th>Order Time</th>
		<th>Product Name</th>
		<th>Quantity</th>
	</tr>
<?php 
	if(is_array($orders) && count($orders)){
		foreach($orders as $order){
			//

			$orderItem = $order->post_excerpt;
			$orderItem = json_decode($orderItem,true);

			foreach($orderItem as $pid=>$qty){
				$product =get_post($pid);
				echo "<tr>
					<td>$order->post_date</td>
					<td>$product->post_title</td>
					<td>$qty</td>
				</tr>";
			}
		}
	}
?>
</table>