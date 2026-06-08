<?php
/**
 * Plugin Name: Reformtax Manager
 * Plugin URI:  https://reformtax.com.br
 * Description: Painel para publicar e gerenciar noticias e categorias do portal Reformtax.
 * Version:     2.0.0
 * Author:      Reformtax
 * Text Domain: reformtax-manager
 * License:     GPL v2 or later
 */

defined('ABSPATH') || exit;

define('RNM_VERSION', '1.0.0');
define('RNM_PATH',    plugin_dir_path(__FILE__));
define('RNM_URL',     plugin_dir_url(__FILE__));

/* ================================================================== */
/*  ADMIN MENU                                                          */
/* ================================================================== */
add_action('admin_menu', function () {
    add_menu_page(
        'Reforma News',
        'Reforma News',
        'edit_posts',
        'reforma-news',
        'rnm_dashboard_page',
        'dashicons-megaphone',
        3
    );

    add_submenu_page(
        'reforma-news',
        'Dashboard',
        'Dashboard',
        'edit_posts',
        'reforma-news',
        'rnm_dashboard_page'
    );

    add_submenu_page(
        'reforma-news',
        'Nova NotÃ­cia',
        '+ Nova NotÃ­cia',
        'edit_posts',
        'reforma-news-new',
        'rnm_new_post_page'
    );

    add_submenu_page(
        'reforma-news',
        'Gerenciar NotÃ­cias',
        'Todas as NotÃ­cias',
        'edit_posts',
        'reforma-news-list',
        'rnm_list_posts_page'
    );

    add_submenu_page(
        'reforma-news',
        'Categorias',
        'Categorias',
        'manage_categories',
        'reforma-news-cats',
        'rnm_categories_page'
    );

    add_submenu_page(
        'reforma-news',
        'ConfiguraÃ§Ãµes',
        'ConfiguraÃ§Ãµes',
        'manage_options',
        'reforma-news-settings',
        'rnm_settings_page'
    );

    add_submenu_page(
        'reforma-news',
        'Newsletter',
        'Newsletter',
        'manage_options',
        'reforma-news-newsletter',
        'rnm_newsletter_page'
    );
});

