<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | Clickvora Digital</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/icon/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @stack('styles')
</head>

<body class="admin-body">

    <div class="admin-wrapper">
        <div class="admin-overlay" id="adminOverlay"></div>

        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-brand">
                <span style="font-size:20px; font-weight:700; color:#fff; letter-spacing:-.02em;">Clickvora <span style="color:#fdc700; font-weight:500;">Digital</span></span>
            </div>
            <ul class="admin-nav">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.quotes.index') }}" class="{{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}"><i class="fa-solid fa-comment-dots"></i> Quotes</a></li>
                <li><a href="{{ route('admin.blogs.index') }}" class="{{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}"><i class="fa-solid fa-newspaper"></i> Blogs</a></li>
                <li><a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}"><i class="fa-solid fa-briefcase"></i> Services</a></li>
                <li><a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"><i class="fa-solid fa-quote-left"></i> Testimonials</a></li>
                <li><a href="{{ route('admin.team-members.index') }}" class="{{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Team</a></li>
                <li><a href="{{ route('admin.additional-contents.index') }}" class="{{ request()->routeIs('admin.additional-contents.*') ? 'active' : '' }}"><i class="fa-solid fa-layer-group"></i> Additional Content</a></li>
                <li><a href="{{ route('admin.redirects.index') }}" class="{{ request()->routeIs('admin.redirects.*') ? 'active' : '' }}"><i class="fa-solid fa-arrows-turn-right"></i> URL Redirects</a></li>
                <li><a href="{{ route('admin.page-metas.index') }}" class="{{ request()->routeIs('admin.page-metas.*') ? 'active' : '' }}"><i class="fa-solid fa-tags"></i> Page SEO</a></li>
                <li><a href="{{ route('admin.page-schemas.index') }}" class="{{ request()->routeIs('admin.page-schemas.*') ? 'active' : '' }}"><i class="fa-solid fa-diagram-project"></i> Page Schemas</a></li>
                <li><a href="{{ route('admin.seo-settings.edit') }}" class="{{ request()->routeIs('admin.seo-settings.*') ? 'active' : '' }}"><i class="fa-solid fa-sliders"></i> SEO Settings</a></li>
                <li><a href="{{ route('admin.robots.index') }}" class="{{ request()->routeIs('admin.robots.*') ? 'active' : '' }}"><i class="fa-solid fa-robot"></i> Robots.txt</a></li>
                <li><a href="{{ route('admin.sitemap.index') }}" class="{{ request()->routeIs('admin.sitemap.*') ? 'active' : '' }}"><i class="fa-solid fa-map"></i> Sitemap</a></li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="admin-nav-logout" style="all:unset; display:flex; align-items:center; gap:12px; padding:11px 14px; border-radius:8px; color:rgba(255,255,255,.75); font-size:14.5px; font-weight:500; cursor:pointer; width:100%;">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <div class="admin-main">
            <div class="admin-topbar">
                <div style="display:flex; align-items:center; gap:14px;">
                    <button class="admin-sidebar-toggle" id="adminSidebarToggle"><i class="fa-solid fa-bars"></i></button>
                    <h1>@yield('title', 'Dashboard')</h1>
                </div>
                <div class="admin-user-chip">
                    <i class="fa-solid fa-circle-user" style="font-size:22px; color:var(--admin-primary);"></i>
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </div>

            <div class="admin-content">
                @if (session('success'))
                    <div class="admin-alert admin-alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="admin-alert admin-alert-danger">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');
        const toggle = document.getElementById('adminSidebarToggle');

        function closeSidebar() {
            sidebar.classList.remove('is-open');
            overlay.classList.remove('is-open');
        }

        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('is-open');
            overlay.classList.toggle('is-open');
        });

        overlay?.addEventListener('click', closeSidebar);
    </script>
    @stack('scripts')
</body>

</html>
