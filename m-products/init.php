<?php

/**
 * Plugin Name: M-Product
 * Plugin URI: 
 * Description: M-Product
 * Version: 1.0.0
 */



if(!session_id())session_start();

register_activation_hook(__FILE__, function(){
     
    wp_insert_post([
       'post_type'     => 'page',
       'post_title'    => 'M-Cart',
       'post_content'  => '[mp-cart]',
       'post_status'   => 'publish'
    ]);
    wp_insert_post([
       'post_type'     => 'page',
       'post_title'    => 'M-Checkout',
       'post_content'  => '[mp-checkout]',
       'post_status'   => 'publish'
    ]);

    wp_insert_post([
       'post_type'     => 'page',
       'post_title'    => 'M-Account',
       'post_content'  => '[m-account]',
       'post_status'   => 'publish'
    ]);

    
    
}); 

add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_style( 'm-product-bootstrap', plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ) );
    wp_enqueue_style( 'm-product-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
    
});

add_action( 'init',function() {
    register_post_type( 'm-product',
        array(
        	//'menu_icon' => '',
            'labels' => array(
                'name' => __( 'M-products' ),
                'singular_name' => __( 'M-products' ),
                'add_new_item' => __('Add M-products', 'txtdomain'),
				'new_item' => __('New m-product', 'txtdomain'),
				'view_item' => __('View m-product', 'txtdomain'),
				'not_found' => __('No m-products found', 'txtdomain'),
				'not_found_in_trash' => __('No m-products found in trash', 'txtdomain'),
				'all_items' => __('All m-products', 'txtdomain'),
				'insert_into_item' => __('Insert into m-product', 'txtdomain')
	        ),
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'public' => true,
            'rewrite' => array('slug' => 'm-product'),
            'capability_type' => 'page',
            
        )
    );
    register_taxonomy('m-product-category', ['m-product'], [
		'hierarchical' => true,
		'rewrite' => ['slug' => 'm-product-category'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'name' => __('Product Category', 'txtdomain'),
			'singular_name' => __('Product Category', 'txtdomain'),
			'all_items' => __('All Product Category', 'txtdomain'),
			'edit_item' => __('Edit Product Category', 'txtdomain'),
			'view_item' => __('View Product Category', 'txtdomain'),
			'update_item' => __('Update Product Category', 'txtdomain'),
			'add_new_item' => __('Add New Product Category', 'txtdomain'),
			'new_item_name' => __('New Product Category Name', 'txtdomain'),
			'search_items' => __('Search Product Categorys', 'txtdomain'),
			'popular_items' => __('Popular Product Categorys', 'txtdomain'),
			//'separate_items_with_commas' => __('Separate authors with comma', 'txtdomain'),
			//'choose_from_most_used' => __('Choose from most used authors', 'txtdomain'),
			'not_found' => __('No Category Found', 'txtdomain'),
		]
	]);

	 
});

/*
add_action( 'admin_menu', function(){
	add_submenu_page(
        'edit.php?post_type=m-product',
        __('Settings', 'txtdomain'),
        __('Settings', 'txtdomain'),
        'manage_options',
        'm-product-settings',
        function(){
        	require_once dirname(__FILE__) .'/settings-m-product.php';
        });
} );
*/

/*
add_action( 'edit_form_after_title', function() {
	$screen = get_current_screen();
	if  ( 'm-product' == $screen->post_type ) {
          echo '<h1> </h1>';
     } 
	
});
*/
   
add_filter( 'enter_title_here', function ( $title ){
     $screen = get_current_screen();
   
     if  ( 'm-product' == $screen->post_type ) {
          $title = 'Enter Product Title';
     }   
     return $title;
});

add_action( 'add_meta_boxes', function() {
    add_meta_box( 'm_product_price', 'Product Price', function($post){
        $meta_val = get_post_meta( $post->ID, 'm-product-price', true );
        echo "<input type='number' name='m-product-price' value='".esc_attr( $meta_val )."' placeholder='Enter Product Price' style='width:100%'/>";
    }, 'm-product', 'normal');
    add_meta_box( 'm_product_stock', 'Stock Quantity', function($post){
    	$meta_val = get_post_meta( $post->ID, 'm-product-stock', true );
    	echo "<input type='number' name='m-product-stock' value='".esc_attr( $meta_val )."' placeholder='Enter Stock Quantity' style='width:100%'/>";
    }, 'm-product', 'normal');
    add_meta_box( 'm_product_available', 'Product Availablity', function($post){
        $meta_val = get_post_meta( $post->ID, 'm-product-available', true );
        $checked = esc_attr( $meta_val )==1?"checked='checked'":'';

        echo "<input type='checkbox' name='m-product-available' value='1' $checked/> Available";
    }, 'm-product', 'normal');
    add_meta_box( 'm_product_checkout_turn_on_off', 'Turn On Checkout Page', function($post){
        $meta_val = get_post_meta( $post->ID, 'm-product-turn-on-off-checkout', true );
        $checked = esc_attr( $meta_val )==1?"checked='checked'":'';

        echo "<input type='checkbox' name='m-product-turn-on-off-checkout' value='1' $checked/> Turned On Checkout Page.";
    }, 'm-product', 'normal');
    
    
} );
 

add_action( 'save_post', function( $post_id ) {
    if ( isset( $_POST['m-product-stock'] ) ) {
        update_post_meta( $post_id, 'm-product-stock', $_POST['m-product-stock'] );
    }
    if ( isset( $_POST['m-product-price'] ) ) {
        update_post_meta( $post_id, 'm-product-price', $_POST['m-product-price'] );
    }
    
    
    update_post_meta( $post_id, 'm-product-available', $_POST['m-product-available']??0 );
    
    
    update_post_meta( $post_id, 'm-product-turn-on-off-checkout', $_POST['m-product-turn-on-off-checkout']??0 );
    
} );



add_filter( 'single_template', function ( $single_template ){
    global $post;
    if($post->post_type == 'm-product'){
    	$file = dirname(__FILE__) .'/single-m-product.php';
    	if( file_exists( $file ) ) $single_template = $file;
    }
    return $single_template;
} );

add_filter( 'archive_template', function ( $single_template ){
    global $post;
    if($post->post_type == 'm-product'){
    	$file = dirname(__FILE__) .'/archive-m-product.php';
    	if( file_exists( $file ) ) $single_template = $file;
    }
    return $single_template;
} );

add_action('wp_footer',function(){
    $cart = (int) array_sum(array_values($_SESSION['mp-cart']??[]));
    echo "<div style='width: 75px;height: 135px;box-shadow: 0 0 3px #999;position: fixed;top: 100px;right: 0;z-index: 9999;background: white;text-align:center'>
 <p><b>Added item:: <br/> $cart</b></p>
 <a href='".get_site_url()."/m-cart'>View Cart</a>
    </div>";
});



add_shortcode( 'mp-cart', function( $atts = '' ) {
    /*$params = shortcode_atts( array(
    ), $atts );*/

	ob_start();
	require_once dirname(__FILE__) .'/short-code-mp-cart.php';
	$output = ob_get_contents();
	ob_end_clean();

    return $output;
});
add_shortcode( 'mp-checkout', function( $atts = '' ) {
    /*$params = shortcode_atts( array(
    ), $atts );*/

    ob_start();
    require_once dirname(__FILE__) .'/short-code-mp-checkout.php';
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
});

add_shortcode( 'm-account', function( $atts = '' ) {
    /*$params = shortcode_atts( array(
    ), $atts );*/

    ob_start();
    require_once dirname(__FILE__) .'/short-code-m-account.php';
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
});





