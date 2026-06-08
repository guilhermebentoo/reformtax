<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ===== TOP BAR ===== -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-ticker">
            <span class="top-bar-badge"><i class="fa-solid fa-bolt"></i> Urgente</span>
            <span class="top-bar-text">
                <?php
                $breaking      = get_theme_mod('reforma_breaking_news', '');
                $breaking_link = get_theme_mod('reforma_breaking_news_link', '');
                if ($breaking) :
                    if ($breaking_link) echo '<a href="' . esc_url($breaking_link) . '">' . esc_html($breaking) . '</a>';
                    else echo esc_html($breaking);
                else :
                    echo 'Acompanhe todas as novidades sobre a Reforma Tributária Brasileira';
                endif;
                ?>
            </span>
        </div>
        <div class="top-bar-right">
            <span class="top-bar-date">
                <i class="fa-regular fa-calendar"></i>
                <?php echo date_i18n('l, d \d\e F \d\e Y'); ?>
            </span>
            <?php
            $socials = [
                'reforma_linkedin'  => ['fa-brands fa-linkedin-in',  ''],
                'reforma_instagram' => ['fa-brands fa-instagram',     ''],
                'reforma_twitter'   => ['fa-brands fa-x-twitter',    ''],
                'reforma_youtube'   => ['fa-brands fa-youtube',      ''],
            ];
            foreach ($socials as $key => [$icon, $_]) :
                $url = get_theme_mod($key, '');
                if ($url) :
            ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                    <i class="<?php echo esc_attr($icon); ?>"></i>
                </a>
            <?php endif; endforeach; ?>
        </div>
    </div>
</div>

<!-- ===== HEADER ===== -->
<header class="site-header">
    <div class="container header-inner">

        <!-- Logo -->
        <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <span class="logo-bold">Reform</span><span class="logo-thin">tax</span>
            </a>
        <?php endif; ?>

        <!-- Search -->
        <form class="header-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" name="s"
                   placeholder="Buscar notícias, análises, legislação..."
                   value="<?php echo esc_attr(get_search_query()); ?>">
            <button type="submit" aria-label="Buscar">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <!-- CTA -->
        <div class="header-right">
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo esc_url(admin_url()); ?>" class="btn btn-ghost">
                    <i class="fa-solid fa-gauge"></i> Painel
                </a>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn btn-gold">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Sair
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(wp_login_url()); ?>" class="btn btn-ghost">
                    <i class="fa-solid fa-right-to-bracket"></i> Entrar
                </a>
                <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn-gold">
                    <i class="fa-solid fa-crown"></i> RFX Pro
                </a>
            <?php endif; ?>
        </div>

        <!-- Mobile toggle -->
        <button class="menu-toggle" aria-label="Menu" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </button>

    </div>
</header>

<!-- ===== NAV ===== -->
<nav class="nav-wrapper" aria-label="Menu principal">
    <div class="container">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'main-nav',
            'walker'         => new Reformtax_Nav_Walker(),
            'fallback_cb'    => 'reformtax_default_menu',
        ]);
        ?>
    </div>
</nav>

<?php
// Breaking news bar
$breaking = get_theme_mod('reforma_breaking_news', '');
if ($breaking) :
    $link = get_theme_mod('reforma_breaking_news_link', '');
?>
<div class="breaking-bar">
    <div class="container">
        <span class="breaking-label"><i class="fa-solid fa-fire"></i> Agora</span>
        <span class="breaking-text">
            <?php if ($link) echo '<a href="' . esc_url($link) . '">' . esc_html($breaking) . '</a>';
            else echo esc_html($breaking); ?>
        </span>
    </div>
</div>
<?php endif; ?>

<?php
function reformtax_default_menu() {
    $cats = get_categories(['orderby' => 'count', 'order' => 'DESC', 'number' => 7]);
    echo '<ul class="main-nav">';
    echo '<li class="current-menu-item"><a href="' . esc_url(home_url('/')) . '">Início</a></li>';
    foreach ($cats as $cat) {
        echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
    }
    echo '<li><a href="#" style="color:var(--gold);font-weight:800;">RFX Pro <i class="fa-solid fa-crown" style="font-size:10px;"></i></a></li>';
    echo '</ul>';
}
?>
