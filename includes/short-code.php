<?php
defined('ABSPATH') || exit;

add_shortcode('featured_projects', function () {

        wp_enqueue_style(
        'themidev-featured-projects',
        plugin_dir_url(__FILE__) . '../assets/plugin.css',
        [],
        '1.0'
    );

    $q = new WP_Query([
        'post_type'      => 'themidev_portfolio',
        'posts_per_page' => 3,
        'meta_query'     => [
            [
                'key'     => '_is_featured',
                'value'   => '1',
                'compare' => '='
            ]
        ]
    ]);

    if (!$q->have_posts()) {
        return '';
    }

    ob_start(); ?>

    <div class="featured-projects__container">
        <div class="featured-projects owl-carousel">
            <?php while ($q->have_posts()) : $q->the_post(); ?>
                <article class="fp-card">
                    <?php $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
                    <div class="fp-card__inner">
                        <div class="fp-hero" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.4)), url('<?php echo esc_url($thumb_url); ?>')">
                            <span class="fp-category">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'portfolio_tech');
                                if ($terms && !is_wp_error($terms)) {
                                    echo esc_html($terms[0]->name);
                                }
                                ?>
                            </span>
                            
                            <div class="fp-icon">
                                <svg class="fp-icon__svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="16" y1="13" x2="8" y2="13" />
                                    <line x1="16" y1="17" x2="8" y2="17" />
                                    <polyline points="10 9 9 9 8 9" />
                                </svg>
                            </div>
                            
                            <div class="fp-hero__overlay"></div>
                        </div>

                        <div class="fp-body">
                            <div class="fp-header">
                                <h3 class="fp-title"><?php the_title(); ?></h3>
                                <div class="fp-dot"></div>
                            </div>

                            <p class="fp-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                            </p>

                            <div class="fp-tags">
                                <?php
                                if ($terms && !is_wp_error($terms)) :
                                    foreach ($terms as $term) :
                                ?>
                                    <span class="fp-tag"><?php echo esc_html($term->name); ?></span>
                                <?php endforeach; endif; ?>
                            </div>

                            <div class="fp-footer">
                                <a href="<?php the_permalink(); ?>" class="fp-btn">
                                    <span class="fp-btn__text">Explore Project</span>
                                    <svg class="fp-btn__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>

    <?php

    wp_reset_postdata();
    return ob_get_clean();
});

