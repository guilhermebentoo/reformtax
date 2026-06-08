<?php get_header(); ?>

<div class="archive-header">
    <div class="container">
        <h1>Resultados para: "<?php echo esc_html(get_search_query()); ?>"</h1>
        <p><?php global $wp_query; echo $wp_query->found_posts; ?> notícia(s) encontrada(s)</p>
    </div>
</div>

<div class="archive-content">
    <div class="container">
        <div class="news-layout">
            <main>
                <?php if (have_posts()) : ?>
                <div class="news-list">
                    <?php while (have_posts()) : the_post(); ?>
                    <div class="news-list-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('reforma-thumb'); ?></a>
                        <?php endif; ?>
                        <div class="news-list-item-body">
                            <?php reforma_the_category_tag(); ?>
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                            <div class="news-list-item-meta"><?php reforma_the_meta(); ?></div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div class="pagination">
                    <?php echo paginate_links(); ?>
                </div>
                <?php else : ?>
                <div class="no-results-msg">
                    <h2>Nenhum resultado encontrado</h2>
                    <p>Tente buscar com outras palavras-chave.</p>
                </div>
                <?php endif; ?>
            </main>
            <aside class="sidebar"><?php get_sidebar(); ?></aside>
        </div>
    </div>
</div>

<?php get_footer(); ?>
