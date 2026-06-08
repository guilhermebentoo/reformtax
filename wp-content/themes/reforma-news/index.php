<?php get_header(); ?>

<!-- ===== HERO — contido no container ===== -->
<section class="hero-section">
    <div class="container">
        <?php
        $hero_query = new WP_Query(['posts_per_page' => 6, 'post_status' => 'publish']);
        $hero_post  = $hero_query->posts[0] ?? null;
        $side_posts = array_slice($hero_query->posts ?? [], 1, 5);
        ?>

        <div class="hero-grid">

            <!-- Destaque principal -->
            <?php if ($hero_post) : ?>
            <div class="hero-main">
                <a href="<?php echo esc_url(get_permalink($hero_post)); ?>">
                    <?php if (has_post_thumbnail($hero_post)) :
                        echo get_the_post_thumbnail($hero_post, 'rfx-hero');
                    else : ?>
                        <div style="width:100%;height:100%;background:var(--navy-card);"></div>
                    <?php endif; ?>
                </a>
                <div class="hero-main-overlay">
                    <?php rfx_the_tag($hero_post->ID); ?>
                    <h2 class="hero-title">
                        <a href="<?php echo esc_url(get_permalink($hero_post)); ?>">
                            <?php echo esc_html($hero_post->post_title); ?>
                        </a>
                    </h2>
                    <p class="hero-excerpt">
                        <?php echo esc_html(wp_trim_words(get_the_excerpt($hero_post), 22)); ?>
                    </p>
                    <div class="hero-meta">
                        <?php rfx_the_meta($hero_post->ID); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Mais lidas -->
            <aside class="hero-side">
                <div class="hero-side-header">
                    <i class="fa-solid fa-fire-flame-curved"></i> Mais Lidas Hoje
                </div>
                <?php foreach ($side_posts as $sp) : ?>
                <a href="<?php echo esc_url(get_permalink($sp)); ?>" class="hero-side-item">
                    <?php if (has_post_thumbnail($sp)) :
                        echo get_the_post_thumbnail($sp, 'rfx-mini');
                    else : ?>
                        <div style="width:72px;height:52px;background:var(--navy-border);border-radius:4px;flex-shrink:0;"></div>
                    <?php endif; ?>
                    <div class="hero-side-content">
                        <?php rfx_the_tag($sp->ID); ?>
                        <h4><?php echo esc_html($sp->post_title); ?></h4>
                        <div class="meta"><?php echo esc_html(get_the_date('d/m/Y', $sp)); ?></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </aside>

        </div>
    </div>
</section>

<!-- ===== NEWS SECTION ===== -->
<section class="news-section">
    <div class="container">
        <div class="news-layout">

            <!-- Main -->
            <main>
                <div class="section-header">
                    <h2 class="section-title">Últimas Notícias</h2>
                    <a href="<?php echo esc_url(home_url('/noticias')); ?>" class="section-link">
                        Ver todas <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <?php if (have_posts()) : ?>
                <div class="news-grid">
                    <?php
                    $first = true;
                    while (have_posts()) : the_post();
                        $wide_class = $first ? ' news-card-wide' : '';
                        $first      = false;
                    ?>
                    <article class="news-card<?php echo $wide_class; ?>" id="post-<?php the_ID(); ?>">
                        <div class="news-card-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) the_post_thumbnail($wide_class ? 'rfx-hero' : 'rfx-card');
                                else echo '<div style="width:100%;height:100%;background:var(--light);"></div>'; ?>
                            </a>
                            <?php rfx_the_tag(); ?>
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="news-card-excerpt">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?>
                            </p>
                            <div class="news-card-meta">
                                <?php rfx_the_meta(); ?>
                            </div>
                        </div>
                    </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php echo paginate_links([
                        'prev_text' => '<i class="fa-solid fa-angle-left"></i>',
                        'next_text' => '<i class="fa-solid fa-angle-right"></i>',
                    ]); ?>
                </div>

                <?php else : ?>
                <div class="no-results-msg">
                    <h2>Nenhuma notícia encontrada</h2>
                    <p>Volte em breve para acompanhar as novidades da Reforma Tributária.</p>
                </div>
                <?php endif; ?>
            </main>

            <!-- Sidebar -->
            <aside class="sidebar">
                <?php get_sidebar(); ?>
            </aside>

        </div>
    </div>
</section>

<!-- ===== CATEGORY STRIP ===== -->
<?php
$strip_cats = get_categories(['orderby' => 'count', 'order' => 'DESC', 'number' => 4, 'hide_empty' => true]);
if ($strip_cats) :
?>
<section class="cat-strip">
    <div class="container">
        <div class="cat-strip-grid">
            <?php foreach ($strip_cats as $sc) :
                $cat_posts = get_posts(['category' => $sc->term_id, 'numberposts' => 4]);
                if (!$cat_posts) continue;
            ?>
            <div>
                <div class="section-header">
                    <h3 class="section-title section-title-sm"><?php echo esc_html($sc->name); ?></h3>
                    <a href="<?php echo esc_url(get_category_link($sc->term_id)); ?>" class="section-link">
                        Ver mais <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                <?php foreach ($cat_posts as $p) : ?>
                <div class="mini-item">
                    <?php if (has_post_thumbnail($p)) : ?>
                        <a href="<?php echo esc_url(get_permalink($p)); ?>">
                            <?php echo get_the_post_thumbnail($p, 'rfx-mini'); ?>
                        </a>
                    <?php endif; ?>
                    <div>
                        <a href="<?php echo esc_url(get_permalink($p)); ?>" class="mini-title">
                            <?php echo esc_html($p->post_title); ?>
                        </a>
                        <div class="mini-date"><?php echo esc_html(get_the_date('d/m/Y', $p)); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
