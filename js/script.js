/* MangaXpress – Main JS (Redesigned) */

document.addEventListener('DOMContentLoaded', () => {

    // ── Flash message auto-dismiss ──────────────────────────
    const flash = document.querySelector('.flash-msg');
    if (flash) {
        const closeBtn = flash.querySelector('.close-flash');
        if (closeBtn) closeBtn.addEventListener('click', () => flash.remove());
        setTimeout(() => flash && flash.remove(), 4500);
    }

    // ── User dropdown ────────────────────────────────────────
    const userToggle = document.getElementById('userDropdownToggle');
    const userMenu   = document.getElementById('userDropdownMenu');
    if (userToggle && userMenu) {
        userToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('open');
        });
        document.addEventListener('click', () => userMenu.classList.remove('open'));
        userMenu.addEventListener('click', (e) => e.stopPropagation());
    }

    // ── Mobile hamburger ─────────────────────────────────────
    const hamburger = document.getElementById('hamburger');
    const mobileNav = document.getElementById('mobileNav');
    if (hamburger && mobileNav) {
        hamburger.addEventListener('click', (e) => {
            e.stopPropagation();
            hamburger.classList.toggle('open');
            mobileNav.classList.toggle('open');
        });
        document.addEventListener('click', (e) => {
            if (!mobileNav.contains(e.target) && !hamburger.contains(e.target)) {
                hamburger.classList.remove('open');
                mobileNav.classList.remove('open');
            }
        });
    }

    // ── Sync quantity inputs ─────────────────────────────────
    document.querySelectorAll('.qty-sync').forEach(input => {
        input.addEventListener('input', () => {
            const id  = input.dataset.id;
            const val = input.value;
            const cart = document.getElementById('cart_qty_' + id);
            const buy  = document.getElementById('buy_now_qty_' + id);
            if (cart) cart.value = val;
            if (buy)  buy.value  = val;
        });
    });

    // ── Product detail qty sync ──────────────────────────────
    const mainQty = document.getElementById('main-qty');
    if (mainQty) {
        mainQty.addEventListener('input', () => {
            const v   = mainQty.value;
            const bnq = document.getElementById('buy_now_quantity');
            const cq  = document.getElementById('cart_quantity');
            if (bnq) bnq.value = v;
            if (cq)  cq.value  = v;
        });
    }

    // ── Active nav link ───────────────────────────────────────
    const currentPath = window.location.pathname.split('/').pop();
    document.querySelectorAll('.main-nav a').forEach(link => {
        if (link.getAttribute('href') === currentPath) link.classList.add('active');
    });

    // ── Confirm dialogs ───────────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', (e) => {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });

    // ── Profile picture preview ───────────────────────────────
    const picInput   = document.getElementById('profilePicInput');
    const picPreview = document.getElementById('profilePicPreview');
    if (picInput && picPreview) {
        picInput.addEventListener('change', () => {
            const file = picInput.files[0];
            if (file) picPreview.src = URL.createObjectURL(file);
        });
    }

});