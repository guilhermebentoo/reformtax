<?php get_header(); ?>

<div class="container" style="padding-top:36px;padding-bottom:48px;">
    <div class="single-layout">
        <main>
            <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header style="margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--color-border);">
                    <h1 class="article-title"><?php the_title(); ?></h1>
                </header>
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('reforma-hero', ['style' => 'width:100%;max-height:400px;object-fit:cover;border-radius:6px;margin-bottom:24px;']); ?>
                <?php endif; ?>
                <div class="article-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php endwhile; ?>
        </main>
        <aside class="sidebar"><?php get_sidebar(); ?></aside>
    </div>
</div>

<?php get_footer(); ?>
