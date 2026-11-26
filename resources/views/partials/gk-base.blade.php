<style>
    [x-cloak] { display: none !important; }
    body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
    h1, h2, .gk-serif { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; font-weight: 800; letter-spacing: -0.02em; }
    .gk-gold { background: linear-gradient(135deg, #ffc2a8 0%, #ff8a65 50%, #ff6b4a 100%); -webkit-background-clip: text; background-clip: text; color: transparent; }
    .gk-btn-gold { background: linear-gradient(135deg, #ff9b7a 0%, #ff6b4a 100%); color: #fff; box-shadow: 0 6px 16px -6px rgba(255,107,74,.6); }
    .gk-btn-gold:hover { filter: brightness(1.05); transform: translateY(-1px); }
    button, a { transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease, opacity .15s ease; }
    button:active { transform: scale(.97); }
    .gk-grow { animation: gk-grow 1.1s ease-out; }
    @keyframes gk-grow { from { width: 0 } }
    .gk-skeleton { animation: gk-pulse 1.4s ease-in-out infinite; }
    @keyframes gk-pulse { 0%,100% { opacity: 1 } 50% { opacity: .45 } }
    dialog::backdrop { background: rgba(15, 23, 42, .55); backdrop-filter: blur(2px); }

    /* Transisi antarhalaman seperti pergantian slide (View Transitions API; browser lama memuat biasa) */
    @view-transition { navigation: auto; }
    .gk-header { view-transition-name: gk-header; }
    ::view-transition-old(root) { animation: gk-slide-out .32s cubic-bezier(.4, 0, .2, 1) both; }
    ::view-transition-new(root) { animation: gk-slide-in .5s cubic-bezier(.2, .8, .2, 1) both; }
    @keyframes gk-slide-out { to { opacity: 0; transform: translateX(-56px) scale(.99); } }
    @keyframes gk-slide-in { from { opacity: 0; transform: translateX(56px) scale(.99); } }

    /* Muncul bertahap saat di-scroll */
    .gk-reveal { opacity: 0; transform: translateY(22px); transition: opacity .7s ease, transform .7s cubic-bezier(.2, .8, .2, 1); transition-delay: var(--d, 0ms); }
    .gk-reveal.is-in { opacity: 1; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        ::view-transition-old(root), ::view-transition-new(root) { animation: none; }
        .gk-reveal { opacity: 1; transform: none; transition: none; }
        .gk-grow, .gk-skeleton { animation: none; }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const els = document.querySelectorAll('.gk-reveal');
        if (!('IntersectionObserver' in window)) { els.forEach((e) => e.classList.add('is-in')); return; }
        const io = new IntersectionObserver((entries) => {
            entries.forEach((en) => { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } });
        }, { threshold: 0.12 });
        els.forEach((e) => io.observe(e));
    });
</script>
