/* Reformtax — main.js */
document.addEventListener('DOMContentLoaded', function () {

    /* ---- Mobile menu ---- */
    const toggle = document.querySelector('.menu-toggle');
    const nav    = document.querySelector('.main-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            const open = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open);
            toggle.innerHTML = open
                ? '<i class="fa-solid fa-xmark"></i>'
                : '<i class="fa-solid fa-bars"></i>';
        });
        document.addEventListener('click', function (e) {
            if (!toggle.contains(e.target) && !nav.contains(e.target)) {
                nav.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
            }
        });
    }

    /* ---- Newsletter AJAX ---- */
    function setupNewsletter(formId, msgId) {
        const form = document.getElementById(formId);
        const msg  = document.getElementById(msgId);
        if (!form || !msg) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const email = form.querySelector('input[name="email"]').value;
            const data  = new FormData();
            data.append('action', 'rfx_newsletter');
            data.append('email',  email);
            data.append('nonce',  (window.rfxData || {}).nonce || '');

            fetch((window.rfxData || {}).ajaxurl || '/wp-admin/admin-ajax.php', {
                method: 'POST', body: data,
            })
            .then(r => r.json())
            .then(res => {
                msg.style.display = 'block';
                msg.textContent   = res.data?.msg || 'Erro.';
                msg.style.color   = res.success ? '#4ade80' : '#fca5a5';
                if (res.success) form.reset();
            })
            .catch(() => {
                msg.style.display = 'block';
                msg.textContent   = 'Erro de conexão.';
                msg.style.color   = '#fca5a5';
            });
        });
    }

    setupNewsletter('sidebar-newsletter-form',    'sidebar-newsletter-msg');
    setupNewsletter('footer-newsletter-form',     'footer-newsletter-msg');

    /* ---- Back to top ---- */
    const btt = document.createElement('button');
    btt.id            = 'rfx-btt';
    btt.innerHTML     = '<i class="fa-solid fa-arrow-up"></i>';
    btt.setAttribute('aria-label', 'Voltar ao topo');
    Object.assign(btt.style, {
        position: 'fixed', bottom: '26px', right: '22px', zIndex: '999',
        width: '40px', height: '40px', borderRadius: '50%',
        background: 'var(--gold)', color: 'var(--navy)',
        border: 'none', cursor: 'pointer', fontSize: '14px',
        display: 'flex', alignItems: 'center', justifyContent: 'center',
        boxShadow: '0 4px 12px rgba(200,168,75,.4)',
        opacity: '0', transition: 'opacity .3s, transform .3s',
        transform: 'translateY(10px)', pointerEvents: 'none',
    });
    document.body.appendChild(btt);

    window.addEventListener('scroll', function () {
        const show = window.scrollY > 400;
        btt.style.opacity      = show ? '1' : '0';
        btt.style.transform    = show ? 'translateY(0)' : 'translateY(10px)';
        btt.style.pointerEvents = show ? 'auto' : 'none';
    }, { passive: true });

    btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    /* ---- Sticky header shadow ---- */
    const hdr = document.querySelector('.site-header');
    if (hdr) {
        window.addEventListener('scroll', () => {
            hdr.style.boxShadow = window.scrollY > 50
                ? '0 2px 20px rgba(0,0,0,.5)'
                : '0 2px 12px rgba(0,0,0,.4)';
        }, { passive: true });
    }
});
