document.addEventListener('DOMContentLoaded', function () {
    var hamburger = document.getElementById('hamburger');
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    function toggle() { sidebar.classList.toggle('open'); overlay.classList.toggle('show'); }
    if (hamburger) hamburger.addEventListener('click', toggle);
    if (overlay) overlay.addEventListener('click', toggle);

    var profileBtn = document.getElementById('profileBtn');
    var profileDropdown = document.getElementById('profileDropdown');
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function () {
            profileDropdown.classList.add('hidden');
        });
        profileDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }
});
