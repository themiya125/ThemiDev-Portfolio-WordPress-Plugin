<?php
/**
 * Plugin Name: ThemiDev Portfolio
 * Description: Portfolio projects manager with Gutenberg blocks.
 * Version: 1.0.0
 * Author: Themiya Jayakodi
 * License: GPL v2 or later
 */

defined( 'ABSPATH' ) || exit;
define('THEMIDEV_PORTFOLIO_URL', plugin_dir_url(__FILE__));
define('THEMIDEV_PORTFOLIO_PATH', plugin_dir_path(__FILE__));


require_once THEMIDEV_PORTFOLIO_PATH . 'includes/meta-fields.php';
require_once THEMIDEV_PORTFOLIO_PATH . 'includes/post-type.php';
require_once THEMIDEV_PORTFOLIO_PATH . 'includes/taxonomies.php';


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

add_action( 'pre_get_posts', function ( $query ) {

    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Portfolio archive
    if ( $query->is_post_type_archive( 'portfolio' ) ) {
        $query->set( 'posts_per_page', 2 );
        return;
    }

    // Portfolio search
    if ( $query->is_search() && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'portfolio' ) {
        $query->set( 'post_type', 'portfolio' );
        $query->set( 'posts_per_page', 2 );
        return;
    }

});
