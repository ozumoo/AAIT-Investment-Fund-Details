<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\CompanyListing;

class CompanyListingsSeeder extends Seeder
{
    public function run() : void
    {
        // Fetch data from the provided JSON file
        $response = Http::get('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json');
        $data = $response->json();

        // Loop through the data and insert into the company_listings table
        foreach ($data as $item) {
            CompanyListing::create([
                'company_name' => $item['Company Name'],
                'financial_status' => $item['Financial Status'],
                'market_category' => $item['Market Category'],
                'round_lot_size' => $item['Round Lot Size'],
                'security_name' => $item['Security Name'],
                'symbol' => $item['Symbol'],
                'test_issue' => $item['Test Issue'],
            ]);
        }
    }
}
