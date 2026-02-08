<?php get_header(); ?>

<section class="blog-hero">
  <!-- Floating particles -->
  <div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
  </div>

  <div class="blog-hero-inner container">
    <h1 class="blog-title">Portfolio</h1>

    <div class="breadcrumb">
      <?php
      if(function_exists('yoast_breadcrumb')){
          yoast_breadcrumb('<span id="breadcrumbs">', '</span>');
      }
      ?>
    </div>

  
  </div>
</section>

<section class="portfolio-archive container">

    <!-- 🔍 SEARCH BAR (always visible) -->
    <section class="portfolio-search-results container">
        <form method="get" action="<?php echo esc_url( home_url('/') ); ?>" class="modern-search-form" id="portfolio-search-form">
            <div class="search-input-wrapper">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>

                <input
                    type="search"
                    name="s"
                    class="modern-search-input"
                    placeholder="Search projects..."
                    value="<?php echo esc_attr( get_search_query() ); ?>"
                >

                <button type="button" class="clear-search">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <input type="hidden" name="post_type" value="themidev_portfolio">

            <button type="submit" class="search-submit-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
        </form>
    </section>

    <?php
    /**
     * =============================
     * SEARCH MODE
     * =============================
     */
    if ( is_search() && get_search_query() !== '' ) :
    ?>

        <?php if ( have_posts() ) : ?>

            <header class="modern-archive-header">
                <div class="results-header-content">
                    <h1 class="results-title">
                        <span class="results-count"><?php echo (int) $wp_query->found_posts; ?></span>
                        project<?php echo $wp_query->found_posts !== 1 ? 's' : ''; ?> found for
                        <span class="search-term">"<?php echo esc_html( get_search_query() ); ?>"</span>
                    </h1>

                    <button class="clear-all-search"
                        onclick="window.location.href='<?php echo esc_url( get_post_type_archive_link('themidev_portfolio') ); ?>'">
                        View all projects
                    </button>
                </div>
            </header>

            <div class="modern-portfolio-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="portfolio-card">
                        <a href="<?php the_permalink(); ?>" class="portfolio-card-link">
                            <div class="card-image-container">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <img src="<?php echo esc_url( get_the_post_thumbnail_url(null,'large') ); ?>" class="card-image">
                                    <div class="image-overlay">
                                        <span class="view-project">View Project</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="card-content">
                                <h3 class="card-title"><?php the_title(); ?></h3>
                                <p class="card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php if ( $wp_query->max_num_pages > 1 ) : ?>
                <div class="modern-pagination">
                    <?php echo paginate_links(); ?>
                </div>
            <?php endif; ?>

        <?php else : ?>

            <div class="modern-empty-state">
                <h2>No results found</h2>
                <p>Nothing matched "<?php echo esc_html( get_search_query() ); ?>"</p>
            </div>

        <?php endif; ?>

    <?php
    /**
     * =============================
     * NORMAL ARCHIVE MODE
     * =============================
     */
    else :
    ?>

        <div class="portfolio-grid">
            
            <?php while ( have_posts() ) : the_post(); ?>
                <article class="portfolio-card">
                    <a href="<?php the_permalink(); ?>" class="portfolio-link">
                        <div class="portfolio-thumb">
                            <?php the_post_thumbnail('medium_large'); ?>
                            <div class="gradient-overlay"></div>
                        </div>

                        <div class="portfolio-content">
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>

                            <?php
                            $terms = get_the_terms( get_the_ID(), 'portfolio_tech' );
                            if ( $terms ) :
                            ?>
                                <div class="portfolio-tags">
                                    <?php foreach ( $terms as $term ) : ?>
                                        <span class="portfolio-tag"><?php echo esc_html( $term->name ); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>

 <div class="portfolio-pagination-wrapper">
    <nav class="modern-pagination" aria-label="Portfolio navigation">
        <?php
        $paginate_links = paginate_links([
            'type' => 'array',
            'mid_size' => 1,
            'end_size' => 1,
            'prev_text' => '<svg class="arrow-icon prev" width="18" height="18" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg><span>Prev</span>',
            'next_text' => '<span>Next</span><svg class="arrow-icon next" width="18" height="18" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>',
        ]);
        
        if ($paginate_links) :
            echo '<ul class="pagination-container">';
            foreach ($paginate_links as $link) :
                $class = 'pagination-item';
                if (strpos($link, 'current') !== false) {
                    $link = str_replace(['page-numbers', 'current'], ['pagination-current', ''], $link);
                    $class .= ' active';
                } elseif (strpos($link, 'dots') !== false) {
                    $link = str_replace('page-numbers dots', 'pagination-dots', $link);
                } elseif (strpos($link, 'prev') !== false) {
                    $link = str_replace('page-numbers', 'pagination-arrow prev', $link);
                } elseif (strpos($link, 'next') !== false) {
                    $link = str_replace('page-numbers', 'pagination-arrow next', $link);
                } else {
                    $link = str_replace('page-numbers', 'pagination-link', $link);
                }
                echo '<li class="' . esc_attr($class) . '">' . $link . '</li>';
            endforeach;
            echo '</ul>';
        endif;
        ?>
    </nav>
