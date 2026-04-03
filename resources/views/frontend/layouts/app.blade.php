<!DOCTYPE html>
<html>
<head>
    <title>My E-commerce</title>
  <link rel="stylesheet" href="{{ asset('asset/frontend/style.css') }}">
</head>
<body>

    {{-- Header --}}
    @include('frontend.partials.header')

    {{-- Content --}}
    <div class="content">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('frontend.partials.footer')

</body>
</html>