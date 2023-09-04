<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Data Price</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <!-- Include CSS stylesheets or external assets here -->
    @vite('resources/js/app.js')

</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="/historical-quotes" class="nav-link active" aria-current="page">Historical Quotes</a></li>
          <li class="nav-item"><a href="/company" class="nav-link">Company Form Submission</a></li>
        </ul>
    </header>
    
    <main>
        <div class="container">
            @yield('content') <!-- This is where the content for each page will be inserted -->
        </div>
    </main>

    <footer>
        <!-- Footer content goes here -->
    </footer>

    <!-- Include JavaScript scripts or external assets here -->
</body>
</html>