</div>
</div>
    <?php endif; ?>

</section>

<?php get_footer(); ?>


<style>
    /* Modern CSS Variables */
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --secondary: #10b981;
        --dark: #1f2937;
        --light: #f9fafb;
        --gray: #6b7280;
        --light-gray: #e5e7eb;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
/* Blog Header */
.blog-hero {
    padding-top: 100px;
    background: linear-gradient(to right, #2563eb, #1d4ed8, #02258e);
    margin-bottom: 50px;
    text-align: center;
    color: #fff;
	    padding-bottom: 20px;
}
.breadcrumb {
    justify-content: center;
}
	.blog-title {
		font-size: 3.75rem;
		font-weight: 800;
		line-height: 1.1;
	    margin-top: 10px;
	}
.particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    pointer-events: none;
}

/* Individual Particle */
.particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    pointer-events: none;
}

/* Particle 1 - Medium sized, slow movement */
.particle:nth-child(1) {
    width: 60px;
    height: 60px;
    top: 20%;
    left: 10%;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.4));
    animation: float 15s infinite ease-in-out;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
}

/* Particle 2 - Small, fast movement */
.particle:nth-child(2) {
    width: 30px;
    height: 30px;
    top: 60%;
    right: 15%;
    background: rgba(255, 255, 255, 0.25);
    animation: float 8s infinite ease-in-out reverse;
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.15);
}

/* Particle 3 - Large, very slow movement */
.particle:nth-child(3) {
    width: 100px;
    height: 100px;
    bottom: 30%;
    left: 20%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 70%);
    animation: float 25s infinite linear;
    filter: blur(2px);
}

/* Floating Animation */
@keyframes float {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg);
    }
    25% {
        transform: translate(20px, -30px) rotate(90deg);
    }
    50% {
        transform: translate(40px, 0) rotate(180deg);
    }
    75% {
        transform: translate(20px, 30px) rotate(270deg);
    }
}

/* Additional floating variations */
@keyframes float-alt {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(-30px, -20px) scale(1.1);
    }
    66% {
        transform: translate(30px, 20px) scale(0.9);
    }
}

/* Pulse Animation */
@keyframes pulse {
    0%, 100% {
        opacity: 0.3;
        transform: scale(1);
    }
    50% {
        opacity: 0.6;
        transform: scale(1.05);
    }
}

/* Add pulse animation to second particle */
.particle:nth-child(2) {
    animation: 
        float 8s infinite ease-in-out reverse,
        pulse 3s infinite ease-in-out;
}

/* Content z-index to appear above particles */
.blog-hero-inner {
    position: relative;
    z-index: 2;
}

