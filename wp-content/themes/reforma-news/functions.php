<?php
defined('ABSPATH') || exit;

/* ------------------------------------------------------------------ */
/*  SETUP                                                               */
/* ------------------------------------------------------------------ */
function reformtax_setup() {
    load_theme_textdomain('reformtax', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('automatic-feed-links');
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    add_image_size('rfx-hero',  900, 500, true);
    add_image_size('rfx-card',  560, 315, true);
    add_image_size('rfx-thumb', 220, 155, true);
    add_image_size('rfx-mini',  130,  95, true);

    register_nav_menus([
        'primary' => 'Menu Principal',
        'footer'  => 'Menu Rodapé',
    ]);
}
add_action('after_setup_theme', 'reformtax_setup');

/* ------------------------------------------------------------------ */
/*  ENQUEUE                                                             */
/* ------------------------------------------------------------------ */
function reformtax_scripts() {
    wp_enqueue_style('reformtax-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&family=Playfair+Display:wght@700;900&display=swap',
        [], null
    );
    wp_enqueue_style('fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        [], '6.5.0'
    );
    wp_enqueue_style('reformtax-style', get_stylesheet_uri(), ['reformtax-fonts','fontawesome'], '2.0.0');

    wp_enqueue_script('reformtax-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [], '2.0.0', true
    );

    if (is_singular() && comments_open()) {
        wp_enqueue_script('comment-reply');
    }

    wp_localize_script('reformtax-main', 'rfxData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('rfx_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'reformtax_scripts');

/* ------------------------------------------------------------------ */
/*  SIDEBARS                                                            */
/* ------------------------------------------------------------------ */
function reformtax_widgets() {
    $cfg = [
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div><div class="widget-body">',
    ];
    register_sidebar(array_merge($cfg, ['name' => 'Sidebar Principal', 'id' => 'sidebar-main']));
    register_sidebar(array_merge($cfg, ['name' => 'Sidebar Artigo',    'id' => 'sidebar-single']));
    register_sidebar(array_merge($cfg, ['name' => 'Footer Col 2',      'id' => 'footer-2']));
    register_sidebar(array_merge($cfg, ['name' => 'Footer Col 3',      'id' => 'footer-3']));
    register_sidebar(array_merge($cfg, ['name' => 'Footer Col 4',      'id' => 'footer-4']));
}
add_action('widgets_init', 'reformtax_widgets');

/* ------------------------------------------------------------------ */
/*  EXCERPT                                                             */
/* ------------------------------------------------------------------ */
add_filter('excerpt_length', fn() => 22);
add_filter('excerpt_more',   fn() => '&hellip;');

/* ------------------------------------------------------------------ */
/*  HELPERS                                                             */
/* ------------------------------------------------------------------ */
function rfx_cat_color_class($cat_id) {
    $saved = get_term_meta($cat_id, '_reforma_cat_color', true);
    if ($saved) {
        $map = [
            '#0b0b1a' => 'tag-navy',
            '#c8a84b' => 'tag-gold',
            '#555555' => 'tag-gray',
        ];
        return $map[$saved] ?? '';
    }
    // Cycle through a palette based on ID
    $classes = ['', 'tag-gold', 'tag-gray', 'tag-navy', '', 'tag-gold'];
    return $classes[$cat_id % count($classes)];
}

function rfx_the_tag($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $cats = get_the_category($post_id);
    if (!$cats) return;
    $cat   = $cats[0];
    $class = rfx_cat_color_class($cat->term_id);
    printf(
        '<a href="%s" class="tag %s">%s</a>',
        esc_url(get_category_link($cat->term_id)),
        esc_attr($class),
        esc_html($cat->name)
    );
}

function rfx_the_meta($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    printf(
        '<span><i class="fa-regular fa-clock"></i> %s</span><span>·</span><span class="author"><i class="fa-regular fa-user"></i> %s</span>',
        esc_html(get_the_date('d/m/Y', $post_id)),
        esc_html(get_the_author_meta('display_name', get_post_field('post_author', $post_id)))
    );
}

function rfx_share_buttons() {
    $url   = urlencode(get_the_permalink());
    $title = urlencode(get_the_title());
    ?>
    <div class="share-bar">
        <span><i class="fa-solid fa-share-nodes"></i> Compartilhar:</span>
        <a class="share-btn whatsapp" target="_blank" rel="noopener"
           href="https://wa.me/?text=<?php echo $title; ?>%20<?php echo $url; ?>">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp
        </a>
        <a class="share-btn facebook" target="_blank" rel="noopener"
           href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>">
            <i class="fa-brands fa-facebook-f"></i> Facebook
        </a>
        <a class="share-btn twitter" target="_blank" rel="noopener"
           href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>">
            <i class="fa-brands fa-x-twitter"></i> X
        </a>
        <a class="share-btn linkedin" target="_blank" rel="noopener"
           href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $url; ?>">
            <i class="fa-brands fa-linkedin-in"></i> LinkedIn
        </a>
    </div>
    <?php
}

/* ------------------------------------------------------------------ */
/*  WALKER MENU                                                         */
/* ------------------------------------------------------------------ */
class Reformtax_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }
}

/* ------------------------------------------------------------------ */
/*  CUSTOMIZER                                                          */
/* ------------------------------------------------------------------ */
function reformtax_customizer($wp_customize) {
    $wp_customize->add_section('reformtax_opts', [
        'title'    => 'Reformtax — Configurações',
        'priority' => 30,
    ]);

    $fields = [
        'reforma_breaking_news'      => 'Últimas notícias (texto da barra)',
        'reforma_breaking_news_link' => 'Últimas notícias (link)',
        'reforma_footer_text'        => 'Texto do rodapé',
        'reforma_linkedin'           => 'LinkedIn (URL)',
        'reforma_instagram'          => 'Instagram (URL)',
        'reforma_twitter'            => 'X / Twitter (URL)',
        'reforma_youtube'            => 'YouTube (URL)',
        'reforma_spotify'            => 'Spotify (URL)',
        'reforma_whatsapp'           => 'WhatsApp (número com DDI)',
    ];
    foreach ($fields as $id => $label) {
        $wp_customize->add_setting($id, ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($id, ['label' => $label, 'section' => 'reformtax_opts', 'type' => 'text']);
    }
}
add_action('customize_register', 'reformtax_customizer');

/* ------------------------------------------------------------------ */
/*  AJAX NEWSLETTER                                                     */
/* ------------------------------------------------------------------ */
function rfx_newsletter() {
    check_ajax_referer('rfx_nonce', 'nonce');
    $email = sanitize_email($_POST['email'] ?? '');
    if (!is_email($email)) {
        wp_send_json_error(['msg' => 'E-mail inválido.']);
    }
    $list = get_option('rfx_newsletter_subscribers', []);
    if (in_array($email, $list)) {
        wp_send_json_error(['msg' => 'E-mail já cadastrado!']);
    }
    $list[] = $email;
    update_option('rfx_newsletter_subscribers', $list);
    wp_send_json_success(['msg' => 'Inscrição realizada com sucesso!']);
}
add_action('wp_ajax_rfx_newsletter',        'rfx_newsletter');
add_action('wp_ajax_nopriv_rfx_newsletter', 'rfx_newsletter');

/* ------------------------------------------------------------------ */
/*  POSTS PER PAGE                                                      */
/* ------------------------------------------------------------------ */
add_action('pre_get_posts', function($q) {
    if (!is_admin() && $q->is_main_query() && (is_category() || is_tag() || is_archive())) {
        $q->set('posts_per_page', 12);
    }
});
