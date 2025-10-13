<nav class="navbar navbar-light navbar-custom shadow-sm">
    <div class="container-fluid">
        <!-- Toggle Sidebar Button (Open) -->
        <button class="btn btn-outline-primary d-lg-none me-2" id="toggleSidebar">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Close Sidebar Button (Mobile Only) -->
        <button class="btn btn-outline-danger d-lg-none" id="closeSidebar">
            <i class="fa fa-times"></i>
        </button>

        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 fw-semibold">{{ Auth::user()->name ?? 'User' }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}"
                class="rounded-circle" width="35" height="35" alt="avatar">
        </div>
    </div>
</nav>

<!-- Sidebar Toggle Script -->
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const closeBtn = document.getElementById('closeSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.add('active'); // open sidebar
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.remove('active'); // close sidebar
    });
</script>

