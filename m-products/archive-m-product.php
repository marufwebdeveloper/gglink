
<?php 

get_header();

$paged = (get_query_var('page')) ? get_query_var('page') : 1;

$args = array(
    'post_type'=>'m-product', // Your post type name
    'posts_per_page' => 20,
    'paged' => $paged,
);

$loop = new WP_Query( $args );
if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) : $loop->the_post();

	?>
<a href="<?php the_permalink(); ?>">
	<div class="etmia col-sm-4 col-md-3">
		<div class="img">
			<img style="max-height: 200px;max-width: 200px;" src='<?php the_post_thumbnail_url() ?>' style='max-width: 100%;'/>
		</div>
		<div>
			<h3><?php the_title(); ?></h3>
		</div>
	</div>
</a>
	<?php

    endwhile;

    $total_pages = $loop->max_num_pages;
    $current_page = max(1, get_query_var('page'));

    echo "<div>";
    echo paginate_links(array(
        'base' => get_post_type_archive_link('team-member' ) . '%_%',
        'format' => '?page=%#%',
        'current' => $current_page,
        'total' => $total_pages,
        'prev_text'    => __('« prev'),
        'next_text'    => __('next »'),
    ));
    echo "</div>";
}
wp_reset_postdata();

get_footer();