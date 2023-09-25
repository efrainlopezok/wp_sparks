<?php

function btn_shortcode( $atts ) {
   	shortcode_atts( array(
    	'text' => '',
    	'link' => '#',
    	'color' => '',
    	'target' => '',
   	), $atts );
   	$link = "<a href='".$atts['link']."' target='_".$atts['target']."'  class='btn ".$atts['color']."'>".$atts['text']."&nbsp; <i class='fas fa-long-arrow-alt-right'></i></a>";
   return $link;
}
add_shortcode( 'button_link', 'btn_shortcode' );

/* Blog Loop Shortcode */
add_shortcode('blog_loop', 'blog_loop_function');
function blog_loop_function(){
	$out = '';
	$loop = new WP_Query( array( 'post_type' => 'post', 'showposts' => 8 ) );
	$loopp = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 8 ) );
	$cloop = new WP_Query( array( 'post_type' => 'post', 'showposts' => -1 ) );
	$total_p = $cloop->found_posts;
	$loopp->max_num_pages;
    if ( $loop->have_posts() ) :
    	$counter = 0;
		$out .= '<div class="list-posts ">';
		$blogCount = 0;
        while ( $loop->have_posts() ) : $loop->the_post();
        	$counter++;
        	if ($counter <= 3) {
				$cclass = 'big-cont';
		
        	}else{
        		$cclass = 'regular-item';
        	}
        	if ($counter == 4) {
				break; // REMOVE THIS TO SHOW THE REST OF POSTS
        		$out .= '<div class="item-post top-p">';
	        		if(has_post_thumbnail()){
	        			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	        			$bg = $image[0];
	        		}else{
	        			$bg = get_stylesheet_directory_uri().'/images/orangebg.jpg';
	        		}
	        		$out .= '<div class="title-b">';
	        			$out .= '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
	        		$out .= '</div>';
	        		$out .= '<div class="content-b">';
		        		$out .= '<div class="excp">'.excerpt(32).'</div>';
		        		$out .= '<a class="link-p" href="'.get_the_permalink().'"><span class="button_label">READ MORE <i class="fas fa-long-arrow-alt-right"></i></span></a>';
	        		$out .= '</div>';
	        		$out .= '<div class="thumbnail-img">';
				  $out .= '<a href="'.get_the_permalink().'">';
				  $out .= '<div class="image-wbg" style="background:url('.$bg.');"></div>';
				  $out .= '</a>';
	        		$out .= '</div>';
	        	$out .= '</div>';
        	}elseif($counter > 4){
        		$out .= '<div class="item-post '.$cclass.'">';
	        		if(has_post_thumbnail()){
	        			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	        			$bg = $image[0];
	        		}else{
	        			$bg = get_stylesheet_directory_uri().'/images/orangebg.jpg';
	        		}
	        		$out .= '<div class="thumbnail-img">';
	        			$out .= '<a href="'.get_the_permalink().'">';
	        			$out .= '<div class="image-wbg" style="background:url('.$bg.');"></div>';
	        			$out .= '</a>';
	        		$out .= '</div>';
	        		$out .= '<div class="content-b">';
		        		$out .= '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
		        		$out .= '<a class="link-p" href="'.get_the_permalink().'"><span class="button_label">READ MORE <i class="fas fa-long-arrow-alt-right"></i></span></a>';
	        		$out .= '</div>';
	        	$out .= '</div>';
        	}else{
        		$out .= '<div class="item-post section_wrapper '.$cclass.' animatedParent"> ';
	        		if(has_post_thumbnail()){
	        			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	        			$bg = $image[0];
	        		}else{
	        			$bg = get_stylesheet_directory_uri().'/images/orangebg.jpg';
					}
					$animateBlog =  "";
					$animateBlog2 =  "";
					$classBlog3 =  "";
					if($blogCount==0 ){
						$animateBlog =  "animated fadeInLeft go";
						$animateBlog2 =  "animated fadeInRight go";
						$blogCount = 1;
					}else{
						$animateBlog =  "animated fadeInRight go";
						$animateBlog2 =  "animated fadeInLeft go";
						$classBlog3  =  "margin-blog";

						$blogCount = 0;
					}
	        		$out .= '<div class="thumbnail-img '.$animateBlog.'"  >';
	        			$out .= '<div class="second-bg" style="background:url('.$bg.');"><div></div></div>';
	        			$out .= '<a href="'.get_the_permalink().'">';
	        			$out .= '<div class="image-wbg" style="background:url('.$bg.');"></div>';
	        			$out .= '</a>';
	        		$out .= '</div>';
	        		$out .= '<div class="content-b '.$animateBlog2.'">';
		        		$out .= '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
		        		$out .= '<div class="excp '.$classBlog3.'">'.excerpt(32).'</div>';
		        		$out .= '<a class="button  button_size_3 button_js" href="'.get_the_permalink().'"><span class="button_label">READ MORE <i class="fas fa-long-arrow-alt-right"></i></span></a>';
	        		$out .= '</div>';
	        	$out .= '</div>';
        	}
        endwhile;
		$out .= '</div>';
		/* Hide Load More, Jus uncomment to show load more
        if ($total_p > 8) {
        	$out .= '<div class="load-morep">';
        		$out .= '<a>Load more <i class="fa fa-redo"></i></a>';
        	$out .= '</div>';
        	$out .= '<script>
        	var counter = 1;
        	var ajaxurl = "'.admin_url('admin-ajax.php').'";
        	jQuery("body").on("click", ".load-morep a", function(e){
				e.preventDefault();
				counter++;
				var page = counter;
				jQuery.ajax({
			        type : "post",
			        url : ajaxurl,
			        data : {
			            action: "pagination_p",
			            page: page,
			        },
			        error: function(response){
			        },
			        success: function(response) {
			            jQuery(".list-posts").append(response);
			            if(counter == '.$loopp->max_num_pages.'){
			    			jQuery(".load-morep").hide(300);
			    		}
			        }
			    });
			});
        	</script>';
        } */
    endif;
    wp_reset_postdata();
	return $out;
}

