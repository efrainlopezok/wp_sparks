<?php
/**
 * 404 page.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */
get_header();
$translate['404-title'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-title', 'Ooops... Error 404') : __('Ooops... Error 404', 'betheme');
$translate['404-subtitle'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-subtitle', 'We are sorry, but the page you are looking for does not exist') : __('We are sorry, but the page you are looking for does not exist', 'betheme');
$translate['404-text'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-text', 'Please check entered address and try again or') : __('Please check entered address and try again or ', 'betheme');
$translate['404-btn'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-btn', 'go to homepage') : __('go to homepage', 'betheme');
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php echo esc_attr(mfn_user_os()); ?>">

<head>

<meta charset="<?php bloginfo('charset'); ?>" />
<?php wp_head(); ?>

</head>

<?php
	$customID = mfn_opts_get('error404-page');
	$body_class = '';
	if ($customID) {
		$body_class .= 'custom-404';
	}
?>

<body <?php body_class($body_class); ?>>

	<?php if ($customID): ?>

		<div id="Content">
			<div class="content_wrapper clearfix">

				<div class="sections_group">
					<?php
						$mfn_builder = new Mfn_Builder_Front($customID, true);
						$mfn_builder->show();
					?>
				</div>

				<?php get_sidebar(); ?>

			</div>
		</div>

	<?php else: ?>

		<div id="Error_404">
			<div class="container">
				<div class="column one">

					<div class="error_pic">
						<i class="<?php echo esc_attr(mfn_opts_get('error404-icon', 'icon-traffic-cone')); ?>"></i>
					</div>

					<div class="error_desk">
						<h2><?php echo esc_html($translate['404-title']); ?></h2>
						<h4><?php echo esc_html($translate['404-subtitle']); ?></h4>
						<p><span class="check"><?php echo wp_kses_post($translate['404-text']); ?></span> &nbsp;&nbsp;<a class="btn orange" href="<?php echo esc_url(site_url()); ?>"><?php echo esc_html($translate['404-btn']); ?></a></p>
					</div>
				</div>
			</div>
		</div>
		
	<?php endif; ?>
	<?php get_footer(); ?>
</body>
</html>
<?php

function btn_shortcode_nt( $atts ) {
   	shortcode_atts( array(
    	'text' => '',
    	'link' => '#',
    	'color' => '',
    	'target' => '',
   	), $atts );
   	$link = "<a href='".$atts['link']."' target='_".$atts['target']."'  class='btn ".$atts['color']."'>".$atts['text']."&nbsp; <i class='fas fa-long-arrow-alt-right'></i></a>";
   return $link;
}
add_shortcode( 'button_link', 'btn_shortcode_nt' );

/* Blog Loop Shortcode */
add_shortcode('blog_loop', 'blog_loop_function_n');
function blog_loop_function_n(){
	$out = '';
	$loop = new WP_Query( array( 'post_type' => 'post', 'showposts' => 8 ) );
	$loopp = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 8 ) );
	$cloop = new WP_Query( array( 'post_type' => 'post', 'showposts' => -1 ) );
	$total_p = $cloop->found_posts;
	$loopp->max_num_pages;
    if ( $loop->have_posts() ) :
    	$counter = 0;
    	$out .= '<div class="list-posts">';
        while ( $loop->have_posts() ) : $loop->the_post();
        	$counter++;
        	if ($counter <= 3) {
        		$cclass = 'big-cont';
        	}else{
        		$cclass = 'regular-item';
        	}
        	if ($counter == 4) {
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
		        		$out .= '<div class="excp">'.get_the_excerpt().'</div>';
		        		$out .= '<a class="link-p" href="'.get_the_permalink().'"><span class="button_label">Read More <i class="fas fa-long-arrow-alt-right"></i></span></a>';
	        		$out .= '</div>';
	        		$out .= '<div class="thumbnail-img">';
	        			$out .= '<div class="image-wbg" style="background:url('.$bg.');"></div>';
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
	        			$out .= '<div class="image-wbg" style="background:url('.$bg.');"></div>';
	        		$out .= '</div>';
	        		$out .= '<div class="content-b">';
		        		$out .= '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
		        		$out .= '<a class="link-p" href="'.get_the_permalink().'"><span class="button_label">Read More <i class="fas fa-long-arrow-alt-right"></i></span></a>';
	        		$out .= '</div>';
	        	$out .= '</div>';
        	}else{
        		$out .= '<div class="item-post '.$cclass.'">';
	        		if(has_post_thumbnail()){
	        			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	        			$bg = $image[0];
	        		}else{
	        			$bg = get_stylesheet_directory_uri().'/images/orangebg.jpg';
	        		}
	        		$out .= '<div class="thumbnail-img">';
	        			$out .= '<div class="second-bg" style="background:url('.$bg.');"><div></div></div>';
	        			$out .= '<div class="image-wbg" style="background:url('.$bg.');"></div>';
	        		$out .= '</div>';
	        		$out .= '<div class="content-b">';
		        		$out .= '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
		        		$out .= '<div class="excp">'.get_the_excerpt().'</div>';
		        		$out .= '<a class="button  button_size_3 button_js" href="'.get_the_permalink().'"><span class="button_label">Read More <i class="fas fa-long-arrow-alt-right"></i></span></a>';
	        		$out .= '</div>';
	        	$out .= '</div>';
        	}
        endwhile;
        $out .= '</div>';
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
			            action: "pagination_px",
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
        }
    endif;
    wp_reset_postdata();
	return $out;
}

/* Search posts */
add_action('wp_ajax_nopriv_pagination_px', 'pagination_px');
add_action('wp_ajax_pagination_px', 'pagination_px');
function pagination_px(){
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
		        	<a class="link-p" href="<?php echo get_the_permalink(); ?>"><span class="button_label">Read More <i class="fas fa-long-arrow-alt-right"></i></span></a>
	        	</div>
	        </div>
			<?php
		}
	}
    die();
}
 