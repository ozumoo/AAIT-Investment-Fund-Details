<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanySubmission;
use App\Models\CompanyListing;
use App\Models\CompanySubmission;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CompanyController extends Controller
{
    public function index()
    {
        $symbols = Cache::remember('company_symbols', now()->addHours(24),  function() {
            return CompanyListing::pluck('symbol');
        });

        return view('company', compact('symbols'));
    }

    public function store(StoreCompanySubmission $request)
    {
        // Handle storing form data to the database (You can implement this)
        CompanySubmission::create($request->validated());

        // save email in session
        Session::put('email', $request->input('email'));

        return redirect('/historical-quotes')->with('success', 'Form submitted successfully.');
    }


    public function showHistoricalQuotes()
    {
        $uniqueEmail = Session::get('email');

        $companySubmission = CompanySubmission::where('email', $uniqueEmail)->first();

        // Check if a valid CompanySubmission record was found
        if (!$companySubmission) {
            return redirect('/company')->with('error', 'No matching record found for this email.');
        }

        // Construct the URL for the API request
        $symbol = $companySubmission->company_symbol;
        $apiUrl = "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol={$symbol}&region=US";

        // Set the headers for the API request
        $headers = [
            'X-RapidAPI-Host' => 'yh-finance.p.rapidapi.com',
            'X-RapidAPI-Key' => '75d2c1aa1dmsh8192713452ec306p10d467jsn66bb1343a817',
        ];

        // Make the GET request to the API
        $response = Http::withHeaders($headers)->get($apiUrl);

        // Check if the request was successful
        if ($response->successful()) {
            // Decode the JSON response to get historical data
            $historicalData = $response->json();

            $historicalDataPrices = $historicalData['prices'];

            // Paginate the historical data
            $perPage = 10; // Set the number of items per page
            $page = request('page', 1); // Get the current page from the query string

            $historicalDataPaginated = array_slice($historicalDataPrices, ($page - 1) * $perPage, $perPage);

            // Create a pagination instance
            $historicalDataPaginated = new LengthAwarePaginator(
                $historicalDataPaginated,
                count($historicalDataPrices),
                $perPage,
                $page,
                [
                    'path' => '/historical-quotes',
                    'query' => ['page' => $page], 
                ]
            );

            $dates = [];
            $openPrices = [];
            $closePrices = [];

            foreach ($historicalDataPrices as $data) {
                $dates[] = date('Y-m-d', $data['date']);
                $openPrices[] = $data['open'];
                $closePrices[] = $data['close'];
            }

            // Assuming the response structure matches your expectations
            return view('historical-quotes', compact('historicalDataPaginated', 'dates', 'openPrices', 'closePrices'));
        } else {
            // Handle the case where the API request was not successful
            return redirect('/company')->with('error', 'Failed to fetch historical quotes data.');
        }
    }

}
