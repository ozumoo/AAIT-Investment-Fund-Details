<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function index()
    {
        // Fetch available company symbols from the JSON file
        $symbols = json_decode(file_get_contents('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json'), true);
        
        return view('company', compact('symbols'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'company_symbol' => 'required|exists:company_listings,Symbol',
            'start_date' => 'required|date|before_or_equal:end_date|before_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:today',
            'email' => 'required|email',
        ]);

        // Handle storing form data to the database (You can implement this)

        // Fetch historical data (You can implement this)

        // Send email (You can implement this)

        return redirect('/company')->with('success', 'Form submitted successfully.');
    }
}
