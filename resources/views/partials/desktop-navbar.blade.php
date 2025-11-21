<!-- 🌐 Desktop-only Navbar -->
<nav class="desktop-navbar d-none d-lg-block bg-light border-top border-bottom">
    <div class="container">
        <ul class="nav justify-content-center py-2 small">

            {{-- 🔹 Main Categories --}}
            @foreach($categories as $category)
                <li class="nav-item dropdown position-static">
                    <a class="nav-link dropdown-toggle fw-bold" style="color: #cd4b57" href="{{ route('category.show', $category->slug) }}">
                        {{ strtoupper($category->name) }}
                    </a>

                    {{-- 🔸 Subcategories --}}
                    @if($category->children->count())
                        <ul class="dropdown-menu">
                            @foreach($category->children as $sub)
                                @if($sub->children->count())
                                    {{-- Subcategory with sub-subcategories --}}
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item dropdown-toggle" href="{{ route('category.show', $sub->slug) }}">
                                            {{ $sub->name }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach($sub->children as $subsub)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('category.show', $subsub->slug) }}">
                                                        {{ $subsub->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('category.show', $sub->slug) }}">
                                            {{ $sub->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach

        </ul>
    </div>
</nav>


{{-- 🎨 CSS --}}
<style>
/* Base dropdown hidden */
.desktop-navbar .dropdown-menu {
    display: none;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s ease;
    animation: fadeIn 0.2s ease;
}

/* ✅ Only show the immediate dropdown menu of hovered item */
.desktop-navbar .nav-item.dropdown:hover > .dropdown-menu {
    display: block;
    opacity: 1;
    visibility: visible;
}

/* ✅ Only show sub-submenu when its parent .dropdown-submenu is hovered */
.desktop-navbar .dropdown-submenu:hover > .dropdown-menu {
    display: block;
    opacity: 1;
    visibility: visible;
}

/* Submenu positioning */
.dropdown-submenu {
    position: relative;
}
.dropdown-submenu > .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -4px;
    margin-left: 0.15rem;
}

/* Styling */
.desktop-navbar .dropdown-item:hover {
    background-color: #f8f9fa;
}
.desktop-navbar .nav-link,
.desktop-navbar .dropdown-item {
    font-size: 0.85rem;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>


{{-- ⚙️ JavaScript for Smooth Hover (Prevents all opening at once) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.desktop-navbar .nav-item.dropdown');

    dropdowns.forEach(dropdown => {
        const submenu = dropdown.querySelector(':scope > .dropdown-menu');
        let timer;

        dropdown.addEventListener('mouseenter', () => {
            clearTimeout(timer);
            closeAllDropdownsExcept(dropdown); // close others
            if (submenu) {
                submenu.style.display = 'block';
                setTimeout(() => submenu.style.opacity = '1', 10);
                submenu.style.visibility = 'visible';
            }
        });

        dropdown.addEventListener('mouseleave', () => {
            timer = setTimeout(() => {
                if (submenu) {
                    submenu.style.display = 'none';
                    submenu.style.opacity = '0';
                    submenu.style.visibility = 'hidden';
                }
            }, 200);
        });
    });

    // Handle sub-submenu hover
    const submenus = document.querySelectorAll('.desktop-navbar .dropdown-submenu');
    submenus.forEach(sub => {
        const menu = sub.querySelector(':scope > .dropdown-menu');
        let timer;

        sub.addEventListener('mouseenter', () => {
            clearTimeout(timer);
            closeSubmenusExcept(sub);
            if (menu) {
                menu.style.display = 'block';
                setTimeout(() => menu.style.opacity = '1', 10);
                menu.style.visibility = 'visible';
            }
        });

        sub.addEventListener('mouseleave', () => {
            timer = setTimeout(() => {
                if (menu) {
                    menu.style.display = 'none';
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                }
            }, 200);
        });
    });

    // Helper: close other dropdowns
    function closeAllDropdownsExcept(current) {
        document.querySelectorAll('.desktop-navbar .nav-item.dropdown').forEach(drop => {
            if (drop !== current) {
                const menu = drop.querySelector(':scope > .dropdown-menu');
                if (menu) {
                    menu.style.display = 'none';
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                }
            }
        });
    }

    // Helper: close other sub-submenus
    function closeSubmenusExcept(current) {
        document.querySelectorAll('.desktop-navbar .dropdown-submenu').forEach(sub => {
            if (sub !== current) {
                const menu = sub.querySelector(':scope > .dropdown-menu');
                if (menu) {
                    menu.style.display = 'none';
                    menu.style.opacity = '0';
                    menu.style.visibility = 'hidden';
                }
            }
        });
    }
});
</script>
