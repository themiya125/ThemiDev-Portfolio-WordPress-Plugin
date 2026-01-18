<?php
get_header();
?>

<section class="portfolio-archive container">

    <header class="archive-header">
        <h1>Featured Work</h1>
        <p>
            A curated selection of technical solutions and design systems.
        </p>
    </header>

    <!-- FILTERS -->
    <?php if ( taxonomy_exists('portfolio_tech') ) : ?>
        <div class="portfolio-filters">
            <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" class="active">All</a>
            <?php
            $terms = get_terms('portfolio_tech');
            foreach ( $terms as $term ) :
            ?>
                <a href="<?php echo esc_url( get_term_link($term) ); ?>">
                    <?php echo esc_html( $term->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- GRID -->
    <div class="portfolio-grid">
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="portfolio-card">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium'); ?>
                    <h3><?php the_title(); ?></h3>
                    <?php the_excerpt(); ?>
                </a>
            </article>
        <?php endwhile; ?>
    </div>

</section>

<?php get_footer(); ?>
