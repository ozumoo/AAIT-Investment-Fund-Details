<!DOCTYPE html>
<html>
<head>
    <title>Company Form</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Company Form</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/company">
            @csrf
            <div class="form-group">
                <label for="company_symbol">Company Symbol:</label>
                <select class="form-control" id="company_symbol" name="company_symbol" required>

                    @foreach ($symbols as $symbolData)
                        <option value="{{ $symbolData['Symbol'] }}">{{ $symbolData['Symbol'] }}</option>
                    @endforeach
                    
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="text" class="form-control datepicker" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="text" class="form-control datepicker" id="end_date" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

        // Initialize datepickers
        $(document).ready(function() {
            $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

            // Initialize Select2 on the select element with the id "company_symbol"
            $('#company_symbol').select2();
        });
    </script>
</body>
</html>
