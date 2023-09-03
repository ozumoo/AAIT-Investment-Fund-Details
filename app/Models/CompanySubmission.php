<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySubmission extends Model
{
    use HasFactory;

    protected $table = 'company_submissions';

    protected $fillable = [
        'company_symbol',
        'start_date',
        'end_date',
        'email',
    ];

}
