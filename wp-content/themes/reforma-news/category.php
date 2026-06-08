<?php get_header(); ?>

<!-- Archive Header -->
<div class="archive-header">
    <div class="container">
        <div class="archive-breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Início</a> /
            <?php if (is_category()) echo esc_html(single_cat_title('', false));
            elseif (is_tag()) echo esc_html(single_tag_title('', false));
            elseif (is_author()) the_author();
            elseif (is_date()) echo get_the_date('F Y'); ?>
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
        <?php
        if (is_category()) {
            $desc = category_description();
            if ($desc) echo '<p>' . esc_html(strip_tags($desc)) . '</p>';
        }
        ?>
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
                                <?php if (has_post_thumbnail()) the_post_thumbnail('reforma-card');
                                else echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/placeholder.jpg') . '" alt="">'; ?>
                            </a>
                            <?php reforma_the_category_tag(); ?>
                        </div>
                        <div class="news-card-body">
                            <h3 class="news-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="news-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                            <div class="news-card-meta"><?php reforma_the_meta(); ?></div>
                        </div>
                    </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php echo paginate_links(['prev_text' => '<i class="fa-solid fa-angle-left"></i>', 'next_text' => '<i class="fa-solid fa-angle-right"></i>']); ?>
                </div>

                <?php else : ?>
                <div class="no-results-msg">
                    <h2>Nenhuma notícia encontrada</h2>
                    <p>Ainda não há publicações nesta categoria.</p>
                </div>
                <?php endif; ?>
            </main>

            <aside class="sidebar"><?php get_sidebar(); ?></aside>
        </div>
    </div>
</div>

<?php get_footer(); ?>
