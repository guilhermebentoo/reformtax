<?php get_header(); ?>

<div class="archive-header">
    <div class="container">
        <div class="archive-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Início</a> /
            <?php
            if (is_category())  echo esc_html(single_cat_title('', false));
            elseif (is_tag())   echo 'Tag: ' . esc_html(single_tag_title('', false));
            elseif (is_author()) the_author();
            elseif (is_date())  echo get_the_date('F Y');
            ?>
        </div>
        <h1>
            <?php
            if (is_category())       single_cat_title();
            elseif (is_tag())        echo 'Tag: ' . single_tag_title('', false);
            elseif (is_author())     echo 'Artigos de: ' . get_the_author();
            elseif (is_date())       echo 'Arquivo: ' . get_the_date('F Y');
            else                     the_archive_title();
            ?>
        </h1>
        <?php if (is_category() && category_description()) : ?>
            <p><?php echo esc_html(strip_tags(category_description())); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="archive-content">
    <div class="container">
        <div class="news-layout">
            <main>
                <?php if (have_posts()) : ?>
                <div class="news-grid">
                    <?php while (have_posts()) : the_post(); ?>
                    <article class="news-card" id="post-<?php the_ID(); ?>">
                        <div class="news-card-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) the_post_thumbnail('rfx-card');
                                else echo '<div style="width:100%;height:100%;background:var(--light);aspect-ratio:16/9;"></div>'; ?>
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
                            <div class="news-card-meta"><?php rfx_the_meta(); ?></div>
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
                    <p>Ainda não há publicações nesta editoria.</p>
                </div>
                <?php endif; ?>
            </main>

            <aside class="sidebar"><?php get_sidebar(); ?></aside>
        </div>
    </div>
</div>

<?php get_footer(); ?>
