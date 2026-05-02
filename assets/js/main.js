// Menu mobile
const navToggle = document.getElementById('navToggle');
const navLinks  = document.getElementById('navLinks');

if (navToggle && navLinks) {
    navToggle.addEventListener('click', () => {
        navLinks.classList.toggle('open');
    });
}

// Aperçu PDF (documents.php)
function togglePreview(id, url) {
    const preview = document.getElementById('preview-' + id);
    if (!preview) return;

    const isOpen = preview.style.display !== 'none';
    if (isOpen) {
        preview.style.display = 'none';
    } else {
        const iframe = preview.querySelector('iframe');
        if (iframe && !iframe.src) {
            iframe.src = iframe.getAttribute('data-src');
        }
        preview.style.display = 'block';
    }
}