/* Modern Minimal Pagination */
.portfolio-pagination-wrapper {
    margin: 3rem auto 2rem;
    padding: 1.5rem 0;
    max-width: 1200px;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.modern-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

.pagination-container {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
}

/* Pagination Items */
.pagination-item {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Pagination Links - Clean Minimal Style */
.pagination-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    color: #4a5568;
    background: white;
    border: 1px solid #e2e8f0;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

/* Hover Effect - Subtle Blue */
.pagination-link:hover {
    color: #2563eb;
    border-color: #2563eb;
    background: #f8fafc;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
}

/* Active/Current Page - Clean Blue */
.pagination-current {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    color: white;
    background: #2563eb;
    border: 1px solid #2563eb;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
    position: relative;
}

.pagination-current::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 8px;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 100%);
}

/* Dots Styling */
.pagination-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    color: #94a3b8;
    font-size: 0.9rem;
    font-weight: 500;
    user-select: none;
}

/* Arrow Buttons - Clean Minimal */
.pagination-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    height: 40px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    color: #4a5568;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
        color: #2563eb;
    border: 1px solid #2563eb !important;
    background: #f8fafc;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
}

.pagination-arrow:hover {
    color: #2563eb;
    border-color: #2563eb;
    background: #f8fafc;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
}

.pagination-arrow:hover .arrow-icon {
    transform: translateX(2px);
}

.pagination-arrow.prev:hover .arrow-icon {
    transform: translateX(-2px);
}

/* Arrow Icons - Clean SVG */
.arrow-icon {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
    transition: transform 0.25s ease;
}

.arrow-icon.prev {
    transform: rotate(90deg);
}

.arrow-icon.next {
    transform: rotate(-90deg);
}

/* Ripple Effect */
.pagination-link::before,
.pagination-arrow::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(37, 99, 235, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.3s ease, height 0.3s ease;
}

.pagination-link:hover::before,
.pagination-arrow:hover::before {
    width: 100%;
    height: 100%;
}

