<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="portfolio-single">

<?php
// Yoast Breadcrumb (safe)
if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<nav class="breadcrumb container">','</nav>' );
}
?>

<?php while ( have_posts() ) : the_post(); ?>

<!-- HEADER -->
<section class="portfolio-header container">
    <div class="portfolio-header-content">
        <span class="portfolio-category">
            <?php 
            $terms = get_the_terms(get_the_ID(), 'portfolio_category');
            if ($terms && !is_wp_error($terms)) {
                echo esc_html($terms[0]->name);
            } else {
                echo 'Portfolio';
            }
            ?>
        </span>
        <h1 class="portfolio-title"><?php the_title(); ?></h1>
        
        <?php if ( has_excerpt() ) : ?>
            <div class="portfolio-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- HERO IMAGE -->
<?php if ( has_post_thumbnail() ) : ?>
<section class="portfolio-hero container">
    <div class="hero-container">
        <?php the_post_thumbnail( 'full', array('class' => 'hero-image') ); ?>
        <div class="hero-badge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7 7h10v10M7 17L17 7"/>
            </svg>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- META + LINKS -->
<section class="portfolio-meta container">
    <div class="meta-grid">
        <?php
        $meta_fields = [
            'CLIENT'   => '_td_client',
            'ROLE'     => '_td_role',
            'TRAINING' => '_td_timeline',
            'TYPE'     => '_td_type',
        ];

        foreach ( $meta_fields as $label => $key ) :
            $value = get_post_meta( get_the_ID(), $key, true );
            if ( $value ) :
        ?>
            <div class="meta-item">
                <h4 class="meta-label"><?php echo esc_html( $label ); ?></h4>
                <p class="meta-value"><?php echo esc_html( $value ); ?></p>
            </div>
        <?php
            endif;
        endforeach;
        ?>
    </div>

    <div class="meta-actions">
        <h4>Project Links</h4>
        <div class="action-buttons">
            <?php if ( $live = get_post_meta( get_the_ID(), '_td_live_url', true ) ) : ?>
                <a class="btn primary" href="<?php echo esc_url( $live ); ?>" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                    View Live Demo
                </a>
            <?php endif; ?>

            <?php if ( $source = get_post_meta( get_the_ID(), '_td_source_url', true ) ) : ?>
                <a class="btn outline" href="<?php echo esc_url( $source ); ?>" target="_blank" rel="noopener">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    Source Code
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CONTENT + SIDEBAR -->
<section class="portfolio-body container">
    <div class="content">
        <?php 
        // Wrap content in card-like container
        echo '<div class="content-card">';
        the_content();
        echo '</div>';
        ?>
    </div>

    <aside class="sidebar">
        <!-- TECH STACK -->
        <?php if ( taxonomy_exists('portfolio_tech') ) : ?>
            <div class="tech-stack-section">
                <h4>Tech Stack</h4>
                <div class="tech-tags">
                    <?php
                    $tech_terms = get_the_terms(get_the_ID(), 'portfolio_tech');
                    if ($tech_terms && !is_wp_error($tech_terms)) {
                        foreach ($tech_terms as $term) {
                            echo '<span class="tech-tag">' . esc_html($term->name) . '</span>';
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- AUTHOR BOX (Kirki Safe) -->
        <?php
        if ( class_exists( 'Kirki' ) ) :

            $author_image    = get_theme_mod( 'author_image' );
            $author_name     = get_theme_mod( 'author_name' );
            $author_position = get_theme_mod( 'author_position' );
            $author_bio      = get_theme_mod( 'author_bio' );

            if ( $author_image || $author_name || $author_position || $author_bio ) :
        ?>
            <div class="author-box">
                <div class="author-header">
                    <?php if ( $author_image ) : ?>
                        <div class="author-image">
                            <img src="<?php echo esc_url( wp_get_attachment_url( $author_image ) ); ?>"
                                 alt="<?php echo esc_attr( $author_name ); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="author-info">
                        <?php if ( $author_name ) : ?>
                            <h3 class="author-name"><?php echo esc_html( $author_name ); ?></h3>
                        <?php endif; ?>

                        <?php if ( $author_position ) : ?>
                            <p class="author-position"><?php echo esc_html( $author_position ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ( $author_bio ) : ?>
                    <p class="author-bio"><?php echo esc_html( $author_bio ); ?></p>
                <?php endif; ?>
            </div>
        <?php
            endif;
        endif;
        ?>

    </aside>
</section>

<!-- GALLERY (ACF Safe) -->
<?php if ( function_exists( 'have_rows' ) && have_rows( 'portfolio_gallery' ) ) : ?>
<section class="portfolio-gallery container">
    <h3>Project Gallery</h3>
    <div class="gallery-grid">
        <?php $counter = 0; ?>
        <?php while ( have_rows( 'portfolio_gallery' ) ) : the_row();
            $image = get_sub_field( 'image' );
            $caption = get_sub_field( 'caption' );
            if ( $image ) :
                $counter++;
        ?>
            <div class="gallery-item group">
                <div class="gallery-image-container">
                    <img src="<?php echo esc_url( $image ); ?>" 
                         alt="<?php echo esc_attr($caption ?: 'Gallery Image ' . $counter); ?>"
                         class="gallery-image">
                    <div class="gallery-overlay">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                    </div>
                </div>
                <?php if ( $caption ) : ?>
                    <p class="gallery-caption"><?php echo esc_html( $caption ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; endwhile; ?>
    </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="portfolio-cta">
    <div class="cta-content container">
        <h2>Have a project in mind?</h2>
        <p>Let's collaborate to build a scalable solution that fits your business needs.</p>
        <div class="cta-buttons">
            <a href="/contact" class="btn primary large group">
                Start a Project
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
            <button class="btn outline large copy-email-btn group" data-email="your@email.com">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
                Copy Email
            </button>
        </div>
        <div class="cta-signature">
            <span class="signature-text">Them!Dev</span>
        </div>
    </div>
</section>

<?php endwhile; wp_reset_postdata(); ?>

</div>

<?php get_footer(); ?>

<style>
/* Base Styles with React-inspired design */
:root {
    --blue-50: #eff6ff;
    --blue-100: #dbeafe;
    --blue-500: #3b82f6;
    --blue-600: #2563eb;
    --blue-700: #1d4ed8;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-900: #111827;
}

body {
    background: linear-gradient(to bottom, #f9fafb, #ffffff);
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.breadcrumb {
    padding: 20px 0;
    font-size: 14px;
    color: #6b7280;
}

/* Header Section - React style */
.portfolio-header {
    padding: 60px 20px 40px;
    text-align: center;
}

.portfolio-header-content {
    max-width: 800px;
    margin: 0 auto;
}

.portfolio-category {
    display: inline-block;
    padding: 6px 16px;
    background: var(--blue-100);
    color: var(--blue-700);
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 20px;
}

.portfolio-title {
    font-size: 48px;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 20px;
    background: linear-gradient(to right, var(--gray-900), var(--gray-700));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.portfolio-excerpt {
    font-size: 18px;
    line-height: 1.6;
    color: var(--gray-600);
    max-width: 600px;
    margin: 0 auto;
}

/* Hero Section - React card style */
.portfolio-hero {
    padding: 0 20px 40px;
}

.hero-container {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transition: all 0.5s ease;
}

.hero-container:hover {
    transform: translateY(-4px);
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.3);
}

.hero-image {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.7s ease;
}

.hero-container:hover .hero-image {
    transform: scale(1.05);
}

.hero-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 44px;
    height: 44px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.hero-container:hover .hero-badge {
    transform: scale(1.1) rotate(5deg);
}

/* Meta Section - React grid layout */
.portfolio-meta {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 60px;
    padding: 60px 20px;
    border-bottom: 1px solid var(--gray-200);
}

.meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.meta-item {
    padding: 24px;
    background: white;
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.meta-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.meta-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--gray-600);
    margin-bottom: 8px;
    font-weight: 600;
}

.meta-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--gray-900);
    margin: 0;
}

.meta-actions {
    background: white;
    padding: 28px;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.meta-actions h4 {
    font-size: 18px;
    margin-bottom: 24px;
    color: var(--gray-900);
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* Button styles - React inspired */
.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 24px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-family: inherit;
    line-height: 1;
}

.btn.primary {
    background: linear-gradient(to right, var(--blue-600), var(--blue-500));
    color: white;
    box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
}

.btn.primary:hover {
    background: linear-gradient(to right, var(--blue-700), var(--blue-600));
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.2);
}

.btn.outline {
    background: white;
    color: var(--gray-700);
    border: 2px solid var(--gray-200);
}

.btn.outline:hover {
    border-color: var(--blue-600);
    color: var(--blue-600);
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

/* Body Section */
.portfolio-body {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 60px;
    padding: 60px 20px;
}

.content {
    font-size: 16px;
    line-height: 1.8;
    color: var(--gray-600);
}

.content-card {
    background: white;
    padding: 32px;
    border-radius: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.content h2 {
    font-size: 28px;
    color: var(--gray-900);
    margin: 32px 0 16px;
}

.content h3 {
    font-size: 22px;
    color: var(--gray-900);
    margin: 24px 0 12px;
}

.content p {
    margin-bottom: 20px;
}

.content ul, .content ol {
    margin-bottom: 24px;
    padding-left: 24px;
}

.content li {
    margin-bottom: 8px;
}

/* Sidebar */
.sidebar {
    position: sticky;
    top: 40px;
    align-self: start;
}

.tech-stack-section {
    background: white;
    padding: 28px;
    border-radius: 20px;
    margin-bottom: 30px;
    border: 1px solid var(--gray-200);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.tech-stack-section h4 {
    font-size: 18px;
    margin-bottom: 20px;
    color: var(--gray-900);
}

.tech-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tech-tag {
    display: inline-block;
    padding: 8px 16px;
    background: var(--blue-50);
    color: var(--blue-700);
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid var(--blue-100);
}

/* Author Box */
.author-box {
    background: white;
    padding: 28px;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.author-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.author-image img {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
}

.author-info h3 {
    font-size: 16px;
    margin: 0 0 6px;
    color: var(--gray-900);
}

.author-position {
    font-size: 14px;
    color: var(--gray-600);
    margin: 0;
}

.author-bio {
    font-size: 14px;
    line-height: 1.6;
    color: var(--gray-600);
    margin: 0;
    border-top: 1px solid var(--gray-200);
    padding-top: 20px;
}

/* Gallery Section - React card style */
.portfolio-gallery {
    padding: 60px 20px;
    border-top: 1px solid var(--gray-200);
}

.portfolio-gallery h3 {
    font-size: 28px;
    text-align: center;
    margin-bottom: 40px;
    color: var(--gray-900);
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 24px;
}

.gallery-item {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.5s ease;
}

.gallery-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.gallery-image-container {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.gallery-item:hover .gallery-image {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 44px;
    height: 44px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
    transform: translateY(0);
}

.gallery-caption {
    padding: 20px;
    margin: 0;
    font-size: 14px;
    color: var(--gray-600);
    border-top: 1px solid var(--gray-200);
}

/* CTA Section - React gradient style */
.portfolio-cta {
    background: linear-gradient(to right, var(--blue-700), var(--blue-600), var(--blue-700));
    padding: 80px 20px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.cta-content {
    max-width: 600px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.portfolio-cta h2 {
    font-size: 36px;
    margin-bottom: 16px;
    color: white;
    font-weight: 700;
}

.portfolio-cta p {
    font-size: 18px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 40px;
}

.cta-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-bottom: 40px;
}

.btn.large {
    padding: 18px 36px;
    font-size: 16px;
}

.btn.large.primary {
    background: white;
    color: var(--blue-700);
}

.btn.large.primary:hover {
    background: var(--blue-100);
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(255, 255, 255, 0.2);
}

.btn.large.outline {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn.large.outline:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: white;
    transform: translateY(-2px);
}

/* Group hover effects */
.group:hover svg {
    transform: translateX(4px);
}

.group svg {
    transition: transform 0.3s ease;
}

.cta-signature {
    font-family: cursive;
    font-size: 20px;
    color: rgba(255, 255, 255, 0.7);
    margin-top: 30px;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .portfolio-meta {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .portfolio-body {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .portfolio-title {
        font-size: 36px;
    }
    
    .meta-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-buttons {
        flex-direction: column;
    }
    
    .gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .btn.large {
        width: 100%;
        justify-content: center;
    }
}

/* Copy Email Animation */
@keyframes copySuccess {
    0% { background-color: white; }
    50% { background-color: #10b981; color: white; }
    100% { background-color: white; }
}

.copy-success {
    animation: copySuccess 0.5s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const copyEmailBtn = document.querySelector('.copy-email-btn');
  
  if (copyEmailBtn) {
    copyEmailBtn.addEventListener('click', function() {
      const email = this.getAttribute('data-email');
      
      navigator.clipboard.writeText(email).then(() => {
        const originalText = this.innerHTML;
        this.innerHTML = `
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 6L9 17l-5-5"/>
          </svg>
          Copied!
        `;
        this.classList.add('copy-success');
        
        setTimeout(() => {
          this.innerHTML = originalText;
          this.classList.remove('copy-success');
        }, 2000);
      }).catch(err => {
        console.error('Failed to copy: ', err);
        alert('Failed to copy email. Please copy manually: ' + email);
      });
    });
  }
});
</script>