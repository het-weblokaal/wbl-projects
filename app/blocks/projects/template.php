<?php 

namespace WBL_Projects;

// If we have query_args then setup a custom query, otherwise fallback to the default query
$query = new \WP_Query( $args );

?>

<?php if ( $query->have_posts() ) : ?>

	<div class="loop loop--wbl-projects">

		<?php while ( $query->have_posts() ) : $query->the_post(); ?>

			<article class="entry entry--project">

				<div class="entry__image">
					<?= the_post_thumbnail( 'thumbnail') ?>
				</div>

				<header class="entry__header">			
					<h3 class="entry__title">
						<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
					</h3>
				</header>

				<footer class="entry__footer">
					#categoriën
				</footer>

			</article>

		<?php endwhile; ?>

	</div>

<?php else : ?>

	<p>Geen projecten</p>

<?php endif; ?>

<?php wp_reset_postdata(); ?>