/* Search posts */
add_action('wp_ajax_nopriv_pagination_p', 'pagination_p');
add_action('wp_ajax_pagination_p', 'pagination_p');
function pagination_p(){
    global $post;
    $page = $_POST['page'];

	$args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
    	'paged' => $page,
    );

    $post_query = new WP_Query($args);
    if($post_query->have_posts() ) {
    	$counter = 0;
		while($post_query->have_posts() ) {
			$post_query->the_post();
			$counter++;
			?>
			<div class="item-post regular-item">
				<?php
        		if(has_post_thumbnail()){
        			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
        			$bg = $image[0];
        		}else{
        			$bg = get_stylesheet_directory_uri().'/images/orangebg.jpg';
        		}
        		?>
	        	<div class="thumbnail-img">
	        		<div class="image-wbg" style="background:url(<?php echo $bg; ?>);"></div>
	        	</div>
	        	<div class="content-b">
		        	<h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
		        	<a class="link-p" href="<?php echo get_the_permalink(); ?>"><span class="button_label">READ MORE <i class="fas fa-long-arrow-alt-right"></i></span></a>
	        	</div>
	        </div>
			<?php
		}
	}
    die();
}

/**/
add_shortcode('table_options', 'table_options_function');
function table_options_function($atts, $content){
	shortcode_atts( array(
    	'title_table' => '',
    	'title_1' => '',
    	'price_1' => '',
    	'desc_1' => '',
    	'link_1' => '',
    	'title_2' => '',
    	'price_2' => '',
    	'desc_2' => '',
    	'link_2' => '',
    	'title_3' => '',
    	'price_3' => '',
    	'desc_3' => '',
    	'link_3' => '',
    	'row_dsc_1' => '',
    	'row_val_1' => '',
    	'row_val_2' => '',
    	'row_val_3' => '',
    	'row_dsc_2' => '',
    	'row_val_2_1' => '',
    	'row_val_2_2' => '',
    	'row_val_2_3' => '',
    	'row_dsc_3' => '',
    	'row_val_3_1' => 'false',
    	'row_val_3_2' => 'false',
    	'row_val_3_3' => 'false',
    	'row_dsc_4' => '',
    	'row_val_4_1' => 'false',
    	'row_val_4_2' => 'false',
    	'row_val_4_3' => 'false',
    	'row_dsc_5' => '',
    	'row_val_5_1' => 'false',
    	'row_val_5_2' => 'false',
    	'row_val_5_3' => 'false',
   	), $atts );
	$out = '';
	if($atts['row_val_3_1'] == 'false'){
		$icon = '<span class="bullet gray"></span>';
	}else{
		$icon = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_3_2'] == 'false'){
		$icon2 = '<span class="bullet gray"></span>';
	}else{
		$icon2 = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_3_3'] == 'false'){
		$icon3 = '<span class="bullet gray"></span>';
	}else{
		$icon3 = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_4_1'] == 'false'){
		$icon21 = '<span class="bullet gray"></span>';
	}else{
		$icon21 = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_4_2'] == 'false'){
		$icon22 = '<span class="bullet gray"></span>';
	}else{
		$icon22 = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_4_3'] == 'false'){
		$icon23 = '<span class="bullet gray"></span>';
	}else{
		$icon23 = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_5_1'] == 'false'){
		$icon31 = '<span class="bullet gray"></span>';
	}else{
		$icon31 = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_5_2'] == 'false'){
		$icon32 = '<span class="bullet gray"></span>';
	}else{
		$icon32 = '<span class="bullet cian"></span>';
	}
	if($atts['row_val_5_3'] == 'false'){
		$icon33 = '<span class="bullet gray"></span>';
	}else{
		$icon33 = '<span class="bullet cian"></span>';
	}
	//<img src="'.get_stylesheet_directory_uri().'/images/img-hand.png" alt="hand">
	$out .= '<div class="table-base">
	<div class="row">
		<div class="col">
			<div class="content">
				<div class="title">
					<div class="bg-title">
						
						<h3>'.$atts['title_table'].'</h3>
					</div>
				</div>
				<div class="body">
					<div class="height-box"></div>
					<div class="x-border">'.$atts['row_dsc_1'].'</div>
					<div class="x-border">'.$atts['row_dsc_2'].'</div>
					<div class="x-border">'.$atts['row_dsc_3'].'</div>
					<div class="x-border">'.$atts['row_dsc_4'].'</div>
					<div class="x-border">'.$atts['row_dsc_5'].'</div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="content">
				<div class="title">
					<h3>'.$atts['title_1'].'</h3> <h2><sup class="sm-sup">$</sup>'.$atts['price_1'].'<sup class="xs-sup">/monthly</sup></h2>
				</div>
				<div class="body">
					<div class="height-box">'.$atts['desc_1'].'</div>
					<div class="x-border">'.$atts['row_val_1'].'</div>
					<div class="x-border">'.$atts['row_val_2_1'].'</div>
					<div class="x-border">'.$icon.'</div>
					<div class="x-border">'.$icon21.'</div>
					<div class="x-border">'.$icon31.'</div>
					<div> <a class="btn orange" href="'.$atts['link_1'].'">Sign Up <i class="fas fa-long-arrow-alt-right"></i></a> </div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="content">
				<div class="title">
					<h3>'.$atts['title_2'].'</h3> <h2><sup class="sm-sup">$</sup>'.$atts['price_2'].'<sup class="xs-sup">/monthly</sup></h2>
				</div>
				<div class="body">
					<div class="height-box">'.$atts['desc_2'].'</div>
					<div class="x-border">'.$atts['row_val_2'].'</div>
					<div class="x-border">'.$atts['row_val_2_2'].'</div>
					<div class="x-border">'.$icon2.'</div>
					<div class="x-border">'.$icon22.'</div>
					<div class="x-border">'.$icon32.'</div>
					<div> <a class="btn orange" href="'.$atts['link_2'].'">Sign Up <i class="fas fa-long-arrow-alt-right"></i></a> </div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="content">
				<div class="title">
					<h3>'.$atts['title_3'].'</h3> <h2><sup class="sm-sup">$</sup>'.$atts['price_3'].'<sup class="xs-sup">/monthly</sup></h2>
				</div>
				<div class="body">
					<div class="height-box">'.$atts['desc_3'].'</div>
					<div class="x-border">'.$atts['row_val_3'].'</div>
					<div class="x-border">'.$atts['row_val_2_3'].'</div>
					<div class="x-border">'.$icon3.'</div>
					<div class="x-border">'.$icon23.'</div>
					<div class="x-border">'.$icon33.'</div>
					<div> <a class="btn orange" href="'.$atts['link_3'].'">Sign Up <i class="fas fa-long-arrow-alt-right"></i></a> </div>
				</div>
			</div>
		</div>
	</div>
</div>';
    return $out;
}

