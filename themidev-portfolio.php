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

function td_settings_media_assets($hook) {

    if ($hook !== 'portfolio_page_td-portfolio-settings') {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script(
        'td-author-js',
        THEMIDEV_PORTFOLIO_URL . 'assets/author-media.js',
        ['jquery'],
        '1.0',
        true
    );
}




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
