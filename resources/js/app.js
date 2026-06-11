document.addEventListener('DOMContentLoaded', () => {
	const sidebar = document.getElementById('sidebar');
	const toggle = document.getElementById('sidebarToggle');
	const backdrop = document.getElementById('sidebarBackdrop');

	if (!sidebar || !toggle) return;

	function openSidebar() {
		sidebar.classList.remove('-translate-x-full');
		backdrop?.classList.remove('hidden');
	}

	function closeSidebar() {
		sidebar.classList.add('-translate-x-full');
		backdrop?.classList.add('hidden');
	}

	toggle.addEventListener('click', (e) => {
		e.stopPropagation();
		if (sidebar.classList.contains('-translate-x-full')) {
			openSidebar();
		} else {
			closeSidebar();
		}
	});

	backdrop?.addEventListener('click', closeSidebar);

	// close sidebar when pressing Escape
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') closeSidebar();
	});
});
