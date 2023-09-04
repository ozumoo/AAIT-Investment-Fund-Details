@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Company Form</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/company">
        @csrf
        <div class="form-group">
            <label for="company_symbol">Company Symbol:</label>
            <select class="form-control" id="company_symbol" name="company_symbol" required>
                
                @foreach ($symbols as $symbol)
                    <option value="{{ $symbol }}">{{ $symbol }}</option>
                @endforeach
                
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="text" class="form-control datepicker" id="start_date" name="start_date" placeholder="YYYY-mm-dd" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="text" class="form-control datepicker" id="end_date" name="end_date" placeholder="YYYY-mm-dd" required>
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

@endsection
