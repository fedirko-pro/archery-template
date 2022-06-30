<?php
get_header();
?>
	<section class="section head tags">
		<h1>Tag: <?=single_tag_title();?></h1>
	</section>

	<section class="section breadcrumbs">
		<?php
		if ( function_exists( 'bcn_display' ) ) {
			bcn_display();
		}
		?>
	</section>

	<section class="section categories tags">
		<div class="container">
			<div class="post_box">
				<?php
				$tag_id = get_queried_object()->term_id;
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

				$post_args = [
					'paged'     => $paged,
                    'tag_id' => $tag_id,
                    'post_type' => 'any'
				];

				//wp query
				$post_query = new WP_Query( $post_args );
				while ( $post_query->have_posts() ) {
					$post_query->the_post();
					$post_url = get_the_permalink();
					$thumb = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri() . '/img/default_thumb.png';
					$title = get_the_title();
					$date = get_the_date('d/m/Y');
					?>
					<div class="post">
						<div class="preview_img" style="background: url(<?= $thumb; ?>) center no-repeat; background-size: cover"></div>
						<div class="preview_description">
							<div class="post_date">
								<?=$date;?>
							</div>
							<div class="post_title">
								<?= $title; ?>
							</div>
							<div class="post_read_more">
								<a class="btn blue" href="<?= $post_url; ?>">
									<?=pll__('read_more');?>
								</a>
							</div>
						</div>
					</div>
					<?php
					$i ++;
				}
				?>
			</div>
			<div class="pagination">
				<?php
				//Fix Pagination with $GLOBALS['wp_query'] = {custom_query}
				$GLOBALS['wp_query'] = $post_query;
				the_posts_pagination( [
					'prev_text'          => pll__( 'Previous' ),
					'next_text'          => pll__( 'Next' ),
				] );
				wp_reset_query(); // Restore the $wp_query and global post data to the original main query.
				?>
			</div>
		</div>
	</section>

<?php get_footer(); ?>