<?php 
if(isset($_POST['m-add-cart'])){
	if(!isset($_SESSION['mp-cart'])){
		$_SESSION['mp-cart'] = [];
	}
	if($_POST['mp-quantity']){
		if(isset($_SESSION['mp-cart'][$_POST['mp-id']])){
			$_SESSION['mp-cart'][$_POST['mp-id']] += (int) $_POST['mp-quantity'];
		}else{
			$_SESSION['mp-cart'][$_POST['mp-id']] = (int) $_POST['mp-quantity'];
		}
		echo "<script>alert('Product Added To Cart')</script>";
	}else{
		echo "<script>alert('Enter Quantity')</script>";
	}
}


get_header();

while ( have_posts() ) :
	the_post();
?>
<div style="padding: 20px 0;">
	<div class="container">

		<div class="row">
			<div class="col-sm-6">
				<div class="mpti">
					<?php the_post_thumbnail();?>
				</div>
			</div>
			<div class="col-sm-6">
				<h3><?php the_title(); ?></h3>
				<p><?php the_content(); ?></p>
				<p>Price : <?php echo get_post_meta( $post->ID, 'm-product-price', true ); ?></p>
				<?php 
					$product_availability = get_post_meta( $post->ID, 'm-product-available', true );
					if($product_availability==1){
				?>
				<form method="post">
					<div>
						<input type="number" name="mp-quantity" placeholder="Enter Quantity">
						<input type="hidden" name="mp-id" value="<?php the_ID(); ?>">
					</div>
					<div class="mt-1">
						<button class="btn btn-primary" name="m-add-cart">Add To Cart</button>
					</div>
				</form>
				<?php 
					}else{
						echo "<h3>Product Not Available</h3>";
					}
				?>
			</div>
			
		</div>
	</div>
</div>




<?php
endwhile; 


get_footer();
?>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>