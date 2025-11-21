<!-- Sidebar Header -->
<div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
    <h5 class="mb-0 fw-bold text-info">📂 Categories</h5>
    <button class="btn-close text-white" id="closeSidebar"></button>
</div>

<!-- Account Info -->
<div class="px-3 py-3 border-bottom border-secondary d-flex align-items-center">
    <div class="rounded-circle bg-info text-dark d-flex align-items-center justify-content-center me-3" style="width:45px; height:45px;">
        <i class="bi bi-person-fill fs-4"></i>
    </div>
    <div>
        <h6 class="mb-0 fw-semibold text-white">Hello, User</h6>
        <small class="text-secondary">View Account</small>
    </div>
</div>

<!-- Category List -->
<!-- Category List -->
<div class="sidebar-content px-3 py-3">
    <ul class="list-unstyled mb-0">
        @foreach($categories as $category)
            <li class="mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('category.show', $category->slug) }}" class="text-white text-decoration-none flex-grow-1">
                        {{ $category->name }}
                    </a>
                    @if($category->children->count())
                        <button class="btn btn-sm text-white p-0 border-0 bg-transparent toggle-btn"
                                data-bs-toggle="collapse"
                                data-bs-target="#cat{{ $category->id }}"
                                aria-expanded="false">
                            <i class="bi bi-plus-lg toggle-icon"></i>
                        </button>
                    @endif
                </div>

                @if($category->children->count())
                    <ul id="cat{{ $category->id }}" class="collapse submenu ps-3 mt-2">
                        @foreach($category->children as $sub)
                            <li class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('category.show', $sub->slug) }}" class="text-white text-decoration-none flex-grow-1">
                                        {{ $sub->name }}
                                    </a>
                                    @if($sub->children->count())
                                        <button class="btn btn-sm text-white p-0 border-0 bg-transparent toggle-btn"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#sub{{ $sub->id }}"
                                                aria-expanded="false">
                                            <i class="bi bi-plus-lg toggle-icon"></i>
                                        </button>
                                    @endif
                                </div>

                                @if($sub->children->count())
                                    <ul id="sub{{ $sub->id }}" class="collapse submenu ps-3 mt-2">
                                        @foreach($sub->children as $subsub)
                                            <li>
                                                <a href="{{ route('category.show', $subsub->slug) }}" class="text-white text-decoration-none">
                                                    {{ $subsub->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>



<!-- Custom Styles -->
<style>
/* Main button style */
.category-btn {
    width: 100%;
    background: transparent;
    border: none;
    color: #fff;
    font-weight: 500;
    text-align: left;
    padding: 10px 0;
    transition: color 0.2s ease;
    cursor: pointer;
    position: relative;
}
.category-btn:hover {
    color: #0dcaf0;
}

/* Submenu links */
.toggle-btn {
    transition: transform 0.25s ease;
}
.toggle-btn[aria-expanded="true"] .toggle-icon {
    transform: rotate(45deg);
}

.submenu {
    border-left: 1px solid #444;
    margin-left: 8px;
    padding-left: 8px;
}

.submenu a {
    display: block;
    padding: 6px 0;
    color: #ccc;
    font-size: 0.95rem;
    text-decoration: none;
}
.submenu a:hover {
    color: #0dcaf0;
}

</style>
