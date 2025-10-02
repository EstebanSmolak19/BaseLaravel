<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    {{-- Map leaflet --}}
     <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>@yield('title', 'MonTitre')</title>
</head>
<body>
    <div class="container mt-2">
        @yield('content')
    </div>
</body>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    #map { height: 200px; }
</style>
</html>