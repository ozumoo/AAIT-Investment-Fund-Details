<?php

namespace App\Services;

use App\Models\CompanySubmission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoricalQuotesService
{
    /**
     * Get historical quotes data from the API.
     *
     * @param string $symbol
     * @return array
     */
    public function getHistoricalQuotesData(string $symbol): array
    {
        $apiUrl = "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol={$symbol}&region=US";

        $headers = [
            'X-RapidAPI-Host' => 'yh-finance.p.rapidapi.com',
            'X-RapidAPI-Key' => '75d2c1aa1dmsh8192713452ec306p10d467jsn66bb1343a817',
        ];

        $response = Http::withHeaders($headers)->get($apiUrl);

        if ($response->successful()) {
            return $response->json();
        } else {
            return redirect('/company')->with('error', 'No matching record found for this email.');
        }
    }

    /**
     * Filter historical data based on the date range.
     *
     * @param array $historicalData
     * @param \App\Models\CompanySubmission $companySubmission
     * @return array
     */
    public function filterHistoricalData(array $historicalData, CompanySubmission $companySubmission): array
    {
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
    public function paginateFilteredData(array $filteredData, int $perPage, int $page): LengthAwarePaginator
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
     * Extract dates and prices from filtered data.
     *
     * @param array $filteredData
     * @param array $dates
     * @param array $openPrices
     * @param array $closePrices
     */
    public function extractDateAndPrices(array $filteredData, array &$dates, array &$openPrices, array &$closePrices): void
    {
        foreach ($filteredData as $data) {
            $dates[] = date('Y-m-d', $data['date']);
            $openPrices[] = $data['open'];
            $closePrices[] = $data['close'];
        }
    }
}
