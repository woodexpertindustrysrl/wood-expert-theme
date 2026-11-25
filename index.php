<?php
/**
 * Șablonul de rezervă. Șabloanele dedicate (homepage, categorii, produs, blog) vin în fazele următoare.
 *
 * @package WoodExpert
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="wrap py-16 tab:py-24">
	<?php if ( is_home() || is_archive() || is_search() ) : ?>
		<header class="mb-12">
			<h1 class="text-[clamp(32px,4vw,48px)] font-bold leading-[1.1] tracking-[-.03em]">
				<?php
				if ( is_search() ) {
					/* translators: %s: termenul căutat */
					printf( esc_html__( 'Rezultate pentru „%s”', 'wood-expert' ), esc_html( get_search_query() ) );
				} elseif ( is_archive() ) {
					echo esc_html( wp_strip_all_tags( get_the_archive_title() ) );
				} else {
					echo esc_html( single_post_title( '', false ) ?: get_bloginfo( 'name' ) );
				}
				?>
			</h1>
		</header>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<?php if ( is_singular() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'max-w-3xl mx-auto' ); ?>>
					<h1 class="text-[clamp(32px,4vw,48px)] font-bold leading-[1.1] tracking-[-.03em]"><?php the_title(); ?></h1>
					<div class="prose-we mt-8"><?php the_content(); ?></div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<div class="grid gap-6 tab:grid-cols-2 desk:grid-cols-3">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<a <?php post_class( 'group flex flex-col text-tx hover:text-tx' ); ?> href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="aspect-[16/10] overflow-hidden rounded-2xl border border-line">
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'size-full object-cover transition-transform duration-500 group-hover:scale-105' ) ); ?>
							</div>
						<?php endif; ?>
						<h2 class="mt-4 text-[19px] font-semibold leading-snug tracking-[-.015em]"><?php the_title(); ?></h2>
						<p class="mt-2 text-sm text-mut"><?php echo esc_html( get_the_date() ); ?></p>
					</a>
				<?php endwhile; ?>
			</div>
			<div class="mt-12">
				<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<p class="text-lg text-mut"><?php esc_html_e( 'Nu am găsit nimic aici.', 'wood-expert' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