add_shortcode('table_price', 'table_price_function');
function table_price_function($atts, $content){
	shortcode_atts( array(
		'title' => 'Our Rates',
		'title-plan-1' => 'Standard',
		'title-plan-2' => 'Business',
		'title-plan-3' => 'Enterprice',
		'plan-1-price' => '95',
		'plan-2-price' => '195',
		'plan-3-price' => '345',
		'plan-1-description' => 'Dolore em nibh ella euismod magna erat emmy volutpat elits',
		'plan-2-description' => 'Dolore em nibh ella euismod magna erat emmy volutpat elits',
		'plan-3-description' => 'Dolore em nibh ella euismod magna erat emmy volutpat elits',
		'row' => '10',
		'row-hidde' => '5',
		'col-1-link' => get_site_url().'/contact/',
		'col-2-link' => get_site_url().'/contact/',
		'col-3-link' => get_site_url().'/contact/'
	   ), $atts );
	   ob_start();   
?>
<div class="table-base">
	<div class="row">
		<div class="col">
			<div class="content first-content">
				<div class="title">
					<div class="bg-title">
						<img src="<?php echo get_stylesheet_directory_uri()?>/images/rate.png" />
						<h3><?php echo $atts['title']?></h3>
					</div>
				</div>
				<div class="body title-body-wp">
					<div class="height-box"></div>
					<?php for ($i=1; $i <= $atts['row'] ; $i++) { 
						$plan = 'plan-'.$i;
						if ( $i > $atts['row-hidde'] ) {
							echo "<div class='box-hide'>";	
						}
						echo '<div class="x-border">'.$atts[$plan].'</div>';
						if ( $i > $atts['row-hidde'] ) {
							echo "</div>";	
						}
					}?>
					<div class="wrap-link"> <a class="view-more-info" href="javascript:;"><i class="fas fa-plus"></i>&nbsp; <span class="view-more-1">View more</span> <span class="view-less-1">View less</span> </a></div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="content">
				<div class="title">
					<h3><?php echo $atts['title-plan-1']?></h3> <h2><sup class="sm-sup">$</sup><?php echo $atts['plan-1-price']?><sup class="xs-sup">/monthly</sup></h2>
				</div>
				<div class="body">
					<div class="height-box"><?php echo $atts['plan-1-description']?></div>
					<?php for ($i=1; $i <= $atts['row'] ; $i++) { 
						$col1 = 'col-1-'.$i;
						$plan = 'plan-'.$i;
						switch ($atts[$col1]) {
							case 'true':
								$atts[$col1] = '<div class="x-border"><span class="plan-name">'.$atts[$plan].'</span><span class="bullet cian"></span></div>';
								break;
							case 'false':
								$atts[$col1] = '<div class="x-border row-gray"><span class="bullet gray"></span></div>';
								break;
							default:
							$atts[$col1]= '<div class="x-border"><span class="plan-name">'.$atts[$plan].': </span><span class="blue-txt">'.$atts[$col1].'</span></div>';
								break;
						}
						if ( $i > $atts['row-hidde'] ) {
							echo "<div class='box-hide'>";	
						}

						echo $atts[$col1];

						if ( $i > $atts['row-hidde'] ) {
							echo "</div>";	
						}
					}?>
					<div> <a class="btn orange" href="<?php echo $atts['col-1-link']?>">Sign Up <i class="fas fa-long-arrow-alt-right"></i></a> </div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="content">
				<div class="title">
					<h3><?php echo $atts['title-plan-2']?></h3> <h2><sup class="sm-sup">$</sup><?php echo $atts['plan-2-price']?><sup class="xs-sup">/monthly</sup></h2>
				</div>
				<div class="body">
					<div class="height-box"><?php echo $atts['plan-2-description']?></div>
					<?php for ($i=1; $i <= $atts['row'] ; $i++) { 
						$col2 = 'col-2-'.$i;
						$plan = 'plan-'.$i;
						switch ($atts[$col2]) {
							case 'true':
								$atts[$col2] = '<div class="x-border"><span class="plan-name">'.$atts[$plan].'</span><span class="bullet cian"></span></div>';
								break;
							case 'false':
								$atts[$col2] = '<div class="x-border row-gray"><span class="bullet gray"></span></div>';
								break;
							default:
							$atts[$col2]= '<div class="x-border"><span class="plan-name">'.$atts[$plan].': </span><span class="blue-txt">'.$atts[$col2].'</span></div>';
								break;
						}
						if ( $i > $atts['row-hidde'] ) {
							echo "<div class='box-hide'>";	
						}
						echo $atts[$col2];
						if ( $i > $atts['row-hidde'] ) {
							echo "</div>";	
						}
					}?>
					<div> <a class="btn orange" href="<?php echo $atts['col-2-link']?>">Sign Up <i class="fas fa-long-arrow-alt-right"></i></a> </div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="content">
				<div class="title">
					<h3><?php echo $atts['title-plan-3']?></h3> <h2><sup class="sm-sup">$</sup><?php echo $atts['plan-3-price']?><sup class="xs-sup">/monthly</sup></h2>
				</div>
				<div class="body">
					<div class="height-box"><?php echo $atts['plan-3-description']?></div>
					<?php for ($i=1; $i <= $atts['row'] ; $i++) { 
						$col3 = 'col-3-'.$i;
						$plan = 'plan-'.$i;
						switch ($atts[$col3]) {
							case 'true':
								$atts[$col3] = '<div class="x-border"><span class="plan-name">'.$atts[$plan].'</span><span class="bullet cian"></span></div>';
								break;
							case 'false':
								$atts[$col3] = '<div class="x-border row-gray"><span class="bullet gray"></span></div>';
								break;
							default:
							$atts[$col3]= '<div class="x-border"><span class="plan-name">'.$atts[$plan].': </span><span class="blue-txt">'.$atts[$col3].'</span></div>';
								break;
						}
						if ( $i > $atts['row-hidde'] ) {
							echo "<div class='box-hide'>";	
						}
						echo $atts[$col3];
						if ( $i > $atts['row-hidde'] ) {
							echo "</div>";	
						}
					}?>
					<div> <a class="btn orange" href="<?php echo $atts['col-3-link']?>">Sign Up <i class="fas fa-long-arrow-alt-right"></i></a> </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

