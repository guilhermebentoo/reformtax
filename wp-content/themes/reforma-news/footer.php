<?php
$footer_text = get_theme_mod('reforma_footer_text', 'O hub de conteúdos sobre a Reforma Tributária Brasileira. Informação, análise e estratégia para empresários, contadores, advogados e tomadores de decisão.');
$socials = [
    'linkedin'  => ['fa-brands fa-linkedin-in',  get_theme_mod('reforma_linkedin','')],
    'instagram' => ['fa-brands fa-instagram',     get_theme_mod('reforma_instagram','')],
    'twitter'   => ['fa-brands fa-x-twitter',    get_theme_mod('reforma_twitter','')],
    'youtube'   => ['fa-brands fa-youtube',      get_theme_mod('reforma_youtube','')],
    'spotify'   => ['fa-brands fa-spotify',      get_theme_mod('reforma_spotify','')],
    'whatsapp'  => ['fa-brands fa-whatsapp',     get_theme_mod('reforma_whatsapp','') ? 'https://wa.me/' . preg_replace('/\D/', '', get_theme_mod('reforma_whatsapp','')) : ''],
];
?>

<!-- ===== FOOTER ===== -->
<footer class="site-footer">
    <div class="footer-top">
        <div class="container">
            <div class="footer-grid">

                <!-- Brand -->
                <div class="footer-brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <span class="logo-bold">Reform</span><span class="logo-thin">tax</span>
                    </a>
                    <p><?php echo esc_html($footer_text); ?></p>
                    <div class="social-links">
                        <?php foreach ($socials as $key => [$icon, $url]) :
                            if ($url) : ?>
                            <a href="<?php echo esc_url($url); ?>" class="social-link"
                               target="_blank" rel="noopener" aria-label="<?php echo esc_attr($key); ?>">
                                <i class="<?php echo esc_attr($icon); ?>"></i>
                            </a>
                        <?php endif; endforeach; ?>
                    </div>
                </div>

                <!-- Col 2 — Editorias -->
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <h4>Editorias</h4>
                        <ul>
                            <?php
                            $cats = get_categories(['orderby' => 'count', 'order' => 'DESC', 'number' => 8, 'hide_empty' => true]);
                            foreach ($cats as $cat) {
                                echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Col 3 — Links -->
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <h4>Reformtax</h4>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/sobre')); ?>">Sobre o portal</a></li>
                            <li><a href="<?php echo esc_url(home_url('/colunistas')); ?>">Colunistas</a></li>
                            <li><a href="<?php echo esc_url(home_url('/rfx-pro')); ?>">RFX Pro</a></li>
                            <li><a href="<?php echo esc_url(home_url('/anuncie')); ?>">Anuncie conosco</a></li>
                            <li><a href="<?php echo esc_url(home_url('/contato')); ?>">Contato</a></li>
                            <li><a href="<?php echo esc_url(home_url('/politica-de-privacidade')); ?>">Privacidade</a></li>
                            <li><a href="<?php echo esc_url(home_url('/termos-de-uso')); ?>">Termos de Uso</a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Col 4 — Newsletter -->
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else : ?>
                        <h4>Newsletter</h4>
                        <p style="font-size:13px;line-height:1.6;margin-bottom:14px;color:var(--gray-400);">
                            Receba análises exclusivas sobre a Reforma Tributária toda semana.
                        </p>
                        <form class="newsletter-form" id="footer-newsletter-form">
                            <input type="email" name="email" placeholder="Seu e-mail" required>
                            <button type="submit">
                                <i class="fa-solid fa-paper-plane"></i> Assinar grátis
                            </button>
                        </form>
                        <div id="footer-newsletter-msg" style="display:none;margin-top:8px;font-size:13px;"></div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="footer-bottom">
            <span>&copy; <?php echo date('Y'); ?> Reformtax. Todos os direitos reservados.</span>
            <div class="footer-bottom-links">
                <a href="<?php echo esc_url(home_url('/politica-de-privacidade')); ?>">Privacidade</a>
                <a href="<?php echo esc_url(home_url('/termos-de-uso')); ?>">Termos de Uso</a>
                <a href="<?php echo esc_url(home_url('/cookies')); ?>">Cookies</a>
            </div>
            <span style="color:var(--gray-600);">
                Feito no Brasil <i class="fa-solid fa-heart" style="color:var(--gold);"></i>
            </span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
