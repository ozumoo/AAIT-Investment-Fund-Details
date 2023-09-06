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
use App\Services\HistoricalQuotesService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class CompanyController extends Controller
{

    /**
     * @var HistoricalQuotesService
     */
    private $historicalQuotesService;

    public function __construct(HistoricalQuotesService $historicalQuotesService)
    {
        $this->historicalQuotesService = $historicalQuotesService;
    }
    
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
    /**
     * Show historical quotes for a company.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showHistoricalQuotes()
    {
        $uniqueEmail = Session::get('email');
        $companySubmission = CompanySubmission::where('email', $uniqueEmail)->first();

        if (!$companySubmission) {
            return redirect('/company')->with('error', 'No matching record found for this email.');
        }

        $historicalQuotesData = $this->historicalQuotesService->getHistoricalQuotesData($companySubmission->company_symbol);
        $filteredData = $this->historicalQuotesService->filterHistoricalData($historicalQuotesData, $companySubmission);

        $perPage = 10;
        $page = request('page', 1);
        $filteredDataPaginated = $this->historicalQuotesService->paginateFilteredData($filteredData, $perPage, $page);

        $dates = [];
        $openPrices = [];
        $closePrices = [];
        $this->historicalQuotesService->extractDateAndPrices($filteredData, $dates, $openPrices, $closePrices);

        return view('historical-quotes', compact('filteredDataPaginated', 'dates', 'openPrices', 'closePrices'));
    }

}
