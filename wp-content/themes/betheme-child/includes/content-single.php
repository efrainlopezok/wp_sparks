<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

// prev & next post

$single_post_nav = array(
	'hide-header'	=> false,
	'hide-sticky'	=> false,
	'in-same-term' => false,
);

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

// translate

$translate['published'] = mfn_opts_get('translate') ? mfn_opts_get('translate-published', 'Published by') : __('Published by', 'betheme');
$translate['at'] = mfn_opts_get('translate') ? mfn_opts_get('translate-at', 'at') : __('at', 'betheme');
$translate['tags'] = mfn_opts_get('translate') ? mfn_opts_get('translate-tags', 'Tags') : __('Tags', 'betheme');
$translate['categories'] = mfn_opts_get('translate') ? mfn_opts_get('translate-categories', 'Categories') : __('Categories', 'betheme');
$translate['all'] = mfn_opts_get('translate') ? mfn_opts_get('translate-all', 'Show all') : __('Show all', 'betheme');
$translate['related']	= mfn_opts_get('translate') ? mfn_opts_get('translate-related', 'Related posts') : __('Related posts', 'betheme');
$translate['readmore'] = mfn_opts_get('translate') ? mfn_opts_get('translate-readmore', 'Read more') : __('Read more', 'betheme');
?>

<div id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>

	<?php
		// single post navigation | sticky
		if (! $single_post_nav['hide-sticky']) {
			echo mfn_post_navigation_sticky($post_prev, 'prev', 'icon-left-open-big');
			echo mfn_post_navigation_sticky($post_next, 'next', 'icon-right-open-big');
		}
	?>

	<?php if (get_post_meta(get_the_ID(), 'mfn-post-template', true) != 'intro'): ?>

		<div class="section section-post-header">
			<div class="section_wrapper clearfix">

				<div class="column one post-header">

					<div class="title_wrapper">

						<?php
							if (mfn_opts_get('blog-title')) {
								if (get_post_format() == 'quote') {
									echo '<blockquote>'. wp_kses(get_the_title(), mfn_allowed_html()) .'</blockquote>';
								} else {
									$h = mfn_opts_get('title-heading', 1);
									echo '<h'. esc_attr($h) .' class="entry-title" itemprop="headline">'. wp_kses(get_the_title(), mfn_allowed_html()) .'</h'. esc_attr($h) .'>';
								}
							}
						?>

						<?php
							if (get_post_format() == 'link') {
								$link = get_post_meta(get_the_ID(), 'mfn-post-link', true);
								echo '<a href="'. esc_url($link) .'" target="_blank">'. esc_url($link) .'</a>';
							}
						?>

						<?php
							$show_meta = false;
							$single_meta = mfn_opts_get('blog-meta');

							if (is_array($single_meta)) {
								if (isset($single_meta['author']) || isset($single_meta['date']) || isset($single_meta['categories'])) {
									$show_meta = true;
								}
							}
						?>

					</div>

				</div>

				<div class="column one single-photo-wrapper <?php echo mfn_post_thumbnail_type(get_the_ID()); ?>">

					<?php if (! post_password_required()): ?>
						<div class="image_frame scale-with-grid <?php if (! mfn_opts_get('blog-single-zoom')){ echo 'disabled'; } ?>">

							<div class="image_wrapper">
								<?php echo mfn_post_thumbnail(get_the_ID()); ?>
							</div>

							<?php
								if ($caption = get_post(get_post_thumbnail_id())->post_excerpt) {
									echo '<p class="wp-caption-text '. esc_attr(mfn_opts_get('featured-image-caption')) .'">'. wp_kses($caption, mfn_allowed_html('caption')) .'</p>';
								}
							?>

						</div>
					<?php endif; ?>

				</div>

			</div>
		</div>

	<?php endif; ?>

	<div class="post-wrapper-content">

		<?php
			$mfn_builder = new Mfn_Builder_Front($post->ID);
			$mfn_builder->show();
		?>

		<div class="section section-post-footer">
			<div class="section_wrapper clearfix">

				<div class="column one post-pager">
					<?php
						wp_link_pages(array(
							'before' => '<div class="pager-single">',
							'after' => '</div>',
							'link_before' => '<span>',
							'link_after' => '</span>',
							'next_or_number' => 'number'
						));
					?>
				</div>

			</div>
		</div>

	</div>
    <?php
    // single post navigation | header
    if (! $single_post_nav['hide-header']) {
        echo mfn_post_navigation_header($post_prev, $post_next, $blog_page_id, $translate);
    }
?>
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

						echo '<div class=" '. esc_attr($related_style) .'">';
                        //echo '<h4>'. esc_html($translate['related']) .'</h4>';
                        echo '<h4 class="title-adjust">You Might Also Like</h4>';
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

									echo '<div class="desc">';
										if (get_post_format() != 'quote') {
											echo '<h5><a href="'. esc_url(get_permalink()) .'">'. wp_kses(get_the_title(), mfn_allowed_html()) .'</a></h5>';
										}
										echo '<hr class="hr_color" />';
										echo '<a href="'. esc_url(get_permalink()) .'" class="link-more"><span class="button_label">'. esc_html($translate['readmore']) .'</span><i class="fas fa-long-arrow-alt-right"></i></a>';
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


<div class="section mcb-section mcb-section-92dc51c91 pre-footer bg-cover" style="padding-top:0px;padding-bottom:0px;background-color:;background-image:url(http://ta-dev01.net/spark/wp-content/uploads/2020/01/bg-pf.jpg);background-repeat:no-repeat;background-position:center;background-attachment:;background-size:;-webkit-background-size:"><div class="section_wrapper mcb-section-inner"><div class="wrap mcb-wrap mcb-wrap-e6bec0353 two-fifth  valign-top bg-cover clearfix" style="padding:45px;background-image:url(http://ta-dev01.net/spark/wp-content/uploads/2020/01/BG2-PRE-FOOTER.jpg);background-repeat:no-repeat;background-position:right center;background-attachment:;background-size:;-webkit-background-size:"><div class="mcb-wrap-inner"><div class="column mcb-column mcb-item-ba2ef9261 one column_visual"><h3>JOIN NOW</h3>
<h2>Space is limited. Sign up today!</h2>
</div><div class="column mcb-column mcb-item-8ebd774cb one column_button"><a class="button  button_size_2 button_js" href="#" style="background-color:#ffffff!important;color:#000000;"><span class="button_label">OUR BENEFITS <i class="fas fa-long-arrow-alt-right"></i></span></a>
</div></div></div></div></div>