/* Animation */
@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.pagination-item {
    animation: fadeInScale 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* Stagger animation */
.pagination-item:nth-child(1) { animation-delay: 0.1s; }
.pagination-item:nth-child(2) { animation-delay: 0.15s; }
.pagination-item:nth-child(3) { animation-delay: 0.2s; }
.pagination-item:nth-child(4) { animation-delay: 0.25s; }
.pagination-item:nth-child(5) { animation-delay: 0.3s; }
.pagination-item:nth-child(6) { animation-delay: 0.35s; }

/* Mobile Responsive */
@media (max-width: 768px) {
    .pagination-container {
        gap: 0.25rem;
    }
    
    .pagination-link,
    .pagination-current,
    .pagination-dots {
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    
    .pagination-arrow {
        padding: 0.5rem 1rem;
        height: 36px;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    
    .pagination-arrow span:not(.arrow-icon) {
        display: none;
    }
    
    .pagination-arrow {
        min-width: 36px;
        width: 36px;
        padding: 0;
        justify-content: center;
    }
}



.portfolio-search {
    max-width: 420px;
    margin: 0 auto 3rem;
    display: flex;
}

.portfolio-search input[type="search"] {
    width: 100%;
    padding: 0.75rem 1.25rem;
    border-radius: 999px;
    border: 1px solid var(--light-gray);
    font-size: 0.95rem;
    outline: none;
}

.portfolio-search input[type="search"]:focus {
    border-color: var(--primary);
}

    .portfolio-archive {
        padding: 2rem 1rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .archive-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .archive-header h1 {
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
    }

    .archive-header p {
        font-size: 1.125rem;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Modern Filter Buttons */
    .portfolio-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: center;
        margin-bottom: 3rem;
        padding: 0 1rem;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        border: 1px solid var(--light-gray);
        border-radius: 50px;
        color: var(--dark);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        cursor: pointer;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        border-color: var(--primary);
        box-shadow: var(--shadow);
    }

    .filter-btn.active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .filter-icon {
        width: 18px;
        height: 18px;
        fill: currentColor;
        transition: var(--transition);
    }

    /* Modern Portfolio Grid */
    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    /* Enhanced Portfolio Card */
    .portfolio-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .portfolio-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 20px;
        padding: 2px;
        background: linear-gradient(45deg, transparent, rgba(99, 102, 241, 0.1), transparent);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        opacity: 0;
        transition: var(--transition);
    }

    .portfolio-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    .portfolio-card:hover::before {
        opacity: 1;
    }

    .portfolio-link {
        color: inherit;
        text-decoration: none;
        display: block;
        height: 100%;
    }

    /* Enhanced Thumbnail */
    .portfolio-thumb {
        position: relative;
        overflow: hidden;
        height: 240px;
    }

    .portfolio-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .portfolio-card:hover .portfolio-thumb img {
        transform: scale(1.1);
    }

    .gradient-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
        opacity: 0;
        transition: var(--transition);
    }

    .portfolio-card:hover .gradient-overlay {
        opacity: 1;
    }

    /* Modern SVG Icons */
    .portfolio-icon-container {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
        opacity: 0;
        transform: translateY(-10px);
        transition: var(--transition);
    }

    .portfolio-card:hover .portfolio-icon-container {
        opacity: 1;
        transform: translateY(0);
    }

    .portfolio-arrow,
    .portfolio-external {
        width: 36px;
        height: 36px;
        padding: 8px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        fill: var(--primary);
        transition: var(--transition);
        cursor: pointer;
    }

    .portfolio-arrow:hover,
    .portfolio-external:hover {
        background: white;
        transform: scale(1.1);
        fill: var(--primary-dark);
    }

    /* Enhanced Content */
    .portfolio-content {
        padding: 1.5rem;
    }

    .portfolio-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .portfolio-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
        flex: 1;
    }

    .portfolio-chevron {
        width: 24px;
        height: 24px;
        fill: var(--primary);
        transform: rotate(-90deg);
        transition: var(--transition);
    }

    .portfolio-card:hover .portfolio-chevron {
        transform: rotate(0deg);
    }

    .portfolio-content p {
        color: var(--gray);
        font-size: 0.9375rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    /* Modern Tags */
    .portfolio-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .portfolio-tag {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(16, 185, 129, 0.1));
        color: var(--primary);
        border-radius: 20px;
        font-weight: 500;
        transition: var(--transition);
    }

    .portfolio-card:hover .portfolio-tag {
        transform: translateY(-2px);
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(16, 185, 129, 0.15));
    }

    /* Enhanced Pagination */
    .portfolio-pagination {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .portfolio-pagination a,
    .portfolio-pagination span {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        background: white;
        color: var(--dark);
        text-decoration: none;
        font-weight: 500;
        border: 1px solid var(--light-gray);
        transition: var(--transition);
    }

    .portfolio-pagination a:hover {
        transform: translateY(-2px);
        border-color: var(--primary);
        color: var(--primary);
        box-shadow: var(--shadow);
    }

    .portfolio-pagination .current {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .pagination-icon {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }
.portfolio-search-results {
    padding: 2rem 0;
   
}

/* Modern Search Form */
.modern-search-form {
    position: relative;
    max-width: 600px;
    margin: 0 auto 3rem;
    display: flex;
    gap: 0.5rem;
}

.search-input-wrapper {
    flex: 1;
    position: relative;
    background: var(--bg-secondary, #f8f9fa);
    border-radius: 12px;
    border: 2px solid var(--border-color, #e9ecef);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-input-wrapper:focus-within {
    border-color: var(--primary-color, #6366f1);
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.15);
    transform: translateY(-1px);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary, #6c757d);
    pointer-events: none;
    transition: color 0.3s ease;
}

.modern-search-input {
    width: 100%;
    padding: 1rem 3rem 1rem 3rem;
    background: transparent;
    border: none;
    font-size: 1rem;
    color: var(--text-primary, #212529);
    outline: none;
}

.modern-search-input::placeholder {
    color: var(--text-tertiary, #adb5bd);
}

.clear-search {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    padding: 0.25rem;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    color: var(--text-secondary, #6c757d);
    transition: all 0.3s ease;
    border-radius: 50%;
}

.clear-search:hover {
    color: var(--primary-color, #6366f1);
    background: var(--bg-hover, #f1f3ff);
}

.modern-search-input:not(:placeholder-shown) ~ .clear-search {
    opacity: 1;
    visibility: visible;
}

.search-submit-btn {
    padding: 1rem 1.5rem;
    background: var(--blue-700, #6366f1);
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-submit-btn:hover {
    background: var(--blue-600, #4f46e5);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
}

/* Results Header */
.modern-archive-header {
    margin-bottom: 3rem;
}

.results-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.results-title {
    font-size: 1.5rem;
    font-weight: 500;
    color: var(--text-primary, #212529);
    margin: 0;
}

.results-count {
    font-weight: 700;
    color: var(--primary-color, #6366f1);
}

.search-term {
    font-weight: 600;
    color: var(--text-primary, #212529);
    background: var(--bg-highlight, #e0e7ff);
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    margin-left: 0.5rem;
}

.clear-all-search {
    padding: 0.75rem 1.5rem;
    background: transparent;
    border: 2px solid var(--border-color, #e9ecef);
    border-radius: 8px;
    color: var(--text-secondary, #6c757d);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.clear-all-search:hover {
    border-color: var(--primary-color, #6366f1);
    color: var(--primary-color, #6366f1);
    background: var(--bg-hover, #f8f9ff);
}

/* Modern Portfolio Grid */
.modern-portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 4rem;
}

.portfolio-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--border-color, #e9ecef);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    height: 100%;
}

.portfolio-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border-color: transparent;
}

.portfolio-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.card-image-container {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: var(--bg-secondary, #f8f9fa);
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.portfolio-card:hover .card-image {
    transform: scale(1.05);
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    padding: 1.5rem;
}

.portfolio-card:hover .image-overlay {
    opacity: 1;
}

.view-project {
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease 0.1s;
}

.portfolio-card:hover .view-project {
    opacity: 1;
    transform: translateY(0);
}

.card-content {
    padding: 1.5rem;
}

.card-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.category-tag {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    background: var(--bg-secondary, #f8f9fa);
    border-radius: 20px;
    color: var(--text-secondary, #6c757d);
    transition: all 0.3s ease;
}

.portfolio-card:hover .category-tag {
    background: var(--primary-light, #e0e7ff);
    color: var(--primary-color, #6366f1);
}

.more-tag {
    font-size: 0.7rem;
    opacity: 0.8;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0 0 0.75rem 0;
    color: var(--text-primary, #212529);
    transition: color 0.3s ease;
}

.portfolio-card:hover .card-title {
    color: var(--primary-color, #6366f1);
}

.card-excerpt {
    font-size: 0.875rem;
    color: var(--text-secondary, #6c757d);
    margin: 0 0 1rem 0;
    line-height: 1.6;
}

.card-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-tertiary, #adb5bd);
}

.card-date {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Modern Pagination */
.modern-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-top: 3rem;
}

.modern-pagination .page-numbers {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: 1px solid var(--border-color, #e9ecef);
    color: var(--text-secondary, #6c757d);
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    min-width: 40px;
    justify-content: center;
}

.modern-pagination .page-numbers:hover {
    border-color: var(--primary-color, #6366f1);
    color: var(--primary-color, #6366f1);
    transform: translateY(-2px);
}

.modern-pagination .current {
    background: var(--primary-color, #6366f1);
    color: white;
    border-color: var(--primary-color, #6366f1);
}

.modern-pagination .dots {
    border: none;
    pointer-events: none;
}

/* Empty State */
.modern-empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 16px;
    border: 2px dashed var(--border-color, #e9ecef);
    margin: 3rem auto;
    max-width: 500px;
}

.empty-state-icon {
    color: var(--text-tertiary, #adb5bd);
    margin-bottom: 1.5rem;
}

.empty-state-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--text-primary, #212529);
    margin-bottom: 1rem;
}

.empty-state-message {
    color: var(--text-secondary, #6c757d);
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.empty-state-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.primary-btn {
    padding: 0.875rem 1.75rem;
    background: var(--primary-color, #6366f1);
    color: white;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.primary-btn:hover {
    background: var(--primary-dark, #4f46e5);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    color: white;
}

.secondary-btn {
    padding: 0.875rem 1.75rem;
    background: transparent;
    border: 2px solid var(--border-color, #e9ecef);
    border-radius: 8px;
    color: var(--text-secondary, #6c757d);
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.secondary-btn:hover {
    border-color: var(--primary-color, #6366f1);
    color: var(--primary-color, #6366f1);
    background: var(--bg-hover, #f8f9ff);
}
    /* Responsive Design */
    @media (max-width: 1024px) {
        .portfolio-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .portfolio-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .portfolio-filters {
            gap: 0.5rem;
        }
        
        .filter-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .archive-header h1 {
            font-size: 2rem;
        }
        .modern-search-form {
        flex-direction: column;
    }
    
    .modern-portfolio-grid {
        grid-template-columns: 1fr;
    }
    
    .results-header-content {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .empty-state-actions {
        flex-direction: column;
    }
    
    .primary-btn,
    .secondary-btn {
        width: 100%;
        justify-content: center;
    }
    }

    @media (max-width: 480px) {
        .portfolio-filters {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .filter-btn {
            flex-shrink: 0;
        }
    }

    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .portfolio-card {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
        animation-delay: calc(var(--index, 0) * 0.1s);
    }

    /* Loading state simulation */
    .portfolio-thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s;
    }

    .portfolio-card.loading .portfolio-thumb::after {
        transform: translateX(100%);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add staggered animation to cards
    const cards = document.querySelectorAll('.portfolio-card');
    cards.forEach((card, index) => {
        card.style.setProperty('--index', index);
        // Add loading animation
        card.classList.add('loading');
        setTimeout(() => card.classList.remove('loading'), 600);
    });

    // Add hover effect to filter buttons
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => {
        btn.addEventListener('mouseenter', (e) => {
            const rect = e.target.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            e.target.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add click animation to cards
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a')) return;
            
            const link = this.querySelector('a');
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const effect = document.createElement('div');
            effect.style.left = x + 'px';
            effect.style.top = y + 'px';
            effect.classList.add('click-effect');
            this.appendChild(effect);
            
            setTimeout(() => effect.remove(), 600);
            setTimeout(() => window.location.href = link.href, 300);
        });
    });
});

// Add this to your theme's JS file or in a script tag
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const searchForm = document.getElementById('portfolio-search-form');
    const searchInput = document.querySelector('.modern-search-input');
    const clearButton = document.querySelector('.clear-search');
    
    if (!searchForm || !searchInput || !clearButton) return;
    
    // Clear search functionality
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.focus();
        clearButton.style.opacity = '0';
        clearButton.style.visibility = 'hidden';
    });
    
    // Show/hide clear button based on input
    searchInput.addEventListener('input', function() {
        if (searchInput.value.length > 0) {
            clearButton.style.opacity = '1';
            clearButton.style.visibility = 'visible';
        } else {
            clearButton.style.opacity = '0';
            clearButton.style.visibility = 'hidden';
        }
    });
    
    // Debounced search (optional for live search)
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            if (searchInput.value.length >= 3) {
                // Optional: Implement live search here
                console.log('Search for:', searchInput.value);
            }
        }, 500);
    });
    
    // Add focus styles
    searchInput.addEventListener('focus', function() {
        this.closest('.search-input-wrapper').classList.add('focused');
    });
    
    searchInput.addEventListener('blur', function() {
        this.closest('.search-input-wrapper').classList.remove('focused');
    });
    
    // Initialize AOS animations if AOS library is loaded
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    }
});
// Add smooth scrolling to pagination
document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('.pagination-container a');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Add ripple effect
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('pagination-ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
            
            // Smooth scroll to top on page change
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }, 100);
        });
    });
});
</script>