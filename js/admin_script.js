/* MangaXpress – Admin JS */

document.addEventListener('DOMContentLoaded', () => {

    // ── Flash auto-dismiss ────────────────────────────────────
    const flash = document.querySelector('.flash-msg');
    if (flash) {
        const closeBtn = flash.querySelector('.close-flash');
        if (closeBtn) closeBtn.addEventListener('click', () => flash.remove());
        setTimeout(() => flash && flash.remove(), 4500);
    }

    // ── Sidebar toggle (mobile) ───────────────────────────────
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar       = document.getElementById('adminSidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('open');
        });
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    // ── Edit product modal ────────────────────────────────────
    const editModal   = document.getElementById('editProductModal');
    const closeModal  = document.querySelectorAll('[data-close-modal]');
    document.querySelectorAll('[data-edit-product]').forEach(btn => {
        btn.addEventListener('click', () => {
            if (editModal) editModal.classList.add('open');
        });
    });
    closeModal.forEach(btn => {
        btn.addEventListener('click', () => {
            if (editModal) editModal.classList.remove('open');
        });
    });
    if (editModal) {
        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) editModal.classList.remove('open');
        });
    }

    // ── Confirm dialogs ───────────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', (e) => {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });

    // ── Active sidebar link ───────────────────────────────────
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.sidebar-nav a').forEach(link => {
        if (link.getAttribute('href') === currentPage) link.classList.add('active');
    });

    // ── Product image preview (add form) ─────────────────────
    const addImgInput   = document.getElementById('addProductImg');
    const addImgPreview = document.getElementById('addProductImgPreview');
    if (addImgInput && addImgPreview) {
        addImgInput.addEventListener('change', () => {
            const file = addImgInput.files[0];
            if (file) {
                addImgPreview.src = URL.createObjectURL(file);
                addImgPreview.style.display = 'block';
            }
        });
    }

});