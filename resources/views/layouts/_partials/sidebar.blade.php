@php
    $currentRoute = Route::currentRouteName();
@endphp

<div class="sidebar-wrapper">
    <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
            data-accordion="false" id="navigation">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link {{ $currentRoute == 'home' ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('service.index') }}" class="nav-link {{ $currentRoute == 'service.index' ? 'active' : '' }}">
                    <i class="nav-icon fa-solid fa-screwdriver-wrench"></i>
                    <p>
                        Services
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('service.provider') }}" class="nav-link {{ $currentRoute == 'service.provider' ? 'active' : '' }}">
                    <i class="nav-icon fa-solid fa-gears"></i>
                    <p>
                        Service Provider
                    </p>
                </a>
            </li>

        </ul>
        <!--end::Sidebar Menu-->
    </nav>
</div>
