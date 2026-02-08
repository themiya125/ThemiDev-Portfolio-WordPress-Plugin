<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>
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
<div class="portfolio-single">



<?php while ( have_posts() ) : the_post(); ?>

<!-- HEADER -->
<section class="portfolio-header container">
    <div class="portfolio-header-content">
    
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
            'TIMELINE' => '_td_timeline',
           'TYPE'     => '_td_project_type',
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
        <!-- GALLERY (ACF Safe) -->
<?php
$images = get_post_meta( get_the_ID(), '_td_gallery_images', true );

if ( is_array( $images ) && ! empty( $images ) ) :

    $images = array_values( array_filter( $images ) );
    $count  = 1;
?>
<section class="project-gallery">
    <?php foreach ( $images as $img_id ) :

        $full  = wp_get_attachment_image_url( $img_id, 'full' );
        $thumb = wp_get_attachment_image( $img_id, 'large', false, [
            'loading' => 'lazy'
        ] );
        ?>
        <div class="gallery-item gallery-item-<?php echo $count; ?>">
            <a
                href="javascript:void(0);"
                data-fancybox="project-gallery"
                data-src="<?php echo esc_url( $full ); ?>"
            >
                <?php echo $thumb; ?>
            </a>
        </div>
        <?php $count++; ?>
    <?php endforeach; ?>
</section>
<?php endif; ?>




    </div>

    <aside class="sidebar">
         <div class="meta-actions">
        <h4>Project Links</h4>
        <div class="action-buttons">
            <?php if ( $live = get_post_meta( get_the_ID(), '_td_live_url', true ) ) : ?>
                <a class="btn primary" href="<?php echo esc_url( $live ); ?>" target="_blank" rel="noopener">
                 <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="group-hover:rotate-12 transition-transform" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M432,320H400a16,16,0,0,0-16,16V448H64V128H208a16,16,0,0,0,16-16V80a16,16,0,0,0-16-16H48A48,48,0,0,0,0,112V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V336A16,16,0,0,0,432,320ZM488,0h-128c-21.37,0-32.05,25.91-17,41l35.73,35.73L135,320.37a24,24,0,0,0,0,34L157.67,377a24,24,0,0,0,34,0L435.28,133.32,471,169c15,15,41,4.5,41-17V24A24,24,0,0,0,488,0Z"></path></svg>
                    View Live Demo
                </a>
            <?php endif; ?>

            <?php if ( $source = get_post_meta( get_the_ID(), '_td_source_url', true ) ) : ?>
                <a class="btn outline" href="<?php echo esc_url( $source ); ?>" target="_blank" rel="noopener">
                  <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 496 512" class="group-hover:scale-110 transition-transform" height="1.2em" width="1.2em" xmlns="http://www.w3.org/2000/svg"><path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path></svg>
                    Source Code
                </a>
            <?php endif; ?>
        </div>
    </div>
        <!-- TECH STACK -->
     <?php if ( taxonomy_exists( 'portfolio_tech' ) ) : ?>
        
  <div class="tech-stack-section">
    <h4>Tech Stack</h4>

    <div class="tech-tags">
        <?php
        $tech_terms = get_the_terms( get_the_ID(), 'portfolio_tech' );

        if ( $tech_terms && ! is_wp_error( $tech_terms ) ) :
            foreach ( $tech_terms as $term ) :

                $svg        = get_term_meta( $term->term_id, 'tech_svg', true );
                $icon_class = get_term_meta( $term->term_id, 'tech_icon_class', true );
                ?>
                <span class="tech-tag">
                    <?php if ( $svg ) : ?>
                        <span class="tech-icon <?php echo esc_attr( $icon_class ); ?>">
                       <?php echo $svg;?>
                        </span>
                    <?php endif; ?>

                    <span class="tech-name">
                        <?php echo esc_html( $term->name ); ?>
                    </span>
                </span>
            <?php endforeach;
        endif;
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
    --text-cyan-500: #06B6D4;
    --bg-cyan-50: #ECFEFF;
    --color-green-600: #16A34A;
    --color-gray-700: #374151;
    --bg-blue-50: #EFF6FF;
    --text-orange-500: #F97316;
}

body {
    background: linear-gradient(to bottom, #f9fafb, #ffffff);
    min-height: 100vh;
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
.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 20px;
}


/* Header Section - React style */
.portfolio-header {
    padding: 60px 20px 40px;
    text-align: center;
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
.gallery-item a {
    position: relative;
    display: block;
}

.gallery-item a::after {
    content: "＋";
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    color: white;
    background: rgba(0,0,0,.35);
    opacity: 0;
    transition: opacity .3s ease;
     pointer-events: none;
}

.gallery-item:hover a::after {
    opacity: 1;
}

.portfolio-title {
 font-size: 3.5rem;
    font-weight: 700;   
    margin-bottom: 1rem; 
    background: linear-gradient(
        90deg,
        #2563eb,
        #9333ea,
        #db2777  
    );
    background-size: 300% 300%;
text-align: left;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-transform: capitalize;
    animation: gradient-move 6s ease infinite;
   
}
@keyframes gradient-move {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.portfolio-excerpt {
    font-size: 18px;
    line-height: 1.6;
    color: var(--gray-600);
    max-width: 600px;
    margin: 0 auto;
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
    gap: 60px;
    padding: 60px 20px;
    border-bottom: 1px solid var(--gray-200);
}

.meta-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    background: #fff;
}

.meta-item {
    padding: 24px;
    background: white;
    border-radius: 16px;
    transition: all 0.3s ease;
    border: 1px solid #0000001c;
}

.meta-label {
    font-size: 15px;
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
   border: 1px solid #e5e7eb;
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 300ms ease;
    background: #fff;
}
.meta-actions:hover{
       border-color: #93c5fd;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
.portfolio-single{
    background: #fbfbfb;
}
.portfolio-single img{
    width: 100%;
    height: auto;
    display: block;
}
/* Button styles - React inspired */
.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 16px;
    font-family: inherit;
    line-height: 1;
    padding: 15px 20px;
}

.btn.primary {
    background: linear-gradient(to right, var(--blue-600), var(--blue-500));
    color: white;
    box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
  
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    background: linear-gradient(
        90deg,
        #2563eb,
        #7c3aed  
    );
    transition: all 300ms ease;
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
.project-gallery {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-top: 50px;
}

/* First image full width */
.project-gallery .gallery-item-1 {
    grid-column: 1 / -1;
}

/* Image wrapper */
.gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 14px;
}

/* Images */
.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
}

/* Hover overlay */
.gallery-item::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.15);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
}

/* Hover effects */
.gallery-item:hover img {
    transform: scale(1.08);
}

.gallery-item:hover::after {
    opacity: 1;
}

/* Body Section */
.portfolio-body {
    display: grid;
    grid-template-columns: 1fr 380px;
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
  border: 1px solid #e5e7eb;
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 300ms ease;
    background: #fff;
    margin-top: 50px;
}
.tech-stack-section:hover{
       border-color: #93c5fd;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
    flex-direction: column;
}
.tech-tags svg{
    font-size: 25px;
}
.tech-tag {
  display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 300ms ease;
}

.tech-tag:hover{
     background-color: #f3f4f6;
    transform: scale(1.05);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -2px rgba(0, 0, 0, 0.1);
}
/* Author Box */
.author-box {
    background: white;
    padding: 28px;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    margin-top: 50px;
        transition: all 300ms ease;
}
.author-box:hover{
          border-color: #93c5fd;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04); 

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
      .project-gallery {
        grid-template-columns: 1fr;
    }
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