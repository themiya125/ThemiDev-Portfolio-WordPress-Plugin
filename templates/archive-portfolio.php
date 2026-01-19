<?php get_header(); ?>

<section class="portfolio-archive container">

    <header class="archive-header">

        <h1>Featured Work</h1>
        <p>
            A curated selection of technical solutions and design systems.
        </p>

<form role="search" method="get" class="portfolio-search mt-5" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input
        type="search"
        placeholder="Search projects..."
        value="<?php echo get_search_query(); ?>"
        name="s"
    />
    <input type="hidden" name="post_type" value="portfolio">
</form>

    </header>

   

    <!-- GRID -->
    <div class="portfolio-grid">
        <?php while ( have_posts() ) : the_post(); ?>
            <article class="portfolio-card" data-category="<?php echo esc_attr( wp_strip_all_tags( get_the_term_list( get_the_ID(), 'portfolio_tech', '', ', ' ) ) ); ?>">
                <a href="<?php the_permalink(); ?>" class="portfolio-link">
                    <div class="portfolio-thumb">
                        <?php the_post_thumbnail( 'medium_large' ); ?>
                        
                        <!-- SVG Arrow Icon -->
                        <div class="portfolio-icon-container">
                            <svg class="portfolio-arrow" viewBox="0 0 24 24">
                                <path d="M18.25 15.5a.75.75 0 0 1-.75-.75V7.56L7.28 18.78a.75.75 0 0 1-1.06-1.06L16.44 6.5H9.25a.75.75 0 0 1 0-1.5h9a.75.75 0 0 1 .75.75v9a.75.75 0 0 1-.75.75z"/>
                            </svg>
                            
                            <!-- External Link SVG -->
                            <svg class="portfolio-external" viewBox="0 0 24 24">
                                <path d="M14 5v2h3.586l-9.293 9.293a1 1 0 1 0 1.414 1.414L19 8.414V12h2V5h-7z"/>
                                <path d="M19 19H5V5h6V3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-2v6z"/>
                            </svg>
                        </div>
                        
                        <!-- Gradient Overlay -->
                        <div class="gradient-overlay"></div>
                    </div>

                    <div class="portfolio-content">
                        <div class="portfolio-header">
                            <h3><?php the_title(); ?></h3>
                            <svg class="portfolio-chevron" viewBox="0 0 24 24">
                                <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
                            </svg>
                        </div>
                        <p><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
                        
                        <!-- Tech Tags -->
                        <?php 
                        $terms = get_the_terms( get_the_ID(), 'portfolio_tech' );
                        if ( $terms && ! is_wp_error( $terms ) ) : ?>
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

<div class="portfolio-pagination">
<?php
global $wp_query;

$paged = max( 1, get_query_var( 'paged' ) );

if ( $wp_query->max_num_pages > 1 ) {
    echo paginate_links([
        'base'      => get_pagenum_link( 1 ) . '%_%',
        'format'    => 'page/%#%/',
        'current'   => $paged,
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '<svg class="pagination-icon" viewBox="0 0 24 24"><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg> Prev',
        'next_text' => 'Next <svg class="pagination-icon" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>',
    ]);
}
?>
</div>

</div>


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
        font-size: 2.5rem;
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
</script>