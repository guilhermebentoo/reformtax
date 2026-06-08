<?php
// Newsletter
?>
<div class="newsletter-widget">
    <h3><i class="fa-solid fa-envelope-open-text" style="color:var(--gold);margin-right:6px;"></i> Newsletter Reformtax</h3>
    <p>As principais análises sobre a Reforma Tributária toda semana no seu e-mail.</p>
    <form class="newsletter-form" id="sidebar-newsletter-form">
        <input type="email" name="email" placeholder="Seu e-mail profissional" required>
        <button type="submit">
            <i class="fa-solid fa-paper-plane"></i> Assinar Gratuitamente
        </button>
    </form>
    <div id="sidebar-newsletter-msg" style="display:none;margin-top:8px;font-size:13px;"></div>
</div>

<!-- Categorias -->
<div class="widget">
    <div class="widget-title"><i class="fa-solid fa-folder-open"></i> Editorias</div>
    <div class="widget-body">
        <?php
        $cats = get_categories(['hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC']);
        foreach ($cats as $cat) :
        ?>
        <div class="cat-list-item">
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                <?php echo esc_html($cat->name); ?>
            </a>
            <span class="cat-count"><?php echo esc_html($cat->count); ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Recentes -->
<div class="widget">
    <div class="widget-title"><i class="fa-solid fa-clock-rotate-left"></i> Notícias Recentes</div>
    <div class="widget-body" style="padding-top:4px;padding-bottom:4px;">
        <?php
        $recent = get_posts(['numberposts' => 5, 'post_status' => 'publish']);
        foreach ($recent as $r) :
        ?>
        <a href="<?php echo esc_url(get_permalink($r)); ?>" class="sidebar-recent-item">
            <?php if (has_post_thumbnail($r)) :
                echo get_the_post_thumbnail($r, 'rfx-mini');
            else : ?>
                <div style="width:62px;height:44px;background:var(--gray-100);border-radius:var(--r);flex-shrink:0;"></div>
            <?php endif; ?>
            <div>
                <div class="sidebar-recent-title">
                    <?php echo esc_html(wp_trim_words($r->post_title, 10)); ?>
                </div>
                <div class="sidebar-recent-date">
                    <?php echo esc_html(get_the_date('d/m/Y', $r)); ?>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Tags -->
<?php
$tags = get_tags(['orderby' => 'count', 'order' => 'DESC', 'number' => 18, 'hide_empty' => true]);
if ($tags) :
?>
<div class="widget">
    <div class="widget-title"><i class="fa-solid fa-tags"></i> Tags</div>
    <div class="widget-body">
        <div class="tags-cloud">
            <?php foreach ($tags as $tag) : ?>
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                    <?php echo esc_html($tag->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (is_active_sidebar('sidebar-main')) dynamic_sidebar('sidebar-main'); ?>
