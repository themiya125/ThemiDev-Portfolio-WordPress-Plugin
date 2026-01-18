<?php
defined('ABSPATH') || exit;

add_action('init', 'themidev_portfolio_register_cpt');

function themidev_portfolio_register_cpt()
{
    register_post_type('themidev_portfolio', [
        'labels' => [
            'name'          => 'Portfolio',
            'singular_name' => 'Project',
        ],
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-portfolio',
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest'  => true,
        'rewrite'       => [
            'slug' => 'portfolio',
            'with_front' => false
        ],
        'has_archive'   => true,
    ]);
}
