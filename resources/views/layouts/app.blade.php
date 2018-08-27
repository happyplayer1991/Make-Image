<!DOCTYPE html>
<!-- test -->
<html lang="{{ app()->getLocale() }}">
<head>
    @include('includes.head')
</head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
    @yield('styles')
</body>
</html>
