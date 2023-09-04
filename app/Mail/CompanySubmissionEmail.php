<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanySubmissionEmail extends Mailable
{
    use SerializesModels;

    public $company_symbol;
    public $startDate;
    public $endDate;

    public function __construct($company_symbol, $startDate, $endDate)
    {
        $this->company_symbol = $company_symbol;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this->subject('Company Submission Email')
            ->view('emails.company-submission');
    }
}
