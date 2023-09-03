<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyListing extends Model
{

    use HasFactory;

    protected $table = 'company_listings';

    protected $fillable = [
        'company_name',
        'financial_status',
        'market_category',
        'round_lot_size',
        'security_name',
        'symbol',
        'test_issue',
    ];

    // Define relationships or additional methods as needed
}
