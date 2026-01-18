<?php 

add_action( 'init', function () {
    register_taxonomy( 'portfolio_tech', 'themidev_portfolio', [
        'label' => 'Tech Stack',
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
    ]);
});
