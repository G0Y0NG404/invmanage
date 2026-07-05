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

    var modalHtml = '' +
        '<div id="confirmModal" class="fixed inset-0 bg-black/70 z-[200] items-center justify-center hidden">' +
            '<div class="bg-white border border-gray-300 shadow-lg w-full max-w-[360px] mx-4 p-6 text-center">' +
                '<p id="confirmMessage" class="text-sm text-black mb-5"></p>' +
                '<div class="flex gap-3 justify-center">' +
                    '<button id="confirmYes" class="px-5 py-2 bg-[#003366] text-white text-sm font-bold border border-[#002244] cursor-pointer font-sans">Yes</button>' +
                    '<button id="confirmNo" class="px-5 py-2 bg-gray-200 text-black text-sm font-bold border border-gray-300 cursor-pointer font-sans">Cancel</button>' +
                '</div>' +
            '</div>' +
        '</div>';

    document.body.insertAdjacentHTML('beforeend', modalHtml);

    var modal = document.getElementById('confirmModal');
    var modalMessage = document.getElementById('confirmMessage');
    var confirmBtn = document.getElementById('confirmYes');
    var cancelBtn = document.getElementById('confirmNo');
    var pendingForm = null;

    if (modal && confirmBtn && cancelBtn) {
        document.querySelectorAll('[data-confirm]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                pendingForm = el.closest('form');
                modalMessage.textContent = el.getAttribute('data-confirm');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        confirmBtn.addEventListener('click', function () {
            if (pendingForm) {
                pendingForm.submit();
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            pendingForm = null;
        });

        cancelBtn.addEventListener('click', function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            pendingForm = null;
        });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                pendingForm = null;
            }
        });
    }
});
