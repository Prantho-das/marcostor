<div class="topbar bg-white d-flex justify-content-between align-items-center shadow-sm px-4 py-3 sticky-top">
    <i class="bi bi-list fs-3 d-lg-none" id="toggleSidebar"></i>
    <h5 class="mb-0">@yield('page_title')</h5>

    <div class="d-flex align-items-center gap-3">
        <span class="text-muted">👤 {{ Auth::user()->name ?? 'Admin' }}</span>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'A') }}"
             alt="avatar" class="rounded-circle" width="35">
    </div>
</div>
