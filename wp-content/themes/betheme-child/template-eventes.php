<?php
/**
 * Template Name: Template Events
 *
 * @package Betheme
 * @author Muffin Group
 * @link https://muffingroup.com
 */

get_header();
?>
<div id="Content">
	<div class="container">
		<?php  
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			$args= array(
				'post_type' => 'event',
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
				'meta_key' => 'event-start-date',
				'paged' => $paged
			);
			$eventes = new WP_Query($args);
		?>
		<div class="loop-events section_wrapper">
			<?php  
				if ($eventes->have_posts()) {
					while ( $eventes->have_posts() ) {
						$eventes->the_post(); 	
						// include event variables
						include 'events/vsel-page-variables.php';
						?> 
							<div class="one-third mcb-wrap">
								<div class="single-event">
								<?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');  ?>
									<img class="scale-with-grid" src="<?php echo $featured_img_url; ?>" alt="">
									<div class="time-event">
										<p>
											<?php  echo '<span class="date">'.get_post_time(( esc_attr('M j')), esc_attr($page_end_date), $utc_time_zone ).'</span> | '; ?>
											<?php  echo '<strong class="time">'.esc_attr($page_time).'</strong>'; ?>
										</p>
									</div>
									<h3><?php  the_title(); ?></h3>
									<a class="btn orange" href="<?php echo get_the_permalink(); ?>">RSVP <i class="fas fa-long-arrow-alt-right"></i></a>
									<a class="btn-white" href="">MORE INFO+</a>
								</div>
							</div>
						<?php
					}
					wp_reset_query(); 
				}
			?>
		</div>
	</div>
	<div class="content_wrapper clearfix">
		<div class="sections_group">
			<div class="entry-content" itemprop="mainContentOfPage">
				<?php
					while (have_posts()) {

						the_post();

						$mfn_builder = new Mfn_Builder_Front(get_the_ID());
						$mfn_builder->show();

					}
				?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();
