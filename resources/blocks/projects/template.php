<?php 

namespace WBL\Projects;

// Setup query
$query = new \WP_Query( [
	'posts_per_page'   => $args['postsToShow'],
	'post_type'        => 'wbl_project',
	// 'post_status'      => 'publish',
	// 'order'            => $attributes['order'],
	// 'orderby'          => $attributes['orderBy'],
	// 'suppress_filters' => false,
] );

// Extra classes
$extra_classes = [];

// Alignment
if (! empty($args['align'])) {
	$extra_classes[] = 'align' . $args['align'];
}

// Make string of array
$extra_classes = implode(' ', $extra_classes);

?>

<?php if ( $query->have_posts() ) : ?>

	<div class="loop loop--<?= $query->query['post_type'] ?> <?= $extra_classes ?>">

		<?php while ( $query->have_posts() ) : $query->the_post(); ?>

			<article class="entry entry--wbl_project">

				<div class="entry__image">
					<?= the_post_thumbnail( 'thumbnail') ?>
				</div>

				<header class="entry__header">			
					<h3 class="entry__title">
						<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
					</h3>
				</header>

				<?php if ( apply_filters( 'wbl/projects/taxonomy/'.TaxCategory::get_taxonomy(), true ) ) : ?>

					<footer class="entry__footer">

						<div class="entry__categories">
							<?php if ( $term_list = get_the_term_list( get_the_ID(), TaxCategory::get_taxonomy(), '', ', ', '' ) ) : ?>

								<?= $term_list ?>

							<?php else : ?>

								<?= __( 'No categories', 'wbl-projects' ); ?>

							<?php endif; ?>
						</div>

					</footer>

				<?php endif; ?>

			</article>

		<?php endwhile; ?>

	</div>

<?php else : ?>

	<p>Geen projecten</p>

<?php endif; ?>

<?php wp_reset_postdata(); ?>