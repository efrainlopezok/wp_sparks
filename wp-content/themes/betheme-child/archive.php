<?php
 
get_header();


$opts_single_post_nav = mfn_opts_get('prev-next-nav');
if (is_array($opts_single_post_nav)) {
	if (isset($opts_single_post_nav['hide-header'])) {
		$single_post_nav['hide-header'] = true;
	}
	if (isset($opts_single_post_nav['hide-sticky'])) {
		$single_post_nav['hide-sticky'] = true;
	}
	if (isset($opts_single_post_nav['in-same-term'])) {
		$single_post_nav['in-same-term'] = true;
	}
}

$post_prev = get_adjacent_post($single_post_nav['in-same-term'], '', true);
$post_next = get_adjacent_post($single_post_nav['in-same-term'], '', false);
$blog_page_id = get_option('page_for_posts');

// post classes

$classes = array();
if (! mfn_post_thumbnail(get_the_ID())) {
	$classes[] = 'no-img';
}
if (get_post_meta(get_the_ID(), 'mfn-post-hide-image', true)) {
	$classes[] = 'no-img';
}
if (post_password_required()) {
	$classes[] = 'no-img';
}
if (! mfn_opts_get('blog-title')) {
	$classes[] = 'no-title';
}


if (mfn_opts_get('share-style')) {
	$classes[] = 'share-'. mfn_opts_get('share-style');
}

// translate

$translate['tags'] = mfn_opts_get('translate') ? mfn_opts_get('translate-tags', 'Tags') : __('Tags', 'betheme');
$translate['categories'] = mfn_opts_get('translate') ? mfn_opts_get('translate-categories', 'Categories') : __('Categories', 'betheme');
$translate['all'] = mfn_opts_get('translate') ? mfn_opts_get('translate-all', 'Show all') : __('Show all', 'betheme');
$translate['related']	= mfn_opts_get('translate') ? mfn_opts_get('translate-related', 'Related posts') : __('Related posts', 'betheme');
$translate['readmore'] = mfn_opts_get('translate') ? mfn_opts_get('translate-readmore', 'Read more') : __('Read more', 'betheme');
?>
    <div class="container article-post">
<?php
/* Posts */
if ( have_posts() ) :
    
	while ( have_posts() ) : the_post(); ?>
		
		<div class="item-post">
			<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			<p class="post-meta"><?php the_time( 'F jS, Y' ); ?> | <a
					href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
				| <?php
				$categories = get_the_category();
				$comma      = ', ';
				$output     = '';
				
				if ( $categories ) {
					foreach ( $categories as $category ) {
						$output .= '<a href="' . get_category_link( $category->term_id ) . '">' . $category->cat_name . '</a>' . $comma;
					}
					echo trim( $output, $comma );
				} ?>
			</p>
			<?php the_content() ?>
		</div>
	
	<?php endwhile;
 
else :
	echo '<h2>There are no posts!</h2>';
 
endif;
?>
<div class="related-section">
<div class="section section-post-related">
		<div class="section_wrapper clearfix">

			<?php
				if (mfn_opts_get('blog-related') && $aCategories = wp_get_post_categories(get_the_ID())) {

					$related_count  = intval(mfn_opts_get('blog-related'));
					$related_cols = 'col-'. absint(mfn_opts_get('blog-related-columns', 3));
					$related_style = mfn_opts_get('related-style');

					$args = array(
						'category__in' => $aCategories,
						'ignore_sticky_posts'	=> true,
						'no_found_rows' => true,
						'post__not_in' => array( get_the_ID() ),
						'posts_per_page' => $related_count,
						'post_status' => 'publish',
					);

					$query_related_posts = new WP_Query($args);
					if ($query_related_posts->have_posts()) {

						echo '<div class="section-related-adjustment '. esc_attr($related_style) .'">';
							echo '<h4>'. esc_html($translate['related']) .'</h4>';
							echo '<div class="section-related-ul '. esc_attr($related_cols) .'">';

								while ($query_related_posts->have_posts()) {
									$query_related_posts->the_post();

									$related_class = '';
									if (! mfn_post_thumbnail(get_the_ID())) {
										$related_class = 'no-img';
									}

									$post_format = mfn_post_thumbnail_type(get_the_ID());

									if (mfn_opts_get('blog-related-images')) {
										$post_format = 'image';
									}

									echo '<div class="column post-related '. esc_attr(implode(' ', get_post_class($related_class))) .'">';

									if (get_post_format() == 'quote') {

										echo '<blockquote>';
											echo '<a href="'. esc_url(get_permalink()) .'">';
												the_title();
											echo '</a>';
										echo '</blockquote>';

									} else {

										echo '<div class="single-photo-wrapper '. esc_attr($post_format) .'">';
											echo '<div class="image_frame scale-with-grid">';

												echo '<div class="image_wrapper">';
													echo mfn_post_thumbnail(get_the_ID(), 'related', false, $post_format);
												echo '</div>';

												if (has_post_thumbnail() && $caption = get_post(get_post_thumbnail_id())->post_excerpt) {
													echo '<p class="wp-caption-text '. esc_attr(mfn_opts_get('featured-image-caption')) .'">'. wp_kses($caption, mfn_allowed_html('caption')) .'</p>';
												}

											echo '</div>';
										echo '</div>';

									}

									echo '<div class="date_label">'. esc_html(get_the_date()) .'</div>';

									echo '<div class="desc">';
										if (get_post_format() != 'quote') {
											echo '<h4><a href="'. esc_url(get_permalink()) .'">'. wp_kses(get_the_title(), mfn_allowed_html()) .'</a></h4>';
										}
										echo '<hr class="hr_color" />';
										echo '<a href="'. esc_url(get_permalink()) .'" class="button button_left button_js"><span class="button_icon"><i class="icon-layout"></i></span><span class="button_label">'. esc_html($translate['readmore']) .'</span></a>';
									echo '</div>';

									echo '</div>';
								}

							echo '</div>';
						echo '</div>';
					}
					wp_reset_postdata();
				}
			?>

		</div>
    </div>
</div> 
<?php
get_footer();
 
?>