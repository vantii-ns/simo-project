console.log("SIMO Dashboard loaded");

// Setup generic delete confirmation using event delegation for static & dynamic elements
document.addEventListener('click', (e) => {
    const btnDelete = e.target.closest('.btn-delete');
    if (btnDelete) {
        e.preventDefault();
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = btnDelete.href;
        }
    }
});
