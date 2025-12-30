<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Asset Management')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>
</head>
@yield('scripts')
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">Asset Management</div>

        @if(config('features.asset_create') && Route::has('assets.create'))
        <a href="{{ route('assets.create') }}"
           class="{{ request()->routeIs('assets.create') ? 'active' : '' }}">
            Create Asset
        </a>
        @endif

        @if(config('features.asset_list') && Route::has('assets.list'))
        <a href="{{ route('assets.list') }}"
           class="{{ request()->routeIs('assets.list') ? 'active' : '' }}">
            Asset List
        </a>
        @endif


        <form method="POST" action="{{ route('logout') }}" class="sidebar-logout">
        @csrf
        <button type="submit">Log out</button>
    </form>
    </div>

    <!-- Main -->
    <div class="main">
        <!-- Header -->
       <div class="header">
        <div>@yield('header')</div>

            <div class="header-right">
                <span>Hello {{ Auth::user()->name }}</span>
                
            </div>
        </div>

        <!-- Main content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</body>
</html>