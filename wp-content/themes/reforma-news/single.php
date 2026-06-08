<?php get_header(); ?>

<div class="archive-header" style="padding:16px 0 12px;">
    <div class="container">
        <div class="archive-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Início</a>
            <?php
            $cats = get_the_category();
            if ($cats) echo ' / <a href="' . esc_url(get_category_link($cats[0]->term_id)) . '">' . esc_html($cats[0]->name) . '</a>';
            ?>
            / <?php the_title(); ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="single-layout">

        <main>
            <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="article-header">
                    <?php rfx_the_tag(); ?>
                    <h1 class="article-title"><?php the_title(); ?></h1>
                    <?php if (has_excerpt()) : ?>
                        <p class="article-subtitle"><?php the_excerpt(); ?></p>
                    <?php endif; ?>
                    <div class="article-meta">
                        <div class="author-info">
                            <?php echo get_avatar(get_the_author_meta('email'), 32); ?>
                            <span><?php the_author(); ?></span>
                        </div>
                        <span><i class="fa-regular fa-calendar"></i> <?php the_date('d/m/Y'); ?></span>
                        <span><i class="fa-regular fa-clock"></i> <?php the_time('H:i'); ?></span>
                        <?php if (comments_open()) : ?>
                        <span>
                            <i class="fa-regular fa-comment"></i>
                            <?php comments_number('0 comentários','1 comentário','% comentários'); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php rfx_share_buttons(); ?>

                <?php if (has_post_thumbnail()) : ?>
                <figure style="margin-bottom:28px;">
                    <?php the_post_thumbnail('rfx-hero', ['class' => 'article-featured-img']); ?>
                    <?php if (get_the_post_thumbnail_caption()) : ?>
                        <figcaption style="font-size:12px;color:var(--gray-400);margin-top:6px;text-align:center;font-style:italic;">
                            <?php the_post_thumbnail_caption(); ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>
                <?php endif; ?>

                <div class="article-content">
                    <?php the_content(); ?>
                </div>

                <!-- Tags -->
                <?php $tags = get_the_tags(); if ($tags) : ?>
                <div class="article-tags">
                    <span>Tags:</span>
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"><?php echo esc_html($tag->name); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php rfx_share_buttons(); ?>

                <!-- Post navigation -->
                <?php
                $prev = get_previous_post();
                $next = get_next_post();
                if ($prev || $next) :
                ?>
                <div style="display:flex;justify-content:space-between;gap:16px;margin-top:32px;padding-top:20px;border-top:1px solid var(--gray-200);">
                    <?php if ($prev) : ?>
                    <a href="<?php echo esc_url(get_permalink($prev)); ?>"
                       style="flex:1;padding:14px;background:var(--white);border-radius:var(--r-lg);box-shadow:var(--sh);border:1px solid var(--gray-200);font-size:13px;font-weight:600;color:var(--dark);">
                        <span style="display:block;font-size:10.5px;color:var(--gray-400);margin-bottom:4px;">
                            <i class="fa-solid fa-angle-left"></i> Anterior
                        </span>
                        <?php echo esc_html(wp_trim_words($prev->post_title, 10)); ?>
                    </a>
                    <?php endif; ?>
                    <?php if ($next) : ?>
                    <a href="<?php echo esc_url(get_permalink($next)); ?>"
                       style="flex:1;padding:14px;background:var(--white);border-radius:var(--r-lg);box-shadow:var(--sh);border:1px solid var(--gray-200);font-size:13px;font-weight:600;color:var(--dark);text-align:right;">
                        <span style="display:block;font-size:10.5px;color:var(--gray-400);margin-bottom:4px;">
                            Próximo <i class="fa-solid fa-angle-right"></i>
                        </span>
                        <?php echo esc_html(wp_trim_words($next->post_title, 10)); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Relacionadas -->
                <?php
                $related = get_posts([
                    'category__in' => wp_get_post_categories(get_the_ID()),
                    'numberposts'  => 3,
                    'post__not_in' => [get_the_ID()],
                ]);
                if ($related) :
                ?>
                <div style="margin-top:36px;">
                    <div class="section-header">
                        <h3 class="section-title">Notícias Relacionadas</h3>
                    </div>
                    <div class="news-grid" style="grid-template-columns:repeat(3,1fr);">
                        <?php foreach ($related as $r) : ?>
                        <article class="news-card">
                            <div class="news-card-thumb">
                                <a href="<?php echo esc_url(get_permalink($r)); ?>">
                                    <?php if (has_post_thumbnail($r)) echo get_the_post_thumbnail($r, 'rfx-card');
                                    else echo '<div style="width:100%;height:100%;background:var(--light);"></div>'; ?>
                                </a>
                                <?php rfx_the_tag($r->ID); ?>
                            </div>
                            <div class="news-card-body">
                                <h3 class="news-card-title">
                                    <a href="<?php echo esc_url(get_permalink($r)); ?>"><?php echo esc_html($r->post_title); ?></a>
                                </h3>
                                <div class="news-card-meta"><?php rfx_the_meta($r->ID); ?></div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php comments_template(); ?>

            </article>
            <?php endwhile; ?>
        </main>

        <aside class="sidebar">
            <?php
            if (is_active_sidebar('sidebar-single')) dynamic_sidebar('sidebar-single');
            else get_sidebar();
            ?>
        </aside>

    </div>
</div>

<?php get_footer(); ?>