/* ================================================================== */
/*  ADMIN STYLES                                                        */
/* ================================================================== */
add_action('admin_enqueue_scripts', function ($hook) {
    if (strpos($hook, 'reforma-news') === false) return;

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_media();

    wp_add_inline_style('wp-admin', '
        .rnm-wrap { max-width:1100px; }
        .rnm-wrap h1 { display:flex;align-items:center;gap:10px;color:#1a1a2e;font-size:22px; }
        .rnm-cards { display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin:24px 0; }
        .rnm-card { background:#fff;border-radius:10px;padding:22px 20px;box-shadow:0 1px 4px rgba(0,0,0,.1);border-left:4px solid #003580; }
        .rnm-card.accent { border-color:#E8301B; }
        .rnm-card.green  { border-color:#0a7a3e; }
        .rnm-card.purple { border-color:#6d28d9; }
        .rnm-card-num { font-size:32px;font-weight:800;color:#1a1a2e;line-height:1; }
        .rnm-card-label { font-size:13px;color:#666;margin-top:4px; }
        .rnm-card-link { display:inline-block;margin-top:12px;font-size:12.5px;color:#003580;font-weight:600; }
        .rnm-box { background:#fff;border-radius:10px;padding:24px;box-shadow:0 1px 4px rgba(0,0,0,.1);margin-bottom:24px; }
        .rnm-box h2 { font-size:16px;font-weight:700;margin:0 0 16px;padding-bottom:10px;border-bottom:2px solid #f0f0f0;display:flex;align-items:center;gap:8px; }
        .rnm-box h2 .dashicons { color:#003580; }
        .rnm-form-grid { display:grid;grid-template-columns:2fr 1fr;gap:24px; }
        .rnm-field { margin-bottom:18px; }
        .rnm-field label { display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#333; }
        .rnm-field input[type=text],.rnm-field input[type=url],.rnm-field select,.rnm-field textarea {
            width:100%;padding:9px 12px;border:1px solid #ddd;border-radius:6px;font-size:14px;
            transition:border .2s; outline:none; }
        .rnm-field input:focus,.rnm-field select:focus,.rnm-field textarea:focus { border-color:#003580;box-shadow:0 0 0 2px rgba(0,53,128,.12); }
        .rnm-field textarea { min-height:180px;resize:vertical;line-height:1.65; }
        .rnm-field .desc { font-size:12px;color:#888;margin-top:4px; }
        .rnm-btn { padding:10px 22px;border-radius:6px;font-size:14px;font-weight:600;cursor:pointer;border:none;transition:all .2s; }
        .rnm-btn-primary { background:#003580;color:#fff; }
        .rnm-btn-primary:hover { background:#002060; }
        .rnm-btn-danger { background:#E8301B;color:#fff; }
        .rnm-btn-danger:hover { background:#c0210f; }
        .rnm-btn-secondary { background:#f0f0f0;color:#333;border:1px solid #ddd; }
        .rnm-btn-secondary:hover { background:#e5e5e5; }
        .rnm-table { width:100%;border-collapse:collapse; }
        .rnm-table th { text-align:left;padding:10px 14px;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;background:#f8f9fc;color:#555;border-bottom:2px solid #e5e7eb; }
        .rnm-table td { padding:12px 14px;border-bottom:1px solid #f0f0f0;vertical-align:middle;font-size:13.5px; }
        .rnm-table tr:hover td { background:#fafbfc; }
        .rnm-table td img { width:60px;height:42px;object-fit:cover;border-radius:4px; }
        .rnm-badge { display:inline-block;padding:2px 9px;border-radius:4px;font-size:11px;font-weight:700;text-transform:uppercase; }
        .rnm-badge-publish { background:#dcfce7;color:#15803d; }
        .rnm-badge-draft   { background:#fef9c3;color:#b45309; }
        .rnm-badge-trash   { background:#fee2e2;color:#b91c1c; }
        .rnm-thumb-preview { width:200px;height:120px;object-fit:cover;border-radius:6px;margin-top:8px;border:1px solid #ddd; display:none; }
        .rnm-notice { padding:12px 16px;border-radius:6px;margin-bottom:18px;font-size:14px; }
        .rnm-notice-success { background:#dcfce7;color:#15803d;border:1px solid #bbf7d0; }
        .rnm-notice-error   { background:#fee2e2;color:#b91c1c;border:1px solid #fecaca; }
        .rnm-search-bar { display:flex;gap:10px;margin-bottom:18px;align-items:center; }
        .rnm-search-bar input { flex:1;max-width:360px;padding:8px 12px;border:1px solid #ddd;border-radius:6px;font-size:14px; }
        .rnm-pagination { margin-top:16px;display:flex;gap:6px;align-items:center; }
        .rnm-pagination a,.rnm-pagination span {
            display:inline-flex;align-items:center;justify-content:center;
            min-width:32px;height:32px;padding:0 8px;
            border-radius:5px;border:1px solid #ddd;background:#fff;
            font-size:13px;text-decoration:none;color:#333; }
        .rnm-pagination .current,.rnm-pagination a:hover { background:#003580;color:#fff;border-color:#003580; }
        .rnm-color-dot { display:inline-block;width:12px;height:12px;border-radius:50%;margin-right:6px;vertical-align:middle; }
        @media (max-width:900px) {
            .rnm-cards { grid-template-columns:repeat(2,1fr); }
            .rnm-form-grid { grid-template-columns:1fr; }
        }
    ');

    wp_add_inline_script('wp-color-picker', '
        jQuery(function($){
            $(".rnm-color-pick").wpColorPicker();
        });
    ');
});

/* ================================================================== */
/*  HELPERS                                                             */
/* ================================================================== */
function rnm_notice($msg, $type = 'success') {
    echo '<div class="rnm-notice rnm-notice-' . esc_attr($type) . '">' . esc_html($msg) . '</div>';
}

function rnm_get_category_color($cat_id) {
    return get_term_meta($cat_id, '_reforma_cat_color', true) ?: '#003580';
}

function rnm_color_class_from_hex($hex) {
    $map = [
        '#003580' => 'tag-blue',
        '#0a7a3e' => 'tag-green',
        '#d9640a' => 'tag-orange',
        '#6d28d9' => 'tag-purple',
        '#0891b2' => 'tag-teal',
        '#E8301B' => '',
        '#e8301b' => '',
    ];
    return $map[strtolower($hex)] ?? '';
}

/* ================================================================== */
/*  1. DASHBOARD                                                        */
/* ================================================================== */
function rnm_dashboard_page() {
    $total_posts   = wp_count_posts('post');
    $published     = $total_posts->publish ?? 0;
    $drafts        = $total_posts->draft   ?? 0;
    $total_cats    = wp_count_terms('category', ['hide_empty' => false]);
    $subscribers   = count(get_option('reforma_newsletter_subscribers', []));

    $recent = get_posts(['numberposts' => 8, 'post_status' => ['publish','draft']]);
    ?>
    <div class="wrap rnm-wrap">
        <h1><span class="dashicons dashicons-megaphone"></span> Reforma News â€” Painel</h1>

        <div class="rnm-cards">
            <div class="rnm-card">
                <div class="rnm-card-num"><?php echo esc_html($published); ?></div>
                <div class="rnm-card-label">NotÃ­cias publicadas</div>
                <a class="rnm-card-link" href="<?php echo admin_url('admin.php?page=reforma-news-list'); ?>">Ver todas â†’</a>
            </div>
            <div class="rnm-card accent">
                <div class="rnm-card-num"><?php echo esc_html($drafts); ?></div>
                <div class="rnm-card-label">Rascunhos</div>
                <a class="rnm-card-link" href="<?php echo admin_url('admin.php?page=reforma-news-new'); ?>">Nova notÃ­cia â†’</a>
            </div>
            <div class="rnm-card green">
                <div class="rnm-card-num"><?php echo esc_html($total_cats); ?></div>
                <div class="rnm-card-label">Categorias</div>
                <a class="rnm-card-link" href="<?php echo admin_url('admin.php?page=reforma-news-cats'); ?>">Gerenciar â†’</a>
            </div>
            <div class="rnm-card purple">
                <div class="rnm-card-num"><?php echo esc_html($subscribers); ?></div>
                <div class="rnm-card-label">Inscritos na newsletter</div>
                <a class="rnm-card-link" href="<?php echo admin_url('admin.php?page=reforma-news-newsletter'); ?>">Ver lista â†’</a>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;">
            <!-- Recent posts -->
            <div class="rnm-box">
                <h2><span class="dashicons dashicons-list-view"></span> NotÃ­cias Recentes</h2>
                <table class="rnm-table">
                    <thead>
                        <tr>
                            <th>TÃ­tulo</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>AÃ§Ãµes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent as $p) :
                            $cats = get_the_category($p->ID);
                            $cat_name = $cats ? $cats[0]->name : 'â€”';
                        ?>
                        <tr>
                            <td>
                                <strong><?php echo esc_html(wp_trim_words($p->post_title, 8)); ?></strong>
                            </td>
                            <td><?php echo esc_html($cat_name); ?></td>
                            <td>
                                <span class="rnm-badge rnm-badge-<?php echo esc_attr($p->post_status); ?>">
                                    <?php echo $p->post_status === 'publish' ? 'Publicado' : 'Rascunho'; ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(get_the_date('d/m/Y', $p)); ?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=reforma-news-new&edit=' . $p->ID); ?>" style="color:#003580;font-size:13px;margin-right:8px;">Editar</a>
                                <a href="<?php echo esc_url(get_permalink($p)); ?>" target="_blank" style="color:#666;font-size:13px;">Ver</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Quick links -->
            <div>
                <div class="rnm-box">
                    <h2><span class="dashicons dashicons-plus-alt2"></span> AÃ§Ãµes RÃ¡pidas</h2>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <a href="<?php echo admin_url('admin.php?page=reforma-news-new'); ?>" class="rnm-btn rnm-btn-primary" style="text-align:center;display:block;text-decoration:none;">
                            <span class="dashicons dashicons-plus" style="vertical-align:middle;"></span> Nova NotÃ­cia
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=reforma-news-cats'); ?>" class="rnm-btn rnm-btn-secondary" style="text-align:center;display:block;text-decoration:none;">
                            <span class="dashicons dashicons-category" style="vertical-align:middle;"></span> Nova Categoria
                        </a>
                        <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" class="rnm-btn rnm-btn-secondary" style="text-align:center;display:block;text-decoration:none;">
                            <span class="dashicons dashicons-external" style="vertical-align:middle;"></span> Ver Site
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=reforma-news-settings'); ?>" class="rnm-btn rnm-btn-secondary" style="text-align:center;display:block;text-decoration:none;">
                            <span class="dashicons dashicons-admin-settings" style="vertical-align:middle;"></span> ConfiguraÃ§Ãµes
                        </a>
                    </div>
                </div>

                <div class="rnm-box">
                    <h2><span class="dashicons dashicons-category"></span> Categorias</h2>
                    <?php
                    $cats = get_categories(['hide_empty' => false, 'orderby' => 'count', 'order' => 'DESC']);
                    if ($cats) :
                    ?>
                    <ul style="margin:0;padding:0;list-style:none;">
                        <?php foreach ($cats as $cat) :
                            $color = rnm_get_category_color($cat->term_id);
                        ?>
                        <li style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid #f0f0f0;font-size:13.5px;">
                            <span>
                                <span class="rnm-color-dot" style="background:<?php echo esc_attr($color); ?>"></span>
                                <?php echo esc_html($cat->name); ?>
                            </span>
                            <strong><?php echo esc_html($cat->count); ?></strong>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else : ?>
                    <p style="color:#888;font-size:13px;">Nenhuma categoria criada ainda.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/* ================================================================== */
/*  2. NOVA NOTÃCIA / EDITAR                                            */
/* ================================================================== */
function rnm_new_post_page() {
    $edit_id  = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
    $post_obj = $edit_id ? get_post($edit_id) : null;
    $notice   = '';

    // --- Handle form submission ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rnm_save_post'])) {
        check_admin_referer('rnm_save_post');

        $pid    = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;
        $title  = sanitize_text_field($_POST['post_title'] ?? '');
        $content= wp_kses_post($_POST['post_content'] ?? '');
        $excerpt= sanitize_textarea_field($_POST['post_excerpt'] ?? '');
        $status = in_array($_POST['post_status'] ?? '', ['publish','draft']) ? $_POST['post_status'] : 'draft';
        $cat_id = (int) ($_POST['post_category'] ?? 0);
        $thumb  = (int) ($_POST['post_thumbnail_id'] ?? 0);
        $tags   = sanitize_text_field($_POST['post_tags'] ?? '');

        if (!$title) {
            $notice = ['error', 'O tÃ­tulo Ã© obrigatÃ³rio.'];
        } else {
            $data = [
                'post_title'   => $title,
                'post_content' => $content,
                'post_excerpt' => $excerpt,
                'post_status'  => $status,
                'post_type'    => 'post',
            ];

            if ($pid) {
                $data['ID'] = $pid;
                wp_update_post($data);
                $new_id = $pid;
            } else {
                $new_id = wp_insert_post($data);
            }

            if ($new_id && !is_wp_error($new_id)) {
                if ($cat_id) wp_set_post_categories($new_id, [$cat_id]);
                if ($thumb)  set_post_thumbnail($new_id, $thumb);
                if ($tags)   wp_set_post_tags($new_id, $tags);

                $notice = ['success', $pid ? 'NotÃ­cia atualizada com sucesso!' : 'NotÃ­cia publicada com sucesso!'];
                $post_obj = get_post($new_id);
                $edit_id  = $new_id;
                // Redirect to edit page
                wp_redirect(admin_url('admin.php?page=reforma-news-new&edit=' . $new_id . '&saved=1'));
                exit;
            } else {
                $notice = ['error', 'Erro ao salvar. Tente novamente.'];
            }
        }
    }

    if (isset($_GET['saved'])) {
        $notice = ['success', 'NotÃ­cia salva com sucesso!'];
        $post_obj = $edit_id ? get_post($edit_id) : $post_obj;
    }

    // --- Delete ---
    if (isset($_GET['delete']) && wp_verify_nonce($_GET['_wpnonce'] ?? '', 'rnm_delete_post_' . $_GET['delete'])) {
        wp_trash_post((int) $_GET['delete']);
        wp_redirect(admin_url('admin.php?page=reforma-news-list&deleted=1'));
        exit;
    }

    $cats          = get_categories(['hide_empty' => false]);
    $current_cats  = $post_obj ? wp_get_post_categories($post_obj->ID) : [];
    $current_thumb = $post_obj ? get_post_thumbnail_id($post_obj->ID) : 0;
    $current_tags  = $post_obj ? implode(', ', wp_get_post_tags($post_obj->ID, ['fields' => 'names'])) : '';
    ?>
    <div class="wrap rnm-wrap">
        <h1>
            <span class="dashicons dashicons-edit"></span>
            <?php echo $edit_id ? 'Editar NotÃ­cia' : 'Nova NotÃ­cia'; ?>
            <?php if ($edit_id) : ?>
                <a href="<?php echo esc_url(get_permalink($edit_id)); ?>" target="_blank" class="rnm-btn rnm-btn-secondary" style="margin-left:12px;font-size:13px;text-decoration:none;">
                    <span class="dashicons dashicons-external" style="vertical-align:middle;font-size:16px;"></span> Ver no site
                </a>
                <a href="<?php echo admin_url('admin.php?page=reforma-news-new'); ?>" class="rnm-btn rnm-btn-secondary" style="margin-left:6px;font-size:13px;text-decoration:none;">
                    + Nova notÃ­cia
                </a>
            <?php endif; ?>
        </h1>

        <?php if ($notice) rnm_notice($notice[1], $notice[0]); ?>

        <form method="post" id="rnm-post-form">
            <?php wp_nonce_field('rnm_save_post'); ?>
            <input type="hidden" name="post_id" value="<?php echo esc_attr($edit_id); ?>">

            <div class="rnm-form-grid">
                <!-- Main content -->
                <div>
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-media-text"></span> ConteÃºdo</h2>
                        <div class="rnm-field">
                            <label for="post_title">TÃ­tulo da NotÃ­cia *</label>
                            <input type="text" id="post_title" name="post_title"
                                value="<?php echo esc_attr($post_obj ? $post_obj->post_title : ''); ?>"
                                placeholder="Digite o tÃ­tulo completo da notÃ­cia..." required>
                        </div>
                        <div class="rnm-field">
                            <label for="post_excerpt">SubtÃ­tulo / Resumo</label>
                            <textarea id="post_excerpt" name="post_excerpt" rows="3"
                                placeholder="Breve descriÃ§Ã£o que aparece nos cards e no inÃ­cio do artigo..."><?php echo esc_textarea($post_obj ? $post_obj->post_excerpt : ''); ?></textarea>
                        </div>
                        <div class="rnm-field">
                            <label for="post_content">ConteÃºdo Completo</label>
                            <?php
                            wp_editor(
                                $post_obj ? $post_obj->post_content : '',
                                'post_content',
                                [
                                    'textarea_name' => 'post_content',
                                    'media_buttons' => true,
                                    'textarea_rows' => 18,
                                    'teeny'         => false,
                                ]
                            );
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar options -->
                <div>
                    <!-- Publish box -->
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-upload"></span> PublicaÃ§Ã£o</h2>
                        <div class="rnm-field">
                            <label for="post_status">Status</label>
                            <select id="post_status" name="post_status">
                                <option value="publish" <?php selected($post_obj ? $post_obj->post_status : 'draft', 'publish'); ?>>âœ… Publicado</option>
                                <option value="draft"   <?php selected($post_obj ? $post_obj->post_status : 'draft', 'draft'); ?>>ðŸ• Rascunho</option>
                            </select>
                        </div>
                        <div style="display:flex;gap:10px;margin-top:6px;">
                            <button type="submit" name="rnm_save_post" class="rnm-btn rnm-btn-primary" style="flex:1;">
                                <span class="dashicons dashicons-saved" style="vertical-align:middle;"></span>
                                <?php echo $edit_id ? 'Atualizar' : 'Publicar'; ?>
                            </button>
                            <?php if ($edit_id) : ?>
                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=reforma-news-new&delete=' . $edit_id), 'rnm_delete_post_' . $edit_id); ?>"
                               class="rnm-btn rnm-btn-danger"
                               onclick="return confirm('Mover para lixeira?');"
                               style="text-decoration:none;">
                                <span class="dashicons dashicons-trash" style="vertical-align:middle;"></span>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-category"></span> Categoria</h2>
                        <div class="rnm-field">
                            <select name="post_category" id="post_category" style="width:100%;">
                                <option value="">â€” Selecione â€”</option>
                                <?php foreach ($cats as $cat) : ?>
                                    <option value="<?php echo esc_attr($cat->term_id); ?>"
                                        <?php selected(in_array($cat->term_id, $current_cats)); ?>>
                                        <?php echo esc_html($cat->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <a href="<?php echo admin_url('admin.php?page=reforma-news-cats'); ?>" style="font-size:12.5px;color:#003580;">
                            + Nova categoria
                        </a>
                    </div>

                    <!-- Featured Image -->
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-format-image"></span> Imagem Destaque</h2>
                        <input type="hidden" id="post_thumbnail_id" name="post_thumbnail_id" value="<?php echo esc_attr($current_thumb); ?>">
                        <?php
                        $thumb_url = $current_thumb ? wp_get_attachment_image_url($current_thumb, 'medium') : '';
                        ?>
                        <img id="rnm-thumb-preview" class="rnm-thumb-preview"
                             src="<?php echo esc_attr($thumb_url); ?>"
                             style="<?php echo $thumb_url ? 'display:block;' : ''; ?>">
                        <div style="display:flex;gap:8px;margin-top:10px;">
                            <button type="button" id="rnm-set-thumb" class="rnm-btn rnm-btn-secondary">
                                <span class="dashicons dashicons-upload" style="vertical-align:middle;"></span>
                                <?php echo $current_thumb ? 'Trocar imagem' : 'Escolher imagem'; ?>
                            </button>
                            <?php if ($current_thumb) : ?>
                            <button type="button" id="rnm-remove-thumb" class="rnm-btn rnm-btn-danger">
                                <span class="dashicons dashicons-trash" style="vertical-align:middle;"></span>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-tag"></span> Tags</h2>
                        <div class="rnm-field">
                            <input type="text" name="post_tags" id="post_tags"
                                value="<?php echo esc_attr($current_tags); ?>"
                                placeholder="reforma, cbs, iva, split payment...">
                            <span class="desc">Separe as tags por vÃ­rgulas</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
    jQuery(function($){
        var frame;
        $('#rnm-set-thumb').on('click', function(e){
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Escolher Imagem Destaque', button: { text: 'Usar esta imagem' }, multiple: false });
            frame.on('select', function(){
                var att = frame.state().get('selection').first().toJSON();
                $('#post_thumbnail_id').val(att.id);
                var preview = $('#rnm-thumb-preview');
                preview.attr('src', att.url).show();
                preview.css('display','block');
                $('#rnm-set-thumb').html('<span class="dashicons dashicons-upload" style="vertical-align:middle;"></span> Trocar imagem');
            });
            frame.open();
        });

        $('#rnm-remove-thumb').on('click', function(){
            $('#post_thumbnail_id').val('');
            $('#rnm-thumb-preview').hide().attr('src','');
            $('#rnm-set-thumb').html('<span class="dashicons dashicons-upload" style="vertical-align:middle;"></span> Escolher imagem');
        });
    });
    </script>
    <?php
}

/* ================================================================== */
/*  3. LISTAR NOTÃCIAS                                                  */
/* ================================================================== */
function rnm_list_posts_page() {
    if (isset($_GET['deleted'])) rnm_notice('NotÃ­cia movida para a lixeira.');

    $paged    = max(1, (int) ($_GET['paged'] ?? 1));
    $search   = sanitize_text_field($_GET['s'] ?? '');
    $cat_filter = (int) ($_GET['cat'] ?? 0);
    $status   = in_array($_GET['status'] ?? '', ['publish','draft','trash']) ? $_GET['status'] : '';

    $args = [
        'posts_per_page' => 20,
        'paged'          => $paged,
        'post_status'    => $status ?: ['publish','draft'],
    ];
    if ($search)     $args['s']           = $search;
    if ($cat_filter) $args['cat']         = $cat_filter;

    $query = new WP_Query($args);
    $total = $query->found_posts;
    $pages = $query->max_num_pages;
    $cats  = get_categories(['hide_empty' => false]);

    $base_url = admin_url('admin.php?page=reforma-news-list');
    ?>
    <div class="wrap rnm-wrap">
        <h1>
            <span class="dashicons dashicons-list-view"></span> Todas as NotÃ­cias
            <a href="<?php echo admin_url('admin.php?page=reforma-news-new'); ?>" class="rnm-btn rnm-btn-primary" style="margin-left:14px;font-size:13px;text-decoration:none;">
                + Nova NotÃ­cia
            </a>
        </h1>

        <!-- Filters -->
        <form method="get" class="rnm-search-bar" style="margin-top:18px;">
            <input type="hidden" name="page" value="reforma-news-list">
            <input type="text" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Buscar notÃ­cias...">
            <select name="cat">
                <option value="">Todas as categorias</option>
                <?php foreach ($cats as $cat) : ?>
                    <option value="<?php echo esc_attr($cat->term_id); ?>" <?php selected($cat_filter, $cat->term_id); ?>>
                        <?php echo esc_html($cat->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="status">
                <option value="" <?php selected($status,''); ?>>Todos</option>
                <option value="publish" <?php selected($status,'publish'); ?>>Publicados</option>
                <option value="draft"   <?php selected($status,'draft'); ?>>Rascunhos</option>
                <option value="trash"   <?php selected($status,'trash'); ?>>Lixeira</option>
            </select>
            <button type="submit" class="rnm-btn rnm-btn-primary">Filtrar</button>
            <?php if ($search || $cat_filter || $status) : ?>
                <a href="<?php echo esc_url($base_url); ?>" class="rnm-btn rnm-btn-secondary">Limpar</a>
            <?php endif; ?>
        </form>

        <p style="font-size:13px;color:#666;margin-bottom:12px;"><?php echo esc_html($total); ?> notÃ­cia(s) encontrada(s)</p>

        <div class="rnm-box" style="padding:0;overflow:hidden;">
            <table class="rnm-table">
                <thead>
                    <tr>
                        <th style="width:60px;">Imagem</th>
                        <th>TÃ­tulo</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th>AÃ§Ãµes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                        $p    = get_post();
                        $pcats = get_the_category($p->ID);
                        $cat_name = $pcats ? $pcats[0]->name : 'â€”';
                    ?>
                    <tr>
                        <td>
                            <?php if (has_post_thumbnail()) the_post_thumbnail([60,42]);
                            else echo '<div style="width:60px;height:42px;background:#f0f0f0;border-radius:4px;"></div>'; ?>
                        </td>
                        <td>
                            <strong><?php echo esc_html(wp_trim_words(get_the_title(), 12)); ?></strong>
                        </td>
                        <td><?php echo esc_html($cat_name); ?></td>
                        <td>
                            <span class="rnm-badge rnm-badge-<?php echo esc_attr(get_post_status()); ?>">
                                <?php
                                $s = get_post_status();
                                echo $s === 'publish' ? 'Publicado' : ($s === 'draft' ? 'Rascunho' : 'Lixeira');
                                ?>
                            </span>
                        </td>
                        <td style="white-space:nowrap;"><?php echo esc_html(get_the_date('d/m/Y')); ?></td>
                        <td style="white-space:nowrap;">
                            <a href="<?php echo admin_url('admin.php?page=reforma-news-new&edit=' . get_the_ID()); ?>" title="Editar" style="color:#003580;margin-right:8px;">
                                <span class="dashicons dashicons-edit"></span>
                            </a>
                            <a href="<?php echo esc_url(get_permalink()); ?>" target="_blank" title="Ver" style="color:#666;margin-right:8px;">
                                <span class="dashicons dashicons-external"></span>
                            </a>
                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=reforma-news-new&delete=' . get_the_ID()), 'rnm_delete_post_' . get_the_ID()); ?>"
                               title="Mover para lixeira"
                               onclick="return confirm('Mover para lixeira?');"
                               style="color:#E8301B;">
                                <span class="dashicons dashicons-trash"></span>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; else : ?>
                    <tr><td colspan="6" style="text-align:center;padding:32px;color:#888;">Nenhuma notÃ­cia encontrada.</td></tr>
                    <?php endif; wp_reset_postdata(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($pages > 1) : ?>
        <div class="rnm-pagination">
            <?php
            for ($i = 1; $i <= $pages; $i++) {
                $url = add_query_arg(['paged' => $i, 's' => $search, 'cat' => $cat_filter, 'status' => $status], $base_url);
                if ($i == $paged) echo '<span class="current">' . $i . '</span>';
                else echo '<a href="' . esc_url($url) . '">' . $i . '</a>';
            }
            ?>
        </div>
        <?php endif; ?>
    </div>
    <?php
}

/* ================================================================== */
/*  4. CATEGORIAS                                                       */
/* ================================================================== */
function rnm_categories_page() {
    $notice = '';

    // Create category
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rnm_save_cat'])) {
        check_admin_referer('rnm_save_cat');
        $name  = sanitize_text_field($_POST['cat_name'] ?? '');
        $desc  = sanitize_textarea_field($_POST['cat_desc'] ?? '');
        $color = sanitize_hex_color($_POST['cat_color'] ?? '#003580') ?: '#003580';
        $slug  = sanitize_title($_POST['cat_slug'] ?? $name);
        $parent = (int) ($_POST['cat_parent'] ?? 0);
        $edit_tid = (int) ($_POST['edit_term_id'] ?? 0);

        if (!$name) {
            $notice = ['error', 'O nome da categoria Ã© obrigatÃ³rio.'];
        } elseif ($edit_tid) {
            $result = wp_update_term($edit_tid, 'category', [
                'name'        => $name,
                'description' => $desc,
                'slug'        => $slug,
                'parent'      => $parent,
            ]);
            if (!is_wp_error($result)) {
                update_term_meta($edit_tid, '_reforma_cat_color', $color);
                $notice = ['success', 'Categoria atualizada!'];
            } else {
                $notice = ['error', $result->get_error_message()];
            }
        } else {
            $result = wp_insert_term($name, 'category', [
                'description' => $desc,
                'slug'        => $slug,
                'parent'      => $parent,
            ]);
            if (!is_wp_error($result)) {
                update_term_meta($result['term_id'], '_reforma_cat_color', $color);
                $notice = ['success', 'Categoria criada com sucesso!'];
            } else {
                $notice = ['error', $result->get_error_message()];
            }
        }
    }

    // Delete
    if (isset($_GET['delete_cat']) && wp_verify_nonce($_GET['_wpnonce'] ?? '', 'rnm_delete_cat_' . $_GET['delete_cat'])) {
        wp_delete_category((int) $_GET['delete_cat']);
        $notice = ['success', 'Categoria excluÃ­da.'];
    }

    $edit_term = isset($_GET['edit_cat']) ? get_term((int) $_GET['edit_cat'], 'category') : null;
    $all_cats  = get_categories(['hide_empty' => false, 'orderby' => 'name']);

    $color_options = [
        '#003580' => 'Azul (padrÃ£o)',
        '#E8301B' => 'Vermelho',
        '#0a7a3e' => 'Verde',
        '#d9640a' => 'Laranja',
        '#6d28d9' => 'Roxo',
        '#0891b2' => 'Ciano',
        '#4b5563' => 'Cinza',
    ];
    ?>
    <div class="wrap rnm-wrap">
        <h1><span class="dashicons dashicons-category"></span> Categorias</h1>
        <?php if ($notice) rnm_notice($notice[1], $notice[0]); ?>

        <div style="display:grid;grid-template-columns:1.4fr 2fr;gap:24px;">
            <!-- Form -->
            <div class="rnm-box">
                <h2><?php echo $edit_term ? 'Editar Categoria' : 'Nova Categoria'; ?></h2>
                <form method="post">
                    <?php wp_nonce_field('rnm_save_cat'); ?>
                    <?php if ($edit_term) : ?>
                        <input type="hidden" name="edit_term_id" value="<?php echo esc_attr($edit_term->term_id); ?>">
                    <?php endif; ?>
                    <div class="rnm-field">
                        <label>Nome *</label>
                        <input type="text" name="cat_name" required placeholder="Ex: TributaÃ§Ã£o"
                            value="<?php echo esc_attr($edit_term ? $edit_term->name : ''); ?>">
                    </div>
                    <div class="rnm-field">
                        <label>Slug (URL)</label>
                        <input type="text" name="cat_slug" placeholder="tributacao"
                            value="<?php echo esc_attr($edit_term ? $edit_term->slug : ''); ?>">
                        <span class="desc">Deixe em branco para gerar automaticamente</span>
                    </div>
                    <div class="rnm-field">
                        <label>DescriÃ§Ã£o</label>
                        <textarea name="cat_desc" rows="3" placeholder="Breve descriÃ§Ã£o da editoria..."><?php echo esc_textarea($edit_term ? $edit_term->description : ''); ?></textarea>
                    </div>
                    <div class="rnm-field">
                        <label>Cor da Tag</label>
                        <select name="cat_color">
                            <?php
                            $current_color = $edit_term ? rnm_get_category_color($edit_term->term_id) : '#003580';
                            foreach ($color_options as $hex => $label) :
                            ?>
                                <option value="<?php echo esc_attr($hex); ?>" <?php selected($current_color, $hex); ?>>
                                    <?php echo esc_html($label); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="rnm-field">
                        <label>Categoria pai</label>
                        <select name="cat_parent">
                            <option value="0">Nenhuma (nÃ­vel raiz)</option>
                            <?php foreach ($all_cats as $cat) :
                                if ($edit_term && $cat->term_id === $edit_term->term_id) continue;
                            ?>
                                <option value="<?php echo esc_attr($cat->term_id); ?>"
                                    <?php selected($edit_term ? $edit_term->parent : 0, $cat->term_id); ?>>
                                    <?php echo esc_html($cat->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="display:flex;gap:10px;">
                        <button type="submit" name="rnm_save_cat" class="rnm-btn rnm-btn-primary">
                            <?php echo $edit_term ? 'Atualizar' : 'Criar Categoria'; ?>
                        </button>
                        <?php if ($edit_term) : ?>
                            <a href="<?php echo admin_url('admin.php?page=reforma-news-cats'); ?>" class="rnm-btn rnm-btn-secondary" style="text-decoration:none;">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- List -->
            <div class="rnm-box" style="padding:0;overflow:hidden;">
                <table class="rnm-table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Cor</th>
                            <th>Posts</th>
                            <th>AÃ§Ãµes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($all_cats) : foreach ($all_cats as $cat) :
                            $color = rnm_get_category_color($cat->term_id);
                        ?>
                        <tr>
                            <td><strong><?php echo esc_html($cat->name); ?></strong></td>
                            <td><code style="font-size:12px;"><?php echo esc_html($cat->slug); ?></code></td>
                            <td>
                                <span class="rnm-color-dot" style="background:<?php echo esc_attr($color); ?>;width:16px;height:16px;border-radius:3px;"></span>
                                <span style="font-size:12px;color:#888;"><?php echo esc_html($color); ?></span>
                            </td>
                            <td><?php echo esc_html($cat->count); ?></td>
                            <td style="white-space:nowrap;">
                                <a href="<?php echo admin_url('admin.php?page=reforma-news-cats&edit_cat=' . $cat->term_id); ?>" style="color:#003580;margin-right:8px;">
                                    <span class="dashicons dashicons-edit"></span>
                                </a>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" target="_blank" style="color:#666;margin-right:8px;">
                                    <span class="dashicons dashicons-external"></span>
                                </a>
                                <?php if ($cat->count == 0) : ?>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=reforma-news-cats&delete_cat=' . $cat->term_id), 'rnm_delete_cat_' . $cat->term_id); ?>"
                                   onclick="return confirm('Excluir categoria?');"
                                   style="color:#E8301B;">
                                    <span class="dashicons dashicons-trash"></span>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; else : ?>
                        <tr><td colspan="5" style="text-align:center;padding:24px;color:#888;">Nenhuma categoria criada ainda.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}

/* ================================================================== */
/*  5. CONFIGURAÃ‡Ã•ES                                                    */
/* ================================================================== */
function rnm_settings_page() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rnm_save_settings'])) {
        check_admin_referer('rnm_save_settings');
        $fields = [
            'reforma_breaking_news',
            'reforma_breaking_news_link',
            'reforma_site_tagline_custom',
            'reforma_footer_text',
            'reforma_facebook',
            'reforma_instagram',
            'reforma_twitter',
            'reforma_linkedin',
            'reforma_youtube',
            'reforma_whatsapp',
        ];
        foreach ($fields as $f) {
            set_theme_mod($f, sanitize_text_field($_POST[$f] ?? ''));
        }
        rnm_notice('ConfiguraÃ§Ãµes salvas!');
    }
    ?>
    <div class="wrap rnm-wrap">
        <h1><span class="dashicons dashicons-admin-settings"></span> ConfiguraÃ§Ãµes do Portal</h1>

        <form method="post">
            <?php wp_nonce_field('rnm_save_settings'); ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                <div>
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-admin-site"></span> CabeÃ§alho</h2>
                        <div class="rnm-field">
                            <label>Slogan do cabeÃ§alho</label>
                            <input type="text" name="reforma_site_tagline_custom"
                                value="<?php echo esc_attr(get_theme_mod('reforma_site_tagline_custom','Portal de NotÃ­cias sobre a Reforma TributÃ¡ria')); ?>">
                        </div>
                        <div class="rnm-field">
                            <label>Texto â€” Ãšltimas notÃ­cias (barra vermelha)</label>
                            <input type="text" name="reforma_breaking_news"
                                value="<?php echo esc_attr(get_theme_mod('reforma_breaking_news','')); ?>"
                                placeholder="Deixe em branco para ocultar">
                        </div>
                        <div class="rnm-field">
                            <label>Link â€” Ãšltimas notÃ­cias</label>
                            <input type="text" name="reforma_breaking_news_link"
                                value="<?php echo esc_attr(get_theme_mod('reforma_breaking_news_link','')); ?>">
                        </div>
                    </div>
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-admin-home"></span> RodapÃ©</h2>
                        <div class="rnm-field">
                            <label>Texto do rodapÃ©</label>
                            <textarea name="reforma_footer_text" rows="3"><?php echo esc_textarea(get_theme_mod('reforma_footer_text','Acompanhe todas as novidades sobre a Reforma TributÃ¡ria Brasileira.')); ?></textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="rnm-box">
                        <h2><span class="dashicons dashicons-share"></span> Redes Sociais</h2>
                        <?php
                        $socials = [
                            'reforma_facebook'  => ['Facebook',  'fa-brands fa-facebook'],
                            'reforma_instagram' => ['Instagram', 'fa-brands fa-instagram'],
                            'reforma_twitter'   => ['Twitter/X', 'fa-brands fa-x-twitter'],
                            'reforma_linkedin'  => ['LinkedIn',  'fa-brands fa-linkedin'],
                            'reforma_youtube'   => ['YouTube',   'fa-brands fa-youtube'],
                            'reforma_whatsapp'  => ['WhatsApp (nÃºmero com DDI)', 'fa-brands fa-whatsapp'],
                        ];
                        foreach ($socials as $key => [$label, $icon]) :
                        ?>
                        <div class="rnm-field">
                            <label><?php echo esc_html($label); ?></label>
                            <input type="text" name="<?php echo esc_attr($key); ?>"
                                value="<?php echo esc_attr(get_theme_mod($key,'')); ?>"
                                placeholder="<?php echo strpos($key,'whatsapp') !== false ? '5511999999999' : 'https://...'; ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <button type="submit" name="rnm_save_settings" class="rnm-btn rnm-btn-primary" style="margin-top:4px;">
                <span class="dashicons dashicons-saved" style="vertical-align:middle;"></span> Salvar ConfiguraÃ§Ãµes
            </button>
        </form>
    </div>
    <?php
}

/* ================================================================== */
/*  6. NEWSLETTER                                                       */
/* ================================================================== */
function rnm_newsletter_page() {
    if (isset($_POST['rnm_export_newsletter'])) {
        check_admin_referer('rnm_export_newsletter');
        $subscribers = get_option('reforma_newsletter_subscribers', []);
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="newsletter-' . date('Y-m-d') . '.csv"');
        echo "\xEF\xBB\xBF"; // BOM UTF-8
        echo "E-mail\n";
        foreach ($subscribers as $email) echo esc_html($email) . "\n";
        exit;
    }

    if (isset($_POST['rnm_clear_newsletter']) && wp_verify_nonce($_POST['_wpnonce_clear'] ?? '', 'rnm_clear_newsletter')) {
        update_option('reforma_newsletter_subscribers', []);
        rnm_notice('Lista limpa.');
    }

    $subscribers = get_option('reforma_newsletter_subscribers', []);
    ?>
    <div class="wrap rnm-wrap">
        <h1><span class="dashicons dashicons-email-alt"></span> Newsletter â€” <?php echo count($subscribers); ?> inscrito(s)</h1>

        <div class="rnm-box">
            <h2>Lista de inscritos</h2>
            <div style="display:flex;gap:10px;margin-bottom:18px;">
                <form method="post" style="display:inline;">
                    <?php wp_nonce_field('rnm_export_newsletter'); ?>
                    <button type="submit" name="rnm_export_newsletter" class="rnm-btn rnm-btn-primary">
                        <span class="dashicons dashicons-download" style="vertical-align:middle;"></span> Exportar CSV
                    </button>
                </form>
                <form method="post" style="display:inline;" onsubmit="return confirm('Limpar toda a lista?');">
                    <?php wp_nonce_field('rnm_clear_newsletter', '_wpnonce_clear'); ?>
                    <button type="submit" name="rnm_clear_newsletter" class="rnm-btn rnm-btn-danger">
                        <span class="dashicons dashicons-trash" style="vertical-align:middle;"></span> Limpar lista
                    </button>
                </form>
            </div>

            <?php if ($subscribers) : ?>
            <table class="rnm-table">
                <thead><tr><th>#</th><th>E-mail</th><th>AÃ§Ã£o</th></tr></thead>
                <tbody>
                    <?php foreach ($subscribers as $i => $email) : ?>
                    <tr>
                        <td><?php echo esc_html($i + 1); ?></td>
                        <td><?php echo esc_html($email); ?></td>
                        <td>
                            <a href="mailto:<?php echo esc_attr($email); ?>" style="color:#003580;font-size:13px;">
                                <span class="dashicons dashicons-email"></span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else : ?>
            <p style="color:#888;padding:20px 0;">Nenhum inscrito ainda.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
