<?php
/**
 * Plugin Name: ThemiDev Portfolio
 * Description: Portfolio projects manager 
 * Version: 1.1.6
 * Author: Themiya Jayakodi
 * License: GPL v2 or later
 * Author URI: https://themidev.com/
 */

defined( 'ABSPATH' ) || exit;
define('THEMIDEV_PORTFOLIO_URL', plugin_dir_url(__FILE__));
define('THEMIDEV_PORTFOLIO_PATH', plugin_dir_path(__FILE__));


require_once THEMIDEV_PORTFOLIO_PATH . 'includes/meta-fields.php';
require_once THEMIDEV_PORTFOLIO_PATH . 'includes/post-type.php';
require_once THEMIDEV_PORTFOLIO_PATH . 'includes/taxonomies.php';
require_once THEMIDEV_PORTFOLIO_PATH . 'includes/schema.php';
require_once THEMIDEV_PORTFOLIO_PATH . 'includes/short-code.php';


add_action( 'init', function () {
    register_block_type( __DIR__ . '/build/portfolio-grid' );
    register_block_type( __DIR__ . '/build/portfolio-single' );
});
add_filter( 'template_include', 'themidev_portfolio_template_loader' );


function themidev_portfolio_template_loader( $template ) {

    if ( is_singular( 'themidev_portfolio' ) ) {

        // 1. Check if theme has override -> this file can create on theme if need override plugin templates
        $theme_template = locate_template( 'single-themidev_portfolio.php' );
        if ( $theme_template ) {
            return $theme_template;
        }

        // 2. Fallback to plugin template
        return plugin_dir_path( __FILE__ ) . 'templates/single-portfolio.php';
    }

    if ( is_post_type_archive( 'themidev_portfolio' ) ) {

        $theme_template = locate_template( 'archive-themidev_portfolio.php' );
        if ( $theme_template ) {
            return $theme_template;
        }

        return plugin_dir_path( __FILE__ ) . 'templates/archive-portfolio.php';
    }

    return $template;
}

add_action( 'portfolio_tech_add_form_fields', function () {
    ?>
    <div class="form-field">
        <label for="tech_svg">Tech SVG Icon</label>
        <textarea name="tech_svg" id="tech_svg" rows="5" placeholder="Paste SVG code here"></textarea>
        <p class="description">Paste full SVG markup</p>
    </div>

    <div class="form-field">
        <label for="tech_class">CSS Class Name</label>
        <input type="text" name="tech_class" id="tech_class" placeholder="e.g. text-black text-xl">
        <p class="description">Optional CSS class for the icon</p>
    </div>
    <?php
});
add_action( 'portfolio_tech_edit_form_fields', function ( $term ) {

    $svg   = get_term_meta( $term->term_id, 'tech_svg', true );
    $class = get_term_meta( $term->term_id, 'tech_class', true );
    ?>
    <tr class="form-field">
        <th scope="row">
            <label for="tech_svg">Tech SVG Icon</label>
        </th>
        <td>
            <textarea name="tech_svg" id="tech_svg" rows="5"><?php echo esc_textarea( $svg ); ?></textarea>
            <p class="description">Paste full SVG markup</p>
        </td>
    </tr>

    <tr class="form-field">
        <th scope="row">
            <label for="tech_class">CSS Class Name</label>
        </th>
        <td>
            <input
                type="text"
                name="tech_class"
                id="tech_class"
                value="<?php echo esc_attr( $class ); ?>"
                placeholder="e.g. text-black text-xl"
            >
            <p class="description">Optional CSS class for styling the icon</p>
        </td>
    </tr>
    <?php
});
add_action( 'created_portfolio_tech', 'td_save_tech_meta' );
add_action( 'edited_portfolio_tech', 'td_save_tech_meta' );

function td_save_tech_meta( $term_id ) {

    if ( isset( $_POST['tech_svg'] ) ) {
        update_term_meta(
            $term_id,
            'tech_svg',
            $_POST['tech_svg']
        );
    }

    if ( isset( $_POST['tech_class'] ) ) {
        update_term_meta(
            $term_id,
            'tech_class',
            sanitize_text_field( $_POST['tech_class'] )
        );
    }
}

//fancy box for gallery images
add_action( 'wp_enqueue_scripts', 'td_enqueue_fancybox' );

function td_enqueue_fancybox() {

    // Fancybox CSS
    wp_enqueue_style(
        'fancybox-css',
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css',
        [],
        '5.0'
    );

    // Fancybox JS
    wp_enqueue_script(
        'fancybox-js',
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js',
        [],
        '5.0',
        true
    );
}

add_action( 'wp_footer', 'td_init_fancybox', 99 );

function td_init_fancybox() {
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        if ( typeof Fancybox !== "undefined" ) {
            Fancybox.bind('[data-fancybox]', {
                Thumbs: false,
                Toolbar: {
                    display: ["close"]
                }
            });
        }
    });
    </script>
    <?php
}

//pagination
add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'themidev_portfolio' ) ) {
        $query->set( 'posts_per_page', 6 );
    }
});

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'owl-carousel',
        plugin_dir_url(__FILE__) . 'assets/owl/owl.carousel.min.css'
    );

    wp_enqueue_style(
        'owl-theme',
        plugin_dir_url(__FILE__) . 'assets/owl/owl.theme.default.min.css'
    );

    wp_enqueue_script(
        'owl-carousel',
        plugin_dir_url(__FILE__) . 'assets/owl/owl.carousel.min.js',
        ['jquery'],
        null,
        true
    );

    wp_enqueue_script(
        'featured-projects',
        plugin_dir_url(__FILE__) . 'assets/featured-projects.js',
        ['jquery', 'owl-carousel'],
        null,
        true
    );
});


require plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$wabUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/themiya125/ThemiDev-Portfolio-WordPress-Plugin', 
    __FILE__,
    'themidev-portfolio'
);
$wabUpdateChecker->setBranch('main');
