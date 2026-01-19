<?php
defined('ABSPATH') || exit;

/* =====================================================
 * REGISTER PORTFOLIO META BOXES
 * ===================================================== */

add_action('add_meta_boxes', 'td_register_portfolio_meta_boxes');

function td_register_portfolio_meta_boxes() {

    add_meta_box(
        'td_project_overview',
        'Project Overview',
        'td_project_overview_box',
        'themidev_portfolio',
        'normal',
        'high'
    );

    add_meta_box(
        'td_project_links',
        'Project Links',
        'td_project_links_box',
        'themidev_portfolio',
        'side'
    );

    add_meta_box(
        'td_project_gallery',
        'Project Gallery',
        'td_project_gallery_box',
        'themidev_portfolio',
        'normal'
    );
}

/* =====================================================
 * OVERVIEW
 * ===================================================== */

function td_project_overview_box( $post ) {

    wp_nonce_field( 'td_portfolio_save_meta', 'td_portfolio_nonce' );

    $fields = [
        'client'   => 'Client Name',
        'role'     => 'Role',
        'timeline' => 'Timeline',
    ];

    foreach ( $fields as $key => $label ) {
        $value = get_post_meta( $post->ID, "_td_$key", true );
        ?>
        <p>
            <label><strong><?php echo esc_html( $label ); ?></strong></label><br>
            <input type="text"
                   name="td_<?php echo esc_attr( $key ); ?>"
                   value="<?php echo esc_attr( $value ); ?>"
                   style="width:100%;">
        </p>
        <?php
    }

    $type = get_post_meta( $post->ID, '_td_project_type', true );
    ?>
    <p>
        <label><strong>Project Type</strong></label><br>
        <input type="text"
               name="td_project_type"
               value="<?php echo esc_attr( $type ); ?>"
               style="width:100%;">
    </p>
    <?php
}

/* =====================================================
 * LINKS
 * ===================================================== */

function td_project_links_box( $post ) {

    $live = get_post_meta( $post->ID, '_td_live_url', true );
    $code = get_post_meta( $post->ID, '_td_source_url', true );
    ?>
    <p>
        <label><strong>Live Demo URL</strong></label>
        <input type="url" name="td_live_url" value="<?php echo esc_url( $live ); ?>" style="width:100%;">
    </p>

    <p>
        <label><strong>Source Code URL</strong></label>
        <input type="url" name="td_source_url" value="<?php echo esc_url( $code ); ?>" style="width:100%;">
    </p>
    <?php
}

/* =====================================================
 * GALLERY (5 FIXED IMAGE FIELDS)
 * ===================================================== */

function td_project_gallery_box( $post ) {

    $images = get_post_meta( $post->ID, '_td_gallery_images', true );
    $images = is_array( $images ) ? $images : [];
    ?>

    <?php for ( $i = 1; $i <= 5; $i++ ) :

        $img_id  = $images[$i] ?? '';
        $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
        ?>
        <div style="margin-bottom:12px;">
            <label><strong>Gallery Image <?php echo $i; ?></strong></label><br>

            <input type="hidden"
                   name="td_gallery_images[<?php echo $i; ?>]"
                   value="<?php echo esc_attr( $img_id ); ?>">

            <button type="button" class="button td-image-upload">
                Select Image
            </button>

            <div class="td-image-preview" style="margin-top:6px;">
                <?php if ( $img_url ) : ?>
                    <img src="<?php echo esc_url( $img_url ); ?>" style="width:100px;border-radius:4px;">
                <?php endif; ?>
            </div>
        </div>
    <?php endfor; ?>
    <?php
}

/* =====================================================
 * SAVE META
 * ===================================================== */

add_action('save_post_themidev_portfolio', 'td_save_portfolio_meta');

function td_save_portfolio_meta( $post_id ) {

    if (
        ! isset( $_POST['td_portfolio_nonce'] ) ||
        ! wp_verify_nonce( $_POST['td_portfolio_nonce'], 'td_portfolio_save_meta' )
    ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    foreach ( ['client', 'role', 'timeline', 'project_type'] as $field ) {
        if ( isset( $_POST["td_$field"] ) ) {
            update_post_meta(
                $post_id,
                "_td_$field",
                sanitize_text_field( $_POST["td_$field"] )
            );
        }
    }

    foreach ( ['live_url', 'source_url'] as $field ) {
        if ( isset( $_POST["td_$field"] ) ) {
            update_post_meta(
                $post_id,
                "_td_$field",
                esc_url_raw( $_POST["td_$field"] )
            );
        }
    }

    // ✅ SAVE GALLERY IMAGES (THIS WAS MISSING)
    if ( isset( $_POST['td_gallery_images'] ) && is_array( $_POST['td_gallery_images'] ) ) {
        $images = array_map( 'absint', $_POST['td_gallery_images'] );
        $images = array_filter( $images );
        update_post_meta( $post_id, '_td_gallery_images', $images );
    }
}

/* =====================================================
 * GALLERY MEDIA
 * ===================================================== */

add_action('admin_enqueue_scripts', 'td_gallery_media_assets');

function td_gallery_media_assets( $hook ) {

    if ( ! in_array( $hook, ['post.php', 'post-new.php'], true ) ) return;

    $screen = get_current_screen();
    if ( ! $screen || $screen->post_type !== 'themidev_portfolio' ) return;

    wp_enqueue_media();

    wp_enqueue_script(
        'td-gallery-js',
        THEMIDEV_PORTFOLIO_URL . 'assets/gallery.js',
        ['jquery'],
        '1.0',
        true
    );
}
