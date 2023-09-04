<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanySubmission;
use App\Jobs\SendCompanySubmissionEmail;
use App\Models\CompanyListing;
use App\Models\CompanySubmission;
use Carbon\Carbon;
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
        $validatedData = $request->validated();

        $companySubmission = CompanySubmission::create($validatedData);

        Session::put('email', $request->input('email'));

        // uncomment dispatch email after adding the credentials

        // dispatch(new SendCompanySubmissionEmail(
        //     $request->input('email'),
        //     $companySubmission->company_symbol,
        //     $validatedData['start_date'],
        //     $validatedData['end_date']
        // ));

        return redirect('/historical-quotes')->with('success', 'Form submitted successfully.');
    }
     /**
     * Show historical quotes for a company.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showHistoricalQuotes()
    {
        $uniqueEmail = Session::get('email');
        $companySubmission = $this->getCompanySubmission($uniqueEmail);

        if (!$companySubmission) {
            return redirect('/company')->with('error', 'No matching record found for this email.');
        }

        $symbol = $companySubmission->company_symbol;
        $apiUrl = $this->constructApiUrl($symbol);

        $headers = $this->getApiHeaders();
        $response = Http::withHeaders($headers)->get($apiUrl);

        if ($response->successful()) {
            $historicalData = $response->json();
            $filteredData = $this->filterHistoricalData($historicalData, $companySubmission);


            $perPage = 10;
            $page = request('page', 1);
            $filteredDataPaginated = $this->paginateFilteredData($filteredData, $perPage, $page);

            $dates = [];
            $openPrices = [];
            $closePrices = [];
            $this->extractDateAndPrices($filteredData, $dates, $openPrices, $closePrices);

            return view('historical-quotes', compact('filteredDataPaginated', 'dates', 'openPrices', 'closePrices'));
        } else {
            return redirect('/company')->with('error', 'Failed to fetch historical quotes data.');
        }
    }

    /**
     * Get a company submission record by email.
     *
     * @param string $email
     * @return \App\Models\CompanySubmission|null
     */
    private function getCompanySubmission(string $email): ?CompanySubmission
    {
        return CompanySubmission::where('email', $email)->first();
    }

    /**
     * Construct the URL for the API request.
     *
     * @param string $symbol
     * @return string
     */
    private function constructApiUrl(string $symbol): string
    {
        return "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol={$symbol}&region=US";
    }

    /**
     * Get the headers for the API request.
     *
     * @return array
     */
    private function getApiHeaders(): array
    {
        return [
            'X-RapidAPI-Host' => 'yh-finance.p.rapidapi.com',
            'X-RapidAPI-Key' => '75d2c1aa1dmsh8192713452ec306p10d467jsn66bb1343a817',
        ];
    }

    /**
     * Filter historical data based on the date range.
     *
     * @param array $historicalData
     * @param \App\Models\CompanySubmission $companySubmission
     * @return array
     */
    private function filterHistoricalData(array $historicalData, CompanySubmission $companySubmission): array
    {
        // Assuming $historicalData has a 'prices' key with an array of historical data
        $historicalDataPrices = $historicalData['prices'];

        $startDate = Carbon::parse($companySubmission->start_date);
        $endDate = Carbon::parse($companySubmission->end_date);

        $filteredData = array_filter($historicalDataPrices, function ($data) use ($startDate, $endDate) {
            $dataDate = Carbon::createFromTimestamp($data['date']);
            return $dataDate->between($startDate, $endDate);
        });

        return $filteredData;
    }

    /**
     * Paginate the filtered historical data.
     *
     * @param array $filteredData
     * @param int $perPage
     * @param int $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function paginateFilteredData(array $filteredData, int $perPage, int $page): LengthAwarePaginator
    {
        $filteredDataPaginated = array_slice($filteredData, ($page - 1) * $perPage, $perPage);

        return new LengthAwarePaginator(
            $filteredDataPaginated,
            count($filteredData),
            $perPage,
            $page,
            [
                'path' => '/historical-quotes',
                'query' => ['page' => $page],
            ]
        );
    }

    /**
     * Extract dates, open prices, and close prices from filtered data.
     *
     * @param array $filteredData
     * @param array $dates
     * @param array $openPrices
     * @param array $closePrices
     */
    private function extractDateAndPrices(array $filteredData, array &$dates, array &$openPrices, array &$closePrices): void
    {
        foreach ($filteredData as $data) {
            $dates[] = date('Y-m-d', $data['date']);
            $openPrices[] = $data['open'];
            $closePrices[] = $data['close'];
        }
    }

}
