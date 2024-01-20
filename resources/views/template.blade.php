<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('libraries/bootstrap/css/bootstrap.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employee.index') }}">@lang('views/template.nav-menu-1')</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col">
                <h2>@yield('title')</h2>
            </div>
            <div class="col-auto">
                @yield('control-buttons')
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('libraries/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('libraries/vue/vue.global.js') }}"></script>

    @stack('script')
</body>
</html>